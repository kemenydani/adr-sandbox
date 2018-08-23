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
        // TODO: notifications
        $UserRecord = $this->repository->find(1);

        $status = $UserRecord ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;
        $data   = $UserRecord ? $UserRecord->getData(UserRecord::USER_EXCLUDE_CREDENTIALS, true) : [];

        $notifications = $this->repository->getNotifications($UserRecord);
        $conversations = $this->repository->getConversations($UserRecord);

        $data['Notifications'] = $notifications;
        $data['Conversations'] = $conversations;

        return $this->responder->__invoke(
            new Payload(
                $status,
                $data
            )
        );
    }
}
