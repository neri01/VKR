<?php
require_once('sql_bd.php');

if(strlen($_POST["phone"])>12) {
    $_POST["phone"] = phone_to_string($_POST["phone"]);
}

if (!check_user($_POST["phone"],$_POST["hash"]))

{exit;}

$data = sql_request("SELECT * FROM `users` WHERE phone = ".$_POST["phone"]);
foreach($data as $row) {
    $obj["user_hash"] = $row["user_hash"];
    $obj["first_name"] = $row["first_name"];
    $obj["second_name"] = $row["second_name"];
    $obj["last_name"] = $row["last_name"];
    $obj["phone"] = $row["phone"];
    $obj["address"] = $row["address"];
}
echo json_encode($obj);