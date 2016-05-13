<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Rackspace Username
    |--------------------------------------------------------------------------
    |
    | The username used to when logging into your rackspace control panel.
    |
    */
    'username' => '',

    /*
    |--------------------------------------------------------------------------
    | Rackspace API Key
    |--------------------------------------------------------------------------
    |
    | The API key from your Rackspace account. You may find this under the
    | 'Account Settings' page inside the rackspace cloud control panel.
    |
    */
    'apiKey' => '',

    /*
    |--------------------------------------------------------------------------
    | Rackspace Region
    |--------------------------------------------------------------------------
    |
    | This should match the region of the conainer being used to store your
    | your uploaded files.
    |
    */

    'region' => '',

    /*
    |--------------------------------------------------------------------------
    | Rackspace Container
    |--------------------------------------------------------------------------
    |
    | This is the name of an existing container that you wish to store your
    | uploaded files in. If you don't already have a container, you can
    | easily create one by using the Rackspace cloud control panel.
    |
    */

    'container' => '',

    /*
    |--------------------------------------------------------------------------
    | Rackspace SSL Links
    |--------------------------------------------------------------------------
    |
    | When generating links to your uploaded files, you may wish to create
    | secure (https) links to your uploaded file assets.
    |
    */

    'use_ssl' => true,

    /*
    |--------------------------------------------------------------------------
    | Rackspace Path
    |--------------------------------------------------------------------------
    |
    | This is the key (in your container) under which a file will be stored.
    | The URL to a file will be generated using the your container's name
    | and this value (once it's been ran through the interpolator).
    |
    */

    'path' => ':attachment/:id/:style/:filename'
];
