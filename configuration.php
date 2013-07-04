<?php
/*
 * Configuration
 * @author: Ah-Lun Tang (tang@ahlun.be)
 * @license: AGPLv3
 */

class Configuration
{
    private static $config;
    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized)
            return;

        # get config
        $ini_iso88591 = file_get_contents("config.ini");
        $ini_utf8     = iconv("ISO-8859-1", "UTF-8", $ini_iso88591);

        self::$config = parse_ini_string($ini_utf8, TRUE);
        self::$initialized = true;
    }

    public static function getconfig()
    {
        self::initialize();
        return self::$config;
    }
}
