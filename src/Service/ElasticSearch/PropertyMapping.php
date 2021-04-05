<?php


namespace App\Service\ElasticSearch;


class PropertyMapping
{

    public static array $serialMapping = [
        'id' => ['integer'],
        'name' => ['keyword'],
        'nameOrig' => ['keyword'],
        'shortDescription' => ['keyword'],
        'averageRating' => ['float']
    ];

}