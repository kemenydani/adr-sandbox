<?php

namespace App\User\Actions;

use App\User\Repository\UserMapper;
use App\User\Repository\UserRecord;
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
        $this->repository = new UserMapper();
        $this->responder  = new AuthResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $status = Payload::STATUS_FOUND;

        // manipulate if needed

        $User = $this->repository->find(1);

        return $this->responder->__invoke(
            new Payload(
                $status,
                $User->getData(UserRecord::USER_EXCLUDE_CREDENTIALS, true)
            )
        );
    }
}
