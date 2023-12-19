<?php

/**
 * Trata as exceptions lançadas no sistema
 * @return void Response::printJson
 */
function catch_fatal_error()
{
    $lastError     = error_get_last();
    $captureErrors = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR]; // CÓDIGOS DE ERRO PARA TRATAR
    /* TRATA OS ERROS QUE FINALIZAM A EXECUÇÃO DO CÓDIGO */
    if ($lastError !== null && in_array($lastError['type'], $captureErrors)) {
        $file     = $lastError['file'];
        $fileLine = $lastError['line'];
        $message  = $lastError['message'];

        $details = [
            "dateTime" => date('y-m-d H:i:s'),
            "details" => [
                "file"    => $file,
                "line"    => $fileLine,
                "message" => $message,
            ]
        ];

        if (ENVIRONMENT === 'production') unset($details['details']);

        \Utils\Files::logExceptions($details);
        session_destroy();
        \Utils\ResponseMessages\Response::printJson('E000-000', 500, $details);
    }
}

/**
 * Creates apache_request_headers if don't exists
 */
if (!function_exists('apache_request_headers')) {
    function apache_request_headers()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

/**
 * Require message files
 *
 * @param string $dir
 * @return void
 */
function requireMessagesFiles($dir = 'app/messages/')
{
    foreach (new \DirectoryIterator($dir) as $f) {
        if (!$f->isDot()) {
            $f->isDir() ? requireMessagesFiles($dir . $f->getFilename() . "/") : require $dir . $f->getFilename();
        }
    }
}

