<?php

return [
    /*
     * Allow all origins or specify a list of allowed origins.
     * Use '*' to allow all origins or provide an array of specific origins.
     */
    'allowed_origins' => ['*'],

    /*
     * Allow all methods or specify a list of allowed HTTP methods.
     */
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'ANY', 'HEAD'],

    /*
     * Allow all headers or specify a list of allowed headers.
     */
    'allowed_headers' => ['Content-Type', 'Authorization'],

    /*
     * Expose additional headers to the client.
     */
    'exposed_headers' => [],

    /*
     * Allow credentials (e.g., cookies, authorization headers) to be included in requests.
     */
    'allow_credentials' => false,

    /*
     * Cache preflight requests for a specified number of seconds.
     */
    'max_age' => 0,
];
