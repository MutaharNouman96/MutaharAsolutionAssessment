<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Middleware\ApiJsonResponseMiddleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php', //
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function ($middleware) {
        $middleware->append(EnsureFrontendRequestsAreStateful::class); // Add Sanctum Middleware
        $middleware->append(ApiJsonResponseMiddleware::class); //register a middlware

        // $middleware->append(SubstituteBindings::class); // Ensure route model binding
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        // custom response sanctum
       
    })->create();
