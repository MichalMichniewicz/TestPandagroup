<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<link rel="stylesheet" type="text/css" href="../../css/styles.css">
<?php
session_start();
include_once("../../php/header.php");

if (!isset($_SESSION['initiate'])) {
    session_regenerate_id();
    $new_session_id = session_id();
    session_write_close();
    session_id($new_session_id);
    session_start();
    $_SESSION['initiate'] = 1;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <body>

        <?php
        if (isset($_GET['akcja']) && $_GET['akcja'] == "logout") {
            $_SESSION['zalogowany'] = 0;
            session_destroy();
            echo "Zostałeś pomyślnie wylogowany<br />";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: http://jubel.ayz.pl/");
        }
        if ($_SESSION['zalogowany'] == 1 && ($_SESSION['info_o_komp'] != $_SERVER['HTTP_USER_AGENT'])) {
            $_SESSION['zalogowany'] = 0;
            session_destroy();
            echo "Prosimy o ponowne zalogowanie się.";
        }
        if ((isset($_POST['login']) && isset($_POST['haslo'])) || $_SESSION['zalogowany'] == 1) {
            if ((!empty($_POST['login']) && !empty($_POST['haslo'])) || $_SESSION['zalogowany'] == 1) {
                if ($_SESSION['zalogowany'] == 0) {
                    $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
                    $haslo = filter_var($_POST['haslo'], FILTER_SANITIZE_STRING);
                }
                $salt = "skbgfkasdrtgh37y1324&%75^&yyhuyTg";
                $pw = hash("sha512", $salt . $haslo);

                require_once("../../php/db.class.php");
                $dataBase = new Db();
                $table = 'user';
                $columns = 'id, email, password, first_name';
                $users = $dataBase->selectAll($table, $columns);
                $temp = 0;
                foreach ($users as $user) {
                    if ($login == $user['email'] && $pw == $user['password']) {
                        $userId = $user['id'];
                        $userName = $user['first_name'];
                        $temp = 1;
                        break;
                    } else {
                        $temp = 0;
                    }
                }

                if (($temp > 0) || $_SESSION['zalogowany'] == 1) {
                    if ($_SESSION['zalogowany'] == 0) {
                        $_SESSION['login'] = $login;
                        $_SESSION['idUser'] = $userId;
                        $_SESSION['userName'] = $userName;
                    }

                    $_SESSION['zalogowany'] = 1;
                    $_SESSION['time'] = time();
                    $_SESSION['info_o_komp'] = $_SERVER['HTTP_USER_AGENT'];
                } else
                    echo "Podałeś niepoprawny login lub hasło.";
            } else
                echo "Nie podałeś loginu lub hasła.";
        }
        if ($temp == 1) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: http://jubel.ayz.pl/");
        }

        if ($_SESSION['zalogowany'] == 0) {
            ?>
            <div class="content">
                <form action="login.php" method="post" >
                    <div>
                        <div class="email">
                            <span>Email: </span><input type="text" name="login" maxlength="8" size="5" />
                        </div>
                        <div class="password">
                            <span>Password: </span><input type="password" name="haslo" maxlength="15" size="5" />
                        </div> 
                        <div>
                            <button type="submit">Zaloguj się</button>
                        </div>
                        <div>
                            <a href="singup.php"> Zarejestruj się </a>
                        </div>
                    </div>
                </form>  
            </div>
            <?php
        }
        ?>
    </body>
</html>