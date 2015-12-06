<?php
require_once __DIR__ . '/../autoload.php';

use SimpleExcel\SimpleExcel;
use comm\Model\Transmission;

$transmission = new Transmission();



$excel = new SimpleExcel('csv');   // instantiate new object (will automatically construct the parser & writer type as XML)

$excel->parser->loadFile('../file/变速箱数据库.csv');   // load an XML file from server to be parsed

$table = $excel->parser->getField();                  // get complete array of the table

$table = array_slice($table, 1);
array_walk($table, function ($v) use($transmission){
    $v = array_filter($v);
    $data = [
      'code' => array_key_exists(0, $v)? $v[0] : 0,
      'brand' => array_key_exists(1, $v)? $v[1] : 0,
      'model' => array_key_exists(2, $v)? $v[2] : 0,
      'forward_gear' => array_key_exists(3, $v)? $v[3] : 0,
      'reverse_gear' => array_key_exists(4, $v)? $v[4] : 0,
      'shift_form' => array_key_exists(5, $v)? $v[5] : 0,
      'max_torque' => array_key_exists(6, $v)? $v[6] : 0,
      'apacity' => array_key_exists(7, $v)? $v[7] : 0,
      'forward_gear_rate' => array_key_exists(8, $v)? $v[8] : 0,
      'reverse_gear_rate' => array_key_exists(9, $v) ? $v[9] : 0,
      'create_time' => time()
    ];
//    $engine->save($data);

    var_dump($data);
});
