<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'application.php';

session_start([
    'cookie_lifetime' => 86400,
    'read_and_close'  => true,
]);

$app->group('/api', function() {
    $this->get('/auth', App\User\Actions\AuthAction::class);
    $this->get('/articles', App\Article\Actions\ListAction::class);

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
