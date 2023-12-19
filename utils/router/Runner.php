<?php

namespace Utils\Router;

use App\Middlewares\MiddlewareRunner;
use Utils\ResponseMessages\Response;
use Utils\Str;

class Runner
{
    private string $url;
    private Request $request;
    private Router $router;

    public function __construct(Router $router)
    {
        $this->request = new Request();
        $this->router  = $router;
        $this->url     = Str::setUrlPattern($this->request->getUrl());
    }

    /**
     * Executa o projeto
     * @author Nathan Silva
     * @return void
     */
    public function run(): void
    {
        $route = $this->getRoute();
        if ($route === null) Response::printJson('E000-001', 404);
        MiddlewareRunner::validate($route->getBefore());
        echo $route->getCallback()($this->request);
        MiddlewareRunner::validate($route->getAfter());
    }

    /**
     * @author Nathan Silva
     * @return Route|null
     */
    private function getRoute()
    {
        return $this->router->getRoutes()[$this->request->getMethod()][$this->url] ?? null;
    }
}