<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Thêm các route API nếu cần thiết
        // 'api/*',
        // 'webhook/*',
    ];

    /**
     * Determine if the request has a valid CSRF token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (!$token && $request->header('X-XSRF-TOKEN')) {
            $token = urldecode($request->header('X-XSRF-TOKEN'));
        }

        return is_string($token) && hash_equals($request->session()->token(), $token);
    }
} 