[titleEn]: <>(Decorating a service)

## Overview

Decorating a service with your plugin is as simple as it is in Symfony.
Make sure to have a look at the [Symfony guide about decorating services](https://symfony.com/doc/current/service_container/service_decoration.html).

## Decorating a service

The main requirement here is to have a `services.xml` file loaded in your plugin.
This can be achieved by placing the file into a `Resources/config` directory relative to your plugin's base class location.
Make sure to also have a look at the method [getContainerPath()](../2-internals/4-plugins/020-plugin-base-class.md#getContainerPath())

From here on, everything works exactly like in Symfony itself.

Here's an example `services.xml`:

```xml
<?xml version="1.0" ?>

<container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <services>
        <service id="Swag\ServiceDecoration\Service\MyService" />

        <service id="Swag\ServiceDecoration\Service\DecoratedService" decorates="Swag\ServiceDecoration\Service\MyService">
            <argument type="service" id="Swag\ServiceDecoration\Service\MyService.inner" />
        </service>
    </services>
</container>
```

And the related example services:
```php
<?php declare(strict_types = 1);

namespace Swag\ServiceDecoration\Service;

class MyService implements MyServiceInterface
{
    public function doSomething(): void
    {
    }
}
```

```php
<?php declare(strict_types=1);

namespace Swag\ServiceDecoration\Service;

class DecoratedService
{
    /**
     * @var MyServiceInterface
     */
    private $coreService;

    public function __construct(MyServiceInterface $myService)
    {
        $this->coreService = $myService;
    }
}

```

Note: It's **highly recommended** to work with interfaces when using the decoration pattern.