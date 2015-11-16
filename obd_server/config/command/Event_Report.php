<?php
$func_event_report = function($packet, $message) {
    echo PHP_EOL."func_event_report:" .PHP_EOL;
    var_dump($message);

};
return $func_event_report;