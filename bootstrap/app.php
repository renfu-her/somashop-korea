<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\VerifyCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/web.php',
            __DIR__ . '/../routes/backend.php',
        ],
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 使用 alias 方法為中間件設置別名
        $middleware->alias([
            'admin.auth' => AdminAuthMiddleware::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'admin/products/*/images/*',
            'admin/upload-image',
            'checkout/map/rewrite',
            'payment/*',
            'logout',
            'admin/orders/update-shipping-status',
            'admin/logout',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
