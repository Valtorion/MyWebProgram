<?php

//Open a new connection to the MySQL server
$mysqli = new mysqli('localhost','p96357hm_datdata','Lena2005','p96357hm_datdata');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

$mysqli->query("SET NAMES 'utf8'"); 
$mysqli->query("SET CHARACTER SET 'utf8'");
$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");



if (isset($_GET["body"]))
{

    if ($_GET["body"] == 1)
    {
        $result = $mysqli->query("DELETE FROM Pacients WHERE NOT EXISTS (SELECT * FROM Priem WHERE Pacients.id = Priem.id_pac)");
    
    }

    if ($_GET["body"] == 2)
    {
        $result = $mysqli->query("UPDATE Diagnoz SET title=REPLACE(title, 'уха', 'ания') WHERE title LIKE '%уха'");
        $result = $mysqli->query("UPDATE Diagnoz SET title=CONCAT(title, 'шис') WHERE title LIKE '_е%'");

    }
    $mysqli->close();

}




    header('Location: http://lab3.ru/Tables.html');
    exit();


?>