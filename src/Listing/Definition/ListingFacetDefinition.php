<?php declare(strict_types=1);

namespace Shopware\Listing\Definition;

use Shopware\Api\Entity\EntityDefinition;
use Shopware\Api\Entity\EntityExtensionInterface;
use Shopware\Api\Entity\Field\BoolField;
use Shopware\Api\Entity\Field\DateField;
use Shopware\Api\Entity\Field\IntField;
use Shopware\Api\Entity\Field\LongTextField;
use Shopware\Api\Entity\Field\StringField;
use Shopware\Api\Entity\Field\TranslatedField;
use Shopware\Api\Entity\Field\TranslationsAssociationField;
use Shopware\Api\Entity\Field\UuidField;
use Shopware\Api\Entity\FieldCollection;
use Shopware\Api\Entity\Write\Flag\PrimaryKey;
use Shopware\Api\Entity\Write\Flag\Required;
use Shopware\Listing\Collection\ListingFacetBasicCollection;
use Shopware\Listing\Collection\ListingFacetDetailCollection;
use Shopware\Listing\Event\ListingFacet\ListingFacetWrittenEvent;
use Shopware\Listing\Repository\ListingFacetRepository;
use Shopware\Listing\Struct\ListingFacetBasicStruct;
use Shopware\Listing\Struct\ListingFacetDetailStruct;

class ListingFacetDefinition extends EntityDefinition
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
        return 'listing_facet';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            (new UuidField('uuid', 'uuid'))->setFlags(new PrimaryKey(), new Required()),
            (new StringField('unique_key', 'uniqueKey'))->setFlags(new PrimaryKey(), new Required()),
            (new LongTextField('payload', 'payload'))->setFlags(new Required()),
            (new TranslatedField(new StringField('name', 'name')))->setFlags(new Required()),
            new BoolField('active', 'active'),
            new BoolField('display_in_categories', 'displayInCategories'),
            new BoolField('deletable', 'deletable'),
            new IntField('position', 'position'),
            new DateField('created_at', 'createdAt'),
            new DateField('updated_at', 'updatedAt'),
            (new TranslationsAssociationField('translations', ListingFacetTranslationDefinition::class, 'listing_facet_uuid', false, 'uuid'))->setFlags(new Required()),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return ListingFacetRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return ListingFacetBasicCollection::class;
    }

    public static function getWrittenEventClass(): string
    {
        return ListingFacetWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return ListingFacetBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return ListingFacetTranslationDefinition::class;
    }

    public static function getDetailStructClass(): string
    {
        return ListingFacetDetailStruct::class;
    }

    public static function getDetailCollectionClass(): string
    {
        return ListingFacetDetailCollection::class;
    }
}