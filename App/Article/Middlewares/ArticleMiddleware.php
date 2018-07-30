<?php

namespace App\Article\Middlewares;

use \Slim\Http\Request;
use \Slim\Http\Response;

class ArticleMiddleware
{
    public function test(Request $request, Response $response, $next)
    {
        // Before action

        $response = $next($request, $response);

        // After responder responded App

        return $response;
    }

}