<?php declare(strict_types=1);

namespace Shopware\Core\Content\Rule\Aggregate\RuleCondition;

use Shopware\Core\Content\Rule\RuleEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class RuleConditionEntity extends Entity
{
    use EntityIdTrait;
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $ruleId;

    /**
     * @var string|null
     */
    protected $parentId;

    /**
     * @var array|null
     */
    protected $value;

    /**
     * @var RuleEntity|null
     */
    protected $rule;

    /**
     * @var RuleConditionCollection|null
     */
    protected $children;

    /**
     * @var RuleConditionEntity|null
     */
    protected $parent;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var array|null
     */
    protected $attributes;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getRuleId(): string
    {
        return $this->ruleId;
    }

    public function setRuleId(string $ruleId): void
    {
        $this->ruleId = $ruleId;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function setParentId(?string $parentId): void
    {
        $this->parentId = $parentId;
    }

    public function getValue(): ?array
    {
        return $this->value;
    }

    public function setValue(?array $value): void
    {
        $this->value = $value;
    }

    public function getRule(): ?RuleEntity
    {
        return $this->rule;
    }

    public function setRule(?RuleEntity $rule): void
    {
        $this->rule = $rule;
    }

    public function getChildren(): ?RuleConditionCollection
    {
        return $this->children;
    }

    public function setChildren(?RuleConditionCollection $children): void
    {
        $this->children = $children;
    }

    public function getParent(): ?RuleConditionEntity
    {
        return $this->parent;
    }

    public function setParent(?RuleConditionEntity $parent): void
    {
        $this->parent = $parent;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function setAttributes(?array $attributes): void
    {
        $this->attributes = $attributes;
    }
}
