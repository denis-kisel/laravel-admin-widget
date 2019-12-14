# LaravelAdminWidget

Package for laravel-admin.

## Installation

Via Composer

``` bash
$ composer require denis-kisel/laravel-admin-widget
```

Add service provider in the config/app.php file. Optional for laravel5.4+ 

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

Run migration
``` bash
$  php artisan migrate
```

## Usage
### Make Widget
Command: `php artisan admin:widget {name}`

``` bash
$ php artisan admin:widget Slider
```

This command will generate file by path: app/Admin/Controllers/Widgets/SliderWidget.php.  
And will add route `site.com/admin/slider-widget`

### Get Widget Data
Get widget data as array:

``` php
<?php

use DenisKisel\LaravelAdminWidget\Facade\Widget;


Widget::getArray($code)
```

Get widget data as collection

``` php
<?php

use DenisKisel\LaravelAdminWidget\Facade\Widget;


Widget::getCollection($code)
```


### Put Custom Data

Also possible put custom data

``` php
<?php

use DenisKisel\LaravelAdminWidget\Facade\Widget;


Widget::put($code, $data) #Store or update widget
```

## Fix Error
`Call to a member function getKey()`  
For fix this error, just run:
```bash
php artisan fix:nested_form
```

