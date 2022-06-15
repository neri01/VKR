<?php
require_once('sql_bd.php');

/*
$_POST['phone']="79198758230";
$_POST['hash'] ="cff1ab137565e40c8c54dc1fd0eeeb3c";
*/

$data = sql_request("SELECT * FROM `users` where phone = ".$_POST['phone']);
foreach($data as $row) {
    $obj["user_hash"] = $row["user_hash"];
    $obj["last_login"] = $row["last_login"];
}



if ((strtotime("now")+10800-strtotime($obj["last_login"]))/60<60*24 and $obj["user_hash"]==$_POST['hash'])
{
    echo 1;
    sql_request("UPDATE `users` SET `user_hash` = '' where phone = '".$_POST['phone']."'");
}
else
{
    echo 0;
}