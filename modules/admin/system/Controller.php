<?php
/**
 * Admin gate controller
 * @package admin
 * @version 0.0.1
 */

namespace Admin;

use AdminUi\Library\AConf;
use LibView\Library\View;
use LibActionLog\Library\Logger;


class Controller extends \Mim\Controller implements \Mim\Iface\GateController
{
    public function addLog(array $data): void{
        if(!module_exists('lib-action-log'))
            return;

        if(!isset($data['user']))
            $data['user'] = $this->user->id;

        Logger::create($data);
    }

    public function ajax(bool $error, $data): void{
        $content = json_encode(['error'=>$error,'data'=>$data], JSON_PRESERVE_ZERO_FRACTION);

        $this->res->addContent($content);
        $this->res->addHeader('Content-Type', 'application/json', false);
        $this->res->addHeader('Connection', 'close');
        $this->res->addHeader('Content-Length', strlen($content));
        $this->res->send();
    }

    // types
    // 1 current url
    // 2 referrer url
    // 3 provided url
    public function loginFirst(int $type, string $url=''): void{
        $next = '';

        switch($type){
            case 1:
                $next = $this->req->url;
                break;
            case 2:
                $next = $this->req->getServer('HTTP_REFERER');
                break;
            case 3:
                $next = $url;
                break;
        }

        if(!$next)
            $next = $this->req->url;

        $login = $this->router->to('adminMeLogin', [], ['next'=>$next]);
        $this->res->redirect($login);
    }

    public function show404(): void{
        $this->res->setStatus(404);
        $params = [
            '_meta' => ['title'=>'Error 404']
        ];
        $this->resp('error/404', $params, 'blank');
    }

    public function show404Action(): void{
        $this->show404();
    }

    public function show500(object $error): void{
        $this->res->setStatus(500);
        $this->res->removeContent();

        $params = [
            'message' => $error->text,
            'traces'  => [],
            '_meta'   => [
                'title'   => 'Error 500'
            ]
        ];

        if(isset($error->trace)){
            $base_len = strlen(BASEPATH);
            foreach($error->trace as $trace){
                if(!isset($trace['file']))
                    continue;

                $params['traces'][] = [
                    'file' => substr($trace['file'], $base_len),
                    'line' => $trace['line']
                ];
            }
        }

        $this->resp('error/500', $params, 'blank');
    }

    public function show500Action(): void{
        $this->show500(\Mim\Library\Logger::$last_error);
    }

    public function resp(string $view, array $params=[], string $layout='default'){
        if(!isset($params['_meta']))
            $params['_meta'] = [];
        if(!isset($params['_meta']['title']))
            $params['_meta']['title'] = $this->config->name;

        $thumb_icon = $this->router->asset('admin', 'icon/file.png', 1);

        // object filter config
        AConf::add('objFilter', [
            'search' => $this->router->to('adminObjectFilter'),
            'thumbs' => $thumb_icon
        ]);

        // upload file config
        if(module_exists('lib-upload')){
            AConf::add('libUpload', [
                'search' => $this->router->to('adminMediaFilter'),
                'upload' => $this->router->to('adminMediaUpload'),
                'thumbs' => $thumb_icon
            ]);
        }

        // render the content
        $content = View::render($view, $params, 'admin') ?? '';

        $layout_params = [
            '_meta'   => $params['_meta'],
            'content' => $content
        ];
        $result  = View::render('layout/' . $layout, $layout_params) ?? '';

        $this->res->addContent($result);
        $this->res->send();
    }
}