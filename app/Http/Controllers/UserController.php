<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBankAccountRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Utilities\Message;
use App\Utilities\UserType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller {

    public function update(UpdateUserRequest $request): JsonResponse {

        /** @var User $user */
        $user = User::query()->findOrFail(Auth::user()->id);

        if (!$user->merchant && isset($request->user[UserType::MERCHANT])) {
            return $this->error(Message::USER_IS_NOT_MERCHANT, 400);
        }

        if (!$user->planner && isset($request->user[UserType::PLANNER])) {
            return $this->error(Message::USER_IS_NOT_PLANNER, 400);
        }

        $merchantData = isset($request->user[UserType::MERCHANT]) ? $request->user[UserType::MERCHANT] : [];
        $plannerData = isset($request->user[UserType::PLANNER]) ? $request->user[UserType::PLANNER] : [];
        $userData = array_diff_key($request->user, array_flip(UserType::all()));

        DB::beginTransaction();
        try {

            if ($merchant = $user->merchant) {
                $merchant->fill($merchantData);
                $merchant->saveOrFail();
            }

            if ($planner = $user->planner) {
                $planner->fill($plannerData);
                $planner->saveOrFail();
            }

            $user->fill($userData);
            $user->saveOrFail();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(['user' => $user->refresh()->toArray()]);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse {

        /** @var User $user */
        $user = Auth::user();
        $password = $request->password;
        $newPassword = $request->new_password;

        if (!password_verify($password, $user->password)) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        $user->password = Hash::make($newPassword);
        $user->saveOrFail();

        return $this->success($user->refresh()->toArray());
    }
}
