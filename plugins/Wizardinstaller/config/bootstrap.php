<?php

    use Cake\Http\Response;
    use Cake\Http\ServerRequestFactory;
    use Cake\Routing\Router;

    /*$configexist = file_exists(ROOT.DS.'install.lock');

    $isCli = PHP_SAPI === 'cli';
    if ($isCli) {
        return;
    }
    if (!$configexist) {
        $request = ServerRequestFactory::fromGlobals();
        if (!$request->is('ajax') && strpos($request->getPath(), 'install') === FALSE && strpos($request->getPath(), 'debug_kit') === FALSE) {
            $response = new Response();
            $response->withStatus(302);
            $response->withLocation(
                Router::url(
                    [
                        'controller' => 'Install',
                        'action'     => 'step',
                        'plugin'     => 'Wizardinstaller',
                        1
                    ],
                    TRUE
                )
            );
            return $response;
        }
    }*/
?>
