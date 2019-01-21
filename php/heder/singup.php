
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

</head>

<?php
require_once("../../php/header.php");
require_once("../../php/db.class.php");

if (isset($_POST['First_name']) && isset($_POST['Last_name']) && isset($_POST['Email']) && isset($_POST['Password']) && isset($_POST['Country'])) {
    if (!empty($_POST['First_name']) && !empty($_POST['Last_name'] && !empty($_POST['Email']) && !empty($_POST['Password']) && !empty($_POST['Country']))) {
        $first_name = filter_var($_POST['First_name'], FILTER_SANITIZE_STRING);
        $last_name = filter_var($_POST['Last_name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['Email'], FILTER_SANITIZE_STRING);
        $genderHelp = filter_var($_POST['Gender'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
        $repeatPassword = filter_var($_POST['repeatPassword'], FILTER_SANITIZE_STRING);
        $country = filter_var($_POST['Country'], FILTER_SANITIZE_STRING);
        $is_active = 1;
        $created_at = date("Y-m-d");
        $salt = "skbgfkasdrtgh37y1324&%75^&yyhuyTg";

        $pw = hash("sha512", $salt . $password);

        switch ($genderHelp) {
            case 'Mężczyzna':
                $gender = 1;
                break;
            case 'Kobieta':
                $gender = 2;
                break;
            default :
                $gender = 0;
                break;
        }
        $table = 'user';
        $columns = 'first_name, last_name, email, gender, is_active, password, create_at, country';
        $value = "'$first_name', '$last_name', '$email', '$gender', '1', '$pw', '$created_at', '$country'";
        if ($password != $repeatPassword) {
            echo "Hasła są różne.";
        } else {
            $db = new Db();
            $insert = $db->insert($table, $columns, $value);
        }
        if ($insert != 0) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: http://jubel.ayz.pl/");
        } else {
            echo "Rejestracja nie powiodła się.";
        }
    }
}
?>

<div class="content">
    <form action="singup.php" method="post" >

        <div class="fname">
            <span>Imię:</span> <input type="text" name="First_name" maxlength="10" size="5" />
        </div>
        <div class="lname">
            <span>Nazwisko:</span> <input type="text" name="Last_name" maxlength="50" size="5" />
        </div>
        <div class="email">
            <span>Email:</span> <input type="text" name="Email" maxlength="50" size="5" />
        </div>
        <div class="gender">
            <span>Płeć:</span> <select name="Gender">
                <option>Nie chcę podawać</option>
                <option>Mężczyzna</option>
                <option>Kobieta</option>
            </select>
        </div>
        <div class="password">
            <span>Hasło:</span> <input type="password" name="Password" size="5" />
        </div>
        <div class="repeatPassword">
            <span>Powtórz hasło:</span> <input type="password" name="repeatPassword" size="5" />
        </div> 
        <div class="country">
            <span>Państwo:</span> <input type="text" name="Country" maxlength="50" size="5" />
        </div>
        <div id="submit">             
            <button type="submit">Zarejestruj</button>
        </div>

    </form> 
</div>
<script>
    $(document).ready(function () {

        //Walidacja hasła
        $('#Password').on('blur', function () {
            var input = $(this);
            var name_length = input.val().length;
            if (name_length >= 5 && name_length <= 15) {
                input.removeClass("invalid").addClass("valid");
                input.next('.komunikat').text("Wprowadzono poprawne hasło.").removeClass("blad").addClass("ok");
            } else {
                input.removeClass("valid").addClass("invalid");
                input.next('.komunikat').text("Hasło musi mieć więcej niż 5 i mniej niż 16 znaków!").removeClass("ok").addClass("blad");

            }
        });
        $('#repeatPassword').on('blur', function () {
            var input = $(this);
            var name_length = input.val().length;
            if (name_length >= 5 && name_length <= 15) {
                input.removeClass("invalid").addClass("valid");
                input.next('.komunikat').text("Wprowadzono poprawne hasło.").removeClass("blad").addClass("ok");
            } else {
                input.removeClass("valid").addClass("invalid");
                input.next('.komunikat').text("Hasło musi mieć więcej niż 5 i mniej niż 16 znaków!").removeClass("ok").addClass("blad");

            }
        });

        //Walidacja email
        $('#Email').on('blur', function () {
            var input = $(this);
            var pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            var is_email = pattern.test(input.val());
            if (is_email) {
                input.removeClass("invalid").addClass("valid");
                input.next('.komunikat').text("Wprowadzono poprawny email.").removeClass("blad").addClass("ok");
            } else {
                input.removeClass("valid").addClass("invalid");
                input.next('.komunikat').text("Wprowadź poprawny email!").removeClass("ok").addClass("blad");
            }
        });



        //Po próbie wysłania formularza

    });
</script>



