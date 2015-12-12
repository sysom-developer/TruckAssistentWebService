<?php
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../third_party/PHPExcel.php';


//use comm\Model\Transmission;

//$transmission = new Transmission();
$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
$objPHPExcel = $objReader->load('../file/变速箱数据库.xls');
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();           //取得总行数
$highestColumn = $sheet->getHighestColumn();


var_dump($highestRow);
var_dump($highestColumn);