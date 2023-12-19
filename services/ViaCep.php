<?php

namespace Services;

use Utils\CurlHandler;

class ViaCep
{
    const BASE_URL = 'viacep.com.br/ws/';

    private CurlHandler $curl;

    public function __construct()
    {
        $this->curl = new CurlHandler();
    }

    /**
     * Searches info for an informed ZIP (CEP) code
     *
     * @param string $cep
     * @return array
     */
    public function consultarCep(string $cep): array
    {
        return $this->response($this->curl->get(self::BASE_URL . $cep . "/json/unicode"));
    }

    /**
     * Searches for an address informed
     *
     * @param string $uf
     * @param string $cidade
     * @param string $logradouro
     * @return array
     */
    public function consultarEndereco(string $uf, string $cidade, string $logradouro): array
    {
        return $this->response($this->curl->get(self::BASE_URL . strtoupper($uf) . "/$cidade/$logradouro" . "/json"));
    }

    /**
     * Patternizes service's responses
     *
     * @param array $response
     * @return array
     */
    private function response(array $response): array
    {
        return ['error' => ($response['httpCode'] !== 200 || @$response['response']->{'erro'} === true), 'data' => $response['response']];
    }
}
