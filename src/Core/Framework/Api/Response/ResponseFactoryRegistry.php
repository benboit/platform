<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Api\Response;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Context\SalesChannelApiSource;
use Shopware\Core\PlatformRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class ResponseFactoryRegistry
{
    public const DEFAULT_RESPONSE_TYPE = 'application/vnd.api+json';
    public const STOREFRONT_DEFAULT_RESPONSE_TYPE = 'application/json';

    /**
     * @var ResponseFactoryInterface[]
     */
    private $responseFactories;

    public function __construct(iterable $responseFactories)
    {
        $this->responseFactories = $responseFactories;
    }

    public function getType(Request $request): ResponseFactoryInterface
    {
        /** @var Context $context */
        $context = $request->attributes->get(PlatformRequest::ATTRIBUTE_CONTEXT_OBJECT);

        $contentTypes = $request->getAcceptableContentTypes();
        if (\in_array('*/*', $contentTypes, true)) {
            $contentTypes[] = ($context->getSource() instanceof SalesChannelApiSource)
                ? self::STOREFRONT_DEFAULT_RESPONSE_TYPE
                : self::DEFAULT_RESPONSE_TYPE;
        }

        foreach ($contentTypes as $contentType) {
            foreach ($this->responseFactories as $factory) {
                if ($factory->supports($contentType, $context->getSource())) {
                    return $factory;
                }
            }
        }

        throw new UnsupportedMediaTypeHttpException(sprintf('All provided media types are unsupported. (%s)', implode(', ', $contentTypes)));
    }
}
