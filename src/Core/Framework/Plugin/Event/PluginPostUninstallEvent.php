<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Plugin\Event;

use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\PluginEntity;

class PluginPostUninstallEvent extends PluginLifecycleEvent
{
    public const NAME = 'plugin.post.uninstall';

    /**
     * @var UninstallContext
     */
    private $context;

    public function __construct(PluginEntity $plugin, UninstallContext $context)
    {
        parent::__construct($plugin);
        $this->context = $context;
    }

    public function getContext(): UninstallContext
    {
        return $this->context;
    }
}
