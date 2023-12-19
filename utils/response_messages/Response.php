<?php

namespace Utils\ResponseMessages;

use Utils\Router\Request;

class Response
{
    /**
     * Retorna um json de uma mensagem
     * @author Nathan Silva
     * @param string $cod Código da mensagem
     * @param int $httpCode
     * @param array $payload informações que possam ser necessárias
     * @return string
     */
    public static function getJson(string $cod, int $httpCode = 200, array $payload = []): string
    {
        header('Content-Type: application/json', true, $httpCode);
        return json_encode(self::getMessage($cod, $payload));
    }

    /**
     * Exibe uma mensagem em formato json já tratando o Content-Type e o status code do header da requisição
     * @author Nathan Silva
     * @param string $cod Código da mensagem
     * @param int $httpCode
     * @param array $payload informações que possam ser necessárias
     * @return void
     */
    public static function printJson(string $cod, int $httpCode = 200, array $payload = []): void
    {
        echo self::getJson($cod, $httpCode, $payload);
        exit;
    }

    /**
     * Retorna um array com uma mensagem
     * @author Nathan Silva
     * @param string $cod Código da mensagem
     * @param array $payload Array contendo informações que possam ser necessárias
     * @return array
     */
    public static function getMessage(string $cod, array $payload = []): array
    {
        return array_merge(['cod' => $cod, 'message' => Messages::getMessageByCode($cod), 'endpoint' => Request::getUrl()], $payload);
    }
}
