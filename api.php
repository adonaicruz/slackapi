<?php

require 'lib/Controller.php';
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $API = new Controller($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->process();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}