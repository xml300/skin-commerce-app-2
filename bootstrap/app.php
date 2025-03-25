<?php

use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RedirectMiddleware;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\UpdateCartMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        /**
         * The application's route middleware groups.
         *
         * @var array<string, array<int, string>>
         */
        $middleware->appendToGroup('web', [
            UpdateCartMiddleware::class,
            TrustProxies::class
        ]);
    
        // $middleware->appendToGroup('api', [
        //         'throttle:api',
        // ]);


        $middleware->alias([
           'auth.user' => AuthMiddleware::class,
           'user' => UserMiddleware::class,
           'auth.admin' => AdminAuthMiddleware::class,
           'update.cart' => UpdateCartMiddleware::class,
           'redirect' => RedirectMiddleware::class
        ]);
    
        /**
         * The application's middleware priority map.
         *
         * These middleware are always run in the listed order. Priority is from top to bottom.
         *
         * @var array<string>
         */
        $middleware->priority([
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\Authenticate::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Auth\Middleware\Authorize::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
