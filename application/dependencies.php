<?php

use api\FieldApi;
use api\ProductApi;
use api\SearchApi;
use api\ShelfApi;
use home\HomeController;
use identity\IdentityModel;
use identity\LoginController;
use identity\LogoutController;
use search\SearchController;
use shelf\ShelfController;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

$container = $app->getContainer();

// controller

$container['homeController'] = function () {
    return function (Request $request, Response $response) {
        return new HomeController($request, $response);
    };
};
$container['loginController'] = function () {
    return function (Request $request, Response $response) {
        return new LoginController($request, $response);
    };
};
$container['logoutController'] = function () {
    return function (Request $request, Response $response) {
        return new LogoutController($request, $response);
    };
};
$container['searchController'] = function () {
    return function (Request $request, Response $response, array $args) {
        return new SearchController($request, $response, $args);
    };
};
$container['shelfController'] = function () {
    return function (Request $request, Response $response, int $activeId) {
        return new ShelfController($request, $response, $activeId);
    };
};

// api

$container['fieldApi'] = function () {
    return function (Request $request, Response $response) {
        return new FieldApi($request, $response);
    };
};
$container['productApi'] = function () {
    return function (Request $request, Response $response) {
        return new ProductApi($request, $response);
    };
};
$container['searchApi'] = function () {
    return function (Request $request, Response $response) {
        return new SearchApi($request, $response);
    };
};
$container['shelfApi'] = function () {
    return function (Request $request, Response $response) {
        return new ShelfApi($request, $response);
    };
};

// helper

$container['isLoggedIn'] = function () {
    return function () {
        return IdentityModel::isLoggedIn();
    };
};
$container['handleIdentity'] = function () use ($container) {
    return function (Request $request, Response $response, Route $route, bool $onlyAjax = false) use ($container) {
        if (($onlyAjax && !IS_AJAX) || !$container->get('isLoggedIn')()) {
            return $response->withRedirect(URL . 'login');
        }

        return $response = $route($request, $response);
    };
};
