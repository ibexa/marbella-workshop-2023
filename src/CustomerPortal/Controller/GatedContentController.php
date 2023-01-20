<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Controller;

use App\CustomerPortal\Pagerfanta\Adapter\GatedContentListAdapter;
use App\CustomerPortal\Views\ContentListView;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Bundle\CorporateAccount\Controller\Controller;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Ibexa\Core\MVC\Symfony\View\BaseView;
use Ibexa\CorporateAccount\Configuration\CorporateAccountConfiguration;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

final class GatedContentController extends Controller
{
    private ConfigResolverInterface $configResolver;

    private SearchService $searchService;

    private PermissionResolver $permissionResolver;

    public function __construct(
        CorporateAccountConfiguration $corporateAccountConfiguration,
        SearchService $searchService,
        ConfigResolverInterface $configResolver,
        PermissionResolver $permissionResolver
    ) {
        parent::__construct($corporateAccountConfiguration);
        $this->configResolver = $configResolver;
        $this->permissionResolver = $permissionResolver;
        $this->searchService = $searchService;
    }

    public function listAction(Request $request): BaseView
    {
        $query = $this->buildSearchQuery();
        $contentList = new Pagerfanta(new GatedContentListAdapter($this->searchService, $query));

        $contentList->setMaxPerPage($this->configResolver->getParameter('product_catalog.pagination.products_limit'));
        $contentList->setCurrentPage($request->query->getInt('page', 1));

        return new ContentListView('@ibexadesign/customer_portal/content/list.html.twig', $contentList);
    }

    private function buildSearchQuery(): LocationQuery
    {
        $parentLocationId = $this->configResolver->getParameter('customer_portal_gated_content_root_location_id');
        $contentTypeIdentifierList = $this->configResolver->getParameter('customer_portal_gated_content_whitelisted_content_types');

        $query = new LocationQuery();
        $query->filter = new LogicalAnd([
            new Criterion\ParentLocationId($parentLocationId),
            new Criterion\ContentTypeIdentifier($contentTypeIdentifierList)
        ]);

        return $query;
    }
}