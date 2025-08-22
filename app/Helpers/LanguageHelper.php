<?php

if (!function_exists('getSupportedLanguages')) {
    function getSupportedLanguages()
    {
        return config('app.supported_languages', ['en']);
    }
}

if (!function_exists('getLanguageName')) {
    function getLanguageName($code)
    {
        $languages = [
            'en' => 'English',
            'id' => 'Indonesia',
            'zh' => '中文',
        ];

        return $languages[$code] ?? $code;
    }
}

if (!function_exists('getLanguageFlag')) {
    function getLanguageFlag($code)
    {
        $flags = [
            'en' => '🇺🇸',
            'id' => '🇮🇩',
            'zh' => '🇨🇳',
        ];

        return $flags[$code] ?? '🌐';
    }
}