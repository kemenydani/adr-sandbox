<?php

namespace App\Article\Actions;

use App\Article\Repository\UserMapper;
use App\Article\Responders\ViewResponder;

use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ViewAction
{
    private $repository = [];
    private $responder;

    public function __construct(Container $container)
    {
        $this->repository = new UserMapper();
        $this->responder  = new ViewResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $articles = $this->repository->all();

        // manipulate here

        return $this->responder->respond($articles);
    }
}