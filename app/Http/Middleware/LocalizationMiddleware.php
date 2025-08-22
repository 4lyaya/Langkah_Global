<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek jika bahasa disimpan di session
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            // Default bahasa dari config atau browser preference
            $browserLanguage = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            $supportedLanguages = ['en', 'id', 'zh'];

            if (in_array($browserLanguage, $supportedLanguages)) {
                App::setLocale($browserLanguage);
                Session::put('locale', $browserLanguage);
            } else {
                // Fallback ke bahasa default dari config
                App::setLocale(config('app.locale'));
            }
        }

        return $next($request);
    }
}