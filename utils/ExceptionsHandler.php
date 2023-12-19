<?php

namespace Utils;

use Throwable;
use Utils\Files;
use Utils\ResponseMessages\Response;

class ExceptionsHandler
{
    protected Throwable $exception;
    protected string $messageCode;
    protected string $statusCode;
    protected Response $response;

    public function __construct(Throwable $exception, string $messageCode = "", int $statusCode = 500)
    {
        $this->_setException($exception);
        $this->_setMessageCode($messageCode);
        $this->_setStatusCode($statusCode);
        $this->response = new Response();
        return $this;
    }

    /**
     * @param Throwable $exception
     * @return void
     */
    public function _setException(Throwable $exception): void
    {
        $this->exception = $exception;
    }

    /**
     * @param string $messageCode
     * @return void
     */
    public function _setMessageCode(string $messageCode)
    {
        $this->messageCode = $messageCode;
    }

    /**
     * @param integer $statusCode
     * @return void
     */
    public function _setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return Throwable
     */
    public function _getException(): Throwable
    {
        return $this->exception;
    }

    /**
     * @return string
     */
    public function _getMessageCode(): string
    {
        return $this->messageCode;
    }

    /**
     * @return Response
     */
    public function _getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function _json(): string
    {
        return $this->response->getJson($this->messageCode, $this->getStatusCode(), $this->details());
    }

    /**
     * @return array
     */
    public function _array(): array
    {
        return $this->response->getMessage($this->messageCode, $this->details());
    }

    /**
     * @return void
     */
    public function _print(): void
    {
        $this->response->printJson($this->messageCode, $this->getStatusCode(), $this->details());
    }

    private function details(): array
    {
        $details = [
            "dateTime" => date('y-m-d H:i:s'),
            "details" => [
                "file"    => $this->_getException()->getFile(),
                "line"    => $this->_getException()->getLine(),
                "message" => $this->_getException()->getMessage(),
                "code"    => $this->_getException()->getCode(),
                "trace"   => $this->_getException()->getTrace()
            ]
        ];

        Files::logExceptions($details);

        if (ENVIRONMENT === 'production') unset($details['details']);
        return $details;
    }
}
