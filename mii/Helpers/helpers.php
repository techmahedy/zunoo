<?php

use Mii\Log as Reader;
use Mii\Request;
use Mii\Session;
use Mii\Redirect;
use Mii\Controllers\Controller;

/**
 * Renders a view with the given data.
 *
 * @param	string $view The name of the view file to render.
 * @param	array  $data An associative array of data to pass to the view (default is an empty array).
 * @return	mixed The rendered view output.
 */
function view($view, $data = []): mixed
{
    return (new Controller())->render($view, $data);
}

/**
 * Creates a new redirect instance for handling HTTP redirects.
 *
 * @return	Redirect A new instance of the Redirect class.
 */
function redirect(): Redirect
{
    return new Redirect();
}

/**
 * Creates a new request instance to handle HTTP requests.
 *
 * @return	Request A new instance of the Request class.
 */
function request(): Request
{
    return new Request();
}

/**
 * Creates a new session instance for handling user sessions.
 *
 * @return	Session A new instance of the Session class.
 */
function session(): Session
{
    return new Session();
}

/**
 * Creates and returns a logger instance for logging messages.
 *
 * @return	\Monolog\Logger An instance of the Monolog Logger.
 */
function logger(): \Monolog\Logger
{
    return (new Reader())->logReader();
}

/**
 * Creates and returns a Faker generator instance for generating fake data.
 *
 * @return	\Faker\Generator An instance of the Faker Generator.
 */
function fake(): \Faker\Generator
{
    $faker = Faker\Factory::create();

    return $faker;
}
