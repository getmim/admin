<?php
/**
 * AuthController
 * @package admin
 * @version 0.0.1
 */

namespace Admin\Controller;

use LibForm\Library\Form;
use LibRecaptcha\Library\Validator;
use LibUserAuthCookie\Authorizer\Cookie;
use LibUserAuthGoogleAuth\Library\Auth;
use LibCaptcha\Library\Captcha;

class AuthController extends \Admin\Controller
{
    public function logoutAction()
    {
        $session = $this->user->getSession();
        if ($session) {
            $this->user->logout();
        }

        $next = $this->router->to('adminMeLogin');
        $this->res->redirect($next);
    }

    public function loginAction()
    {
        $next = $this->req->getQuery('next');
        if (!$next) {
            $next = $this->router->to('adminHome');
        }

        if ($this->user->isLogin()) {
            return $this->res->redirect($next);
        }

        $form = new Form('admin.me.login');

        $params = [
            '_meta' => [
                'title' => 'Login'
            ],
            'error' => false,
            'captcha_error' => false,
            'form'  => $form,
            'recovery' => null,
            'register' => null
        ];

        $config = $this->config->admin->login;
        if (isset($config->recovery)) {
            $params['recovery'] = to_route($config->recovery);
        }
        if (isset($config->register)) {
            $params['register'] = to_route($config->register);
        }

        if (!is_dev() && $this->req->method == 'POST' && $config->recaptcha) {
            $token = $this->req->getPost('recaptcha');
            if (!$token || !Validator::validate($token)) {
                return $this->resp('me/login', $params, 'blank');
            }
        }

        if ($this->req->method == 'POST'
            && $this->config->admin->login->captcha) {
            $answer = $this->req->getPost('captcha');
            $token = $this->req->getPost('noob');

            if (!$token || !Captcha::validate($token, $answer)) {
                $params['captcha_error'] = true;
                return $this->resp('me/login', $params, 'blank');
            }
        }

        if (!($valid = $form->validate()) || !$form->csrfTest('noob')) {
            return $this->resp('me/login', $params, 'blank');
        }

        $ad_cond = [];
        if (isset($config->where)) {
            $ad_cond = (array)$config->where;
        }
        
        $user = $this->user->getByCredentials($valid->name, $valid->password, $ad_cond);
        if (!$user) {
            $params['error'] = true;
            return $this->resp('me/login', $params, 'blank');
        }

        if ($config->googleauthenticator) {
            $token = $this->req->getPost('gatoken');
            if (!$token || !Auth::validate($user, $token)) {
                $params['error'] = true;
                return $this->resp('me/login', $params, 'blank');
            }
        }

        Cookie::loginById($user->id);

        $this->res->redirect($next);
    }
}
