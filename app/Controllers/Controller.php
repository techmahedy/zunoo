<?php

namespace App\Controllers;

use Exception;

class Controller
{
    protected $viewsPath = "resources/views";

    public function view($view, $data = [])
    {
        $viewPath = $this->viewsPath . '/' . $view . '.blade.php';

        if (!file_exists($viewPath)) {
            throw new Exception("View not found: $view");
        }

        ob_start();
        extract($data);
        include $viewPath;
        $content = ob_get_clean();

        return $content;
    }
}
