<?php
header("Content-Type:text/html; charset=utf-8;");

$data = json_decode(file_get_contents('php://input'), true);

if(strcasecmp($data["resultCode"], "0000") == 0){
    echo 'ok';
    http_response_code(200);
}else{
    http_response_code(500);
}