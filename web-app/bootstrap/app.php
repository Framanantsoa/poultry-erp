<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            $status = $response->getStatusCode();

            // ─── Skip non-HTML requests ───
            if ($status < 400 || $status >= 600) {
                return $response;
            }

            // If the client expects JSON (API calls), let Laravel handle it
            if ($request->expectsJson() && !$request->header('X-Inertia')) {
                return $response;
            }

            // ─── Handle 404 → standalone page ───
            if ($status === 404) {
                return Inertia::render('Errors/404', [
                    'message' => app()->isLocal() ? $exception->getMessage() : null,
                ])
                    ->toResponse($request)
                    ->setStatusCode($status);
            }

            // ─── Handle other errors → Standard page (with layout) ───
            $handled = [401, 403, 419, 429, 500, 503];

            if (in_array($status, $handled, true)) {
                return Inertia::render('Errors/Standard', [
                    'status' => $status,
                    'message' => app()->isLocal() ? $exception->getMessage() : null,
                ])
                    ->toResponse($request)
                    ->setStatusCode($status);
            }

            return $response;
        });
    })->create();
