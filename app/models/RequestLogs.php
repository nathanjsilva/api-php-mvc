<?php

namespace App\Models;

use App\Model;
use Utils\ExceptionsHandler;

class RequestLogs extends Model
{
    private int $id;
    private int $userId;
    private string $createdAt;
    private string $requestUrl;
    private string $request;
    private string $response;
    private string $statusCode;
    private string $errors;

    public function __construct($attrs = [])
    {
        if ($attrs) {
            $this->setId(@$attrs['id'] ?? 0);
            $this->setUserId(@$attrs['userId'] ?? 0);
            $this->setCreatedAt(@$attrs['createdAt'] ?? "");
            $this->setRequestUrl(@$attrs['requestUrl'] ?? "");
            $this->setRequest(@$attrs['request'] ?? "");
            $this->setResponse(@$attrs['response'] ?? "");
            $this->setStatusCode(@$attrs['statusCode'] ?? "");
            $this->setErrors(@$attrs['errors'] ?? "");
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function getErrors(): string
    {
        return $this->errors;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setRequestUrl($requestUrl): void
    {
        $this->requestUrl = $requestUrl;
    }

    public function setRequest($request): void
    {
        $this->request = $request;
    }

    public function setResponse($response): void
    {
        $this->response = $response;
    }

    public function setStatusCode($statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function setErrors($errors): void
    {
        $this->errors = $errors;
    }

    public function insert(): int
    {
        try {
            return (int) $this->runQuery(
                "INSERT INTO request_logs SET
                created_at  = NOW(),
                user_id     = :user_id,
                request_url = :request_url,
                request     = :request,
                response    = :response,
                status_code = :status_code,
                errors      = :errors", 
                [
                    ':user_id'     => $this->userId,
                    ':request_url' => $this->requestUrl,
                    ':request'     => $this->request,
                    ':response'    => $this->response,
                    ':status_code' => $this->statusCode,
                    ':errors'      => $this->errors,
                ]
            )->getLastId();
        } catch (\Exception $e) {
            (new ExceptionsHandler($e, 'E031-001', 500))->_print();
        }
    }
}
