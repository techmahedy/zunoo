<?php

namespace App;

use App\TestInterface;

class TestClass implements TestInterface
{
    public function testName(): string
    {
        dd('Caleb Brooks');
    }
}
