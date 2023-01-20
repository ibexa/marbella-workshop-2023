<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Form\Processor;

use App\CustomerPortal\Form\Data\SupportTicketData;
use App\CustomerPortal\Form\Events\CreateSupportTicketEvent;
use App\CustomerPortal\Services\SupportTicketService;
use App\Model\SupportTicket;
use App\Model\User;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Core\Repository\SiteAccessAware\Repository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SupportTicketFormProcessor implements EventSubscriberInterface
{
    private SupportTicketService $supportTicketService;

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    private Repository $repository;

    public function __construct(
        SupportTicketService $supportTicketService,
        PermissionResolver $permissionResolver,
        UserService $userService,
        Repository $repository
    ) {
        $this->supportTicketService = $supportTicketService;
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CreateSupportTicketEvent::class => ['processCreate', 10],
        ];
    }

    public function processCreate(CreateSupportTicketEvent $event): void
    {
        $userReference = $this->permissionResolver->getCurrentUserReference();
        $userId = $userReference->getUserId();

        /** @var \Ibexa\Core\Repository\Values\User\User $ibexaUser */
        $ibexaUser = $this->repository->sudo(function (Repository $repository) use ($userId) {
            return $this->userService->loadUser($userId);
        });

        $data = $event->getData();

        if (!$data instanceof SupportTicketData) {
            return;
        }

        //dump($data);
        //dump($ibexaUser);

        $user = new User();
        $user->setEmail($ibexaUser->email);
        $user->setRemoteId((string)$userId);
        $user->setName($ibexaUser->getName());

        /** @var \App\CustomerPortal\Form\Data\SupportTicketData $data */
        $ticket = new SupportTicket();
        $ticket->setSubject($data->getSubject());
        $ticket->setDescription($data->getDescription());
        $ticket->setType($data->getType());
        $ticket->setPriority($data->getPriority());
        $ticket->setRequester($user);

        $this->supportTicketService->createSupportTicket($ticket);
    }
}
