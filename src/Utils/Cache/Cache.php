<?php


namespace App\Utils\Cache;


interface Cache
{

    public function getValueFromCache(string $key);

    public function setValueToCache(string $key, $value, int $ttl);

}