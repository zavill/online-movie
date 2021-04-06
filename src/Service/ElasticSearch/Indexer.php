<?php


namespace App\Service\ElasticSearch;

use Elasticsearch\Client;

class Indexer
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
}