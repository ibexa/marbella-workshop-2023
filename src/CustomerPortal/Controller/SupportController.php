<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Controller;

use App\CustomerPortal\Pagerfanta\Adapter\SupportTicketListAdapter;
use App\CustomerPortal\Services\SupportTicketService;
use App\CustomerPortal\SupportTicket\SupportTicketFilter;
use App\CustomerPortal\Views\SupportTicketView;
use Ibexa\Bundle\CorporateAccount\Controller\Controller;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Ibexa\Core\MVC\Symfony\View\BaseView;
use Ibexa\CorporateAccount\Configuration\CorporateAccountConfiguration;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SupportController extends Controller
{
    private ConfigResolverInterface $configResolver;

    private SupportTicketService $supportTicketService;

    public function __construct(
        CorporateAccountConfiguration $corporateAccountConfiguration,
        ConfigResolverInterface $configResolver,
        SupportTicketService $supportTicketService
    ) {
        parent::__construct($corporateAccountConfiguration);
        $this->configResolver = $configResolver;
        $this->supportTicketService = $supportTicketService;
    }

    public function listAction(Request $request): BaseView
    {
        $pagerfanta = new Pagerfanta(
            new SupportTicketListAdapter(
                $this->supportTicketService,
                new SupportTicketFilter()
            )
        );

        $pagerfanta->setMaxPerPage($this->configResolver->getParameter('corporate_account.pagination.orders_limit'));
        $pagerfanta->setCurrentPage($request->query->getInt('page', 1));

        return new SupportTicketView(
            '@ibexadesign/customer_portal/support/list.html.twig',
            $pagerfanta
        );
    }
}
