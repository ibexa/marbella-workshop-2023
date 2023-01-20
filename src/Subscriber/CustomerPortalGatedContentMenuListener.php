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

class CustomerPortalGatedContentMenuListener implements EventSubscriberInterface, TranslationContainerInterface
{
    public const ITEM_GATED_CONTENT = 'customer_portal.gated_content';
    public const ITEM_GATED_CONTENT_LIST = 'customer_portal.gated_content.list';

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
            CorporateCustomerPortalMenuBuilder::EVENT_NAME => ['onMenuConfigure', 300],
        ];
    }

    public function onMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();
        $this->addMyProductsItems($menu);
    }

    public function addMyProductsItems(ItemInterface $menu): void
    {
        $my_productsMenu = $menu->addChild(self::ITEM_GATED_CONTENT, [
            'label' => self::ITEM_GATED_CONTENT,
        ]);

        $my_productsMenu->addChild(self::ITEM_GATED_CONTENT_LIST, [
            'route' => 'ibexa.corporate_account.customer_portal.gated_content.list',
            'label' => self::ITEM_GATED_CONTENT_LIST,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM_GATED_CONTENT))->setDesc('Reseller Program'),
            (new Message(self::ITEM_GATED_CONTENT_LIST))->setDesc('Document Library'),
        ];
    }
}
