<?php

function setConnection() {
    $dblocation = "127.0.0.1";
    $dbname = "myshop";
    $dbuser = "root";
    $dbpasswrd = "";

    $db = mysqli_connect($dblocation, $dbuser, $dbpasswrd);

    if (! $db) {
        echo 'Ошибка доступа к MySQL';
        exit();
    }

    mysqli_set_charset($db, 'utf8');

    if (! mysqli_select_db($db, $dbname)) {
        echo 'Ошибка доступа к базе данных: ' .$dbname;
        exit();
    }
    return $db;
}

