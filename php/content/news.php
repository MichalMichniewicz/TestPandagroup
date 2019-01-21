<?php

$addres = $_SERVER['REQUEST_URI'];
$addres = substr($addres, 5);
if ($addres != 'userpanel.php') {
    $where = '*';
    $isUser = 0;
} else {
    session_start();
    $where = "author_id = " . $_SESSION['idUser'];
    $isUser = 1;
}
$table = 'news';
$columns = 'id, name, description, is_active, created_at, updated_at, author_id';
$dataBase = new Db();
$news = $dataBase->selectAll($table, $columns, $where);
foreach ($news as $new) {
    if ($isUser == 1) {
        echo "<div class='news'>";
        echo "<div class='titel'><span>" . $new['name'] . "</span></div>";
        echo "<div class='autor'>";
        if($new["is_active"]==1){
            echo "<span class='active'>Aktywny</span>";
        }else{
            echo "<span class='noactive'> Nie aktywny </span>";
        }
        echo "<a href='content/editnews.php?akcja=edytuj_" . $new['id'] . "'> Edytuj </a><a href='userpanel.php?akcja=usun_" . $new['id'] . "'> Usuń </a></div>";
        echo "<div class='new'>" . $new['description'] . "</div>";
        echo "</div>";
    } else {
        if ($new['is_active'] == 1) {
            echo "<div class='news'>";
            echo "<div class='titel'><h3>" . $new['name'] . "</h3></div>";
            echo "<div class='new'>" . $new['description'] . "</div>";
            echo "</div>";
        }
    }
}