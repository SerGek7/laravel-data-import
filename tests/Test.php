<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 02.05.2019
 * Time: 20:18
 */

use Tests\TestCase;
use DataImport\app\Http\Controllers;

class Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testBasicTest()
    {
        $dataImport = new Controllers\DataImportController();
        $dataImport->setSource(app_path('/tests/test.csv'));
        $dataImport->configureFields([
            'Title'=>['field'=>'title','validators'=>'required|max:64'],
            'Lat'=>['field'=>'lat','validators'=>'required|max:16'],
            'Lon'=>['field'=>'lon','validators'=>'required|max:16'],
            'Residents'=>['field'=>'residents','validators'=>'integer']
        ]);

        $result = $dataImport->import();
        $this->assertTrue($result);

    }
}