<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';



/*
 * Asset management
 */
Assets::add([
    'assets/css/pixeladmin/bootstrap.min.css',
    'assets/css/pixeladmin/pixel-admin.min.css',
    'assets/css/pixeladmin/widgets.min.css',
    'assets/css/pixeladmin/rtl.min.css',
    'assets/css/pixeladmin/themes.min.css',
    'assets/css/pixeladmin/pages.min.css',
    'assets/css/animate.min.css',
    'assets/css/cropper.min.css',
    '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css',
    'assets/css/chosen.min.css',
    'assets/css/chosen.bootstrap.min.css',
    'assets/css/lightbox.min.css',
    '//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.css',
    '//fonts.googleapis.com/css?family=Open+Sans:100,300,600',
    'assets/css/template.min.css',
    'https://code.jquery.com/jquery-1.10.2.min.js',
    'assets/js/bootstrap.min.js',
    'assets/js/bootbox.min.js',
    'assets/js/bootstrap.maxlength.min.js',
    'assets/js/chosen.jquery.min.js',
    'assets/js/starrr.jquery.min.js',
    '//cdn.datatables.net/1.10.0/js/jquery.dataTables.min.js',
    'assets/js/dataTables.bootstrap.min.js',
    'assets/js/ie.min.js',
    'assets/js/sharrre.min.js',
    'assets/js/pixel-admin.min.js',
    'assets/js/lightbox.min.js',
    'assets/js/cropper.min.js',
    'assets/js/app.min.js'
]);
