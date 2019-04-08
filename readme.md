# LaravelAdminWidget

Package for laravel admin.

## Installation

Via Composer

``` bash
$ composer require denis-kisel/laravel-admin-widget
```

Add service provider in the config/app.php file
``` php
/*
 * Package Service Providers...
 */
DenisKisel\LaravelAdminWidget\LaravelAdminWidgetServiceProvider::class,
```

Make publish
``` bash
$  php artisan vendor:publish --provider="DenisKisel\\LaravelAdminWidget\\LaravelAdminWidgetServiceProvider"
```

## Usage
Make widget by code
``` bash
$ php artisan admin:widget slider
```

Fill generated file by path: app/Admin/Controllers/Widgets/SliderWidget.php. You can view example file in the same dir.

In the address link
``` bash
site.com/admin/slider-widget
```
