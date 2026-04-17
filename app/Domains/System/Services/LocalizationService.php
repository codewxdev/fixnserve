<?php

namespace App\Domains\System\Services;

class LocalizationService
{
    public static function country()
    {
        return app('country');
    }

    public static function currency()
    {
        return app('currency');
    }

    public static function formatDate($date)
    {
        $country = self::country();

        return $date->format($country->date_format);
    }

    public static function formatNumber($number)
    {
        $country = self::country();

        return number_format(
            $number,
            2,
            $country->decimal_separator,
            $country->thousand_separator
        );
    }
}
