<?php
global $servername;
global $database;
global $username;
global $password;
$servername = "localhost";
$database = "project";
$password = "root";
$username = "root";
function get_data($req)
{
    global $servername;
    global $database;
    global $username;
    global $password;
    $conn = mysqli_connect($servername, $username, $password, $database);
	$conn->set_charset("utf8mb4");
    $result = $conn->query($req);
    return $result;
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

function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
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

function check()
{
    global $servername;
    global $database;
    global $username;
    global $password;

    $link=mysqli_connect($servername, $username, $password, $database);

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
    {
        $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
            or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")))
        {
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
            print "Хм, что-то не получилось";
        }
        else
        {
            print "Привет, ".$userdata['user_login'].". Всё работает!";
        }
    }
    else
    {
        print "Включите куки";
    }
}

function logout(){
    // Удаляем куки
    setcookie("id", "", time() - 3600*24*30*12, "/");
    setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!!

// Переадресовываем браузер на страницу проверки нашего скрипта
    header("Location: /"); exit;

}

?>