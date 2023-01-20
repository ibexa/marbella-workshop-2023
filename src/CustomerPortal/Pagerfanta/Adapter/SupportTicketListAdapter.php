<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Pagerfanta\Adapter;

use App\CustomerPortal\Services\SupportTicketService;
use App\CustomerPortal\SupportTicket\SupportTicketFilter;
use Pagerfanta\Adapter\AdapterInterface;

final class SupportTicketListAdapter implements AdapterInterface
{
    private SupportTicketService $supportTicketService;

    private SupportTicketFilter $filter;

    public function __construct(SupportTicketService $supportTicketService, SupportTicketFilter $filter)
    {
        $this->supportTicketService = $supportTicketService;
        $this->filter = $filter;
    }

    public function getNbResults(): int
    {
        return $this->supportTicketService->getTicketCount();
    }

    public function getSlice($offset, $length)
    {
        return $this->supportTicketService->getTickets($offset, $length);
    }
}
