<?php

namespace App\Core;

use Psr\Http\Message\ResponseInterface;

interface ResponderInterface
{
    public function respond() : ResponseInterface;
}