<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'application.php';

session_start();

function array_keys_included(array $array = [], array $keyMap = [])
{
    return  array_intersect_key($array, array_flip($keyMap));
}

function array_keys_excluded(array $array  = [], array $keyMap = [])
{
    return array_diff_key($array, array_flip($keyMap));
}

$app->group('/api', function()
{
    $this->get('/auth', App\User\Actions\AuthAction::class);
    $this->post('/signin', App\User\Actions\SignInAction::class);
    $this->get('/articles', App\Article\Actions\ListAction::class);

    $this->get('/user/notifications', App\User\Actions\NotificationAction::class);
    $this->get('/user/conversations', App\User\Actions\ConversationAction::class);

})->add(function($request, $response, $next) {
    $response = $next( $request, $response );
    return $response
        ->withHeader( 'Access-Control-Allow-Origin', '*')
        ->withHeader( 'Access-Control-Allow-Credentials', 'true')
        ->withHeader( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )
        ->withHeader( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
});


try
{
    $app->run();
}
catch(Exception $e)
{
    echo 'Slim App: ' . $e->getMessage();
}
