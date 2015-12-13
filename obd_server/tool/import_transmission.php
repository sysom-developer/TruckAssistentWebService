<?php
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../third_party/PHPExcel.php';


use comm\Model\Transmission;

$transmission = new Transmission();

$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
$objPHPExcel = $objReader->load('../file/变速箱数据库.xls');
$currentSheet = $objPHPExcel->getSheet(0);


/**取得一共有多少行*/
$allRow = $currentSheet->getHighestRow();
/**取得最大的列号*/
$allColumn = $currentSheet->getHighestColumn();



//循环读取每个单元格的内容。注意行从2开始，列从A开始
for($rowIndex=2; $rowIndex <= $allRow; $rowIndex++){
    $data = $tmp = [];
    for($colIndex='A'; $colIndex <= $allColumn; $colIndex++){
        $addr = $colIndex.$rowIndex;
        $cell = $currentSheet->getCell($addr)->getValue();
        if($cell instanceof PHPExcel_RichText)     //富文本转换字符串
            $cell = $cell->__toString();
        $tmp[] = $cell;
    }
    $data = [
        'code' => $tmp[0],
        'brand' => $tmp[1],
        'model' => $tmp[2],
        'forward_gear' => $tmp[3],
        'reverse_gear' => $tmp[4],
        'shift_form' => $tmp[5],
        'max_torque' => $tmp[6],
        'apacity' => $tmp[7],
        'forward_gear_rate' => implode(',', (explode("\n", $tmp[8]))),
        'reverse_gear_rate' => implode(',', (explode("\n", $tmp[9]))),
        'create_time' => time()
    ];

//    $transmission->save($data);

}