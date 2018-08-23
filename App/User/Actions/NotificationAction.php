<?php

namespace App\User\Actions;

use App\User\Repository\UserMapper;
use App\User\Responders\AuthResponder;

use App\Core\Action;
use App\Core\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


class NotificationAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new UserMapper();
        $this->responder  = new AuthResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        // TODO: notifications
        $UserRecord = $this->repository->find(1);

        $notifications = $this->repository->getNotifications($UserRecord);

        $status = is_array($notifications) ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;

        return $this->responder->__invoke(
            new Payload(
                $status,
                $notifications
            )
        );
    }
}