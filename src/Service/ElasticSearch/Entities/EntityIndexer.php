<?php


namespace App\Service\ElasticSearch\Entities;


use App\Service\ElasticSearch\Indexer;
use App\Service\ElasticSearch\PropertyMapping;
use Elasticsearch\Client;
use ErrorException;

abstract class EntityIndexer extends Indexer
{
    protected array $mapping;
    protected string $index;

    public function __construct(Client $elastic)
    {
        parent::__construct($elastic);

        $this->initializeEntity();
    }

    /**
     * Заполнение свойств mapping и index
     */
    abstract protected function initializeEntity();

    /**
     * Добавление элемента
     *
     * @param $entity
     * @return array
     * @throws ErrorException
     */
    public function put($entity): array
    {
        if (empty($this->index)) {
            throw new ErrorException('Не задан индекс');
        } elseif (empty($this->mapping)) {
            throw new ErrorException("Отсутствует маппинг для сущности $entity");
        }

        foreach ($this->mapping as $property => $typeProperty) {
            $methodName = 'get' . ucfirst($property);
            if (method_exists($entity, $methodName)) {
                throw new ErrorException("Свойство $property не доступно для чтения у сущности $entity");
            }
            $data[$property] = $entity->$methodName();
        }

        $arParams = [
            'index' => 'serial',
            'id' => $entity->getId(),
            'type' => '_doc',
            'body' => [
                'doc' => $data,
                'upsert' => $data
            ]
        ];

        return $this->getElastic()->update($arParams);
    }

    /**
     * Получение элемента по id
     *
     * @param int $id
     * @return array
     * @throws ErrorException
     */
    public function get(int $id): array
    {
        if (empty($this->index)) {
            throw new ErrorException('Не задан индекс');
        }

        $query = [
            'index' => $this->index,
            'id' => $id
        ];

        return $this->getElastic()->get($query);
    }

    /**
     * Поиск по свойствам элементов в ElasticSearch
     *
     * @param array $arFilter
     * @return array
     * @throws ErrorException
     */
    public function search(array $arFilter): array
    {
        if (empty($this->index)) {
            throw new ErrorException('Не задан индекс');
        }

        $query = [
            'index' => $this->index,
            'body' => [
                'query' => $this->prepareFilter($arFilter)
            ]
        ];

        return $this->getElastic()->search($query);
    }

}
