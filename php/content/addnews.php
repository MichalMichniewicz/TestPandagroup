<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>-->
        <script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    </head>
    <body>
        <?php
        require_once("../../php/header.php");
        require_once("../../php/db.class.php");
        session_start();

        if (isset($_POST['titel']) && isset($_POST['myeditor']) && isset($_POST['isactive'])) {
            if (!empty($_POST['titel']) && !empty($_POST['myeditor'] && !empty($_POST['isactive']))) {
                $titel = filter_var($_POST['titel'], FILTER_SANITIZE_STRING);
                $myeditor = $_POST['myeditor'];
                $is_active = filter_var($_POST['isactive'], FILTER_SANITIZE_STRING);
                $created_at = date("Y-m-d");
                $userId = $_SESSION['idUser'];

                $table = 'news';
                $columns = 'name, description, is_active, created_at, author_id';
                $value = "'$titel', '$myeditor', '$is_active', '$created_at', '$userId'";

                $db = new Db();
                $insert = $db->insert($table, $columns, $value);
                ?>
                <script> location.replace("../userpanel.php");</script>
                <?php
            }
        }
        ?>
        <h3>Dodaj nowy news</h3>
        <form method="POST" action="addnews.php">
            <ul>
                <li><span>Tytył: </span><input name="titel" type="text"></li>
                <li><span>Treść: </span>
                    <textarea name="myeditor" id="myeditor" rows="10" cols="80">
                    </textarea>
                    <script>
                        CKEDITOR.replace('myeditor');
                    </script>
                </li>
                <li><span>Czy news ma być aktywny: </span> 
                    <select name="isactive">
                        <option value="1">Tak</option>
                        <option value="0">Nie</option>
                    </select>
                </li>
                <li>
                    <input type="submit" value="zapisz news" />
                </li>
            </ul>
        </form>
    </body>
</html>