<?php
require_once('sql_bd.php');


$_POST['phone']=phone_to_string($_POST['phone']);

    $data = sql_request("SELECT * FROM `users` where phone = '" . $_POST['phone'] . "'");

    foreach ($data as $row) {
        $obj["code"] = $row["code"];
    }

    $file = fopen("logger.txt", "a");
    fwrite($file, "login проверено телефон - " . $_POST['phone'] . " код - " . $obj["code"] . " код пришедший на проверку - " . $_POST['code'] . "\n");
    fclose($file);

    if ($obj["code"] == $_POST["code"]) {
        $hash = md5(generateCode(10));
        $data = sql_request("UPDATE `users` 
SET `user_hash` = '" . $hash . "', `last_login` = NOW() 
where phone = '" . $_POST['phone'] . "'");

        echo $hash;
    } else {
        echo 0;
    }
