<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Attachment Implementation
    |--------------------------------------------------------------------------
    |
    | The concrete implementation for the attachment contract.
    |
    */

    'attachment' => '\Codesleeve\Stapler\Attachment',

    /*
    |--------------------------------------------------------------------------
    | The concrete implementation for the interpolator contract.
    |--------------------------------------------------------------------------
    |
    | The location of the web application's document root.
    |
    */

    'interpolator' => '\Codesleeve\Stapler\Interpolator',

    /*
    |--------------------------------------------------------------------------
    | The concrete implementation for the resizer contract.
    |--------------------------------------------------------------------------
    |
    | The location of the web application's document root.
    |
    */

    'resizer' => '\Codesleeve\Stapler\File\Image\Resizer',

    /*
    |--------------------------------------------------------------------------
    | The concrete implementation for the style contract.
    |--------------------------------------------------------------------------
    |
    | The location of the web application's document root.
    |
    */
    'style' => '\Codesleeve\Stapler\Style',

    /*
    |--------------------------------------------------------------------------
    | The concrete implementation for the validator contract.
    |--------------------------------------------------------------------------
    |
    | The location of the web application's document root.
    |
    */
    'validator' => '\Codesleeve\Stapler\Validator',

];