laravel-stapler
===============
[![Latest Stable Version](https://poser.pugx.org/codesleeve/laravel-stapler/v/stable.svg)](https://packagist.org/packages/codesleeve/laravel-stapler)[![Total Downloads](https://poser.pugx.org/codesleeve/laravel-stapler/downloads.svg)](https://packagist.org/packages/codesleeve/laravel-stapler) 
[![Latest Unstable Version](https://poser.pugx.org/codesleeve/laravel-stapler/v/unstable.svg)](https://packagist.org/packages/codesleeve/laravel-stapler) 
[![License](https://poser.pugx.org/codesleeve/laravel-stapler/license.svg)](https://packagist.org/packages/codesleeve/laravel-stapler)

Laravel-Stapler is a Stapler-based file upload package for the Laravel framework.  It provides a full set of Laravel commands, a migration generator, and a cascading package config on top of the [Stapler](https://github.com/CodeSleeve/stapler) package.  It also bootstraps Stapler with very sensible defaults for use with Laravel.  If you are wanting to use [Stapler](https://github.com/CodeSleeve/stapler) with Laravel, it is strongly recommended that you use this package to do so.

Laravel-Stapler was created by [Travis Bennett](https://twitter.com/tandrewbennett).

* [Requirements](#requirements)
* [Installation](#installation)
* [Migrating From Stapler v1.0.0-Beta4](#migrating-from-Stapler-v1.0.0-Beta4)
* [Quick Start](#quickstart)
* [Commands](#commands)
  * [Fasten](#fasten)
  * [Refresh](#refresh)
* [Contributing](#contributing)

## Requirements
This package currently requires php >= 5.4 as well as Laravel >= 4.

## Installation
Laravel-Stapler is distributed as a composer package, which is how it should be used in your app.

Install the package using Composer.  Edit your project's `composer.json` file to require `codesleeve/laravel-stapler`.

```js
  "require": {
    "laravel/framework": "4.*",
    "codesleeve/laravel-stapler": "1.0.*"
  }
```

Once this operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

```php
    'Codesleeve\LaravelStapler\LaravelStaplerServiceProvider'
```

## migrating-from-Stapler-v1.0.0-Beta4
If you've been using Stapler (prior to v1.0.0-Beta4) in your Laravel app, you now need to be using this package instead.  Uninstall Stapler (remove it from your composer.json, remove the service provider, etc) and install this package following the instructions above.  Once installed, the following changes may need need to be made in your application:

* In your models that are using Stapler, change `use Codesleeve\Stapler\Stapler` to `use Codesleeve\Stapler\ORM\EloquentTrait`.  Your models will also need to implement `Codesleeve\Stapler\ORM\StaplerableInterface`.

* If you published stapler's config, you'll need to rename config folder from `app/config/packages/codesleeve/stapler` to `app/config/packages/codesleeve/laravel-stapler`.

* Image processing libraries are now referenced by their full class name from the [Imagine Image](https://github.com/avalanche123/Imagine) package (e.g `gd` is now reference by `Imagine\Gd\Imagine`).

* In your s3 configuration, instead of passing 'key', 'secret', 'region', and 'scheme' options, you'll now need to pass a single 's3_client_config' array containing these options (and any others you might want).  These will be passed directly to the s3ClientFactory when creating an S3 client.  Passing the params as an array now allows you to configure your s3 client (for a given model/attachment) however you like.  See:  http://docs.aws.amazon.com/aws-sdk-php/guide/latest/configuration.html#client-configuration-options

* In your s3 configuration, instead of passing 'bucket' and 'ACL', you'll now need to pass a single 's3_object_config' array containing these values (this is used by the S3Client::putObject() method).  See:  http://docs.aws.amazon.com/aws-sdk-php/latest/class-Aws.S3.S3Client.html#_putObject

* The ':laravel_root' interpolation has been changed to ':app_root'

## Quickstart
In the document root of your application (most likely the public folder), create a folder named system and 
grant your application write permissions to it.  For this, we're assuming the existence of an existing `User` model in which we're going to add an avatar image to. 

In your model:

```php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class User extends Eloquent implements StaplerableInterface {
	use EloquentTrait;
	
	// Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
	protected $fillable = ['avatar', 'first_name', 'last_name'];

	public function __construct(array $attributes = array()) {
		$this->hasAttachedFile('avatar', [
			'styles' => [
			'medium' => '300x300',
			'thumb' => '100x100'
			]
		]);

		parent::__construct($attributes);
	}
}
```

> Make sure that the `hasAttachedFile()` method is called right before `parent::__construct()` of your model.

From the command line, use the migration generator:

```php
php artisan stapler:fasten users avatar
php artisan migrate
```

In your new view:
```php
<?= Form::open(['url' => action('UsersController@store'), 'method' => 'POST', 'files' => true]) ?>
	<?= Form::input('first_name') ?>
	<?= Form::input('last_name') ?>
	<?= Form::file('avatar') ?>
    <?= Form::submit('save') ?>   
<?= Form::close() ?>
```

In your controller:
```php
public function store()
{
	// Create and save a new user, mass assigning all of the input fields (including the 'avatar' file field).
    $user = User::create(Input::all());	
}
```

In your show view:
```php
<img src="<?= $user->avatar->url() ?>" >
<img src="<?= $user->avatar->url('medium') ?>" >
<img src="<?= $user->avatar->url('thumb') ?>" >
```

To detach (reset) a file, simply assign the constant STAPLER_NULL to the attachment and the save):

```php
$user->avatar = STAPLER_NULL;
$user->save();
```

This will ensure the the corresponding attachment fields in the database table record are cleared and the current file is removed from storage.  The database table record itself will not be destroyed and can be used normally (or even assigned a new file upload) as needed.

## Commands
### fasten
This package provides a `fasten` command that can be used to generate migrations for adding image file fields to existing tables.  The method signature for this command looks like this:
`php artisan stapler:fasten <tablename> <attachment>`

In the quickstart example above, calling
`php artisan stapler:fasten users avatar` followed by `php artisan migrate` added the following fields to the users table:

*   (string) avatar_file_name
*   (integer) avatar_file_size
*   (string) avatar_content_type
*   (timestamp) avatar_updated_at


### refresh
The `refresh` command can be used to reprocess uploaded images on a model's attachments.  It workds by calling the reprocess() method on each of the model's attachments (or on specific attachments only).  This is very useful for adding new styles to an existing attachment when a file has already been uploaded for that attachment.

Reprocess all attachments for the ProfilePicture model:
`php artisan stapler:refresh ProfilePicture`

Reprocess only the photo attachment on the ProfilePicture model:
`php artisan stapler:refresh TestPhoto --attachments="photo"`

Reprocess a list of attachments on the ProfilePicture model:
`php artisan stapler:refresh TestPhoto --attachments="foo, bar, baz, etc"`

## Contributing
This package is always open to contributions:

* Master will always contain the newest work (bug fixes, new features, etc), however it may not always be stable; use at your own risk.  Every new tagged release will come from the work done on master, once things have stablized, etc.