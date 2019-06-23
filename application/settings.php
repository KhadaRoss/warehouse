<?php

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @param Container $container
 *
 * @return Closure
 */
$container['notFoundHandler'] = function ($container) {
    return function (Request $request, Response $response) use ($container) {
        if ($container->get('isLoggedIn')) {
            return $response->withRedirect(URL . 'home');
        }

        return $response->withRedirect(URL . 'login');
    };
};
