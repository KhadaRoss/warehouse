<?php

use api\FieldApi;
use api\ProductApi;
use api\SearchApi;
use api\ShelfApi;
use field\FieldModel;
use home\HomeController;
use home\HomeView;
use identity\IdentityModel;
use identity\LoginController;
use identity\LoginModel;
use identity\LoginView;
use identity\LogoutController;
use product\ProductModel;
use search\SearchController;
use search\SearchView;
use shelf\ShelfController;
use shelf\ShelfModel;
use shelf\ShelfView;
use sidebar\SidebarModel;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;
use system\StringsModel;

$container = $app->getContainer();

// controller

$container['homeController'] = function () {
    return function (Request $request, Response $response) {
        return new HomeController(
            $request,
            $response,
            new StringsModel(),
            new HomeView(),
            new SidebarModel()
        );
    };
};
$container['loginController'] = function () {
    return function (Request $request, Response $response) {
        return new LoginController(
            $request,
            $response,
            new StringsModel(),
            new LoginModel($request),
            new LoginView()
        );
    };
};
$container['logoutController'] = function () use ($container) {
    return function (Request $request, Response $response) use ($container) {
        return new LogoutController(
            $request,
            $response,
            new StringsModel(),
            $container->get('resetIdentity')
        );
    };
};
$container['searchController'] = function () {
    return function (Request $request, Response $response, array $args) {
        return new SearchController(
            $request,
            $response,
            $args,
            new StringsModel(),
            new ProductModel(),
            new SearchView(),
            new SidebarModel()
        );
    };
};
$container['shelfController'] = function () {
    return function (Request $request, Response $response, int $activeId) {
        return new ShelfController(
            $request,
            $response,
            $activeId,
            new StringsModel(),
            new FieldModel(),
            new ShelfModel(),
            new ShelfView(),
            new SidebarModel()
        );
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
$container['resetIdentity'] = function () {
    return function () {
        IdentityModel::reset();
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
