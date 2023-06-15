<?php

use App\Controllers\Advertising;
use App\Controllers\Ajax;
use App\Controllers\Auth;
use App\Controllers\Credits;
use App\Controllers\Flags;
use App\Controllers\Services\Unban;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

require_once 'App/Config/Config.php';
require_once 'App/functions.php';
require_once 'vendor/autoload.php';

$dispatcher = FastRoute\cachedDispatcher(function (RouteCollector $r) {
    $r->addGroup('/payments', function (RouteCollector $r) {

        $r->addRoute('GET', '/', [Auth::class, 'login']);
        $r->addRoute('POST', '/', [Auth::class, 'loginForm']);
        $r->addRoute('GET', '/register', [Auth::class, 'register']);
        $r->addRoute('POST', '/register', [Auth::class, 'registerForm']);
        $r->addRoute('GET', '/logout', [Auth::class, 'logout']);
        $r->addRoute('GET', '/forgot-password', [Auth::class, 'forgotPassword']);
        $r->addRoute('POST', '/forgot-password', [Auth::class, 'forgotPasswordForm']);

        $r->addRoute('GET', '/reset-password/{token}', [Auth::class, 'resetPassword']);
        $r->addRoute('POST', '/reset-password/{token}', [Auth::class, 'resetPasswordForm']);

        $r->addRoute('GET', '/dashboard', [Auth::class, 'index']);

        $r->addRoute('GET', '/flags', [Flags::class, 'index']);
        $r->addRoute('GET', '/flags/buy/{id}', [Flags::class, 'buy']);
        $r->addRoute('POST', '/flags/buy/{id}', [Flags::class, 'buyForm']);

        $r->addRoute('GET', '/advertising', [Advertising::class, 'index']);
        $r->addRoute('POST', '/advertising', [Advertising::class, 'buyForm']);

        $r->addRoute('GET', '/transactions', [Auth::class, 'transactions']);
        $r->addRoute('GET', '/chronology', [Auth::class, 'chronology']);
        $r->addRoute('GET', '/unban', [Unban::class, 'index']);
        $r->addRoute('POST', '/unban', [Unban::class, 'remove']);

        $r->addRoute('GET', '/credits/sms', [Credits::class, 'smsTemplate']);
        $r->addRoute('POST', '/credits/sms', [Credits::class, 'sms']);

        if (getUser('admin') == 1) {
            $r->addGroup('/admin', function (RouteCollector $r) {
                $r->addRoute('GET', '/users', [\App\Controllers\Admin\Users::class, 'index']);
                $r->addRoute('GET', '/users/edit/{id}', [\App\Controllers\Admin\Users::class, 'edit']);
                $r->addRoute('POST', '/users/edit/{id}', [\App\Controllers\Admin\Users::class, 'editForm']);

                $r->addRoute('GET', '/credits', [\App\Controllers\Admin\Credits::class, 'index']);
                $r->addRoute('POST', '/credits', [\App\Controllers\Admin\Credits::class, 'AdForm']);
                $r->addRoute('GET', '/credits/edit/{id}', [\App\Controllers\Admin\Credits::class, 'edit']);
                $r->addRoute('POST', '/credits/edit/{id}', [\App\Controllers\Admin\Credits::class, 'editForm']);

                $r->addRoute('GET', '/flags', [\App\Controllers\Admin\Flags::class, 'index']);
                $r->addRoute('GET', '/flags/create', [\App\Controllers\Admin\Flags::class, 'create']);
                $r->addRoute('POST', '/flags/create', [\App\Controllers\Admin\Flags::class, 'createForm']);
                $r->addRoute('GET', '/flags/edit/{id}', [\App\Controllers\Admin\Flags::class, 'edit']);
                $r->addRoute('POST', '/flags/edit/{id}', [\App\Controllers\Admin\Flags::class, 'editForm']);
                $r->addRoute('GET', '/flags/remove/{id}', [\App\Controllers\Admin\Flags::class, 'remove']);
            });
        }

        $r->addGroup('/ajax', function (RouteCollector $r) {
            $r->addRoute('GET', '/flags', [Ajax::class, 'flags']);
        });
    });

}, [
    'cacheFile' => __DIR__ . '/cache/route/route.cache',
    'cacheDisabled' => true,
]);

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controllerClass, $method] = $handler;
        $controller = new $controllerClass();
        $response = call_user_func_array([$controller, $method], $vars);
        break;
}

\App\Session::delete('alert');