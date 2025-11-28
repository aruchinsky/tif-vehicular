<?php
// bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets; // Si lo necesitas

return Application::configure(basePath: dirname(__DIR__))
    ->registered(function ($app) {
        $app->usePublicPath(base_path('public'));
    })
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // Quita 'channels: __DIR__.'/../routes/channels.php',' de aquí
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->web(append: [
                // AddLinkHeadersForPreloadedAssets::class, // Si lo tenías
            ])
            // Solo si usas Sanctum para algo. Si es puramente JWT, no es estrictamente necesario para broadcast
            // pero no suele hacer daño si lo mantienes:
            ->statefulApi()
            ->trustProxies('*');
            // ->validateCsrfTokens();
        $middleware->validateCsrfTokens(except: [
            'api/*',
            // 'broadcasting/auth', // No es necesario si Apache lo envía a Node.js
        ]);
    })
    
    // ¡ESTO ES LO CLAVE! Usamos 'auth:api' (o el nombre de tu guard JWT)
    ->withBroadcasting(base_path('routes/channels.php'), attributes: ['middleware' => ['api', 'auth:api']]) // <--- ¡CAMBIO AQUÍ!
    ->withExceptions()
    ->create();