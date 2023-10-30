<?php

namespace App\Http\Controllers;

use App\Core\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        $title = 'blade test';

        // Custom directive test
        $this->directive('capitalize', function ($text) {
            return "<?php echo strtoupper($text) ?>";
        });
        dd(env('DB_CONNECTION'));
        return view('home.index', compact('title'));
    }
}
