<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

$app->group('/search', function () use ($app) {
    $app->get('/{searchTerm}', function (Request $request, Response $response, array $args) {
        $searchController = $this->get('searchController');

        $response->write($searchController($request, $response, $args)->index());
    });
})->add(function (Request $request, Response $response, Route $route) {
    $handleIdentity = $this->get('handleIdentity');

    return $handleIdentity($request, $response, $route);
});

$app->group('/shelf', function () use ($app) {
    $app->get('/{id}', function (Request $request, Response $response, array $args) {
        $shelfController = $this->get('shelfController');
        $activeId = (int)$args['id'];

        $response->write($shelfController($request, $response, $activeId)->show());
    });
    $app->get('/{id}/open/{fieldId}/{productId}', function (Request $request, Response $response, array $args) {
        $shelfController = $this->get('shelfController');
        $activeId = (int)$args['id'];

        $response->write($shelfController($request, $response, $activeId)->show());
    });
})->add(function (Request $request, Response $response, Route $route) {
    $handleIdentity = $this->get('handleIdentity');

    return $handleIdentity($request, $response, $route);
});

$app->group('/home', function () use ($app) {
    $app->get('', function (Request $request, Response $response) {
        $homeController = $this->get('homeController');

        $response->write($homeController($request, $response)->index());
    });
})->add(function (Request $request, Response $response, Route $route) {
    $handleIdentity = $this->get('handleIdentity');

    return $handleIdentity($request, $response, $route);
});

$app->group('/login', function () use ($app) {
    $app->get('', function (Request $request, Response $response) {
        $loginController = $this->get('loginController');

        $response->write($loginController($request, $response)->index());
    });
    $app->get('/error', function (Request $request, Response $response) {
        $loginController = $this->get('loginController');

        $response->write($loginController($request, $response)->error());
    });
    $app->post('/authenticate', function (Request $request, Response $response) {
        $loginController = $this->get('loginController');
        $loginController($request, $response)->authenticate();

        return $response->withRedirect(URL . ($this->get('isLoggedIn') ? 'home' : 'login/error'));
    });
})->add(function (Request $request, Response $response, Route $route) {
    if ($this->get('isLoggedIn')) {
        return $response->withRedirect(URL . 'home');
    }

    return $route($request, $response);
});

$app->group('/api', function () use ($app) {
    $app->post('/shelf', function (Request $request, Response $response) {
        $shelfApi = $this->get('shelfApi');

        $response->write($shelfApi($request, $response)->newShelf());
    });
    $app->delete('/shelf/{id}', function (Request $request, Response $response, array $args) {
        $shelfApi = $this->get('shelfApi');

        $response->write($shelfApi($request, $response)->deleteShelf((int)$args['id']));
    });
    $app->post('/field', function (Request $request, Response $response) {
        $fieldApi = $this->get('fieldApi');

        $response->write($fieldApi($request, $response)->newField());
    });
    $app->delete('/field/{id}', function (Request $request, Response $response, array $args) {
        $fieldApi = $this->get('fieldApi');

        $response->write($fieldApi($request, $response)->deleteField((int)$args['id']));
    });
    $app->get('/fieldProducts/{id}', function (Request $request, Response $response, array $args) {
        $fieldApi = $this->get('fieldApi');

        $response->write($fieldApi($request, $response)->getProductsByFieldId((int)$args['id']));
    });
    $app->post('/product', function (Request $request, Response $response) {
        $productApi = $this->get('productApi');

        $response->write($productApi($request, $response)->new());
    });
    $app->put('/product', function (Request $request, Response $response) {
        $productApi = $this->get('productApi');

        $response->write($productApi($request, $response)->update());
    });
    $app->get('/product/{id}', function (Request $request, Response $response, array $args) {
        $productApi = $this->get('productApi');

        $response->write($productApi($request, $response)->get((int)$args['id']));
    });
    $app->delete('/product/{id}', function (Request $request, Response $response, array $args) {
        $productApi = $this->get('productApi');

        $response->write($productApi($request, $response)->delete((int)$args['id']));
    });
    $app->get('/group/{term}', function (Request $request, Response $response, array $args) {
        $searchApi = $this->get('searchApi');

        $response->write($searchApi($request, $response)->get($args['term']));
    });
})->add(function (Request $request, Response $response, Route $route) {
    $handleIdentity = $this->get('handleIdentity');

    return $handleIdentity($request, $response, $route, true);
});

$app->get('/logout', function (Request $request, Response $response) {
    $logoutController = $this->get('logoutController');
    $logoutController($request, $response)->logout();

    return $response->withRedirect(URL . 'login');
});
