<?php
require_once('sql_bd.php');


if(check($_POST["phone"],$_POST["hash"])){
    echo true;
}else{
    echo false;
}
/*
$_POST['phone']="79198758230";
$_POST['hash'] ="cff1ab137565e40c8c54dc1fd0eeeb3c";
*/

