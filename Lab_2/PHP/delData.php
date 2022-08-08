<?php

$mysqli = new mysqli('localhost','p96357hm_datdata','Lena2005','p96357hm_datdata');

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}


if (isset($_POST["param"]))
{
    $p = $_POST["param"];
    $result = $mysqli->query("DELETE FROM grafick WHERE param=$p");

    print "Данные удалены";
}

$mysqli->close();

?>