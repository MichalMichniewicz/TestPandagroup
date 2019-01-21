<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wczytaj CSV</title>
        <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    </head>
    <body>
        <?php
        require_once("../header.php");
        require_once("../db.class.php");
        ?>
        <div class="content">
            <p>
                <b>Wymagany plik csv w formacie: </b>
            <pre>
<code>
id,first_name,last_name,email,gender,country
1,Brena,Baterip,bbaterip0@ustream.tv,Female,France
</code>
            </pre>	
        </p>
        <b>Wybierz plik do importu:</b>&nbsp;&nbsp;&nbsp;
        <form action="readcsv.php" method="POST" id="import_csv" enctype="multipart/form-data">
            <p><input type="file" name="csvupload" /></p>
            <button type="submit"  class="scalable" /><span><span><span>Importuj >></span></span></span></button>
        </form>
        <?php require_once("../readcsvControler.php") ?>
    </div>
</body>
</html>
