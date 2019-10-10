<?php
/**
 * HomeController
 * @package admin
 * @version 0.0.1
 */

namespace Admin\Controller;

use LibForm\Library\Form;

class HomeController extends \Admin\Controller
{

    public function indexAction() {
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->read_dashboard)
            return $this->show404();

        $params = [
            '_meta' => [
                'title' => 'Dashboard',
                'menus' => ['dashboard']
            ]
        ];

        return $this->resp('home', $params);
    }
}