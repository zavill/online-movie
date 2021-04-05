<?php


namespace App\Service\ElasticSearch;


use App\Entity\Anime;
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

    /**
     * Добавление сериала в индекс
     *
     * @param Anime $anime
     * @return array
     */
    public function putSerial(Anime $anime): array
    {
        foreach (PropertyMapping::$serialMapping as $property => $typeProperty) {
            $methodName = 'get'.ucfirst($property);
            $data[$property] = $anime->$methodName();
        }

        $arParams = [
            'index' => 'serial',
            'id' => $anime->getId(),
            'type' => '_doc',
            'body' => [
                'doc' => $data,
                'upsert' => $data
            ]
        ];

        return $this->getElastic()->update($arParams);
    }

}