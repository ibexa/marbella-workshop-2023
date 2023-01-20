<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Views;

use Ibexa\Core\MVC\Symfony\View\BaseView;

class SupportTicketView extends BaseView
{
    private iterable $tickets;

    public function __construct(
        string $templateIdentifier,
        iterable $tickets
    ) {
        parent::__construct($templateIdentifier);

        $this->tickets = $tickets;
    }

    protected function getInternalParameters()
    {
        return [
            'tickets' => $this->tickets,
        ];
    }

    public function getTickets(): iterable
    {
        return $this->tickets;
    }

    public function setTickets(iterable $tickets): void
    {
        $this->tickets = $tickets;
    }
}
