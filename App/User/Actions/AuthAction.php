<?php

namespace App\User\Actions;

use App\Article\Repository\ArticleMapper;
use App\User\Responders\AuthResponder;

use App\Core\Action;
use App\Core\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new ArticleMapper();
        $this->responder  = new AuthResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $status = Payload::STATUS_FOUND;

        // manipulate if needed

        return $this->responder->__invoke(
            new Payload(
                $status,
                [
                    'userName' => 'snowy',
                    'email' => 'kemenydani93@gmail.com'
                ]
            )
        );
    }
}
