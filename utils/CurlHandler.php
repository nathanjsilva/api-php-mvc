<?php

namespace Utils;

use App\Models\RequestLogs;
use Utils\ExceptionsHandler;
use Exception;

class CurlHandler
{
    private $curl;
    private int $userId;
    private array $header;
    private array $data;
    private string $url;

    public function __construct(array $header = [])
    {
        $this->userId = $_SESSION['userId'];
        $this->curl = curl_init();
        $this->header = $header;
    }

    public function get(string $url, array $data = []): array
    {
        $this->url = $url;
        $this->data = $data;
        try {
            if (!empty($data)) $url = sprintf("%s?%s", $url, http_build_query($data));
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
            return $this->request();
        } catch (\Exception $e) {
            (new ExceptionsHandler($e, 'E000-004', 500))->_print();
        }
    }

    public function post(string $url, array $data = []): array
    {
        $this->url = $url;
        $this->data = $data;
        try {
            $this->addHeader(['Content-Type: application/json']);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($this->curl, CURLOPT_POST, true);
            if (!empty($data)) curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
            return $this->request();
        } catch (\Exception $e) {
            (new ExceptionsHandler($e, 'E000-004', 500))->_print();
        }
    }

    public function put(string $url, array $data = []): array
    {
        $this->url = $url;
        $this->data = $data;
        try {
            $this->addHeader(['Content-Type: application/json']);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            if (!empty($data)) curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
            return $this->request();
        } catch (\Exception $e) {
            (new ExceptionsHandler($e, 'E000-004', 500))->_print();
        }
    }

    public function patch(string $url, array $data = []): array
    {
        $this->url = $url;
        $this->data = $data;
        try {
            $this->addHeader(['Content-Type: application/json']);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
            if (!empty($data)) curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
            return $this->request();
        } catch (\Exception $e) {
            (new ExceptionsHandler($e, 'E000-004', 500))->_print();
        }
    }

    public function delete(string $url, array $data = []): array
    {
        $this->url = $url;
        $this->data = $data;
        try {
            $this->addHeader(['Content-Type: application/json']);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
            if (!empty($data)) curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
            return $this->request();
        } catch (\Exception $e) {
            (new ExceptionsHandler($e, 'E000-004', 500))->_print();
        }
    }

    public function addHeader(array $array): void
    {
        $this->header = array_merge($this->header, $array);
    }

    private function request(): array
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_ENCODING, '');
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->header);

        $response  = curl_exec($this->curl);
        $curlError = curl_error($this->curl);
        $httpCode  = (int) curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $curlInfo  = curl_getinfo($this->curl);
        curl_close($this->curl);

        Files::logCurlRequests($this->userId, $this->url, json_encode($this->data), $response, $httpCode, $curlError, json_encode($curlInfo));

        (new RequestLogs([
            "userId"     => $this->userId,
            "requestUrl" => $this->url,
            "request"    => json_encode($this->data),
            "response"   => $response,
            "statusCode" => $httpCode,
            "errors"     => $curlError
        ]))->insert();

        $response  = json_decode($response);

        if (!empty($curlError)) throw new Exception('[CurlHandler] "' . $curlError . '"');
        // if (!$response)         throw new Exception('[CurlHandler] Json decode failed');

        return [
            "response" => $response,
            "httpCode" => $httpCode
        ];
    }
}
