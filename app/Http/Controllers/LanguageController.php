<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        // Validasi bahasa yang didukung
        $supportedLanguages = ['en', 'id', 'zh'];

        if (!in_array($lang, $supportedLanguages)) {
            abort(400, 'Language not supported');
        }

        // Set bahasa di session
        Session::put('locale', $lang);

        // Set bahasa di aplikasi
        App::setLocale($lang);

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back()->with('success', __('messages.language_changed'));
    }
}