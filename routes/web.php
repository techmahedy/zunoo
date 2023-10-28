<?php

$app->route->get('/', function () {
    $data = [
        'title' => 'My Custom Blade Template',
        'name' => 'John Doe',
    ];

    return view('welcome', compact('data'));
});
