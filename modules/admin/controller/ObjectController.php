<?php
/**
 * ObjectController
 * @package admin
 * @version 0.0.1
 */

namespace Admin\Controller;

class ObjectController extends \Admin\Controller
{
    public function filterAction(){
        if(!$this->user->isLogin())
            return $this->show404();

        $result = [];

        $type = $this->req->getQuery('type');
        if(!$type)
            return $this->ajax(false, 'Type query string not provided');

        $handler = $this->config->admin->objectFilter->handlers->$type ?? null;
        if(!$handler)
            return $this->ajax(true, 'Handler not found');

        $cond = $this->req->getQuery();
        if(isset($cond['query']) && !isset($cond['q']))
            $cond['q'] = $cond['query'];

        $result = $handler::filter($cond);
        if(is_null($result))
            return $this->ajax(true, $handler::lastError());

        return $this->ajax(false, $result);
    }
}