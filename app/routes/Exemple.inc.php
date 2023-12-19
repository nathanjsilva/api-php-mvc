<?php

namespace App\Routes;

use App\Controllers\ExempleController;
use App\Middlewares\Validations\Auth;
use Utils\Router\Request;
use Utils\Router\Router;

/**
 * @var Router $router
 */

$router->get('/exemple', fn (Request $request) => (new ExempleController())->consultarCep($request->getData()))->before(new Auth());

$router->get('/exemple/address', fn (Request $request) => (new ExempleController())->consultarEndereco($request->getData()))->before(new Auth());
