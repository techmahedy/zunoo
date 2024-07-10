<?php

namespace App\Http\Controllers;

use App\Interface\ConnectionInterface;

class ExampleController extends Controller
{
    public function index(ConnectionInterface $connectionInterface)
    {
        return $connectionInterface->getConnection();
    }
}
