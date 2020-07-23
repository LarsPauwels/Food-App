<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Helpers\ErrorHandler as ErrorHelper;
use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class Handler extends ExceptionHandler
{
    private $notFoundCode = 404;
    private $authCode = 401;
    private $forbiddenCode = 403;
    private $tokenCode = 419;
    private $methodCode = 405;

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
     * @throws \Exception
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

        if ($exception instanceof NotFoundHttpException) {
            $message = 'Page could not be found.';
            return ErrorHelper::exceptions($message, $this->notFoundCode);
        }

        if ($exception instanceof ModelNotFoundException) {
            $message = 'Resource item (Model) could not be found.';
            return ErrorHelper::exceptions($message, $this->notFoundCode);
        }

        if ($exception instanceof AuthenticationException) {
            $message = 'You are unauthorized to do this action.';
            return ErrorHelper::exceptions($message, $this->authCode);
        }

        if ($exception instanceof AuthorizationException) {
            $message = 'You are unauthorized to do this action.';
            return ErrorHelper::exceptions($message, $this->forbiddenCode);
        }

        if ($exception instanceof TokenMismatchException) {
            $message = 'Your token is incorrect or expired.';
            return ErrorHelper::exceptions($message, $this->tokenCode);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $message = 'You do not have access to this medthod or the method does not exist.';
            return ErrorHelper::exceptions($message, $this->methodCode);
        }

        return parent::render($request, $exception);
    }
}
