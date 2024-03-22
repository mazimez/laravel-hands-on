<?php

use App\Http\Middleware\HandleLocalization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Traits\ExceptionHandler;
use App\Traits\RouteHandler;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: RouteHandler::configureApiVersioning(),
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(HandleLocalization::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReport([
            MethodNotAllowedHttpException::class,
        ]);
        ExceptionHandler::handleApiException($exceptions);
    })->create();