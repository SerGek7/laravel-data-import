<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 26.04.2019
 * Time: 16:00
 */

namespace DataImport\app\Http\Controllers;

use DataImport\app\Jobs\StoreToDB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Queue;
use DataImport\app\Utilities;
use Mockery\Exception;

class DataImportController
{

    protected $stream;
    protected $validators;

    public function __construct()
    {
    }

    public function index()
    {
        return view('dataImport::form');
    }

    public function import()
    {
        $this->setSource();
        $this->storeSource();
        return true;
    }

    public function setSource($path = null)
    {
        if ($path) {
            $this->stream = fopen($path, 'r');
        } else {
            $file = Input::file('source_file');
            $this->stream = fopen(storage_path('app/' . $file->storeAs('source')), 'r');
        }
    }

    public function storeSource()
    {
        //Read header and body of csv
        $data = Utilities\Helper::readCsv($this->stream);
        try {
            //Sort key in array for validation
            $sort_validator = Utilities\Helper::sortArrayKey($this->validators, $data['header']);

            //Validate csv body
            $correct_data = csv_validate($data['body'], $sort_validator);

            dump('Start saving in to database');
            //Push to queue and start saving in to database
            Queue::push(new StoreToDB($correct_data, config('dataImport.table')));

        } catch (Exception $ex) {
            Utilities\Helper::notification($ex->getMessage());
            dump('[Error]:' . $ex->getMessage());
        }
    }

    public function csv_validate($data, $validator)
    {
        $store_data = [];
        foreach ($data as $key => $value) {
            $valid = Validator::make($value, $validator);
            if ($valid->fails()) {
                dump('not valid');
            } else {
                array_push($store_data, $value);
            }
        }
        return $store_data;
    }

    public function configLoad($arr)
    {
        foreach ($arr as $key => $value) {
            $this->validators[strtolower($key)] = $value['validators'];
        }
    }
}