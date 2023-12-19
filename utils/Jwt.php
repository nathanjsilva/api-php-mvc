<?php

namespace Utils;

class Jwt
{
    const TYP = "JWT";
    const ALG = "HS256";
    /**
     * Tempo de vida do token em segundos
     * @var int ALIVE_FOR
     */
    const ALIVE_FOR = 3600;

    /**
     * Cria o token
     *
     * @param array $payload Dados necessários no payload do token
     * @return array [
     *  token - jwt gerado
     *  exp - timestamp de expiração do token
     * ]
     */
    public function create(array $payload): array
    {
        $iat = time();
        $exp = $iat + self::ALIVE_FOR;

        $header    = $this->base64UrlEncode(json_encode(['typ' => self::TYP, 'alg' => self::ALG]));
        $payload   = $this->base64UrlEncode(json_encode(array_merge($payload, ['iat' => $iat, 'exp' => $exp])));
        $signature = $this->base64UrlEncode($this->sign($header, $payload));

        return [
            "token" => $header . "." . $payload . "." . $signature,
            "exp" => $exp
        ];
    }

    /**
     * Valida o jwt
     *
     * @param string $jwt
     * @return boolean
     */
    public function validate(string $jwt): bool
    {
        $tokenParts        = explode('.', $jwt);
        $header            = base64_decode($tokenParts[0]);
        $payload           = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        if (!$this->validateExp($payload)) return false;

        $encodedHeader  = $this->base64UrlEncode($header);
        $encodedPayload = $this->base64UrlEncode($payload);
        $signature      = $this->base64UrlEncode($this->sign($encodedHeader, $encodedPayload));

        return $signature === $signatureProvided;
    }

    /**
     * Valida a data de expiração do token
     *
     * @param string $payload
     * @return boolean
     */
    public function validateExp(string $payload): bool
    {
        $payload = json_decode($payload);
        return $payload->exp > time();
    }

    /**
     * Lê o payload do jwt
     *
     * @param string $jwt
     * @return object
     */
    public function getPayload(string $jwt): object
    {
        $tokenParts = explode('.', $jwt);
        return json_decode(base64_decode($tokenParts[1]));
    }

    /**
     * Assina o token
     *
     * @param string $encodedHeader
     * @param string $encodedPayload
     * @return string
     */
    private function sign(string $encodedHeader, string $encodedPayload): string
    {
        return hash_hmac($this->getHashAlgName(), $encodedHeader . "." . $encodedPayload, SECRET, true);
    }

    /**
     * Recupera o algoritmo de criptografia
     *
     * @return string
     */
    private function getHashAlgName(): string
    {
        switch (self::ALG) {
            case 'HS256':
                return 'sha256';
            default:
                throw new \Exception("Jwt::ALG not identified");
        }
    }

    /**
     * @param string $str
     * @return string
     */
    private function base64UrlEncode(string $str): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($str));
    }
}
