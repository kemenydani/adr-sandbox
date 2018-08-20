<?php

namespace App\Article\Actions;

use App\Article\Repository\UserMapper;
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
        $this->repository = new UserMapper();
        $this->responder  = new ListResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $articleRecordSet = $this->repository->all();

        $status = count($articleRecordSet) ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;

        // manipulate if needed

        return $this->responder->__invoke(
            new Payload(
                $status,
                $articleRecordSet->getData()
            )
        );
    }
}
