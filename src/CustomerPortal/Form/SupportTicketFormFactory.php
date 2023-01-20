<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Form;

use App\CustomerPortal\Form\Data\SupportTicketData;
use App\CustomerPortal\Form\Type\SupportTicketCreateType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SupportTicketFormFactory extends CustomerPortalFormFactory
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator
    ) {
        parent::__construct($formFactory);
        $this->urlGenerator = $urlGenerator;
    }

    public function getSupportTicketCreateForm(): FormInterface
    {
        return $this->formFactory->create(
            SupportTicketCreateType::class,
            new SupportTicketData(),
            [
                'action' => $this->urlGenerator->generate(
                    'ibexa.corporate_account.customer_portal.support.create_ticket'
                ),
            ]
        );
    }
}
