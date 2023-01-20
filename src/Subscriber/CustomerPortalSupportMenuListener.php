<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Subscriber;

use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Ibexa\AdminUi\Menu\MenuItemFactory;
use Ibexa\CorporateAccount\Menu\CorporateCustomerPortalMenuBuilder;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerPortalSupportMenuListener implements EventSubscriberInterface, TranslationContainerInterface
{
    public const ITEM_SUPPORT = 'customer_portal.support';
    public const ITEM_SUPPORT_TICKETS = 'customer_portal.support.list';

    /** @var \Ibexa\AdminUi\Menu\MenuItemFactory */
    private $menuItemFactory;

    public function __construct(
        MenuItemFactory $menuItemFactory
    ) {
        $this->menuItemFactory = $menuItemFactory;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CorporateCustomerPortalMenuBuilder::EVENT_NAME => ['onMenuConfigure', 200],
        ];
    }

    public function onMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();
        $this->addSupportItems($menu);
    }

    public function addSupportItems(ItemInterface $menu): void
    {
        $supportMenu = $menu->addChild(self::ITEM_SUPPORT, [
            'label' => self::ITEM_SUPPORT,
        ]);

        $supportMenu->addChild(self::ITEM_SUPPORT_TICKETS, [
            'route' => 'ibexa.corporate_account.customer_portal.support.ticket_list',
            'label' => self::ITEM_SUPPORT_TICKETS,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM_SUPPORT))->setDesc('Support'),
            (new Message(self::ITEM_SUPPORT_TICKETS))->setDesc('My Support tickets'),
        ];
    }
}
