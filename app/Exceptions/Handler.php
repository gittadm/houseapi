<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Render errors like JSON
        $this->renderable(function (Throwable $e, Request $request) {
            $data = ['status' => 'ERROR'] + $this->convertExceptionToArray($e);
            $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : null;
            $headers = $this->isHttpException($e) ? $e->getHeaders() : [];

            if ($status == 401 || $e instanceof AuthenticationException) {
                $data['message'] = 'Sorry, you are not authorized to access this data.';
                $status = 401;
            } elseif ($status == 403 || $e instanceof AuthorizationException) {
                $data['message'] = 'Sorry, you are forbidden from accessing this data.';
                $status = 403;
            } elseif ($status == 404 || $e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                $data['message'] = 'Sorry, the data you are looking for could not be found.';
                $status = 404;
            } elseif ($status == 405 || $e instanceof MethodNotAllowedException) {
                $data['message'] = 'Sorry, the request method is not allowed.';
                $status = 405;
            } elseif ($status == 422 || $e instanceof ValidationException) {
                $data['message'] = $e->validator->errors();
                $status = 422;
            } elseif ($status == 429 || $e instanceof TooManyRequestsHttpException) {
                $data['message'] = 'Sorry, you are making too many requests to our servers.';
                $status = 429;
            } elseif ($status == 503 || $e instanceof MaintenanceModeException) {
                $data['message'] = 'Sorry, we are doing some maintenance. Please check again soon.';
                $status = 503;
            } elseif ($e instanceof UsedInOtherTableException) {
                $data['message'] = 'Already used in other table';
                $status = 403;
            } elseif ($status == 419 || $e instanceof TokenMismatchException) {
                $data['message'] = 'Token mismatch';
                $status = 419;
            } else {
                $data['message'] = 'Whoops, something went wrong on our servers.';
                $status = 500;
            }

            return new JsonResponse($data, $status, $headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        });
    }
}
