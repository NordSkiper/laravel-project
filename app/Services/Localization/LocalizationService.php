<?php

namespace App\Services\Localization;

use Illuminate\Support\Facades\Config;

class LocalizationService implements LocalizationServiceInterface
{

    public static function localize()
    {
        $locale = request()->segment(1, '');

        if ($locale && in_array($locale, Config::get('app.languages'))) {
            app()->setLocale($locale);
            return $locale;
        } else {
            return 'en';
        }

    }
}
