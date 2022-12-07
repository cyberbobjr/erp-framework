<?php

    use Cake\Http\Response;
    use Cake\Routing\Router;

    $configexist = file_exists(ROOT . DS . 'install.lock');

    $isCli = PHP_SAPI === 'cli';
    if ($isCli) return;
    if (!$configexist) {
        $request = \Cake\Http\ServerRequestFactory::fromGlobals();
        if (!str_contains($request->getPath(), 'install') && !str_contains($request->getPath(), 'debug_kit') && !$request->is('ajax')) {
            $response = new Response();
            $response->withStatus(302);
            $response->withLocation(Router::url(['plugin'     => 'Wizardinstaller',
                                                 'controller' => 'Install',
                                                 'action'     => 'step',
                                                 1], TRUE));
            return $response;
        }
    }
?>
