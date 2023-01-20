<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Form;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

abstract class CustomerPortalFormFactory
{
    protected const IBEXA_CUSTOMER_PORTAL_EDIT_FORM_NAME = 'ibexa_customer_portal_forms_edit';

    protected FormFactoryInterface $formFactory;

    public function __construct(
        FormFactoryInterface $formFactory
    ) {
        $this->formFactory = $formFactory;
    }

    /**
     * @param mixed $data
     * @param array<string, mixed> $options
     */
    public function createCustomerPortalEditForm(string $type, $data = null, array $options = []): FormInterface
    {
        return $this->formFactory->createNamed(self::IBEXA_CUSTOMER_PORTAL_EDIT_FORM_NAME, $type, $data, $options);
    }
}
