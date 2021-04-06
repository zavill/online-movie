<?php


namespace App\Service\ElasticSearch\Indexer;


use App\Service\ElasticSearch\PropertyMapping;

class AnimeIndexer extends AbstractEntityIndexer
{
    protected function initializeEntity()
    {
        $this->mapping = PropertyMapping::$serialMapping;
        $this->index = 'serial';
    }
}