<?php
require_once __DIR__ . '/../autoload.php';

use Maatwebsite\Excel\Facades\Excel as Excel;
//use comm\Model\Transmission;

//$transmission = new Transmission();

Excel::load('../file/变速箱数据库.xls', function($reader) {

})->get();
