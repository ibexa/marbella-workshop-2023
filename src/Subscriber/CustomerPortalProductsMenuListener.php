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

class CustomerPortalProductsMenuListener implements EventSubscriberInterface, TranslationContainerInterface
{
    public const ITEM_PRODUCTS_ROOT = 'customer_portal.products';
    public const ITEM_PRODUCTS = 'customer_portal.products.list';

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
        $this->addProductsItems($menu);
    }

    public function addProductsItems(ItemInterface $menu): void
    {
        $my_productsMenu = $menu->addChild(self::ITEM_PRODUCTS_ROOT, [
            'label' => self::ITEM_PRODUCTS_ROOT,
        ]);

        $my_productsMenu->addChild(self::ITEM_PRODUCTS, [
            'route' => 'ibexa.corporate_account.customer_portal.products.list',
            'label' => self::ITEM_PRODUCTS,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM_PRODUCTS_ROOT))->setDesc('Product Catalog'),
            (new Message(self::ITEM_PRODUCTS))->setDesc('Products'),
        ];
    }
}
