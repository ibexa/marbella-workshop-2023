<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Services;

use App\Contracts\Services\SupportTicketServiceInterface;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;

class SupportTicketService implements SupportTicketServiceInterface
{
    private ConfigResolverInterface $configResolver;

    private string $webhookUrl;

    public function __construct(
        ConfigResolverInterface $configResolver
    ) {
        $this->configResolver = $configResolver;
        $this->webhookUrl = $this->configResolver->getParameter('customer_portal_support_api_endpoint');
    }

    public function getTickets($offset = 0, $limit = self::DEFAULT_LIMIT): array
    {
        $tickets = [];

        return $tickets;
    }

    public function getTicketCount(): int
    {
        return 0;
    }
}
