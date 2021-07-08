<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Mi\Core\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response as HttpStatusCode;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $statusCode = HttpStatusCode::HTTP_BAD_REQUEST;
        $errors = [];
        $message = __('messages.errors.unhandled_exception');
        $messageCode = '';

        switch (true) {
            case $exception instanceof ValidationException:
                /** \Illuminate\Validation\ValidationException $exception */
                $message = __('messages.errors.validation_error');
                $errors = $exception->errors();
                $statusCode = HttpStatusCode::HTTP_UNPROCESSABLE_ENTITY;
                break;

            case $exception instanceof NotFoundHttpException:
            case $exception instanceof MethodNotAllowedHttpException:
            case $exception instanceof AccessDeniedHttpException:
                $message = __('messages.errors.route_not_found');
                $statusCode = HttpStatusCode::HTTP_NOT_FOUND;
                $messageCode = 'route.not_found';
                break;

            case $exception instanceof AuthorizationException:
                $message = __('messages.auth.unauthorized');
                $statusCode = HttpStatusCode::HTTP_NOT_FOUND;
                $messageCode = 'auth.unauthorized';
                break;

            case $exception instanceof ModelNotFoundException:
                $message = __('messages.errors.record_not_found');
                $statusCode = HttpStatusCode::HTTP_NOT_FOUND;
                $messageCode = 'record.not_found';
                break;

            case $exception instanceof JWTException:
            case $exception instanceof TokenInvalidException:
            case $exception instanceof TokenBlacklistedException:
            case $exception instanceof AuthenticationException:
                $message = __('messages.auth.invalid_token');
                $statusCode = HttpStatusCode::HTTP_UNAUTHORIZED;
                $messageCode = 'auth.invalid_token';
                break;

            case $exception instanceof ThrottleRequestsException:
                $message = __('messages.errors.throttle_request');
                $statusCode = HttpStatusCode::HTTP_TOO_MANY_REQUESTS;
                $messageCode = 'request.max_attemps';
                break;

            case $exception instanceof BaseException:
                $message = $exception->getMessage();
                $messageCode = method_exists($exception, 'getMessageCode') ? $exception->getMessageCode() : null;
                $statusCode = $exception->getCode();
                break;

            default:
                break;
        }

        return $request->is('api/*')
            ? response()->json([
                'code' => $messageCode,
                'errors' => $errors,
                'message' => $message,
            ], $statusCode) : response($message, HttpStatusCode::HTTP_BAD_REQUEST);
    }
}
