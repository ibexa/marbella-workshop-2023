<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Contracts\Services;

use App\Model\SupportTicket;

interface SupportTicketServiceInterface
{
    public const DEFAULT_LIMIT = 10;

    public function getTickets($offset = 0, $limit = self::DEFAULT_LIMIT): array;

    public function getTicketCount(): int;

    public function createSupportTicket(SupportTicket $ticket): void;
}