<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Exceptions\MissingScopeException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];



    public function render($request, Throwable $exception)
    {
        // Handle token errors thrown by Passport
        if ($exception instanceof UnauthorizedHttpException) {
            $previous = $exception->getPrevious();

            if ($previous instanceof \League\OAuth2\Server\Exception\OAuthServerException) {
                return response()->json([
                    'message' => 'Invalid or expired token.',
                ], 401);
            }
        }

        // Handle scope-related errors (optional)
        if ($exception instanceof MissingScopeException) {
            return response()->json([
                'message' => 'You do not have the required scope to access this resource.',
            ], 403);
        }

        return parent::render($request, $exception);
    }




    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthenticated. Your token may be expired or invalid.',
            ], 401);
        }

        // return redirect()->guest(route('login'));
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
    }
}
