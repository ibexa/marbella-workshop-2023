<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Pagerfanta\Adapter;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchHit;
use Pagerfanta\Adapter\AdapterInterface;

final class GatedContentListAdapter implements AdapterInterface
{
    private LocationQuery $query;

    private SearchService $searchService;

    public function __construct(SearchService $searchService, LocationQuery $query)
    {
        $this->searchService = $searchService;
        $this->query = $query;
    }

    public function getNbResults(): int
    {
        $query = $this->query;
        $query->limit = 0;

        return $this->searchService->findLocations($query)->totalCount;
    }

    public function getSlice($offset, $length)
    {
        $query = $this->query;
        $query->limit = $length;
        $query->offset = $offset;
        $query->performCount = false;

        $result = $this->searchService->findLocations($query);
        return \array_map(static function (SearchHit $searchHit) {
            return $searchHit->valueObject;
        }, $result->searchHits);
    }
}
