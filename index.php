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
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        
        <?php
        $filepath = realpath(dirname(__FILE__));
        require_once("php/header.php");
        include_once("php/db.class.php");
        echo "<div class='content'>";
        include_once("php/content/news.php");
        echo "</div>";
        ?>
    </body>
</html>
