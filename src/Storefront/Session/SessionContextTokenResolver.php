<?php

namespace Shopware\Storefront\Session;

use Shopware\Framework\Routing\Router;
use Shopware\StorefrontApi\Context\ContextTokenResolverInterface;
use Shopware\StorefrontApi\Context\StorefrontContextValueResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionContextTokenResolver implements ContextTokenResolverInterface
{
    /**
     * @var ContextTokenResolverInterface
     */
    protected $decorated;

    public function __construct(ContextTokenResolverInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function resolve(Request $request): string
    {
        if (!$this->isStorefrontRequest($request)) {
            return $this->decorated->resolve($request);
        }

        $session = $request->getSession();
        if (!$session) {
            return $this->decorated->resolve($request);
        }

        $request->attributes->set(StorefrontContextValueResolver::CONTEXT_TOKEN_KEY, $this->getContextToken($session));
    }

    private function isStorefrontRequest(Request $request): bool
    {
        $type = $request->attributes->get(Router::REQUEST_TYPE_ATTRIBUTE);

        return $type === Router::REQUEST_TYPE_STOREFRONT;
    }

    private function getContextToken(SessionInterface $session): string
    {
        if (!$session->has(StorefrontContextValueResolver::CONTEXT_TOKEN_KEY)) {
            $session->set(StorefrontContextValueResolver::CONTEXT_TOKEN_KEY, Uuid::uuid4()->toString());
        }

        return $session->get(StorefrontContextValueResolver::CONTEXT_TOKEN_KEY);
    }
}