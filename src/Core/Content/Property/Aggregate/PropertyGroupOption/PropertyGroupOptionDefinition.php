<?php declare(strict_types=1);

namespace Shopware\Core\Content\Property\Aggregate\PropertyGroupOption;

use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Content\Product\Aggregate\ProductConfiguratorSetting\ProductConfiguratorSettingDefinition;
use Shopware\Core\Content\Product\Aggregate\ProductOption\ProductOptionDefinition;
use Shopware\Core\Content\Product\Aggregate\ProductProperty\ProductPropertyDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Content\Property\Aggregate\PropertyGroupOptionTranslation\PropertyGroupOptionTranslationDefinition;
use Shopware\Core\Content\Property\PropertyGroupDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ReverseInherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UpdatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class PropertyGroupOptionDefinition extends EntityDefinition
{
    public static function getEntityName(): string
    {
        return 'property_group_option';
    }

    public static function getCollectionClass(): string
    {
        return PropertyGroupOptionCollection::class;
    }

    public static function getEntityClass(): string
    {
        return PropertyGroupOptionEntity::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return PropertyGroupOptionTranslationDefinition::class;
    }

    public static function getParentDefinitionClass(): ?string
    {
        return PropertyGroupDefinition::class;
    }

    protected static function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('property_group_id', 'groupId', PropertyGroupDefinition::class))->addFlags(new Required()),
            (new TranslatedField('name'))->addFlags(new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            new TranslatedField('position'),
            new StringField('color_hex_code', 'colorHexCode'),
            new FkField('media_id', 'mediaId', MediaDefinition::class),
            new TranslatedField('attributes'),
            new CreatedAtField(),
            new UpdatedAtField(),
            new ManyToOneAssociationField('media', 'media_id', MediaDefinition::class, 'id', true),
            new ManyToOneAssociationField('group', 'property_group_id', PropertyGroupDefinition::class, 'id', false),
            (new TranslationsAssociationField(PropertyGroupOptionTranslationDefinition::class, 'property_group_option_id'))->addFlags(new Required()),
            (new OneToManyAssociationField('productConfiguratorSettings', ProductConfiguratorSettingDefinition::class, 'property_group_option_id', 'id'))->addFlags(new CascadeDelete()),
            (new ManyToManyAssociationField('productProperties', ProductDefinition::class, ProductPropertyDefinition::class, 'property_group_option_id', 'product_id'))->addFlags(new CascadeDelete(), new ReverseInherited('properties')),
            (new ManyToManyAssociationField('productOptions', ProductDefinition::class, ProductOptionDefinition::class, 'property_group_option_id', 'product_id'))->addFlags(new CascadeDelete()),
        ]);
    }
}
