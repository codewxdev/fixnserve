<?php

if (! function_exists('currency')) {
    function currency()
    {
        return app('country')->currency_code;
    }
}

if (! function_exists('format_date')) {
    function format_date($date)
    {
        return $date->format(app('country')->date_format);
    }
}

if (! function_exists('format_number')) {
    function format_number($number)
    {
        $country = app('country');

        return number_format(
            $number,
            2,
            $country->decimal_separator,
            $country->thousand_separator
        );
    }
}
