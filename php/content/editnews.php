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
        include_once("../../php/header.php");
        require_once("../../php/db.class.php");
        $dataBase = new Db();
        session_start();
        if (isset($_GET['akcja']) && substr($_GET['akcja'], 0, -strlen($_GET['akcja']) + 6) == "edytuj") {
            $table = 'news';
            $where = "id = " . substr($_GET['akcja'], 7);
            $_SESSION['where'] = $where;
            $columns = 'id, name, description';

            $news = $dataBase->selectAll($table, $columns, $where);
            foreach ($news as $new) {
                $titel = $new['name'];
                $description = $new['description'];
            }
        }

        if (isset($_POST['titel']) && isset($_POST['myeditor']) && isset($_POST['isactive'])) {
            if (!empty($_POST['titel']) && !empty($_POST['myeditor'] && !empty($_POST['isactive']))) {
                $titel = filter_var($_POST['titel'], FILTER_SANITIZE_STRING);
                $myeditor = $_POST['myeditor'];
                $is_active = filter_var($_POST['isactive'], FILTER_SANITIZE_STRING);
                $updated_at = date("Y-m-d");
                $userId = $_SESSION['idUser'];
                if ($is_active == "Tak") {
                    $is_active_up = 1;
                } else {
                    $is_active_up = 0;
                }
                $table = 'news';
                $data = [
                    'name' => $titel,
                    'description' => $myeditor,
                    'is_active' => $is_active_up,
                    'updated_at' => $updated_at,
                ];
                $insert = $dataBase->updeate($table, $data, $_SESSION['where']);
                ?>
                <script> location.replace("../userpanel.php");</script>
                <?php
            }
        }
        ?>
        <h3>Dodaj nowy news</h3>
        <form method="POST" action="editnews.php">
            <ul>
                <li><span>Tytył: </span><input name="titel" type="text" value="<?php echo $titel ?>"></li>
                <li><span>Treść: </span>
                    <textarea name="myeditor" id="myeditor" rows="10" cols="80">
                        <?php echo $description ?>
                    </textarea>
                    <script>
                        CKEDITOR.replace('myeditor');
                    </script>
                </li>
                <li><span>Czy news ma być aktywny: </span> 
                    <select name="isactive">
                        <option>Tak</option>
                        <option>Nie</option>
                    </select>
                </li>
                <li>
                    <input type="submit" value="zapisz news" />
                </li>
            </ul>
        </form>
    </body>
</html>