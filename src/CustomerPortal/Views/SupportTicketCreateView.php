<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Views;

use Ibexa\Core\MVC\Symfony\View\BaseView;
use Symfony\Component\Form\FormInterface;

class SupportTicketCreateView extends BaseView
{
    private FormInterface $form;

    public function __construct(
        string $templateIdentifier,
        FormInterface $form
    ) {
        parent::__construct($templateIdentifier);

        $this->form = $form;
    }

    /**
     * @return array{
     *     form: \Symfony\Component\Form\FormView
     * }
     */
    protected function getInternalParameters()
    {
        return [
            'form' => $this->form->createView(),
        ];
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function setForm(FormInterface $form): void
    {
        $this->form = $form;
    }
}
