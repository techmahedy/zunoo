<?php

namespace App\Providers;

use App\Core\Container;

class AppServiceProvider extends Container
{
    public function register()
    {
        $this->directive('capitalize', function ($text) {
            return "<?php echo strtoupper($text) ?>";
        });
    }
}
