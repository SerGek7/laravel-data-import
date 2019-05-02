<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 26.04.2019
 * Time: 15:29
 */

Route::get('/data/import', 'DataImport\DataImportController@index');
Route::post('/data/import', 'DataImport\DataImportController@import');
