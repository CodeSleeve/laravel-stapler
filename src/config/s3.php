<?php

return [

	's3_client_config' => [
		
		/*
		|--------------------------------------------------------------------------
		| AWS Access Key
		|--------------------------------------------------------------------------
		|
		| This is an alphanumeric text string that uniquely
		| identifies the user who owns the account. No two accounts can have the
		| same AWS Access Key.
		|
		*/

		'key' => '',

		/*
		|--------------------------------------------------------------------------
		| AWS Secret Key
		|--------------------------------------------------------------------------
		|
		| This key plays the role of a  password . It's called secret because it is
		| assumed to be known by the owner only.  A Password with Access Key forms a
		| secure information set that confirms the user's identity.
		| You are advised to keep your Secret Key in a safe place.
		|
		*/

		'secret' => '',

		/*
		|--------------------------------------------------------------------------
		| S3 Region
		|--------------------------------------------------------------------------
		|
		| The region name of your bucket (e.g. 'us-east-1', 'us-west-1', 'us-west-2',
		| 'eu-west-1').  Determines the base url where your objects are stored at
		| (e.g a region of us-west-2 has a base url of s3-us-west-2.amazonaws.com).
		| Defaults to empty (US Standard *).
		|
		*/

		'region' => '',

		/*
		|--------------------------------------------------------------------------
		| S3 Scheme (s3_protocol)
		|--------------------------------------------------------------------------
		|
		| The protocol for the URLs generated to your S3 assets. Can be either 'http'
		| or 'https'. Defaults to 'http' when your ACL is 'public-read' (the default)
		| and 'https' when your ACL is anything else.
		|
		*/
		'scheme' => 'http'
	],
	
	's3_object_config' => [
		
		/*
		|--------------------------------------------------------------------------
		| S3 Bucket
		|--------------------------------------------------------------------------
		|
		| The bucket where you wish to store your objects.  Every object in Amazon S3
		| is stored in a bucket.  If the specified bucket doesn't exist Stapler will
		| attempt to create it.  The bucket name will not be interpolated.
		| You can define the bucket as a closure if you want to determine it's name at
		| runtime. Stapler will call that closure with attachment as the only argument.
		|
		*/

		'Bucket' => '',

		/*
		|--------------------------------------------------------------------------
		| S3 ACL (s3_permissions)
		|--------------------------------------------------------------------------
		|
		| This is a string/array that should be one of the canned access policies
		| that S3 provides (private, public-read, public-read-write, authenticated-read,
		| bucket-owner-read, bucket-owner-full-control). The default for Stapler is
		| public-read.  An associative array (style => permission) may be passed to
		| specify permissions on a per style basis.
		|
		*/

		'ACL' => 'public-read'
	],

	/*
	|--------------------------------------------------------------------------
	| S3 Path
	|--------------------------------------------------------------------------
	|
	| This is the key under the bucket in which the file will be stored.
	| The URL will be constructed from the bucket and the path.
	| This is what you will want to interpolate. Keys should be unique,
	| like filenames, and despite the fact that S3 (strictly speaking) does not
	| support directories, you can still use a / to separate parts of your file name.
	|
	*/

	'path' => ':attachment/:id/:style/:filename',

];