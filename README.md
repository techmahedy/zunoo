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
- [Global Middleware](#section-10)

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

class TestController extends Controller
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

use App\Core\Application;

$app->route->get('/', function () {
    $version = Application::VERSION;
    
    //for nested folder file view: home.index
    return view('welcome', compact('version'));
});
```

This will load `welcome.blade.php` file. We can print this value like

```HTML
<h1>{{ $version }}</h1>
```
### Avaiable blade systex
```HTML
@section('looping-test')
  <p>Let's print odd numbers under 50:</p>
  <p>
    @foreach($numbers as $number)
      @if($number % 2 !== 0)
        {{ $number }} 
      @endif
    @endforeach
  </p>
@endsection
```
For mastering template
```HTML
@include('shared.header')
<body>
  <div id="container">
    <h3>Welcome to <span class="reddish">{{ $title }}</span></h3>
    <p>{{ $content }}</p>
    
    <p>Master file</p>
    
    @yield('looping-test')

  </div>
  @include('shared.footer')
</body>
</html>
```
`You can use any blade systex as you want like`

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

class ProfileController extends Controller
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

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->params['id'];
        $username = $request->params['username'];

        dd($request->params);
    }
}
```

<a name="section-10"></a>

## Global Middleware
We can define multiple global middleware. To define global middleware, just update the `App\Http\Kernel.php` file's `$middleware` array as like below 
```php
<?php

public $middleware = [
    \App\Http\Middleware\ExampleMiddleware::class,
];
```

Now update your middleware like

```php
<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\Request;
use App\Core\Middleware\Contracts\Middleware;

class ExampleMiddleware implements Middleware
{
    public function __invoke(Request $request, Closure $next)
    {
        $data = $request->getBody();
        dump($data);
        return $next($request);
    }
}
```