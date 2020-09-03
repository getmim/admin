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
        if(!\Mim::$app->user->isLogin())
            return [];

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
        if(!\Mim::$app->user->isLogin())
            return [];

        if(module_exists('site')){
            $back_site_link = \Mim::$app->router->to('siteHome');
            if(\Mim::$app->config->admin->login->frontpage){
                if(module_exists('admin-user-handshake') && module_exists('site-user-handshake')){
                    $next = \Mim::$app->router->to('siteMeHandshakeReceive');
                    $back_site_link = \Mim::$app->router->to('adminMeHandshakeDeliver', [], ['next'=>$next]);
                }
            }

            $result[] = (object)[
                'label'     => 'Back to site',
                'icon'      => '<i class="fas fa-globe"></i>',
                'link'      => $back_site_link,
                'priority'  => 10000
            ];
            
            $result[] = (object)[
                'label'     => '---',
                'link'      => '#0',
                'priority'  => 9999
            ];
        }

        $result[] = (object)[
            'label'     => '---',
            'link'      => '#0',
            'priority'  => 100
        ];

        $result[] = (object)[
            'label'     => 'Logout',
            'icon'      => '<i class="fas fa-sign-out-alt"></i>',
            'link'      => \Mim::$app->router->to('adminMeLogout'),
            'priority'  => 0
        ];

        return $result;
    }

    static function getSidebarMenu(array $params): array{}
}