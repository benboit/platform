<?php declare(strict_types=1);

namespace Shopware\Core\Content\Category\Storefront;

use Shopware\Core\Content\Category\CategoryDefinition;
use Shopware\Core\Content\Category\Exception\CategoryNotFoundException;
use Shopware\Core\Framework\Api\Response\ResponseFactoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder;
use Shopware\Core\Framework\Uuid\Exception\InvalidUuidException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StorefrontCategoryController extends AbstractController
{
    /**
     * @var EntityRepositoryInterface
     */
    private $repository;

    /**
     * @var RequestCriteriaBuilder
     */
    private $criteriaBuilder;

    public function __construct(
        EntityRepositoryInterface $repository,
        RequestCriteriaBuilder $criteriaBuilder
    ) {
        $this->repository = $repository;
        $this->criteriaBuilder = $criteriaBuilder;
    }

    /**
     * @Route("/storefront-api/v{version}/category", name="storefront-api.category.list", methods={"GET", "POST"})
     */
    public function list(Request $request, SalesChannelContext $salesChannelContext, ResponseFactoryInterface $responseFactory): Response
    {
        $criteria = new Criteria();

        $criteria = $this->criteriaBuilder->handleRequest(
            $request,
            $criteria,
            CategoryDefinition::class,
            $salesChannelContext->getContext()
        );

        $result = $this->repository->search($criteria, $salesChannelContext->getContext());

        return $responseFactory->createListingResponse(
            $result,
            CategoryDefinition::class,
            $request,
            $salesChannelContext->getContext()
        );
    }

    /**
     * @Route("/storefront-api/v{version}/category/{categoryId}", name="storefront-api.category.detail", methods={"GET"})
     *
     * @throws CategoryNotFoundException
     * @throws InvalidUuidException
     */
    public function detail(string $categoryId, Request $request, SalesChannelContext $salesChannelContext, ResponseFactoryInterface $responseFactory): Response
    {
        $categories = $this->repository->search(new Criteria([$categoryId]), $salesChannelContext->getContext());
        if (!$categories->has($categoryId)) {
            throw new CategoryNotFoundException($categoryId);
        }

        return $responseFactory->createDetailResponse(
            $categories->get($categoryId),
            CategoryDefinition::class,
            $request,
            $salesChannelContext->getContext()
        );
    }
}
