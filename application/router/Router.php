<?php

namespace router;

use api\FieldApi;
use api\ProductApi;
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

        $app->group('', function () use ($app) {
            $app->get('/home', function (Request $request, Response $response) {

                return $response->write((new HomeController($request, $response))->index());
            });
            $app->get('/shelf/{id}', function (Request $request, Response $response, array $args) {

                return $response->write((new ShelfController($request, $response, $args))->show());
            });
            $app->get('/logout', function (Request $request, Response $response) {

                (new LogoutController($request, $response))->logout();

                return $response->withRedirect(URL . 'login');
            });
            $app->get('/search/{searchTerm}', function (Request $request, Response $response, array $args) {

                return $response->write((new SearchController($request, $response, $args))->index());
            });
        })->add(function (Request $request, Response $response, Route $next) {
            if (IS_AJAX || IdentityModel::isLoggedIn()) {
                return $next($request, $response);
            }

            return $response->withRedirect(URL . 'login');
        });

        $app->group('/login', function () use ($app) {
            if (IdentityModel::isLoggedIn()) {
                $app->redirect(URL . 'login', URL . 'home');

                return;
            }

            $app->get('', function (Request $request, Response $response) {
                return $response->write((new LoginController($request, $response))->index());
            });
            $app->post('/authenticate', function (Request $request, Response $response) {
                (new LoginController($request, $response))->authenticate();

                return $response->withRedirect(URL . 'login/error');
            });
        })->add(function (Request $request, Response $response, Route $next) {
            if (IdentityModel::isLoggedIn()) {
                return $response->withRedirect(URL . 'home');
            }

            return $next($request, $response);
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
                $response->write((new ProductApi($request, $response))->newProduct());
            });
        })->add(function (Request $request, Response $response, Route $next) {
            if (!IS_AJAX || !IdentityModel::isLoggedIn()) {
                return $response->withRedirect(URL . 'login');
            }

            return $next($request, $response);
        });

        try {
            return $app->run();
        } catch (\Exception | MethodNotAllowedException | NotFoundException $e) {
            return $e->getMessage();
        }
    }
}
