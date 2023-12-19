<?php

namespace App\Middlewares;

use App\Middlewares\MiddlewareInterface;

class MiddlewareRunner
{
    /**
     * @param array $middlewares coleção de middlewares
     * @return void
     */
    public static function validate(array $middlewares)
    {
        /**
         * @var MiddlewareInterface $middleware
         */
        foreach ($middlewares as $middleware) {
            $middleware->handle();
        }
    }
}
