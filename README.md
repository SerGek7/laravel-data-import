Laravel Data Import 
=

COMMAND-LINE AND API BASED CSV IMPORT TOOL WITH AN ADMIN USER INTERFACE

This package allows you to import data in CSV format into a database.


INSTALLATION
------------
This package can be used in Laravel 5.6 or higher. 

You can install the package via composer:

```
composer require sergek7/laravel-data-import
```
manually add the service provider in your config/app.php file:

```
'providers' => [
    // ...
    DataImport\DataImportServiceProvider::class,
];
```
You can publish the package with:

```
php artisan vendor:publish --provider="DataImport\DataImportServiceProvider" 
```
Also you need run migrate in Laravel:

```
php artisan migrate
```
After that you need to set widget config variables in congig/data_import_config.php:



```php
return [

    // ...
    'send_email_to' => '',
    'csv_delimiter' => ';',
    'table' => ''
];
```

To call simple view use:
--
```
view('dataImport::form');
```

You need to set up queues for logging to work.

Log file you can read at: storage/logs/data_import.log

To get notification you need to configure your mail server in .env file For Example like this

```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=mail@gmail.com
MAIL_PASSWORD=Password
MAIL_ENCRYPTION=tls

```
