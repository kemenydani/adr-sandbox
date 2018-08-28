<?php

namespace App\User\Actions;

use App\Core\Session;
use App\User\Repository\UserMapper;
use App\User\Repository\UserRecord;
use App\User\Responders\SignOutResponder;

use App\Core\Action;
use App\Core\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class SignOutAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new UserMapper();
        $this->responder  = new SignOutResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        Session::delete('UserId');

        $status = Session::exists('UserId') ? Payload::STATUS_NOT_DELETED : Payload::STATUS_DELETED;

        return $this->responder->__invoke(
            new Payload($status)
        );
    }
}
