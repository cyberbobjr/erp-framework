<?php

// In src/Middleware/TrackingCookieMiddleware.php
    namespace App\Middleware;

    use Cake\Core\Configure;
    use Cake\Core\Exception\Exception;
    use Cake\ORM\TableRegistry;
    use Cake\Utility\Security;
    use Firebase\JWT\JWT;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use UserManager\Utility\Droits;

    class SecurityMiddleware
    {

        /**
         * @param ServerRequestInterface $request The request.
         * @param ResponseInterface $response The response.
         * @param callable $next Callback to invoke the next middleware.
         * @return ResponseInterface A response
         *
         */
        public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
        {
            if ($request->session()
                        ->check('Auth.User')
            ) {
                Droits::setUser($request->session()
                                        ->read('Auth.User'));
            }
            if ($request->session()
                        ->check('rights')
            ) {
                Droits::setDroits($request->session()
                                          ->read('rights'));
            }
            if ($request->getHeaderLine('Authorization')) {
                $this->_decodeToken($request);
            }
            $response = $next($request, $response);
            return $response;
        }

        private function _decodeToken($request)
        {
            $token = $this->_getToken($request);
            if ($token) {
                try {
                    $payload = JWT::decode($token, Security::getSalt(), ['HS256']);
                    $usersTable = TableRegistry::getTableLocator()
                                               ->get('UserManager.Users');
                    $user = Droits::getUser();
                    $user['id'] = $payload->id;
                    Droits::setUser($user);
                    $fullUser = $usersTable->find('auth')
                                           ->contain(['Groupes',
                                                      'Groupes.Rights'])
                                           ->where(['Users.id' => $payload->id])
                                           ->first()
                                           ->toArray();
                    Droits::setUser($fullUser);
                } catch (Exception $e) {
                    if (Configure::read('debug')) {
                        debug($e);
                    }
                }
            }
        }

        public function _getToken($request)
        {
            $header = $request->getHeaderLine('Authorization');
            if ($header) {
                return str_ireplace('bearer ', '', $header);
            }

            return NULL;
        }
    }
