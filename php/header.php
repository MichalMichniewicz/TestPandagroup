<div class="heder">
    <?php
    session_start();
    if ($_SESSION['zalogowany'] == 1) {
        ?>
        <div class="logged">
            <p>Witaj <?php echo $_SESSION['userName'] ?></p>
            <a href="/php/userpanel.php">Panel użytkownika</a>
            <a href="/php/heder/login.php?akcja=logout">Wyloguj</a>
        </div>
    <?php } else {
        ?>
        <div class="notloggedin">
            <div class="reistery">
                <a href="/php/heder/singup.php">Rejestracja</a>
            </div>
            <div class="login">
                <a href="/php/heder/login.php">Logowanie</a>
            </div>
        </div>
    <?php } ?>
    <div class="menu">
        <ul>
            <li class="menuitem">
                <a href="../../index.php">Strona główna</a>
            </li>
            <li class="menuitem">
                <a href="/php/content/readcsv.php">Wczytaj CSV</a>
            </li>
        </ul>
    </div>
</div>