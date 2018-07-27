<?php

namespace App\Article\Responders;

use App\Core\Responder;

use Psr\Http\Message\ResponseInterface;

class ViewResponder extends Responder
{
    public function respond($collection = null) : ResponseInterface
    {
        return $this->response->write('article view response body');
    }
}