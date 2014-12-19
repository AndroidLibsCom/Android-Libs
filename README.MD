Android-Libs
============
[![License](http://img.shields.io/badge/license-GPL--2.0-green.svg)](http://choosealicense.com/licenses/gpl-2.0/)


Because of my passwords stored in `/app/config/database.php` I had to remove it from the repository.

Get a fresh one from [here.](https://github.com/laravel/laravel/blob/master/app/config/database.php)

Do a `composer install` in the root directory.

I have used several packages. Please install them and follow their installation instructions:
* [Laravel IDE Helper Generator] (https://github.com/barryvdh/laravel-ide-helper)
* [Laravel 4 Debugbar] (https://github.com/barryvdh/laravel-debugbar)
* [Cartalyst Sentry] (https://cartalyst.com/manual/sentry)
* [Laravel GitHub] (https://github.com/GrahamCampbell/Laravel-GitHub)
* [Eloquent Sluggable] (https://github.com/cviebrock/eloquent-sluggable)
* The initial library list used contents of the [Android Arsenal] (http://android-arsenal.com) Thanks for that!


After the `composer install` do a `php artisan migrate --package=cartalyst/sentry` for the Sentry2 package and a `php artisan migrate` for the Android-Libs tables.


Stuff
========

Thanks for any contributions made!
Also thank you for submitting your libraries to Android-Libs.com

I would appreciate any supports on GratiPay:


[![GratiPay - Cyruxx](http://img.shields.io/gratipay/Cyruxx.svg)](https://gratipay.com/Cyruxx/)
