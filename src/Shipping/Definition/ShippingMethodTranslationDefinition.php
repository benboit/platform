<?php declare(strict_types=1);

namespace Shopware\Shipping\Definition;

use Shopware\Api\Entity\EntityDefinition;
use Shopware\Api\Entity\EntityExtensionInterface;
use Shopware\Api\Entity\Field\FkField;
use Shopware\Api\Entity\Field\LongTextField;
use Shopware\Api\Entity\Field\ManyToOneAssociationField;
use Shopware\Api\Entity\Field\StringField;
use Shopware\Api\Entity\FieldCollection;
use Shopware\Api\Entity\Write\Flag\PrimaryKey;
use Shopware\Api\Entity\Write\Flag\Required;
use Shopware\Shipping\Collection\ShippingMethodTranslationBasicCollection;
use Shopware\Shipping\Collection\ShippingMethodTranslationDetailCollection;
use Shopware\Shipping\Event\ShippingMethodTranslation\ShippingMethodTranslationWrittenEvent;
use Shopware\Shipping\Repository\ShippingMethodTranslationRepository;
use Shopware\Shipping\Struct\ShippingMethodTranslationBasicStruct;
use Shopware\Shipping\Struct\ShippingMethodTranslationDetailStruct;
use Shopware\Shop\Definition\ShopDefinition;

class ShippingMethodTranslationDefinition extends EntityDefinition
{
    /**
     * @var FieldCollection
     */
    protected static $primaryKeys;

    /**
     * @var FieldCollection
     */
    protected static $fields;

    /**
     * @var EntityExtensionInterface[]
     */
    protected static $extensions = [];

    public static function getEntityName(): string
    {
        return 'shipping_method_translation';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            (new FkField('shipping_method_uuid', 'shippingMethodUuid', ShippingMethodDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new FkField('language_uuid', 'languageUuid', ShopDefinition::class))->setFlags(new PrimaryKey(), new Required()),
            (new StringField('name', 'name'))->setFlags(new Required()),
            new LongTextField('description', 'description'),
            new StringField('comment', 'comment'),
            new ManyToOneAssociationField('shippingMethod', 'shipping_method_uuid', ShippingMethodDefinition::class, false),
            new ManyToOneAssociationField('language', 'language_uuid', ShopDefinition::class, false),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return ShippingMethodTranslationRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return ShippingMethodTranslationBasicCollection::class;
    }

    public static function getWrittenEventClass(): string
    {
        return ShippingMethodTranslationWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return ShippingMethodTranslationBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return null;
    }

    public static function getDetailStructClass(): string
    {
        return ShippingMethodTranslationDetailStruct::class;
    }

    public static function getDetailCollectionClass(): string
    {
        return ShippingMethodTranslationDetailCollection::class;
    }
}