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



    if (isset($_GET["action"]))
    {

        $result = $mysqli->query("SELECT * FROM ".$_GET["nametable"].";");

        $nameparam = $result->fetch_assoc();
        $nameparam = array_keys($nameparam);

        

        if ($_GET["action"] == "Добавить")
        {
            AddT($nameparam);
        }

        if ($_GET["action"] == "Изменить")
        {
            SetT($nameparam);
        }

        if ($_GET["action"] == "Удалить")
        {
            DeleteT($nameparam);
        }

    }




    function AddT($nameparam)
    {
        global $mysqli;

        
        $body = "";
        $body1 = "";

        for ($i = 0;$i < count($nameparam) - 1;$i++)
        {   
            
            $body = $body."'".$nameparam[$i]."', ";
            
        }
        $body = $body."'".$nameparam[count($nameparam) - 1]."'";



        $body1 = $body1."'0', ";
        for ($i = 0;$i < count($_GET["param"]) - 1;$i++)
        {

            $body1 = $body1."'".$_GET["param"][$i]."', ";
            
        }
        $body1 = $body1."'".$_GET["param"][count($_GET["param"]) - 1]."'";

        $result = $mysqli->query("INSERT INTO ".$_GET["nametable"]." VALUES (".$body1.");");

        

       /* if ($result)
        {
            echo "Sus";
        }else echo mysqli_error($mysqli);
        */

    }


    function SetT($nameparam)
    {
        global $mysqli;

        $body = "";

        
        for ($i = 0;$i < count($_GET["param"]) - 1;$i++)
        {
            $body = $body.$nameparam[$i+1]." = '".$_GET["param"][$i]."', ";
        }
        $body = $body.$nameparam[count($_GET["param"])]." = '".$_GET["param"][count($_GET["param"])-1]."'";

        $result = $mysqli->query("UPDATE ".$_GET["nametable"]." SET ".$body." WHERE id='".$_GET["id"]."';");

        /*
        if ($result)
        {
            echo "Sus";
        }else echo mysqli_error($mysqli);
       */

    }

    function DeleteT($nameparam)
    {
        global $mysqli;

        $body = "";

        $result = $mysqli->query("DELETE FROM ".$_GET["nametable"]." WHERE id='".$_GET["id"]."';");
    }

    

    header('Location: http://p96357hm.beget.tech/Tables.html');
    exit();
    

?>