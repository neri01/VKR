<?php
require_once("variables.php");
function sql_request($req)
{
    global $servername;
    global $database;
    global $username;
    global $password;
    $conn = mysqli_connect($servername, $username, $password, $database);
	$conn->set_charset("utf8mb4");
    $result = $conn->query($req);

    mysqli_close($conn);

    return $result;
}

function phone_to_string($phone){
    $phone=$phone[1].$phone[4].$phone[5].$phone[6].$phone[9].$phone[10].$phone[11].$phone[13].$phone[14].$phone[16].$phone[17];
    return $phone;
}


function string_to_phone($phone){
    $phone="+".$phone[0]." (".$phone[1].$phone[2].$phone[3].") ".$phone[4].$phone[5].$phone[6]."-".$phone[7].$phone[8]."-".$phone[9].$phone[10];

    return $phone;
}
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

function registration()
{

    global $servername;
    global $database;
    global $username;
    global $password;

    $link=mysqli_connect($servername, $username, $password, $database);

    if(isset($_POST['submit']))
    {
        $err = [];

        // проверям логин
        if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
        {
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
        }

        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
        {
            $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
        }

        // проверяем, не сущестует ли пользователя с таким именем
        $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
        if(mysqli_num_rows($query) > 0)
        {
            $err[] = "Пользователь с таким логином уже существует в базе данных";
        }

        // Если нет ошибок, то добавляем в БД нового пользователя
        if(count($err) == 0)
        {

            $login = $_POST['login'];

            // Убераем лишние пробелы и делаем двойное хеширование
            $password = md5(md5(trim($_POST['password'])));

            mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
            header("Location: login.php"); exit();
        }
        else
        {
            print "<b>При регистрации произошли следующие ошибки:</b><br>";
            foreach($err AS $error)
            {
                print $error."<br>";
            }
        }
    }
}



function login()
{
    global $servername;
    global $database;
    global $username;
    global $password;

    $link=mysqli_connect($servername, $username, $password, $database);

    if(isset($_POST['submit']))
    {
        // Вытаскиваем из БД запись, у которой логин равняеться введенному
        $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
        $data = mysqli_fetch_assoc($query);

        // Сравниваем пароли
        if($data['user_password'] === md5(md5($_POST['password'])))
        {
            // Генерируем случайное число и шифруем его
            $hash = md5(generateCode(10));

            if(!empty($_POST['not_attach_ip']))
            {
                // Если пользователя выбрал привязку к IP
                // Переводим IP в строку
                $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
            }

            // Записываем в БД новый хеш авторизации и IP
            mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

            // Ставим куки
            setcookie("id", $data['user_id'], time()+60*60*24*30, "/");
            setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!!

            // Переадресовываем браузер на страницу проверки нашего скрипта
            header("Location: check.php"); exit();
        }
        else
        {
            print "Вы ввели неправильный логин/пароль";
        }
    }
}

function check_user($phone,$hash)
{
    $data = sql_request("SELECT * FROM `users` where phone = ".$_POST['phone']);
    foreach($data as $row) {
        $obj["user_hash"] = $row["user_hash"];
        $obj["last_login"] = $row["last_login"];
    }

    if ((strtotime("now")+60*60*3-strtotime($obj["last_login"]))<60*60*24 and $obj["user_hash"]==$_POST['hash'] and !empty($obj["user_hash"]))
    {
        return true;
        sql_request("UPDATE `users` SET `last_login` = NOW() where phone = '".$_POST['phone']."'");
    }
    else
    {
        return false;
    }
}

function logout($phone){
    sql_request("UPDATE `users` SET `user_hash` = '' WHERE `users`.`phone` = ".$phone.";");
}

?>