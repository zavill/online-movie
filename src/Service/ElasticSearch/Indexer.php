<?php


namespace App\Service\ElasticSearch;

use Elasticsearch\Client;

abstract class Indexer
{

    private Client $elastic;

    public function __construct(Client $elastic)
    {
        $this->elastic = $elastic;
    }

    /**
     * @return Client
     */
    public function getElastic(): Client
    {
        return $this->elastic;
    }

    protected function prepareFilter(array $arFilter): array
    {
        $normalizedFilter = [];
        foreach ($arFilter as $property => $value) {
            $normalizedFilter['must']['match'][$property] = $value;
        }

        return $normalizedFilter ? ['bool' => $normalizedFilter] : ['match_all' => new \stdClass()];
    }
}