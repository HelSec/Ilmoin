<?php

namespace App\Utils;

use Carbon\Carbon;
use DateTime;

class Date
{
    /**
     * @param $string string
     * @return Carbon|null
     */
    public static function fromString($string)
    {
        if ($string === null) {
            return null;
        }

        return Carbon::createFromTimeString($string, config('app.timezone'));
    }

    /**
     * @param $datetime string|DateTime
     * @return string|null
     */
    public static function format($datetime)
    {
        if ($datetime === null) {
            return null;
        }

        if (is_string($datetime)) {
            $datetime = self::fromString($datetime);
        }

        $carbon = Carbon::instance($datetime)
            ->setTimezone(env('TIMEZONE', 'UTC'));

        return $carbon->format('Y-m-d H:i') . ' ' . strtoupper($carbon->getTimezone()->getAbbreviatedName());
    }
}
