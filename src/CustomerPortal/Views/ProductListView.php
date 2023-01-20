<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Views;

use Ibexa\Core\MVC\Symfony\View\BaseView;

class ProductListView extends BaseView
{
    private iterable $products;

    public function __construct(
        string $templateIdentifier,
        iterable $products
    ) {
        parent::__construct($templateIdentifier);

        $this->products = $products;
    }

    protected function getInternalParameters()
    {
        return [
            'products' => $this->products,
        ];
    }

    public function getProducts(): iterable
    {
        return $this->products;
    }

    public function setProducts(iterable $products): void
    {
        $this->products = $products;
    }
}