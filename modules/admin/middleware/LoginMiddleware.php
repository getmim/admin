<?php
/**
 * LoginMiddleware
 * @package admin
 * @version 0.6.0
 */

namespace Admin\Middleware;

use LibUser\Library\Fetcher;

class LoginMiddleware extends \Mim\Middleware
{
	public function authAction(){
		$ignored = (array)$this->config->admin->middleware->login->ignore;
		if($ignored){
			if(isset($ignored[$this->req->route->name]) && $ignored[$this->req->route->name])
				return $this->req->next();
		}

		if(!$this->user->isLogin())
			return $this->req->next();

		$cond = $this->config->admin->login->where ?? [];
		if(!$cond)
			return $this->req->next();

		$u_cond = (array)$cond;
		$u_cond['id'] = $this->user->id;

		if(Fetcher::getOne($u_cond))
			return $this->req->next();

		$ctrl = new \Admin\Controller;
		$ctrl->show404();
	}
}