<?php

/*
|--------------------------------------------------------------------------
| Default Filesystem Disk
|--------------------------------------------------------------------------
|
| This configuration file defines the file storage settings for the Zuno 
| Framework. The default disk is set based on the "FILESYSTEM_DISK" 
| environment variable, allowing flexibility between local and cloud storage.
|
| Available storage options:
| - "local": Stores files within the application's storage directory.
|
*/

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | You can configure multiple storage disks here, each with different
    | drivers. This allows the application to manage files across various 
    | storage locations, whether local or external.
    |
    | Supported drivers: "local"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false, // If true, errors will be thrown for storage issues
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public', // Allows public access to files in this disk
            'throw' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | This section defines symbolic links that will be created when the 
    | `storage:link` command is executed. Symbolic links help serve storage 
    | files from public directories, making them accessible via URLs.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
