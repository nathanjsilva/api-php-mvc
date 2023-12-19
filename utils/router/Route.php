<?php

namespace Utils\Router;

use App\Middlewares\MiddlewareInterface;
use Closure;

class Route
{
    private string $name;
    private string $method;
    private Closure $callback;
    private array $before = [];
    private array $after = [];

    public function __construct(string $name, string $method, Closure $callback)
    {
        $this->setName($name);
        $this->setMethod($method);
        $this->setCallback($callback);
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getCallback(): Closure
    {
        return $this->callback;
    }

    public function getBefore(): array
    {
        return $this->before;
    }

    public function getAfter(): array
    {
        return $this->after;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    public function before(MiddlewareInterface $middleware)
    {
        $this->before[] = $middleware;
        return $this;
    }

    public function after(MiddlewareInterface $middleware)
    {
        $this->after[] = $middleware;
        return $this;
    }
}
