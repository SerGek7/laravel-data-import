<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 26.04.2019
 * Time: 14:37
 */

namespace DataImport;

use Illuminate\Support\ServiceProvider;

class DataImportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'dataImport');
        $this->mergeConfigFrom(__DIR__ . '/config/data_import_config.php', 'dataImport');
    }

    public function register()
    {

    }
}