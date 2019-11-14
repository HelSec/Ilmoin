<?php

namespace App\Utils;

use Exception;

class Version
{
    private static $version = "";

    /**
     * @return string
     */
    public static function getVersion()
    {
        if (!self::$version) {
            if (file_exists(__DIR__ . '/../../.git') && function_exists('exec')) {
                try {
                    $gitRevision = htmlspecialchars(trim(exec('git rev-parse --short HEAD')));

                    if (strlen($gitRevision) > 0) {
                        self::$version = " (<code><a href='https://github.com/helsec/ilmoin/commit/$gitRevision' class='hover:underline'>$gitRevision</a></code>)";
                    }
                } catch (Exception $ignored) {}
            }
        }

        return self::$version;
    }
}
