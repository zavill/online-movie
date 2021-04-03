<?php


namespace App\Utils\Cache\Adapter;


interface CacheInterface
{

    public function getValueFromCache(string $key);

    public function setValueToCache(string $key, $value, int $ttl);

}