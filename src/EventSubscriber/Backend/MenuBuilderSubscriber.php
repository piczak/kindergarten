<?php

namespace App\EventSubscriber\Backend;

use App\Services\SettingsService;
use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use KevinPapst\AdminLTEBundle\Event\ThemeEvents;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class MenuBuilderSubscriber
 * @package App\EventSubscriber\Backend
 */
class MenuBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @var SettingsService
     */
    protected $settingsService;

    /**
     * MenuBuilderSubscriber constructor.
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ThemeEvents::THEME_SIDEBAR_SETUP_MENU => ['onSetupMenu', 100],
            ThemeEvents::THEME_BREADCRUMB => ['onSetupNavbar', 100],
        ];
    }

    /**
     * @param SidebarMenuEvent $event
     */
    public function onSetupMenu(SidebarMenuEvent $event)
    {
        //Header
        $event->addItem(new MenuItemModel('menu-main-header', 'Menu', ''));

        //Przedszkola
        $event->addItem(new MenuItemModel('menu-kindergartens-item', 'Przedszkola', 'admin.kindergarten.index', [], 'fas fa-bars'));

        //Linki
        $event->addItem(new MenuItemModel('menu-links-item', 'Linki', 'admin.links.index', [], 'fas fa-bars'));

        //Statistics
        $event->addItem(new MenuItemModel('menu-statistics-item', 'Statystyki', 'admin.statistics.index', [], 'fas fa-bars'));

        //Uczestnicy
        $event->addItem(new MenuItemModel('menu-participants-item', 'Uczestnicy', 'admin.participants.index', [], 'fas fa-bars'));

        ///System
        $event->addItem(new MenuItemModel('menu-system-header', 'System', ''));

        //System - Wyczyść cache
        $event->addItem(new MenuItemModel('menu-cache-item', 'Wyczyść cache', 'admin.cache.clear', [], 'fas fa-bars'));

        //System - Administratorzy
        $event->addItem(new MenuItemModel('menu-admins-item', 'Administratorzy', 'admin.admins', [], 'fas fa-users'));

        //System - Szablony e-mail
        $event->addItem(new MenuItemModel('menu-messages-item', 'Szablony e-mail', 'admin.emails', [], 'fas fa-envelope'));

        //System - Przekierowania
        $event->addItem(new MenuItemModel('menu-redirects-item', 'Przekierowania', 'admin.redirects', [], 'fas fa-arrow-right'));

        //System - Ustawienia
        $settings = new MenuItemModel('menu-settings-item', 'Ustawienia', 'admin.settings', ['section' => 1], 'fas fa-cog');

        $this->addSettingsMenu($settings);

        $event->addItem($settings);

        $this->activateByRoute(
            $event->getRequest(),
            $event->getItems()
        );
    }

    /**
     * @param SidebarMenuEvent $event
     */
    public function onSetupNavbar(SidebarMenuEvent $event)
    {

    }

    /**
     * @param MenuItemModel $node
     */
    protected function addSettingsMenu(MenuItemModel &$node)
    {
        foreach ($this->settingsService->getTree() as $tree) {
            if (isset($tree['children']) && !empty($this['children'])) {
                $settings = new MenuItemModel('menu-settings-' . $tree['id'] . '-item', $tree['name'], 'admin.settings', ['section' => $tree['id']], 'fas fa-cog');

                $this->addSettingsMenu($settings);
            } else {
                $node->addChild(
                    new MenuItemModel('menu-settings-' . $tree['id'] . '-item', $tree['name'], 'admin.settings', ['section' => $tree['id']], 'fas fa-cog')
                );
            }
        }
    }

    /**
     * Oznaczanie elementu w menu jako aktywnego na podstawie routingu
     * @param $route
     * @param $items
     */
    protected function activateByRoute($request, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($request, $item->getChildren());
            } else if ($item->getRoute() == 'admin.settings') {
                if ($request->get('section') == $item->getRouteArgs()['section']) {
                    $item->setIsActive(true);
                }
            } elseif ($item->getRoute() == $request->get('_route')) {
                $item->setIsActive(true);
            }
        }
    }
}
