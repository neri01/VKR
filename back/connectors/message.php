<?php
require_once('SMS.php');
require_once('sql_bd.php');

$_POST['phone']=phone_to_string($_POST['phone']);

$code = generateCode();
$log="пользователь заходит ";

$data = sql_request("SELECT * FROM `users` where phone = '" . $_POST['phone'] . "'");

foreach ($data as $row) {
    $obj["code"] = $row["code"];
}

if (empty($obj['code'])) {
    sql_request("INSERT INTO `users` (`user_id`, `code`, `user_hash`, `last_login`, `first_name`, `second_name`, `last_name`, `phone`, `ID_corp`, `address`) 
    VALUES (NULL, '', '', NULL, NULL, NULL, NULL, '".$_POST['phone']."', NULL, '');");
    $log="пользователь зарегистрирован ";
}

echo sql_request("UPDATE `users` 
SET `code` = '".$code."' 
WHERE `users`.`phone` = '".$_POST['phone']."'");

//send("gate.iqsms.ru", 80, "z1651764933610", "250678",$_POST['phone'], "autorization code - ".$code, "SMS DUCKOHT", "wap.yousite.ru");

$file = fopen("logger.txt", "a");
fwrite($file, $log.$code."\n");
fclose($file);


?>