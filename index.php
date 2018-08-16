<?php

require 'vendor/autoload.php';
require 'application.php';

//
/*
$app->get('/articles', App\Article\Actions\ListAction::class)
    ->add('App\Article\Middlewares\ArticleMiddleware:test');
*/


$app->group('/api', function()
{

    $this->get('/articles', App\Article\Actions\ListAction::class);

})->add(function($request, $response, $next)
{
    $response = $next( $request, $response );
    return $response
        ->withHeader( 'Access-Control-Allow-Origin', '*')
        ->withHeader( 'Access-Control-Allow-Credentials', 'true')
        ->withHeader( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )
        ->withHeader( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
});



$app->get('/article/view/{title}', App\Article\Actions\ViewAction::class)->setName('article.view');




try
{
    $app->run();
}
catch(Exception $e)
{
    echo 'Slim App: ' . $e->getMessage();
}
