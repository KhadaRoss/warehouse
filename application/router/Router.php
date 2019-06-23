<?php

namespace router;

use api\FieldApi;
use api\ProductApi;
use api\SearchApi;
use api\ShelfApi;
use home\HomeController;
use identity\IdentityModel;
use identity\LoginController;
use identity\LogoutController;
use Psr\Http\Message\ResponseInterface;
use search\SearchController;
use shelf\ShelfController;
use Slim\App;
use Slim\Container;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;

class Router
{
    /** @var Container */
    private $container;

    public function __construct()
    {
        $this->container = new Container();
        $this->setNotFoundHandler();
    }

    /**
     * @return void
     */
    private function setNotFoundHandler(): void
    {
        $this->container['notFoundHandler'] = function ($container) {
            return function (Request $request, Response $response) use (
                $container
            ) {
                if (IdentityModel::isLoggedIn()) {
                    return $response->withRedirect(URL . 'home');
                }

                return $response->withRedirect(URL . 'login');
            };
        };
    }

    /**
     * @return ResponseInterface|string
     */
    public function route()
    {
        $app = new App($this->container);

        $app->group('/search', function () use ($app) {
            $app->get('/{searchTerm}', function (Request $request, Response $response, array $args) {
                $response->write((new SearchController($request, $response, $args))->index());
            });
        })->add(function (Request $request, Response $response, Route $route) {
            return Router::handleAccess($request, $response, $route);
        });

        $app->group('/shelf', function () use ($app) {
            $app->get('/{id}', function (Request $request, Response $response, array $args) {
                $response->write((new ShelfController($request, $response, (int)$args['id']))->show());
            });
            $app->get('/{id}/open/{fieldId}/{productId}',
                function (Request $request, Response $response, array $args) {
                    $response->write((new ShelfController($request, $response, (int)$args['id']))->show());
                });
        })->add(function (Request $request, Response $response, Route $route) {
            return Router::handleAccess($request, $response, $route);
        });

        $app->group('/home', function () use ($app) {
            $app->get('', function (Request $request, Response $response) {
                $response->write((new HomeController($request, $response))->index());
            });
        })->add(function (Request $request, Response $response, Route $route) {
            return Router::handleAccess($request, $response, $route);
        });

        $app->group('/login', function () use ($app) {
            $app->get('', function (Request $request, Response $response) {
                $response->write((new LoginController($request, $response))->index());
            });
            $app->get('/error', function (Request $request, Response $response) {
                $response->write((new LoginController($request, $response))->error());
            });
            $app->post('/authenticate', function (Request $request, Response $response) {
                (new LoginController($request, $response))->authenticate();

                return $response->withRedirect(URL . (IdentityModel::isLoggedIn() ? 'home' : 'login/error'));
            });
        });

        $app->group('/api', function () use ($app) {
            $app->post('/shelf', function (Request $request, Response $response) {
                $response->write((new ShelfApi($request, $response))->newShelf());
            });
            $app->delete('/shelf/{id}', function (Request $request, Response $response, array $args) {
                $response->write((new ShelfApi($request, $response))->deleteShelf((int)$args['id']));
            });
            $app->post('/field', function (Request $request, Response $response) {
                $response->write((new FieldApi($request, $response))->newField());
            });
            $app->delete('/field/{id}', function (Request $request, Response $response, array $args) {
                $response->write((new FieldApi($request, $response))->deleteField((int)$args['id']));
            });
            $app->get('/fieldProducts/{id}', function (Request $request, Response $response, array $args) {
                $response->write((new FieldApi($request, $response))->getProductsByFieldId((int)$args['id']));
            });
            $app->post('/product', function (Request $request, Response $response) {
                $response->write((new ProductApi($request, $response))->new());
            });
            $app->put('/product', function (Request $request, Response $response) {
                $response->write((new ProductApi($request, $response))->update());
            });
            $app->get('/product/{id}', function (Request $request, Response $response, array $args) {
                $response->write((new ProductApi($request, $response))->get((int)$args['id']));
            });
            $app->delete('/product/{id}', function (Request $request, Response $response, array $args) {
                $response->write((new ProductApi($request, $response))->delete((int)$args['id']));
            });
            $app->get('/group/{term}', function (Request $request, Response $response, array $args) {
                $response->write((new SearchApi($request, $response))->get($args['term']));
            });
        })->add(function (Request $request, Response $response, Route $route) {
            return Router::handleAccess($request, $response, $route);
        });

        $app->get('/logout', function (Request $request, Response $response) {
            (new LogoutController($request, $response))->logout();

            return $response->withRedirect(URL . 'login');
        });

        try {
            return $app->run();
        } catch (\Exception | MethodNotAllowedException | NotFoundException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param Route    $route
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public static function handleAccess(Request $request, Response $response, Route $route): ResponseInterface
    {
        if (!IdentityModel::isLoggedIn()) {
            $response->getBody()->write('Forbidden');

            return $response->withStatus(403);
        }

        return $response = $route($request, $response);
    }
}
