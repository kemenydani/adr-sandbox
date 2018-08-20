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
        $status = Payload::STATUS_FOUND;

        // manipulate if needed

        return $this->responder->__invoke(
            new Payload(
                $status,
                [
                    [
                        'Id' => 1,
                        'Message' => 'Notification message 1'
                    ],
                    [
                        'Id' => 1,
                        'Message' => 'Notification message 2'
                    ],
                    [
                        'Id' => 1,
                        'Message' => 'Notification message 3'
                    ],
                    [
                        'Id' => 1,
                        'Message' => 'Notification message 4'
                    ],
                    [
                        'Id' => 1,
                        'Message' => 'Notification message 5'
                    ]
                ]
            )
        );
    }
}
