<a name="section-1"></a>
# How to use

- [About](#section-1)
- [Define Route](#section-2)
- [Route Parameter](#section-8)
- [Multiple Route Parameters](#section-9)
- [Binding Interface to Service Class](#section-3)
- [Controller Method Dependency Injection](#section-4)
- [Model](#section-5)
- [Database Connection](#section-6)
- [Views](#section-7)

<a name="section-1"></a>

## About
This is a mini PHP framework with some basic features like di-container, dependency injection, routing, accepting request with routing, controller and model.

<a name="section-2"></a>

## Define Route
To define route, navigate to this file and update
### `routes/web.php`
```php

<?php
use App\Controllers\TestController;

$app->route->get('/', [TestController::class, 'index']);
$app->route->get('/about', [TestController::class, 'about']);
```

<a name="section-3"></a>

## Binding Interface to Service Class
To bind interface with your service class, just update `App\Providers\AppServiceProvider.php`.

```php
<?php

namespace App\Providers;

use App\Core\Container;
use App\Services\StripePaymentService;
use App\Contracts\PaymentServiceContract;

class AppServiceProvider extends Container
{
    public function register()
    {
       return $this->bind(PaymentServiceContract::class, StripePaymentService::class);
    }
}
```

<a name="section-4"></a>

## Dependency Injection
Now look at that, how you can use dependency injection.
```php

<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Core\Request;
use App\Contracts\PaymentServiceContract;

class TestController
{   
    /**
     * You can pass as many class as you want as parameter
     */
    public function index(
        Request $request, //class dependency injection
        User $user, //class dependency injection
        Post $post, //class dependency injection
        PaymentServiceContract $payment //interface dependency injection
    ) {
        
        /**
         * The request you are sending
         */
        $data = $request->getBody();
        
        /**
         * You can use here Laravel eloquent query
         */
        User::orderBy('id', 'desc')->first();
    }

    public function about()
    {
        return "About";
    }
}
```

<a name="section-5"></a>

## Model
Now look at Model, how you can use it
```php

use Illuminate\Database\Eloquent\Model;

class User extends Model
{   
    /**
     * You can use any features of Laravel inside this Model class
     */
}
```

<a name="section-6"></a>

## Database Connection
Connect your database like that, just pass your credentials to `.env`
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

```

And you can print configuration value like `$_ENV['DB_CONNECTION']`

<a name="section-7"></a>

## Views
To work with views, default view file path inside `resources/views`. Now passing data with views like
```php
<?php

$app->route->get('/', function () {
    $data = [
        'title' => 'My Custom Blade Template',
        'name' => 'John Doe',
    ];

    return view('welcome', compact('data'));
});
```

This will load `welcome.blade.php` file. We can print this value like

```HTML
<h1>Welcome, <?php echo $data['name']; ?></h1>
```

<a name="section-8"></a>

## Route Parameters
You can pass single or multiple parameter with route as like below
```php
<?php

use App\Controllers\ProfileController;

$app->route->get('/user/{id}', [ProfileController::class, 'index']);
```

Now accept this param in your controller like:

```php
<?php

namespace App\Controllers;

use App\Core\Request;

class ProfileController
{
    public function index(Request $request)
    {
        return $request->params['id'];
    }
}
```

<a name="section-9"></a>

## Multiple Route Parameters
You can pass multiple parameter with route as like below
```php
<?php

use App\Controllers\ProfileController;

$app->route->get('/user/{id}/{username}', [ProfileController::class, 'index']);
```

Now accept this multiple param in your controller like:

```php
<?php

namespace App\Controllers;

use App\Core\Request;

class ProfileController
{
    public function index(Request $request)
    {
        $id = $request->params['id'];
        $username = $request->params['username'];

        dd($request->params);
    }
}
```