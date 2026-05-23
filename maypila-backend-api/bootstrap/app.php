<?php

use App\Exceptions\AppBaseException;
use App\Http\Resources\ApiBaseResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    // Later, when enabling Laravel broadcasting, add:
    // ->withBroadcasting(__DIR__.'/../routes/channels.php')
    ->withMiddleware(function (Middleware $middleware): void {
        
        $middleware->alias([
            'role.check' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (AppBaseException $exception, Request $request) {
            $status = is_int($exception->getCode()) && $exception->getCode() >= 400 && $exception->getCode() < 600
                ? $exception->getCode()
                : 400;

            return ApiBaseResponse::error(
                $exception->getMessage(),
                $status,
                $exception->getMeta()
            );
        });

        $exceptions->render(function (Throwable $exception, Request $request) {

            Log::error($exception->getMessage(), [
                'exception' => get_class($exception),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
                'stack_trace' => $exception->getTraceAsString(),
            ]);

            return ApiBaseResponse::error(
                'Internal server error, check exception logs!',
                500
            );
        });

    })->create();
