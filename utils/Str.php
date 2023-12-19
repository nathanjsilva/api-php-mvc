<?php

namespace Utils;

use Utils\ResponseMessages\Response;

class Str
{
    /**
     * Formata a url para o padrão
     * @author Nathan Silva
     * @param string $url
     * @return string
     */
    public static function setUrlPattern(string $url): string
    {
        $url = explode('?', $url);
        return preg_replace('/\/$/', '', preg_replace('/^\//', '', trim($url[0])));
    }

    static function removeMascaras($string)
    {
        $string = str_replace('.', '', $string);
        $string = str_replace('/', '', $string);
        $string = str_replace('-', '', $string);
        $string = str_replace('(', '', $string);
        $string = str_replace(')', '', $string);
        $string = str_replace('R$', '', $string);
        $string = str_replace(' ', '', $string);

        return $string;
    }

    /**
     * Trata uma string json para uma linha
     * @param string $data
     * @return string
     */
    public static function dataToJsonStr($data)
    {
        if (is_object($data) || is_array($data)) return json_encode($data);
        return json_encode(json_decode(trim(preg_replace("/\r|\n/", "", $data))));
    }
}
