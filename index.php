<?php

require 'vendor/autoload.php';
require 'application.php';

//

$app->get('/articles', App\Article\Actions\ListAction::class)
    ->add('App\Article\Middlewares\ArticleMiddleware:test')
    ->setName('articles');

$app->get('/article/view/{title}', App\Article\Actions\ViewAction::class)->setName('article.view');




try
{
    $app->run();
}
catch(Exception $e)
{
    echo 'Slim App: ' . $e->getMessage();
}
