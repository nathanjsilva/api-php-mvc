<?php

namespace App\Controllers;

use Services\ViaCep;
use Utils\ResponseMessages\Response;
use Utils\Str;

class ExempleController
{
    public function consultarCep(array $data): string
    {
        $consulta = (new ViaCep())->consultarCep(Str::removeMascaras($data['CEP']));
        if ($consulta['error']) return Response::getJson('E023-001', 502);

        return Response::getJson('S023-001', 200, [
            "consulta" => [
                "cep"        => $consulta['data']->{'cep'},
                "logradouro" => $consulta['data']->{'logradouro'},
                "bairro"     => $consulta['data']->{'bairro'},
                "estado"     => $consulta['data']->{'localidade'},
                "uf"         => $consulta['data']->{'uf'},
                "ddd"        => $consulta['data']->{'ddd'},
            ]
        ]);
    }

    public function consultarEndereco(array $data): string
    {
        $consulta = (new ViaCep())->consultarEndereco($data['UF'], $data['CIDADE'], $data['LOGRADOURO']);
        if ($consulta['error']) return Response::getJson('E023-001', 502);

        $results = ["results" => []];
        foreach ($consulta['data'] as $result) {
            $results["results"][] = [
                "cep"        => $result->cep,
                "logradouro" => $result->logradouro,
                "bairro"     => $result->bairro,
                "estado"     => $result->localidade,
                "uf"         => $result->uf,
                "ddd"        => $result->ddd,
            ];
        }

        return Response::getJson('S023-001', 200, $results);
    }
}
