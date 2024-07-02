<?php


namespace Mii;

class Session
{
    /**
     * flash.
     *
     * @param	mixed	$key  	
     * @param	mixed	$value	
     * @return	void
     */
    public function flash($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get.
     *
     * @param	mixed	$key	
     * @return	mixed
     */
    public function get($key): mixed
    {
        $message = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $message;
    }

    /**
     * has.
     *
     * @param	mixed	$key	
     * @return	mixed
     */
    public function has($key): mixed
    {
        return $_SESSION[$key] ?? false;
    }
}
