<?php

namespace App\Article\Actions;

use App\Article\Repository\ArticleMapper;
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
        $this->repository = new ArticleMapper();
        $this->responder  = new ListResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $result = $this->repository->paginate(
            @$queryParams['search'],
            @$queryParams['page'],
            @$queryParams['perPage'],
            @$queryParams['sortBy'],
            @$queryParams['descending']
        );

        $status = count($result) ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;

        // manipulate if needed

        return $this->responder->__invoke(
            new Payload(
                $status,
                $result
            )
        );
    }
}
