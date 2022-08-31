<?php

namespace App\Http\Controllers;

use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\VerificationCodeMismatchException;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerifyRequest;
use App\Jobs\ForgotPasswordEmailJob;
use App\Jobs\RegisterEmailJob;
use App\Jobs\SendVerificationEmailJob;
use App\Models\Merchant;
use App\Models\PasswordReset;
use App\Models\Planner;
use App\Models\User;
use App\Models\UserRole;
use App\Models\VerificationCode;
use App\Utilities\Message;
use App\Utilities\UserType;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Psy\Exception\RuntimeException;
use Stripe\Account;
use Stripe\AccountLink;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller {


    public function register(RegisterRequest $request): JsonResponse {
        $type = $request->type;

        $user = new User();

        try {

            DB::beginTransaction();

            $user->fill($request->validated());
            $user->saveOrFail();

            $userRole = new UserRole();
            $userRole->user_id = $user->id;
            $userRole->setRole(ucfirst($type));

            $userRole->saveOrFail();
            if ($type === UserType::MERCHANT) {
                $subcategory = new Merchant();
                $account = self::createConnectAccount();
                $subcategory->stripe_connect_id = $account->id;
            } else {
                $subcategory = new Planner();
            }

            $subcategory->user_id = $user->id;
            $subcategory->saveOrFail();

            print_r('subcategory');

            SendVerificationEmailJob::dispatch($user->email);

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            Log::debug('Exception in registration', [$e]);
            return $this->error(Message::SOMETHING_WENT_WRONG, 500);
        }

        return $this->success(compact('user'));
    }

    public function verify(VerifyRequest $request): JsonResponse {

        try {

            /** @var VerificationCode $verificationCode */
            $verificationCode = VerificationCode::query()
                ->where('email', $request->email)
                ->where('created_at', '>=', now()->subSeconds(60)->toDateTimeString())
                ->firstOrFail();

            if (password_verify($request->code, $verificationCode->code)) {
                $isDeleted = $verificationCode->delete();

                if (!$isDeleted) {
                    throw new Exception(Message::SOMETHING_WENT_WRONG);
                }
            } else {
                throw new VerificationCodeMismatchException();
            }

        } catch (ModelNotFoundException $e) {
            return $this->error(Message::NOT_FOUND, 404);
        } catch (VerificationCodeMismatchException $e) {
            return $this->error(Message::CODE_MISMATCH, 409);
        } catch (Throwable $e) {
            return $this->error(Message::SOMETHING_WENT_WRONG, 500);
        }

        /** @var User $user */
        $user = User::query()
            ->where('email', $request->email)
            ->firstOrFail();

        if (!$token = JWTAuth::fromUser($user)) {
            return $this->error(Message::SOMETHING_WENT_WRONG, 500);
        }

        RegisterEmailJob::dispatch($user);

        return $this->success([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function resend(ResendRequest $request): JsonResponse {

        VerificationCode::query()
            ->where('email', $request->email)
            ->delete();

        SendVerificationEmailJob::dispatch($request->email);

        return $this->success();
    }

    public function heartbeat(): JsonResponse {
        return $this->success();
    }

    public function login(LoginRequest $request): JsonResponse {

        $credentials = $request->only(['email', 'password']);

        try {
            /** @var User $user */
            $user = User::query()
            ->with(['merchant', 'planner'])
            ->where('email', $credentials['email'])
            ->whereHas($request->type)
            ->firstOrFail();
            

            if ($user->verificationCodes->isNotEmpty()) {
                throw new EmailNotVerifiedException();
            }

            PasswordReset::query()
                ->where('email', $user->email)
                ->delete();

            if ($user->merchant) {
                if (!$user->merchant->stripe_connect_id) {
                    
                    $account = self::createConnectAccount();

                    $user->merchant->stripe_connect_id = $account->id;
                    $user->merchant->saveOrFail();
                }

                $accountId = $user->merchant->stripe_connect_id;
                $account = Account::retrieve($accountId);
                $links = AccountLink::create([
                    'account' => $accountId,
                    'type' => 'account_onboarding',
                    'refresh_url' => env('STRIPE_CONNECT_REDIRECT_URL'),
                    'return_url' => env('STRIPE_CONNECT_REFRESH_URL'),
                ]);
                $user->merchant->links = $links;
                $user->merchant->onboarding_complete = $account->charges_enabled;
            }

        } catch (EmailNotVerifiedException $e) {
            return $this->error(Message::NOT_VERIFIED, 403);
        } catch (ModelNotFoundException $e) {
            return $this->error(Message::WRONG_CREDENTIALS, 404);
        } catch (Throwable $e) {
            return $this->error(Message::SOMETHING_WENT_WRONG, 500);
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->error(Message::WRONG_CREDENTIALS, 404);
        }

        return $this->success([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function logout(): JsonResponse {
        auth('api')->logout();

        return $this->success();
    }

    public function refresh(): JsonResponse {
        return $this->success([
            'user' => auth('api')->user(),
            'access_token' => auth('api')->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse {
        ForgotPasswordEmailJob::dispatch($request->email);

        return $this->success();
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse {

        /** @var PasswordReset $passwordReset */
        $passwordReset = PasswordReset::query()
            ->where('email', $request->email)
            ->firstOrFail();

        /** @var User $user */
        $user = User::query()
            ->where('email', $request->email)
            ->firstOrFail();

        if (!password_verify($request->code, $passwordReset->code)) {
            return $this->error(Message::RESET_CODE_MISMATCH, 409);
        }

        DB::beginTransaction();

        try {

            $user->password = Hash::make($request->password);
            $user->saveOrFail();

            $deleted = $passwordReset->delete();

            if (!$deleted) {
                throw new Exception();
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Message::SOMETHING_WENT_WRONG, 500);
        }

        return $this->success();
    }

    private static function createConnectAccount(): Account {
        $account = Account::create([
            'country' => 'US',
            'type' => 'express',
        ]);

        Account::update($account->id, [
            'settings' => [
                'payouts' => [
                    'schedule' => [
                        'interval' => 'manual',
                    ],
                ],
            ],
        ]);

        return $account;
    }
}
