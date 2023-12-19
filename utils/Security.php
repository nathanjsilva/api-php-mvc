<?php

namespace Utils;

class Security
{
    public static function encryptPass($pass, $alg = 'sha256')
    {
        return hash($alg, $pass);
    }
}
