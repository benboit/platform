<?php declare(strict_types=1);

namespace Shopware\Shop\Event\ShopTemplateConfigFormFieldValue;

use Shopware\Api\Entity\Search\UuidSearchResult;
use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Event\NestedEvent;

class ShopTemplateConfigFormFieldValueUuidSearchResultLoadedEvent extends NestedEvent
{
    const NAME = 'shop_template_config_form_field_value.uuid.search.result.loaded';

    /**
     * @var UuidSearchResult
     */
    protected $result;

    public function __construct(UuidSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): TranslationContext
    {
        return $this->result->getContext();
    }

    public function getResult(): UuidSearchResult
    {
        return $this->result;
    }
}