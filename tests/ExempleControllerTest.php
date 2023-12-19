<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Controllers\ExempleController;

class ExempleControllerTest extends TestCase
{
    public function testViaCep()
    {
        $exemple = new ExempleController();
        $this->assertTrue($exemple->viaCep([
            "CEP" => "01001-000"
        ]));
    }
}
