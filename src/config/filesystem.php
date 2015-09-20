<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stapler File Url
    |--------------------------------------------------------------------------
    |
    | The url (relative to your project document root) where files will be stored.
    | It is composed of 'interpolations' that will be replaced their
    | corresponding values during runtime.  It's unique in that it functions as both
    | a configuration option and an interpolation.
    |
    */

    'url' => '/system/:class/:attachment/:id_partition/:style/:filename',

    /*
    |--------------------------------------------------------------------------
    | Stapler File Path
    |--------------------------------------------------------------------------
    |
    | Similar to the url, the path option is the location where your files will
    | be stored at on disk.  It should be noted that the path option should not
    | conflict with the url option.  Stapler provides sensible defaults that take
    | care of this for you.
    |
    */

    'path' => ':app_root/public:url',

    /*
    |--------------------------------------------------------------------------
    | Override File Permissions Flag
    |--------------------------------------------------------------------------
    |
    | Override the default file permissions used by stapler when creating a new
    | file in the file system.  Leaving this value as null will result in stapler
    | chmod'ing files to 0666.  Set it to a specific octal value and stapler will
    | chmod accordingly.  Set it to false to prevent chmod from occuring (useful
    | for non unix-based environments).
    |
    */

    'override_file_permissions' => null,

];
