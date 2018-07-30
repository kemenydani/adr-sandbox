<?php

namespace App\Article\Actions;

use App\Article\Repository\ArticleRepository;
use App\Article\Responders\ListResponder;

use App\Core\Action;
use App\Core\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ListAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new ArticleRepository();
        $this->responder  = new ListResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $articles = $this->repository->all();

        // manipulate here

        $status = true ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;

        return $this->responder->respond(
            new Payload($status, $articles)
        );
    }
}
