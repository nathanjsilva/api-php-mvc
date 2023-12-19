<?php

namespace App\Middlewares;

/**
 * interface MiddlewareInterface Padroniza o modelo de middlewares para implementação
 */

interface MiddlewareInterface
{
    /**
     * @method handle Executa o tratamento do middleware
     */
    public function handle(array $params = []): void;
}
