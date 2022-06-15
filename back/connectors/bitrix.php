<?php

require_once("variables.php");

function decode_bitrix($str){
    return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }, $str);
}

function b24($metod,$param=array()){
    global $b24Url;
    global $b24WebHook;
    global $b24UserID;
    $queryURL = "$b24Url/rest/$b24UserID/$b24WebHook/$metod.json";

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryURL,
        CURLOPT_POSTFIELDS => http_build_query($param),
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
    return $result;
}
?>
