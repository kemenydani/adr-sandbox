<?php

namespace App\Article\Responders;

use App\Core\Payload;
use App\Core\Responder;

use Psr\Http\Message\ResponseInterface;

class ListResponder extends Responder
{
    public function __invoke(Payload $payload)
    {
        return $this->respond($payload);
    }

    public function respond(Payload $payload) : ResponseInterface
    {
        //if($this->request->isXhr())

        return $this->response->withJson([
            ['title' => 'bar'],
            ['title' => 'baz'],
        ]);

        return $this->view->render($this->response, 'article/route.list.html.twig', [
            'foo' => 'foo'
        ]);
    }

}
