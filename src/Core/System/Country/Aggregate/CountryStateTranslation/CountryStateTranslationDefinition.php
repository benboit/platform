<?php declare(strict_types=1);

namespace Shopware\Core\System\Country\Aggregate\CountryStateTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\AttributesField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Country\Aggregate\CountryState\CountryStateDefinition;

class CountryStateTranslationDefinition extends EntityTranslationDefinition
{
    public static function getEntityName(): string
    {
        return 'country_state_translation';
    }

    public static function getCollectionClass(): string
    {
        return CountryStateTranslationCollection::class;
    }

    public static function getEntityClass(): string
    {
        return CountryStateTranslationEntity::class;
    }

    public static function getParentDefinitionClass(): string
    {
        return CountryStateDefinition::class;
    }

    protected static function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            new AttributesField(),
        ]);
    }
}
