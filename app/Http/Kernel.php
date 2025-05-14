<?php

namespace App\Http; // Namespace untuk Kernel class

use Illuminate\Foundation\Http\Kernel as HttpKernel;

// Pastikan use statement untuk AdminMiddleware ada di sini atau di atas namespace
use App\Http\Middleware\AdminMiddleware;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // ... middleware global lainnya
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            // ... middleware web group lainnya
        ],

        'api' => [
            // ... middleware api group lainnya
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     * For Laravel 9 and below, this property is named $routeMiddleware.
     * For Laravel 10+, this property is named $middlewareAliases.
     *
     * @var array<string, class-string|string>
     */
    // Untuk Laravel 9 dan sebelumnya:
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        // TAMBAHKAN ALIAS ANDA DI SINI
        'admin' => \App\Http\Middleware\AdminMiddleware::class, // Lebih aman pakai Full Namespace
        // ATAU jika 'use App\Http\Middleware\AdminMiddleware;' ada di atas:
        // 'admin' => AdminMiddleware::class,
    ];

    // JIKA ANDA MENGGUNAKAN LARAVEL 10+ (seperti yang terlihat dari versi 12.13.0 di error):
    // Ganti $routeMiddleware dengan $middlewareAliases
    /*
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        // TAMBAHKAN ALIAS ANDA DI SINI
        'admin' => \App\Http\Middleware\AdminMiddleware::class, // Lebih aman pakai Full Namespace
        // ATAU jika 'use App\Http\Middleware\AdminMiddleware;' ada di atas:
        // 'admin' => AdminMiddleware::class,
    ];
    */
}