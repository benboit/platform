<?php declare(strict_types=1);

namespace Shopware\Api\User\Collection;

use Shopware\Api\Entity\EntityCollection;
use Shopware\Api\User\Struct\UserBasicStruct;

class UserBasicCollection extends EntityCollection
{
    /**
     * @var UserBasicStruct[]
     */
    protected $elements = [];

    public function get(string $uuid): ? UserBasicStruct
    {
        return parent::get($uuid);
    }

    public function current(): UserBasicStruct
    {
        return parent::current();
    }

    public function getLocaleUuids(): array
    {
        return $this->fmap(function (UserBasicStruct $user) {
            return $user->getLocaleUuid();
        });
    }

    public function filterByLocaleUuid(string $uuid): self
    {
        return $this->filter(function (UserBasicStruct $user) use ($uuid) {
            return $user->getLocaleUuid() === $uuid;
        });
    }

    public function getRoleUuids(): array
    {
        return $this->fmap(function (UserBasicStruct $user) {
            return $user->getRoleUuid();
        });
    }

    public function filterByRoleUuid(string $uuid): self
    {
        return $this->filter(function (UserBasicStruct $user) use ($uuid) {
            return $user->getRoleUuid() === $uuid;
        });
    }

    protected function getExpectedClass(): string
    {
        return UserBasicStruct::class;
    }
}