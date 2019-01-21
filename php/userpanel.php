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
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <?php
        include_once("header.php");
        include_once("db.class.php");
        $dataBase = new Db();
        ?>
        <div class="content">
            <div class="infopanel">
                <h2>Planel użytkownika</h2>
                <a href="content/addnews.php">Dodaj news</a>
            </div>
            <?php require_once("content/news.php"); ?>
        </div>
    </body>
</html>
<?php
if (isset($_GET['akcja']) && substr($_GET['akcja'], 0, -strlen($_GET['akcja']) + 4) == "usun") {
    $idTask = substr($_GET['akcja'], 5);
    $table = "news";
    $where = "id = " . $idTask;
    $follow = $dataBase->delete($table, $where);
    ?>
    <script> location.replace("userpanel.php");</script>
    <?php
}
?>
