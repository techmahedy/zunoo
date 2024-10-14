<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\TestInterface;
use Mii\Controllers\Controller;

class ExampleController extends Controller
{
    public function __construct(private TestInterface $testInterface)
    {
        # code...
    }

    public function index(TestInterface $testInterface): string
    {
        return $this->testInterface->testName();
    }
}
