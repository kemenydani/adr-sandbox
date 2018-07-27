<?php

namespace App\Article\Actions;

use App\Article\Repository\ArticleRepository;
use App\Article\Responders\ListResponder;

use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ListAction
{
    private $repository = [];
    private $responder;

    public function __construct(Container $container)
    {
        $this->repository = new ArticleRepository();
        $this->responder  = new ListResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $articles = $this->repository->all();

        // manipulate here

        return $this->responder->respond($articles);
    }
}