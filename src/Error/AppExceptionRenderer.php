<?php

namespace App\Error;

use App\Controller\AppController;
use Cake\Error\ExceptionRenderer;
use Cake\Routing\Router;
use UnauthorizedJWTException;
use Exception;

class AppExceptionRenderer extends ExceptionRenderer
{
    public function __construct(Exception $exception)
    {
        parent::__construct($exception);
    }

    public function render()
    {
        $controller = $this->_getController();
        $header = $controller->request->getHeaderLine('accept');
        if ($controller->request->is('get') && $this->error->getCode() === 401 && (strpos(strtolower($header), 'application/json') === FALSE)) {
            $appController = new AppController();
            $urlRedirect = $appController->Auth->_config['loginAction'];
            return $controller->redirect($urlRedirect, TRUE);
        } else {
            return parent::render(); // TODO: Change the autogenerated stub
        }
    }

    public function UnauthorizedJWT(UnauthorizedJWTException $error)
    {
        $controller = $this->_getController();
        $header = $controller->request->getHeaderLine('accept');
        if (strpos(strtolower($header), 'application/json') === FALSE) {
            $controller->response = $controller->response->withStatus(302);
            $controller->response = $controller->response->withHeader('location', Router::url(['plugin' => 'UserManager',
                'controller' => 'Users',
                'action' => 'login',
                '_ssl' => TRUE]));
            return $controller->response;
        } else {
            $code = $this->_code($error);
            $message = $this->_message($error, $code);
            $viewVars = ['message' => $message,
                'code' => $code,
                '_serialize' => ['message',
                    'code']];
            $this->controller->set($viewVars);
            $response = $this->_outputMessage("error401");
            $response = $response->withStatus($code);
            return $response;
        }
    }
}