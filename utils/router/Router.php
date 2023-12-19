<?php

namespace Utils\Router;

use Closure;
use Utils\Str;

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @author Nathan Silva
     * @param string $url Endpoint para ser adicionado às rotas GET do sistema
     * @param Closure $callback
     * @return Route
     */
    public function get(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'GET');
    }

    /**
     * @author Nathan Silva
     * @param string $url Endpoint para ser adicionado às rotas POST do sistema
     * @param Closure $callback
     * @return Route
     */
    public function post(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'POST');
    }

    /**
     * @author Nathan Silva
     * @param string $url Endpoint para ser adicionado às rotas PUT do sistema
     * @param Closure $callback
     * @return Route
     */
    public function put(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'PUT');
    }

    /**
     * @author Nathan Silva
     * @param string $url Endpoint para ser adicionado às rotas DELETE do sistema
     * @param Closure $callback
     * @return Route
     */
    public function delete(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'DELETE');
    }

    /**
     * @author Nathan Silva
     * @param string $url Endpoint para ser adicionado às rotas PATCH do sistema
     * @param Closure $callback
     * @return Route
     */
    public function patch(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'PATCH');
    }

    /**
     * Registra as rotas no sistema
     * @author Nathan Silva
     * @param string $url
     * @param Closure $callback
     * @param string $method
     * @return Route
     */
    private function addRoute(string $url, Closure $callback, string $method): Route
    {
        $url = Str::setUrlPattern($url);
        return $this->routes[$method][$url] = new Route($url, $method, $callback);
    }
}
