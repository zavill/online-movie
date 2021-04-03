<?php


namespace App\Utils\Cache\Adapter;

/**
 * Class Memcached
 * @package App\Utils\Cache\Adapter
 */
class Memcached implements CacheInterface
{

    public $memcached;

    public function __construct()
    {
        $this->memcached = new \Memcached();
    }

    public function getValueFromCache(string $key)
    {
        // TODO: Implement getValueFromCache() method.
    }

    public function setValueToCache(string $key, $value, int $ttl)
    {
        // TODO: Implement setValueToCache() method.
    }
}