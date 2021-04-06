## **ElasticSearch**

Сервис для работы с ElasticSearch. Его задачей является удобная работа с ElasticSearch посредством сущностей.

## Создание сущности

После создания сущности в Symfony, необходимо:

1. Добавить поля, которые будут сохраняться в Elastic,
  в [PropertyMapping](/src/Service/ElasticSearch/PropertyMapping.php).
2. Создать Indexer в директории `src/Service/ElasticSearch/Indexer`. У Indexer'a должен быть создан
  метод `initializeEntity`, в котором вы должны заполнить свойства `mapping` и `index`.

```php
protected function initializeEntity()
{
    $this->mapping = PropertyMapping::$serialMapping;
    $this->index = 'serial';
}
```
    mapping - свойство, которое вы создавали на первом шаге
    index - индекс, в котором хранятся элементы в ElasticSearch 