<?php

namespace Utils\Router;

class Request
{
    /**
     * Retorna o endpoint da request
     */
    public static function getUrl(): string
    {
        return @$_GET['url'];
    }

    /**
     * Retorna o método da requisição
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Retorna um array com os dados da request
     */
    public function getData(): array
    {
        switch ($this->getMethod()) {
            case 'GET':
                return $_GET;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), 1);
                if (is_null($data))  $data = $_POST;
                if (!empty($_FILES)) $data = array_merge($data, $_FILES);
                return (array) $data;
            default:
                $data = json_decode(file_get_contents('php://input'), 1);
                if (is_null($data)) $data = $_POST;
                return (array) $data;
        }
    }

    public static function lowerCaseHeader()
    {
        $header = apache_request_headers();
        foreach ($header as $key => $h) $header[strtolower($key)] = $h;
        return $header;
    }
}
