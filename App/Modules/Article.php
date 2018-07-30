<?php

namespace App\Modules;

use App\Article\Actions\ListAction;

class Article
{
    public static $routes = [
        'article.list' => [
            'path' => 'articles',
            'callable' => ListAction::class,
            'middleware' => ''
        ]
    ];
}