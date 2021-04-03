<?php


namespace App\Utils\Cache;


use App\Utils\Cache\Adapter\Redis;

class Cache
{

    public static function make($cacheName)
    {
        $cacheName = ucfirst($cacheName);
        $prefix = 'App\Utils\Cache\Adapter\\';

        if (class_exists($prefix . $cacheName)) {
            $class = $prefix . $cacheName;
            return new $class();
        } else {
            return new Redis(); //@todo: Заменить базовое кэширование на файловое
        }
    }

}