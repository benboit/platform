<?php declare(strict_types=1);

namespace Shopware\Shop\Repository;

use Shopware\Api\Entity\Read\EntityReaderInterface;
use Shopware\Api\Entity\RepositoryInterface;
use Shopware\Api\Entity\Search\AggregationResult;
use Shopware\Api\Entity\Search\Criteria;
use Shopware\Api\Entity\Search\EntityAggregatorInterface;
use Shopware\Api\Entity\Search\EntitySearcherInterface;
use Shopware\Api\Entity\Search\UuidSearchResult;
use Shopware\Api\Entity\Write\EntityWriterInterface;
use Shopware\Api\Entity\Write\GenericWrittenEvent;
use Shopware\Api\Entity\Write\WriteContext;
use Shopware\Context\Struct\TranslationContext;
use Shopware\Shop\Collection\ShopTemplateConfigFormFieldBasicCollection;
use Shopware\Shop\Collection\ShopTemplateConfigFormFieldDetailCollection;
use Shopware\Shop\Definition\ShopTemplateConfigFormFieldDefinition;
use Shopware\Shop\Event\ShopTemplateConfigFormField\ShopTemplateConfigFormFieldAggregationResultLoadedEvent;
use Shopware\Shop\Event\ShopTemplateConfigFormField\ShopTemplateConfigFormFieldBasicLoadedEvent;
use Shopware\Shop\Event\ShopTemplateConfigFormField\ShopTemplateConfigFormFieldDetailLoadedEvent;
use Shopware\Shop\Event\ShopTemplateConfigFormField\ShopTemplateConfigFormFieldSearchResultLoadedEvent;
use Shopware\Shop\Event\ShopTemplateConfigFormField\ShopTemplateConfigFormFieldUuidSearchResultLoadedEvent;
use Shopware\Shop\Struct\ShopTemplateConfigFormFieldSearchResult;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ShopTemplateConfigFormFieldRepository implements RepositoryInterface
{
    /**
     * @var EntityReaderInterface
     */
    private $reader;

    /**
     * @var EntityWriterInterface
     */
    private $writer;

    /**
     * @var EntitySearcherInterface
     */
    private $searcher;

    /**
     * @var EntityAggregatorInterface
     */
    private $aggregator;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        EntityReaderInterface $reader,
        EntityWriterInterface $writer,
        EntitySearcherInterface $searcher,
        EntityAggregatorInterface $aggregator,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->reader = $reader;
        $this->writer = $writer;
        $this->searcher = $searcher;
        $this->aggregator = $aggregator;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function search(Criteria $criteria, TranslationContext $context): ShopTemplateConfigFormFieldSearchResult
    {
        $uuids = $this->searchUuids($criteria, $context);

        $entities = $this->readBasic($uuids->getUuids(), $context);

        $aggregations = null;
        if ($criteria->getAggregations()) {
            $aggregations = $this->aggregate($criteria, $context);
        }

        $result = ShopTemplateConfigFormFieldSearchResult::createFromResults($uuids, $entities, $aggregations);

        $event = new ShopTemplateConfigFormFieldSearchResultLoadedEvent($result);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $result;
    }

    public function aggregate(Criteria $criteria, TranslationContext $context): AggregationResult
    {
        $result = $this->aggregator->aggregate(ShopTemplateConfigFormFieldDefinition::class, $criteria, $context);

        $event = new ShopTemplateConfigFormFieldAggregationResultLoadedEvent($result);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $result;
    }

    public function searchUuids(Criteria $criteria, TranslationContext $context): UuidSearchResult
    {
        $result = $this->searcher->search(ShopTemplateConfigFormFieldDefinition::class, $criteria, $context);

        $event = new ShopTemplateConfigFormFieldUuidSearchResultLoadedEvent($result);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $result;
    }

    public function readBasic(array $uuids, TranslationContext $context): ShopTemplateConfigFormFieldBasicCollection
    {
        /** @var ShopTemplateConfigFormFieldBasicCollection $entities */
        $entities = $this->reader->readBasic(ShopTemplateConfigFormFieldDefinition::class, $uuids, $context);

        $event = new ShopTemplateConfigFormFieldBasicLoadedEvent($entities, $context);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $entities;
    }

    public function readDetail(array $uuids, TranslationContext $context): ShopTemplateConfigFormFieldDetailCollection
    {
        /** @var ShopTemplateConfigFormFieldDetailCollection $entities */
        $entities = $this->reader->readDetail(ShopTemplateConfigFormFieldDefinition::class, $uuids, $context);

        $event = new ShopTemplateConfigFormFieldDetailLoadedEvent($entities, $context);
        $this->eventDispatcher->dispatch($event->getName(), $event);

        return $entities;
    }

    public function update(array $data, TranslationContext $context): GenericWrittenEvent
    {
        $affected = $this->writer->update(ShopTemplateConfigFormFieldDefinition::class, $data, WriteContext::createFromTranslationContext($context));
        $event = GenericWrittenEvent::createFromWriterResult($affected, $context, []);
        $this->eventDispatcher->dispatch(GenericWrittenEvent::NAME, $event);

        return $event;
    }

    public function upsert(array $data, TranslationContext $context): GenericWrittenEvent
    {
        $affected = $this->writer->upsert(ShopTemplateConfigFormFieldDefinition::class, $data, WriteContext::createFromTranslationContext($context));
        $event = GenericWrittenEvent::createFromWriterResult($affected, $context, []);
        $this->eventDispatcher->dispatch(GenericWrittenEvent::NAME, $event);

        return $event;
    }

    public function create(array $data, TranslationContext $context): GenericWrittenEvent
    {
        $affected = $this->writer->insert(ShopTemplateConfigFormFieldDefinition::class, $data, WriteContext::createFromTranslationContext($context));
        $event = GenericWrittenEvent::createFromWriterResult($affected, $context, []);
        $this->eventDispatcher->dispatch(GenericWrittenEvent::NAME, $event);

        return $event;
    }
}