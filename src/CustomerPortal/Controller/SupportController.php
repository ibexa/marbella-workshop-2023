<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Controller;

use App\CustomerPortal\Form\Events\CreateSupportTicketEvent;
use App\CustomerPortal\Form\SupportTicketFormFactory;
use App\CustomerPortal\Pagerfanta\Adapter\SupportTicketListAdapter;
use App\CustomerPortal\Services\SupportTicketService;
use App\CustomerPortal\SupportTicket\SupportTicketFilter;
use App\CustomerPortal\Views\SupportTicketCreateView;
use App\CustomerPortal\Views\SupportTicketView;
use App\Model\SupportTicket;
use Ibexa\Bundle\CorporateAccount\Controller\Controller;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Ibexa\Core\MVC\Symfony\View\BaseView;
use Ibexa\CorporateAccount\Configuration\CorporateAccountConfiguration;
use Pagerfanta\Pagerfanta;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SupportController extends Controller
{
    private ConfigResolverInterface $configResolver;

    private SupportTicketService $supportTicketService;

    private EventDispatcherInterface $actionDispatcher;

    private UrlGeneratorInterface $urlGenerator;

    private SupportTicketFormFactory $formFactory;

    public function __construct(
        CorporateAccountConfiguration $corporateAccountConfiguration,
        ConfigResolverInterface $configResolver,
        SupportTicketService $supportTicketService,
        EventDispatcherInterface $actionDispatcher,
        UrlGeneratorInterface $urlGenerator,
        SupportTicketFormFactory $formFactory
    ) {
        parent::__construct($corporateAccountConfiguration);
        $this->configResolver = $configResolver;
        $this->supportTicketService = $supportTicketService;
        $this->actionDispatcher = $actionDispatcher;
        $this->urlGenerator = $urlGenerator;
        $this->formFactory = $formFactory;
    }

    public function listAction(Request $request): BaseView
    {
        $pagerfanta = new Pagerfanta(
            new SupportTicketListAdapter(
                $this->supportTicketService,
                new SupportTicketFilter([SupportTicket::STATUS_OPEN])
            )
        );

        $pagerfanta->setMaxPerPage($this->configResolver->getParameter('corporate_account.pagination.orders_limit'));
        $pagerfanta->setCurrentPage($request->query->getInt('page', 1));

        return new SupportTicketView(
            '@ibexadesign/customer_portal/support/list.html.twig',
            $pagerfanta
        );
    }

    public function createAction(Request $request)
    {
        /** @var \Symfony\Component\Form\Form $createForm */
        $createForm = $this->formFactory->getSupportTicketCreateForm();

        $createForm->handleRequest($request);
        if ($createForm->isSubmitted() && $createForm->isValid() && null !== $createForm->getClickedButton()) {
            $this->actionDispatcher->dispatch(
                new CreateSupportTicketEvent(
                    $createForm,
                    $createForm->getData(),
                    $createForm->getClickedButton()->getName(),
                    []
                )
            );

            return new RedirectResponse(
                $this->urlGenerator->generate('ibexa.corporate_account.customer_portal.support.ticket_list')
            );
        }

        return new SupportTicketCreateView(
            '@ibexadesign/customer_portal/support/create.html.twig',
            $createForm
        );
    }
}
