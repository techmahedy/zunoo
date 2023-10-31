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
    return (new Controller())->render($view, $data);
}

/**
 * redirect.
 *
 * @author	Mahedi Hasan
 * @since	v0.0.1
 * @version	v1.0.0	Tuesday, October 31st, 2023.
 * @global
 * @param	mixed  	$url       	
 * @param	integer	$statusCode	Default: 302
 * @return	void
 */
function redirect($url, $statusCode = 302)
{
    if (!headers_sent()) {
        // If headers haven't been sent yet, perform the redirect
        header('Location: ' . $url, true, $statusCode);
        exit();
    } else {
        // If headers have already been sent, you can output a message or handle it in some way
        echo "Headers have already been sent. Unable to redirect.";
    }
}
