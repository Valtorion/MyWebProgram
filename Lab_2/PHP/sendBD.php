<?php

$mysqli = new mysqli('localhost','p96357hm_datdata','Lena2005','p96357hm_datdata');

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}


$body = "INSERT INTO grafick(id, param, datazamer, znachenie) VALUES ";


if (isset($_POST["lables"]))
{
    
    for ($i = 0;$i < count($_POST["lables"]) - 1;$i++)
    {
        $temp = "('0', '".$_POST["param"]."', '".$_POST["lables"][$i]."', '".$_POST["Ddata"][$i]."'), ";
        $body = $body.$temp;
    }

    $body = $body."( '0', '".$_POST["param"]."', '".$_POST["lables"][count($_POST["lables"]) - 1]."', '".$_POST["Ddata"][count($_POST["lables"]) - 1]."');";
    
    $mysqli->query($body);
    print "Данные успешно добавлены";

    
}

$mysqli->close();
?>