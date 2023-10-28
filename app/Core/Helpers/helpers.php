<?php

function view($view, $data = [])
{
    $viewsPath = "resources/views";

    $viewPath = $viewsPath . '/' . $view . '.blade.php';

    if (!file_exists($viewPath)) {
        throw new Exception("View not found: $view");
    }

    ob_start();
    extract($data);
    include $viewPath;
    $content = ob_get_clean();

    // Implement Blade-like directives (e.g., @if, @foreach) and variable substitution here

    return $content;
}
