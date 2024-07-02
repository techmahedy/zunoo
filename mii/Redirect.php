<?php

namespace Mii;

class Redirect
{
    /**
     * redirect.
     *
     * @author	Mahedi Hasan
     * @global
     * @param	mixed  	$url       	
     * @param	integer	$statusCode	Default: 302
     * @return	void
     */
    public function url($url, $statusCode = 302): void
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

    /**
     * back.
     *
     * @access	public
     * @return	void
     */
    public function back(): void
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
