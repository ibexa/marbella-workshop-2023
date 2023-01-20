<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace App\Model;

class SupportTicket
{
    public const DEFAULT_DUE = 'P1D';

    public const STATUS_OPEN = 2;
    public const STATUS_PENDING = 3;
    public const STATUS_RESOLVED = 4;
    public const STATUS_CLOSED = 5;

    public const PRIORITY_LOW = 1;
    public const PRIORITY_MEDIUM = 2;
    public const PRIORITY_HEIGH = 3;
    public const PRIORITY_URGENT = 4;

    public const SOURCE_EMAIL = 1;
    public const SOURCE_PORTAL = 2;
    public const SOURCE_PHONE = 3;
    public const SOURCE_CHAT = 7;

    public const TYPE_NONE = 'Keine';
    public const TYPE_QUESTION = 'Question';
    public const TYPE_INCIDENT = 'Incident';
    public const TYPE_PROBLEM = 'Problem';
    public const TYPE_FEATURE = 'Feature Request';
    public const TYPE_REFUND = 'Refund';

    protected int $id;

    protected User $requester;

    protected string $type;

    protected int $source;

    protected ?string $description;

    protected string $subject;

    protected \DateTime $created;

    protected \DateTime $updated;

    protected \DateTime $due;

    protected int $status;

    protected int $priority;

    protected array $attachments;

    public function __construct()
    {
        $now = new \DateTime();
        $defaultDue = $now->add(new \DateInterval(self::DEFAULT_DUE));

        $this->setStatus(self::STATUS_OPEN);
        $this->setPriority(self::PRIORITY_MEDIUM);
        $this->setType(self::TYPE_NONE);
        $this->setSource(self::SOURCE_PORTAL);
        $this->setCreated($now);
        $this->setUpdated($now);
        $this->setDue($defaultDue);
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setRequester(User $requester): self
    {
        $this->requester = $requester;

        return $this;
    }

    public function getRequester(): User
    {
        return $this->requester;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $due
     */
    public function setDue(\DateTime $due): self
    {
        $this->due = $due;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDue(): \DateTime
    {
        return $this->due;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setSource(int $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getSource(): int
    {
        return $this->source;
    }

    public function setAttachments(array $attachments): self
    {
        $this->attachments = $attachments;

        return $this;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function __toString()
    {
        return '#' . $this->id . ' ' . $this->subject;
    }
}
