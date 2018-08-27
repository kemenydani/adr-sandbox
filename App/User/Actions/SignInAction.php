<?php

namespace App\User\Actions;

use App\Core\Session;
use App\User\Repository\UserMapper;
use App\User\Repository\UserRecord;
use App\User\Responders\SignInResponder;

use App\Core\Action;
use App\Core\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class SignInAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new UserMapper();
        $this->responder  = new SignInResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $formData = $request->getParsedBody();

        $Email    = @$formData['Email'];
        $Password = @$formData['Password'];

        $UserRecord = $this->repository->find($Email, 'Email');

        if($UserRecord instanceof UserRecord) Session::put('UserId', $UserRecord->getId());

        $status = $UserRecord ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;
        $data   = $UserRecord ? $UserRecord->getData(UserRecord::USER_EXCLUDE_CREDENTIALS, true) : [];

        return $this->responder->__invoke(
            new Payload(
                $status,
                $data
            )
        );
    }
}
