<?php declare(strict_types=1);

namespace Shopware\Core\Content\Product;

use Shopware\Core\Content\Product\Util\VariantCombinationLoader;
use Shopware\Core\Framework\Context;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductActionController extends AbstractController
{
    /**
     * @var VariantCombinationLoader
     */
    private $combinationLoader;

    public function __construct(VariantCombinationLoader $combinationLoader)
    {
        $this->combinationLoader = $combinationLoader;
    }

    /**
     * @Route("/api/v{version}/_action/product/{productId}/combinations", name="api.action.product.combinations", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function getCombinations(string $productId, Context $context)
    {
        return new JsonResponse(
            $this->combinationLoader->load($productId, $context)
        );
    }
}
