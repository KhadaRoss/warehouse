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
use system\Database;
use system\StringsModel;

$container = $app->getContainer();

// controller

$container['homeController'] = function () use ($container) {
    return function (Request $request, Response $response) use ($container) {
        return new HomeController(
            $request,
            $response,
            $container->get('stringsModel')(),
            $container->get('homeView'),
            $container->get('sidebarModel')(),
            $container->get('isLoggedIn')
        );
    };
};
$container['loginController'] = function () use ($container) {
    return function (Request $request, Response $response) use ($container) {
        return new LoginController(
            $request,
            $response,
            $container->get('stringsModel')(),
            $container->get('loginModel')($request),
            $container->get('loginView'),
            $container->get('isLoggedIn')
        );
    };
};
$container['logoutController'] = function () use ($container) {
    return function (Request $request, Response $response) use ($container) {
        return new LogoutController(
            $request,
            $response,
            $container->get('stringsModel')(),
            $container->get('resetIdentity'),
            $container->get('isLoggedIn')
        );
    };
};
$container['searchController'] = function () use ($container) {
    return function (Request $request, Response $response, array $args) use ($container) {
        return new SearchController(
            $request,
            $response,
            $args,
            $container->get('stringsModel')(),
            $container->get('productModel')(),
            $container->get('searchView'),
            $container->get('sidebarModel')(),
            $container->get('isLoggedIn')
        );
    };
};
$container['shelfController'] = function () use ($container) {
    return function (Request $request, Response $response, int $activeId) use ($container) {
        return new ShelfController(
            $request,
            $response,
            $activeId,
            $container->get('stringsModel')(),
            $container->get('fieldModel')(),
            $container->get('shelfModel')(),
            $container->get('shelfView'),
            $container->get('sidebarModel')(),
            $container->get('isLoggedIn')
        );
    };
};

// api

$container['fieldApi'] = function () use ($container) {
    return function (Request $request, Response $response) use ($container) {
        return new FieldApi(
            $request,
            $response,
            $container->get('fieldModel')(),
            $container->get('productModel')()
        );
    };
};
$container['productApi'] = function () use ($container) {
    return function (Request $request, Response $response) use ($container) {
        return new ProductApi($request, $response, $container->get('productModel')());
    };
};
$container['searchApi'] = function () use ($container) {
    return function (Request $request, Response $response) use ($container) {
        return new SearchApi($request, $response, $container->get('productModel')());
    };
};
$container['shelfApi'] = function () use ($container) {
    return function (Request $request, Response $response) use ($container) {
        return new ShelfApi($request, $response, $container->get('shelfModel')());
    };
};

// helper

$container['isLoggedIn'] = function () use ($container) {
    return IdentityModel::isLoggedIn($container->get('database'));
};
$container['resetIdentity'] = function () use ($container) {
    return function () use ($container) {
        IdentityModel::reset($container->get('database'));
    };
};
$container['handleIdentity'] = function () use ($container) {
    return function (Request $request, Response $response, Route $route, bool $onlyAjax = false) use ($container) {
        if (($onlyAjax && !IS_AJAX) || !$container->get('isLoggedIn')) {
            return $response->withRedirect(URL . 'login');
        }

        return $response = $route($request, $response);
    };
};
$container['database'] = function () {
    return Database::getConnection();
};

// models

$container['fieldModel'] = function () use ($container) {
    return function () use ($container) {
        return new FieldModel($container->get('database'));
    };
};
$container['identityModel'] = function () use ($container) {
    return function (int $userId, string $username) use ($container) {
        return new IdentityModel($container->get('database'), $userId, $username);
    };
};
$container['loginModel'] = function () use ($container) {
    return function (Request $request) use ($container) {
        return new LoginModel($container->get('database'), $request);
    };
};
$container['productModel'] = function () use ($container) {
    return function () use ($container) {
        return new ProductModel($container->get('database'));
    };
};
$container['shelfModel'] = function () use ($container) {
    return function () use ($container) {
        return new ShelfModel($container->get('database'));
    };
};
$container['sidebarModel'] = function () use ($container) {
    return function () use ($container) {
        return new SidebarModel($container->get('database'), $container->get('shelfModel')());
    };
};
$container['stringsModel'] = function () use ($container) {
    return function () use ($container) {
        return new StringsModel($container->get('database'));
    };
};

// views

$container['homeView'] = function () {
    return new HomeView();
};
$container['loginView'] = function () {
    return new LoginView();
};
$container['searchView'] = function () {
    return new SearchView();
};
$container['shelfView'] = function () {
    return new ShelfView();
};
