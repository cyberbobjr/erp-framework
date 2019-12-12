<?php

// In src/Middleware/TrackingCookieMiddleware.php
namespace App\Middleware;

use Cake\Log\Log;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Request;

class CorsMiddleware
{
    public function __invoke($request, ResponseInterface $response, $next)
    {
        if ($request->getMethod() == "OPTIONS") {
            $method = $request->getHeader('Access-Control-Request-Method');
            $headers = $request->getHeader('Access-Control-Request-Headers');
            /*$response = $response->cors($request)
                                 ->allowOrigin(['*'])
                                 ->allowMethods(['GET', 'POST'])
                                 ->allowHeaders(['X-CSRF-Token'])
                                 ->allowCredentials()
                                 ->exposeHeaders(['Link'])
                                 ->maxAge(300)
                                 ->build();*/
            $response = $response->withHeader('Access-Control-Allow-Headers', $headers)
                                 ->withHeader('Access-Control-Allow-Methods', empty($method) ? 'GET, POST, PUT, DELETE' : $method)
                                 ->withHeader('Access-Control-Allow-Credentials', 'true')
                                 ->withHeader('Access-Control-Max-Age', '120')
                                 ->withHeader('Access-Control-Allow-Origin', $request->getHeader('Origin'));
        } else {
            $response = $next($request, $response);
            $response = $response->withHeader('Access-Control-Allow-Origin', '*')
                                 ->withHeader('Access-Control-Allow-Credentials', 'true')
                                 ->withHeader('Access-Control-Max-Age', '86400');
        }
        return $response;
    }
}