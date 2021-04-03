<?php


namespace App\Utils\Cache\Adapter;


use Symfony\Component\Cache\Adapter\RedisAdapter;

/**
 * Класс для работы с кэшем Redis
 *
 * Class Redis
 * @package App\Utils\Cache\Adapter
 */
class Redis implements CacheInterface
{

    private $client;

    public function __construct()
    {
        $this->client = RedisAdapter::createConnection('redis://127.0.0.1:6379');
    }

    public function getValueFromCache(string $key)
    {
        return json_decode($this->client->get($key), JSON_UNESCAPED_UNICODE);
    }

    public function setValueToCache(string $key, $value, int $ttl = 3600)
    {
        $this->client->set($key, json_encode($value), $ttl);
    }
}