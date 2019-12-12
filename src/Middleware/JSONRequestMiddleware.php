<?php

// In src/Middleware/TrackingCookieMiddleware.php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;

class JSONRequestMiddleware
{
    public function __invoke($request, ResponseInterface $response, $next)
    {
        if (strtolower($request->getHeaderLine('Accept')) == 'application/json') {
            $queries = $request->getQueryParams();
            foreach ($queries as $key => $query) {
                $filter[$key] = is_array($query) ? $query : json_decode($request->getQuery($key), TRUE);
            }
            if (isset($filter)) {
                $request = $request->withQueryParams($filter);
            }
        }
        $response = $next($request, $response);
        return $response;
    }
}