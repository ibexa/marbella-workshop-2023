<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Controller;

use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use App\CustomerPortal\Views\ProductListView;
use Ibexa\Bundle\CorporateAccount\Controller\Controller;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Ibexa\ProductCatalog\Pagerfanta\Adapter\ProductListAdapter;
use Ibexa\Contracts\ProductCatalog\Permission\Policy\Product\View;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Core\MVC\Symfony\View\BaseView;
use Ibexa\CorporateAccount\Configuration\CorporateAccountConfiguration;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause;
use Ibexa\Contracts\ProductCatalog\CatalogServiceInterface;

final class ProductController extends Controller
{
    private const RESELLER_CATALOG_IDENTIFIER = 'reseller_catalog';

    private ConfigResolverInterface $configResolver;

    private ProductServiceInterface $productService;

    private CatalogServiceInterface $catalogService;

    public function __construct(
        CorporateAccountConfiguration $corporateAccountConfiguration,
        ProductServiceInterface $productService,
        CatalogServiceInterface $catalogService,
        ConfigResolverInterface $configResolver
    ) {
        parent::__construct($corporateAccountConfiguration);
        $this->configResolver = $configResolver;
        $this->productService = $productService;
        $this->catalogService = $catalogService;
    }

    public function listAction(Request $request): BaseView
    {
        $this->denyAccessUnlessGranted(new View());

        $query = $this->buildProductQuery();
        $products = new Pagerfanta(new ProductListAdapter($this->productService, $query));

        $products->setMaxPerPage($this->configResolver->getParameter('product_catalog.pagination.products_limit'));
        $products->setCurrentPage($request->query->getInt('page', 1));

        return new ProductListView('@ibexadesign/customer_portal/products/list.html.twig', $products);
    }

    private function buildProductQuery(): ProductQuery
    {
        $catalog = $this->catalogService->getCatalogByIdentifier(self::RESELLER_CATALOG_IDENTIFIER);
        $query = $catalog->getQuery();

        return new ProductQuery(
            $query,
            null,
            [new SortClause\ProductName(ProductQuery::SORT_ASC)]
        );
    }
}