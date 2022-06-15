<?php
include "sql_bd.php";



//$_POST['addresses'] = json_decode($_POST['addresses']);

if (!check_user($_POST["phone"],$_POST["hash"]))
{
    $file = fopen("logger.txt", "a");
    fwrite($file,"phone=".$_POST["phone"]." hash= ".$_POST["user_hash"]." выполнение скрипта установки данных прервано из-за неверной авторизации\n");
    fclose($file);
    exit;}


echo sql_request("UPDATE `users` 
SET `first_name` = '".$_POST['first_name']."', 
    `second_name` = '".$_POST['second_name']."', 
    `last_name` = '".$_POST['last_name']."',
    `address` = '".$_POST['address']."'
WHERE `users`.`phone` = '".$_POST['phone']."'");
/*
echo sql_request("DELETE FROM `addresses` 
WHERE ID_user = '".$_POST['user_ip']."';");

$request_to_sql = "INSERT INTO `addresses` (`ID_user`, `address`) VALUES";
#INSERT INTO `addresses` (`ID_user`, `address`) VALUES ('1', 'asgf'), ('1', '944');
$temp = false;
foreach ($_POST['addresses'] as &$value) {
    if ($temp){
        $request_to_sql.=",";
    }else{
        $temp=true;
    }
    $request_to_sql.=" ('".$_POST['user_ip']."', '".$value."')";
}
$request_to_sql.=";";
echo $request_to_sql.sql_request($request_to_sql);
unset($value);
*/
$file = fopen("logger.txt", "a");
fwrite($file,$_POST['address']."\n");
fclose($file);
?>