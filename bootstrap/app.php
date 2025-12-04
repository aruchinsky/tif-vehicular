<?php
// bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->registered(function ($app) {
        $app->usePublicPath(base_path('public'));
    })

    // ------------------------------------------------------------------------------
    // 🔵 RUTEO PRINCIPAL DEL SISTEMA
    // ------------------------------------------------------------------------------
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )

    // ------------------------------------------------------------------------------
    // 🔴 REGISTRO DE MIDDLEWARES (Laravel 12 reemplaza Kernel.php)
    // ------------------------------------------------------------------------------
    ->withMiddleware(function (Middleware $middleware) {

        // -------------------------------
        // Web, API, proxies, CSRF, etc.
        // -------------------------------
        $middleware
            ->web(append: [
                // AddLinkHeadersForPreloadedAssets::class,
            ])
            ->statefulApi()
            ->trustProxies('*');

        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);
        

        // --------------------------------------------------------
        // 🔥 AQUÍ REGISTRAMOS LOS MIDDLEWARES DE SPATIE (OBLIGATORIO)
        // --------------------------------------------------------
        $middleware->alias([
            'role'       => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);
    })

    // ------------------------------------------------------------------------------
    // 🟣 BROADCASTING (Reverb / Pusher / Websockets)
    // ------------------------------------------------------------------------------
    ->withBroadcasting(
        base_path('routes/channels.php'),
        attributes: ['middleware' => ['web', 'auth']]
    )

    // ------------------------------------------------------------------------------
    // ⚪ EXCEPCIONES
    // ------------------------------------------------------------------------------
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
