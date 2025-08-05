<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class CsrfHelper
{
    /**
     * Lấy CSRF token hiện tại hoặc tạo mới
     */
    public static function getToken()
    {
        if (!Session::has('_token')) {
            Session::regenerateToken();
        }
        
        return Session::token();
    }

    /**
     * Kiểm tra và refresh token nếu cần
     */
    public static function refreshTokenIfNeeded()
    {
        if (!Session::has('_token') || !Session::token()) {
            Session::regenerateToken();
        }
    }

    /**
     * Tạo meta tag cho CSRF token
     */
    public static function metaTag()
    {
        return '<meta name="csrf-token" content="' . self::getToken() . '">';
    }
} 