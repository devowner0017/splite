<?php

namespace App\Exceptions;

use App\Utilities\Message;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler {

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register() {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e) {
        if ($request->expectsJson()) {
            if ($e instanceof UnauthorizedHttpException) {
                return response()->json(['message' => Message::UNAUTHORIZED], 403);
            }
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json(['message' => Message::NOT_FOUND], 404);
        }

        if ($e instanceof QueryException) {
            return response()->json(['message' => Message::SOMETHING_WENT_WRONG], 500);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json(['message' => Message::UNAUTHORIZED], 403);
        }

        if ($e instanceof ValidationException) {
            return parent::render($request, $e);
        }

        if ($e instanceof Throwable) {
            if (env('APP_ENV') === 'production') {
                return response()->json(['message' => Message::SOMETHING_WENT_WRONG], 500);
            }

            return response()->json([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }

        return parent::render($request, $e);
    }
}
