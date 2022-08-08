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



    $ntable = "Error";
    $action = "Добавить";
    if (isset($_GET['table'])) $ntable = $_GET["table"];
    $action = $_GET['action'];

   
    if ($action == 'Добавить')
    {
        CreateFormT($ntable, $action);
    }

    if ($action == 'Изменить')
    {
        CreateFormT($ntable, $action);
    }

    if ($action == 'Удалить')
    {
        CreateFormT($ntable, $action);
    }


    function OpSelect($fkname, $nact, $idrow)
    {
        global $mysqli;

        // SELECT * FROM `INNODB_SYS_FOREIGN` WHERE ID LIKE '%/Priem_ibfk_1%'
        
        $result = $mysqli->query("SELECT REF_NAME FROM INFORMATION_SCHEMA.INNODB_SYS_FOREIGN WHERE ID LIKE '%/".$fkname."%';");
        
        $idrow1 = $idrow;
        $idrow = $mysqli->query("SELECT ".$idrow1." FROM ".$_GET["tn"]." WHERE id='".$_GET["id"]."';");
        
        $idrow = $idrow->fetch_assoc();
        $idrow = $idrow[$idrow1];
        
        
        $refname = $result->fetch_assoc();
        $refname = str_replace("Lab_1/", "", $refname["REF_NAME"]);

        $result = $mysqli->query("SELECT * FROM ".$refname.";");
        
        $body = "";
        while ($cell = $result->fetch_assoc())
        {
            if (!array_key_exists("title", $cell))
            {
                $body = "<option id='".$cell["id"]."' >".$cell["Fname"]." ".$cell["Name"]." ".$cell["Mname"]."</option>";
            }else $body = "<option id='".$cell["id"]."' >".$cell["title"]."</option>";
            

            if ($nact == "Изменить" && $cell["id"] == $idrow)
            {
                $body = str_replace(">", "selected >", $body);
            }

            if ($nact == "Удалить" && $cell["id"] == $idrow)
            {
                $body = str_replace(">", "selected disabled>", $body);

            }

            print $body;
            
        }
    }



    function CreateFormT($ntable, $nact)
    {
        global $mysqli;

        print "<form id='".$_GET["tn"]."' name='".$_GET["id"]."' action='phpsend.php' method='POST'>";
        print "<h3>".$nact." запись к таблице \"".$ntable."\""."</h3>";


        //  SELECT COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA ='Lab_1' AND TABLE_NAME ='Priem' AND CONSTRAINT_NAME <>'PRIMARY' AND REFERENCED_TABLE_NAME is not null 

        $result = $mysqli->query("SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$_GET["tn"]."';");
        $foerkey = $mysqli->query("SELECT COLUMN_NAME, CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA ='Lab_1' AND TABLE_NAME ='".$_GET["tn"]."' AND CONSTRAINT_NAME <>'PRIMARY' AND REFERENCED_TABLE_NAME is not null;");
        $namerow = $mysqli->query("SELECT * FROM ".$_GET["tn"].";");
        $curparam = $mysqli->query("SELECT * FROM ".$_GET["tn"]." WHERE id='".$_GET["id"]."';");

        $namerow = array_keys($namerow->fetch_assoc());
        $curparam = $curparam->fetch_assoc();

        $fk[] = "";
        while ($fk1 = $foerkey->fetch_assoc())
        {
            $fk[] = $fk1;
        
        }

        
        $i = 0;
        while ($row = $result->fetch_assoc())
        {
            if ($i == 0) 
            {
                $i++;
                continue;
            }

            $col = $row["DATA_TYPE"];
            print $_GET["title"][$i];
            

            
            if ($col == "varchar")
            {
                if ($nact != "Добавить")
                {
                    print "<input type='text' id='".$namerow[$i]."' name='srs' value='".$curparam[$namerow[$i]]."' style='display: block;'>";
                }else print "<input type='text' id='".$namerow[$i]."' name='srs' value='' style='display: block;'>";
                
            }

            if ($col == "date")
            {
                if ($nact != "Добавить")
                {
                    print "<input type='date' id='".$namerow[$i]."' name='srs' value='".$curparam[$namerow[$i]]."' style='display: block;'>";
                }else print "<input type='date' id='".$namerow[$i]."' name='srs' value='' style='display: block;'>";
            }

            if ($col == "int")
            {
                $trufals = false;
                
                for ($g = 1;$g < count($fk);$g++)
                {
                    if ($namerow[$i] == $fk[$g]["COLUMN_NAME"])
                    {
                        print "<select id='".$namerow[$i]."' style='display: block;'>";

                        if ($nact != "Добавить")
                        {
                            print "<option value = '".$_GET["title"][$i]."'disabled>Выберите ".$_GET["title"][$i]."</option>";
                        }else print "<option value = '".$_GET["title"][$i]."'selected disabled>Выберите ".$_GET["title"][$i]."</option>";
    
                        OpSelect($fk[$g]["CONSTRAINT_NAME"], $nact, $fk[$g]["COLUMN_NAME"]);
                        print "</select>";
                        $trufals = true;
                        break;
                    }
                }
                
                if ($trufals == false)
                {

                    if ($nact != "Добавить")
                    {
                        print "<input type='text' id='".$namerow[$i]."' name='srs' value='".$curparam[$namerow[$i]]."' style='display: block;'>";
                    }else print "<input type='text' id='".$namerow[$i]."' name='srs' value='' style='display: block;'>";
                }              
            }

            $i++;
        }


        print "<input type='button' id='b1' value='ОК' onclick='SendForm()'>";
        print "<input type='button' id='b2' value='Отмена' onclick='document.location.href = \"http://p96357hm.beget.tech/Tables.html\"'>";
        print "</form>";
    }
    
    $mysqli->close();
    
?>