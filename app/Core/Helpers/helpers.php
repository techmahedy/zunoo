<?php

use App\Core\Controllers\Controller;

/**
 * view.
 *
 * @author	Mahedi Hasan
 * @since	v0.0.1
 * @version	v1.0.0	Tuesday, October 31st, 2023.
 * @global
 * @param	mixed	$view	
 * @param	array	$data	Default: []
 * @return	mixed
 */
function view($view, $data = []): mixed
{
    $blade = new Controller;

    return $blade->render($view, $data);
}
