<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function setLanguage($language)
    {
        if (in_array($language, getSupportedLanguages())) {
            session()->put('locale', $language);
            app()->setLocale($language);
        }

        return $this;
    }
}