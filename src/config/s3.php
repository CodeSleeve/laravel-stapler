<?php

return [

	/*
	|--------------------------------------------------------------------------
	| S3 Client Config
	|--------------------------------------------------------------------------
	|
	| This is array holds the default configuration options used when creating
	| an instance of Aws\S3\S3Client.  These options will be passed directly to 
	| the s3ClientFactory when creating an S3 client instance.
	|
	*/
	's3_client_config' => [
		'key' => '',
		'secret' => '',
		'region' => '',
		'scheme' => 'http'
	],
	
	/*
	|--------------------------------------------------------------------------
	| S3 Object Config
	|--------------------------------------------------------------------------
	|
	| An array of options used by the Aws\S3\S3Client::putObject() method when
	| storing a file on S3.
	| AWS Documentation for Aws\S3\S3Client::putObject() at 
	| http://docs.aws.amazon.com/aws-sdk-php/latest/class-Aws.S3.S3Client.html#_putObject
	|
	*/
	's3_object_config' => [
		'Bucket' => '',
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
