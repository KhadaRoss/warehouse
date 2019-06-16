<?php

namespace router;

use home\HomeController;
use identity\IdentityModel;
use identity\LoginController;
use identity\LogoutController;
use Psr\Http\Message\ResponseInterface;
use shelf\ShelfController;
use Slim\App;
use Slim\Container;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

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
            if (!IdentityModel::isLoggedIn()) {
                $app->redirect(URL . '/home', URL . '/login');

                return;
            }

            $app->get('/home', function (Request $request, Response $response) {

                return $response->write((new HomeController($request, $response))->index());
            });
            $app->get('/shelf/{id}', function (Request $request, Response $response, array $args) {

                return $response->write((new ShelfController($request, $response, $args))->show());
            });
            $app->get('/logout', function (Request $request, Response $response) {

                (new LogoutController($request, $response))->logout();

                return $response->withRedirect(URL . '/login');
            });
        });

        $app->group('/login', function () use ($app) {
            if (IdentityModel::isLoggedIn()) {
                $app->redirect(URL . '/login', URL . '/home');

                return;
            }

            $app->get('', function (Request $request, Response $response) {
                return $response->write((new LoginController($request, $response))->index());
            });
            $app->post('/authenticate', function (Request $request, Response $response) {
                (new LoginController($request, $response))->authenticate();

                return $response->withRedirect(URL . 'login/error');
            });
            $app->get('/error', function (Request $request, Response $response) {
                return $response->write((new LoginController($request, $response))->error());
            });
        });

        try {
            return $app->run();
        } catch (\Exception | MethodNotAllowedException | NotFoundException $e) {
            return $e->getMessage();
        }
    }
}
