<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 02.05.2019
 * Time: 12:44
 */

namespace DataImport\app\Utilities;

use DataImport\app\Jobs\Notification;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Helper
{
    //Read head and body of csv stream
    public static function readCsv($source)
    {
        $csv_array_header = fgetcsv($source, 1000, config('dataImport.csv_delimiter'));
        $csv_array_body = [];

        while (($data = fgetcsv($source, 1000, config('dataImport.csv_delimiter'))) !== false) {
            array_push($csv_array_body, $data);
        }

        $csv_array = [
            'header' => $csv_array_header,
            'body' => $csv_array_body
        ];
        return $csv_array;
    }

    //Sort key in array for validation
    public static function sortArrayKey(array $array, array $orderArray) {
        $sorted_arr = [];
        foreach ($orderArray as $key => $val){
            $sorted_arr +=
                [
                    strtolower($key) => $array[strtolower($key)]
                ];
        }
        return $sorted_arr;
    }


    public static function sendNotification($message)
    {
        $log = ['date' => date("Y-m-d H:i:s"), 'error' => $message];
        $orderLog = new Logger('DataImport');
        $orderLog->pushHandler(new StreamHandler(storage_path('logs/data_import.log')), Logger::INFO);
        $orderLog->info('DataImport', $log);

        Queue::push(new Notification($message));
    }
}