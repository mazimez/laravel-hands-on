<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    //Using the trait created trait branch
    use ApiResponser;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        //handling the different exceptions of laravel in our custom way
        if (request()->is('*api/*')) {

            if ($exception instanceof QueryException) {
                $errorCode = $exception->errorInfo[1];

                if ($errorCode == 1451) {
                    return $this->errorResponse(__('messages.can_not_remove_this'), 409);
                }
            }

            if ($exception instanceof ValidationException) {
                return $this->validationResponse($exception, $request);
            }

            if ($exception instanceof ModelNotFoundException) {
                $modelName = strtolower(class_basename($exception->getModel()));
                return $this->errorResponse(__('messages.model_not_exists'), 200);
            }

            if ($exception instanceof AuthenticationException) {
                return $this->unauthenticatedResponse($request, $exception);
            }

            if ($exception instanceof AuthorizationException) {
                return $this->errorResponse($exception->getMessage(), 403);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse(__('messages.invalid_method'), 405);
            }

            if ($exception instanceof NotFoundHttpException) {
                return $this->errorResponse(__('messages.url_not_found'), 403);
            }

            if ($exception instanceof HttpException) {
                return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
            }


            if (config('app.debug')) {
                return parent::render($request, $exception);
            }

            return $this->errorResponse($exception->getMessage(), 500);
        } else {
            return parent::render($request, $exception);
        }
    }



    //creating some of our own methods to use for exception handling
    protected function validationResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        foreach ($errors as $field => $messages) {
            $errors = $messages[0];
        }
        return $this->errorResponse($errors, 200);
    }

    protected function unauthenticatedResponse($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Unauthenticated.',
            'status' => '401',
        ], 401);
    }

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
