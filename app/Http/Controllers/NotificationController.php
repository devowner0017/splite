<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use App\Utilities\Message;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class NotificationController extends Controller {

    public function index() {
        return $this->success(UserNotification::query()->where('user_id', Auth::user()->id)->get()->toArray());
    }

    public function add(AddNotificationRequest $request) {

        /** @var User $user */
        $user = Auth::user();

        DB::beginTransaction();

        try {

            $exist = UserNotification::query()
                ->where('user_id', $user->id)
                ->first();

            if ($exist) {
                $deleted = UserNotification::query()
                    ->where('user_id', $user->id)
                    ->delete();

                if (!$deleted) {
                    throw new Exception(Message::SOMETHING_WENT_WRONG);
                }
            }

            foreach ($request->notification_ids as $notification_id) {
                $userNotification = new UserNotification();
                $userNotification->user_id = $user->id;
                $userNotification->notification_id = $notification_id;

                $userNotification->saveOrFail();
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->error(Message::SOMETHING_WENT_WRONG, 500);
        }

        return $this->success(UserNotification::query()->where('user_id', Auth::user()->id)->get()->toArray(), [], 201);
    }
}
