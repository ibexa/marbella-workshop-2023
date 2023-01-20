<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Views;

use Ibexa\Core\MVC\Symfony\View\BaseView;

class ContentListView extends BaseView
{
    private iterable $contents;

    public function __construct(
        string $templateIdentifier,
        iterable $contents
    ) {
        parent::__construct($templateIdentifier);

        $this->contents = $contents;
    }

    protected function getInternalParameters()
    {
        return [
            'contents' => $this->contents,
        ];
    }

    public function getContents(): iterable
    {
        return $this->contents;
    }

    public function setContents(iterable $contents): void
    {
        $this->contents = $contents;
    }
}