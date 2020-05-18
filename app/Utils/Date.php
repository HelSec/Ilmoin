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
     * @param $obj string|DateTime|Carbon
     * @return Carbon
     */
    public static function getCarbon($obj)
    {
        // String check
        if (is_string($obj)) {
            $obj = self::fromString($obj);
        }

        // This will return the same Carbon instance both for DateTime and Carbon objects
        return Carbon::instance($obj)
            ->setTimezone(env('TIMEZONE', 'UTC'));
    }

    /**
     * @param $datetime string|DateTime|Carbon
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

    /**
     * @param $from string|DateTime|Carbon
     * @param $to string|DateTime|Carbon
     * @return string|null
     */
    public static function diff($from, $to)
    {
        if ($from === null || $to === null) {
            return null;
        }

        // Make sure these are Carbon objects
        $from = self::getCarbon($from);
        $to = self::getCarbon($to);

        return $from->diffForHumans($to);
    }
}
