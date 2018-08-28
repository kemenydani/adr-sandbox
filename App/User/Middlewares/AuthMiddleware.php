<?php

namespace App\User\Middlewares;

use App\Core\Session;
use \Slim\Http\Request;
use \Slim\Http\Response;

class AuthMiddleware
{
    public static function isAuth(Request $request, Response $response, $next)
    {
        // Before action

        if(!Session::exists('UserId')) return $response->withStatus(401, 'Unauthorized');

        // After responder responded App

        return $next($request, $response);
    }

}