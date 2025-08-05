<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    public static function redirectTo()
    {
        // Check if user is authenticated with any guard
        $user = Auth::user() ?? Auth::guard('doctor')->user() ?? Auth::guard('patient')->user();
        
        if (!$user) {
            return '/';
        }

        return match ($user->role) {
            'admin' => '/admin/dashboard',
            'doctor' => '/doctors/dashboard',
            'patient' => '/patient/home',
            default => '/',
        };
    }
}
