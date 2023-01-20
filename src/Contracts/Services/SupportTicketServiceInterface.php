<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Contracts\Services;

interface SupportTicketServiceInterface
{
    public function getTickets($offset = 0, $limit = 10): array;

    public function getTicketCount(): int;
}