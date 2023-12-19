<?php

namespace App\Middlewares\Validations;

use App\Middlewares\MiddlewareInterface;
use Utils\Jwt;
use Utils\ResponseMessages\Response;
use Utils\Router\Request;

class Auth implements MiddlewareInterface
{
    public function handle(array $params = []): void
    {
        if (!self::validateAuthorizationToken()) Response::printJson('E004-001', 401);
    }

    /**
     * Validates user's authorization token
     * @return bool
     */
    private static function validateAuthorizationToken(): bool
    {
        $jwt     = new Jwt();
        $header  = Request::lowerCaseHeader();
        $token   = explode(" ", $header['authorization'])[1];
        $payload = $jwt->getPayload($token);
        $_SESSION['userId'] = $payload->userId;
        return $jwt->validate($token);
    }
}