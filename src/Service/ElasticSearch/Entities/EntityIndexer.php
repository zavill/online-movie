<?php


namespace App\Service\ElasticSearch\Entities;


use App\Service\ElasticSearch\Indexer;
use Elasticsearch\Client;
use ErrorException;
use Psr\Log\LoggerInterface;

abstract class EntityIndexer extends Indexer
{
    protected array $mapping;
    protected string $index;

    private LoggerInterface $logger;

    public function __construct(Client $elastic, LoggerInterface $logger)
    {
        parent::__construct($elastic);

        $this->initializeEntity();
        $this->logger = $logger;
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
     */
    public function put($entity): array
    {
        try {
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
        } catch (ErrorException $exception) {
            $this->logger->critical($exception->getMessage());
        }
    }

    /**
     * Получение элемента по id
     *
     * @param int $id
     * @return array
     */
    public function get(int $id): array
    {
        try {
            if (empty($this->index)) {
                throw new ErrorException('Не задан индекс');
            }

            $query = [
                'index' => $this->index,
                'id' => $id
            ];

            return $this->getElastic()->get($query);
        } catch (ErrorException $exception) {
            $this->logger->critical($exception->getMessage());
            return [];
        }
    }

    /**
     * Поиск по свойствам элементов в ElasticSearch
     *
     * @param array $arFilter
     * @return array
     */
    public function search(array $arFilter): array
    {
        try {
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
        } catch (ErrorException $exception) {
            $this->logger->critical($exception->getMessage());
            return [];
        }
    }

}
