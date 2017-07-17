<?php
session_start();
$menu = $_SESSION['my'];
$data = array();
foreach ($menu as $key => $value) {

    $data[$key]['number'] = $key + 1;
    $data[$key]['tweet'] = $value[1];
}

function cleanData($str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// filename for download
$filename = "my_tweets_" . date('Ymdhis') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
foreach ($data as $row) {
    if (!$flag) {
        // display field/column names as first row
        echo implode("\t", array_keys($row)) . "\r\n";
        $flag = true;
    }
    array_walk($row,'cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
}


?>
