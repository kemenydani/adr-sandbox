<?php

namespace App\Article\Responders;

use App\Core\Responder;

use Psr\Http\Message\ResponseInterface;

class ListResponder extends Responder
{
    public function respond($collection = null) : ResponseInterface
    {
        return $this->view->render($this->response, 'article/route.list.html.twig', [
            'foo' => 'foo'
        ]);
    }
}