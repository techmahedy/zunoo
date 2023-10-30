<?php

use App\Core\Controllers\Controller;

function view($view, $data = [])
{
    $blade = new Controller;

    return $blade->render($view, $data);
}
