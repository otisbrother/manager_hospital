<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Redirect theo guard được sử dụng
            $guard = $this->getGuard($request);
            
            return match ($guard) {
                'doctor' => route('doctor.login'),
                'patient' => route('patient.login'),
                default => route('login'),
            };
        }
        
        return null;
    }
    
    /**
     * Get the guard that should be used for authentication.
     */
    protected function getGuard(Request $request): string
    {
        // Lấy guard từ route middleware
        $route = $request->route();
        if ($route) {
            $middleware = $route->middleware();
            foreach ($middleware as $middlewareName) {
                if (str_starts_with($middlewareName, 'auth:')) {
                    return substr($middlewareName, 5); // Lấy phần sau 'auth:'
                }
            }
        }
        
        return 'web'; // Default guard
    }
} 