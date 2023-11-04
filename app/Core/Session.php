<?php


namespace App\Core;

class Session
{
    /**
     * flash.
     *
     * @param	mixed	$key  	
     * @param	mixed	$value	
     * @return	mixed
     */
    public function flash($key, $value): mixed
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * get.
     *
     * @param	mixed	$key	
     * @return	mixed
     */
    public function get($key): mixed
    {
        return $_SESSION[$key];
    }

    /**
     * has.
     *
     * @param	mixed	$key	
     * @return	mixed
     */
    public function has($key): mixed
    {
        // if ($this->has('errors')) {
        //     unset($_SESSION['errors']);
        //     return true;
        // }
        return $_SESSION[$key] ?? false;
    }
}
