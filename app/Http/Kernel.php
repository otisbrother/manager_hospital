<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // middleware toàn cục...
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\CheckSession::class, // Thêm middleware kiểm tra session
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    // ✅ middleware dùng trong route (route middleware)
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'role' => \App\Http\Middleware\CheckRole::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'patient_session' => \App\Http\Middleware\CheckPatientSession::class,
        'patient_timeout' => \App\Http\Middleware\PatientSessionTimeout::class, // Thêm middleware timeout cho patient
        'doctor_auth' => \App\Http\Middleware\DoctorAuth::class, // Middleware cho doctor authentication
    ];
}
