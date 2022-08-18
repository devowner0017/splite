<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Utilities\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentMethodController extends Controller {

    public function index(): JsonResponse {
        return $this->success(PaymentMethod::query()->where('user_id', Auth::user()->id)->get()->toArray());
    }

    public function store(CreatePaymentMethodRequest $request): JsonResponse {

        /** @var User $user */
        $user = Auth::user();

        $paymentMethod = new PaymentMethod();
        $paymentMethod->fill($request->validated());
        $paymentMethod->user_id = $user->id;

        if (!PaymentMethod::query()->where('user_id', $user->id)->first()) {
            $paymentMethod->primary = 1;
        }

        $paymentMethod->saveOrFail();

        return $this->success($paymentMethod->toArray(), [], 201);
    }

    public function update(PaymentMethod $paymentMethod): JsonResponse {

        DB::beginTransaction();

        try {

            PaymentMethod::query()
                ->where('user_id', Auth::user()->id)
                ->update(['primary' => 0]);

            $paymentMethod->primary = 1;
            $paymentMethod->saveOrFail();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Message::SOMETHING_WENT_WRONG, 500);
        }

        return $this->success($paymentMethod->toArray());
    }

    public function destroy(PaymentMethod $paymentMethod): JsonResponse {

        if ($paymentMethod->primary) {
            return $this->error(Message::PRIMARY_PAYMENT_METHOD, 403);
        }

        $paymentMethod->delete();

        return $this->success();
    }
}
