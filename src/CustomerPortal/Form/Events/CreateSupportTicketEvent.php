<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Form\Events;

use App\CustomerPortal\Form\Data\SupportTicketData;
use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CreateSupportTicketEvent extends Event
{
    private FormInterface $form;

    private SupportTicketData $data;

    private ?string $actionName;

    private ?array $options;

    public function __construct(FormInterface $form, SupportTicketData $data, $actionName = null, $options = [])
    {
        $this->form = $form;
        $this->data = $data;
        $this->actionName = $actionName;
        $this->options = $options;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function getData(): SupportTicketData
    {
        return $this->data;
    }

    public function getActionName()
    {
        return $this->actionName;
    }
}
