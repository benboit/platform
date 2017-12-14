<?php declare(strict_types=1);

namespace Shopware\Unit\Event\Unit;

use Shopware\Api\Entity\Write\WrittenEvent;
use Shopware\Unit\Definition\UnitDefinition;

class UnitWrittenEvent extends WrittenEvent
{
    const NAME = 'unit.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return UnitDefinition::class;
    }
}