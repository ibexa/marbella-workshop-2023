<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Form\Data;

use App\Model\SupportTicket;
use Symfony\Component\Validator\Constraints as Assert;

final class SupportTicketData
{
    /**
     * @Assert\NotNull()
     */
    private ?string $subject;

    /**
     * @Assert\NotNull()
     */
    private ?string $description;

    /**
     * @Assert\NotNull()
     */
    private ?string $type;

    /**
     * @Assert\NotNull()
     */
    private ?int $priority;

    public function __construct(?string $subject = null, ?string $description = null, ?string $type = SupportTicket::TYPE_QUESTION, ?int $priority = SupportTicket::PRIORITY_MEDIUM)
    {
        $this->subject = $subject;
        $this->description = $description;
        $this->type = $type;
        $this->priority = $priority;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setPriority($priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority()
    {
        return $this->priority;
    }
}
