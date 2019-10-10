<?php
/**
 * Menu
 * @package admin
 * @version 0.0.1
 */

namespace Admin\Library;

class Menu
    implements 
        \AdminUi\Iface\NavbarMenu,
        \AdminUi\Iface\SidebarMenu
{
    static function getNavbarMenu(object $menu, array $params): array{
        $result = [];

        $result[] = (object)[
            'id'       => 'me-auth',
            'label'    => \Mim::$app->user->fullname,
            'link'     => '#0',
            'priority' => 0
        ];

        return $result;
    }

    static function getSubNavbarMenu(object $menu, object $parent, array $params): array{
        $result = [];

        if(module_exists('site')){
            $result[] = (object)[
                'label'     => 'Back to site',
                'icon'      => '<i class="fas fa-globe"></i>',
                'link'      => \Mim::$app->router->to('siteHome'),
                'priority'  => 300
            ];
        }

        if($result){
            $result[] = (object)[
                'label'     => '---',
                'link'      => '#0',
                'priority'  => 200
            ];
        }

        $result[] = (object)[
            'label'     => 'Logout',
            'icon'      => '<i class="fas fa-sign-out-alt"></i>',
            'link'      => \Mim::$app->router->to('adminMeLogout'),
            'priority'  => 100
        ];

        return $result;
    }

    static function getSidebarMenu(array $params): array{}
}