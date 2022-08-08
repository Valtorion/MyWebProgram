<?php

session_start();

$mysqli = new mysqli('localhost','Tomarovski','Lena2005Lena','data-prakt');

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}





ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

    if (true)
    {
        $post = file_get_contents("php://input");

        $post = json_decode($post, true);
        
        $result = $post;
        
            if ($result[0] == "CheckForm") 
            {
                CheckForm($result);
            }

            if ($result[0] == "AddStudent") 
            {
                AddStudent($result);
            }

            if ($result[0] == "login") 
            {
                sleep(0.0100);echo (json_encode($result));
                
            }

            if ($result[0] == "AStudent") 
            {
                sleep(0.0100);echo (json_encode($result));
            }

            if ($result[0] == "GetForm") 
            {
                GetForm($result[1], $result[2]);     
            }

            if ($result[0] == "AccesForm")
            {
                AccesForm($result);
            }

            if ($result[0] == "CreateTable")
            {
                CreateTable($result);
            }

            if ($result[0] == "AddDZ")
            {
                CheckDZ($result);
            }

            if ($result[0] == "ChancheDZ")
            {
                ChancheDZ($result);
            }

            if ($result[0] == "Obj") 
            {
                GetObj();    
            }

            if ($result[0] == "SearchDZ") 
            {
                SearchDZ($result);    
            }

            if ($result[0] == "DeleteDZ") 
            {
                DeleteDZ($result);
            }

            if ($result[0] == "Groop_id") 
            {
                echo (json_encode(["Groop_id", $_SESSION["groop_id"]]));  
            }
            


        
    };


function GetTimespand($data)
{
    $date = implode("-",(explode("/",$data)));
    $time = strtotime($date);

    return $time;
}
function AccesForm($result) 
{
    unset($result[0]);

    $_SESSION["groop_id"] = (int)$result[3];
    
    echo(json_encode(["FormAcces"]));
}



// Функции страницы результата

function CreateTable($result)
{
    global $mysqli;
    $DZplan = array();
    $DZ = array();
    $resR = array();
    $timeSpand = 0;
 
    $timeSpand = GetTimespand($result[1]);
    $dateArray = getdate($timeSpand);

    

    $DZ[0] = "CreateTable";

    if ($dateArray != "Invalid date")
    {
        
        
        $strdate = (string)$dateArray["year"]."-".(string)($dateArray["mon"])."-".(string)$dateArray["mday"];
        
        for ($i = 0;$i< 2; $i++) 
        {
            for ($j = 0;$j< 6; $j++) 
            {
                $DZplan[] = ($strdate);

                $timeSpand = $timeSpand + ((1) * 24 * 60 * 60);
                $dateArray = getdate($timeSpand);

                $strdate = (string)$dateArray["year"]."-".(string)($dateArray["mon"])."-".(string)$dateArray["mday"];
            }
            
        }

        $strplan = str_replace("[","", json_encode($DZplan));
        $strplan = str_replace("]","", $strplan);

        $res = $mysqli->query("SELECT * FROM DZ_study NATURAL JOIN DZ WHERE Groop_id =$result[2] AND date IN (".$strplan.")");
        
        $resR[] = array();
        while ($row = mysqli_fetch_array($res))
        {
            $resR[] = $row;
        }
        
        

        
        $tempf = function($resR, $DZplan, $DZ)
        {
            $coinc = false;
            $dateISO = "";
            $DZarr = array();

            
            for ($i = 0;$i < 12; $i++) 
            {
                $coinc = false;
                
                
                for ($g = 1;$g < count($resR); $g++) 
                {
                    
                    $dateISO = date("Y-m-d",GetTimespand($resR[$g]["date"]));
                    
                    
                    if (strcmp(date("Y-m-d",GetTimespand($DZplan[$i])),$dateISO) == false) 
                    {
                        $DZarr[] = ($resR[$g]);
                        $coinc = true;
                    }
                        
                }

                if ($coinc == false) 
                {
                    $DZ[] = ([$DZplan[$i], ""]);    
                }else
                {
                    $DZ[] = ([$DZplan[$i], $DZarr]);
                    $DZarr = [];
                }


            }


            
            echo (json_encode($DZ));
        };
        
        
        $tempf($resR, $DZplan, $DZ);

        
        
    }
    
    

    
}


function CheckDZ($result) 
{
    global $mysqli;
    $checkP = array();

    $checkP[] = ($result["Groop"]);
    $checkP[] = (date("Y-m-d",GetTimespand($result["date"])));
    $checkP[] = ($result["Obj"]);

    

    $res = $mysqli->query("SELECT EXISTS(SELECT * FROM DZ_study NATURAL JOIN DZ WHERE Groop_id=$checkP[0] AND date='$checkP[1]' AND Obj='$checkP[2]');");
    
    $res = mysqli_fetch_array($res);
    

    if ($res[0] == 0) 
    {
        AddDZ($result);
    }else
    {
        
        echo (json_encode(["AddDZ", false]));
        
    }
    

}




function AddDZID($result)
{
    global $mysqli;
    $res = $mysqli->query("INSERT INTO DZ_study(Groop_id, dz_id) VALUES('".$result["Groop"]."', '".$result["DZ_id"]."')"); 
    

}


function AddDZ($result)
{
    global $mysqli;
    $pushOn = array();

    $pushOn[] = (date("Y-m-d",GetTimespand($result["date"])));
    $pushOn[] = ($result["Obj"]);
    $pushOn[] = ($result["DZtext"]);

    
    
    $res = $mysqli->query("INSERT INTO DZ(date, obj, DZ, OTime) values('$pushOn[0]', '$pushOn[1]', '$pushOn[2]', '');"); 
    

    $res = $mysqli->query("SELECT dz_id FROM DZ WHERE date='".$result["date"]."' AND obj='".$result["Obj"]."'");
    

    $resR[] = array(); 
    while ($row = mysqli_fetch_array($res))
    {
        $resR[] = $row;
    };

    
    $result["DZ_id"] = $resR[1]["dz_id"];
    AddDZID($result);
    


    echo (json_encode(["AddDZ", true]));


}



function ChancheDZ($result)
{
    global $mysqli;
    $res = $mysqli->query("Update DZ SET DZ='$result[1]' WHERE DZ_id=$result[2]"); 
    
    echo (json_encode(["ChancheDZ", true]));
    
      
}



function DeleteDZ($result)
{
    global $mysqli;
    $res = $mysqli->query("DELETE from $DZ WHERE $DZ_id=$result[1]");
    

    echo (json_encode(["DeleteDZ", true]));
}



function SearchDZ($result) 
 {
    global $mysqli;
    $res = $mysqli->query("select * from DZ WHERE obj='$result[1]'");
    $resR[] = array();
    while ($row = mysqli_fetch_array($res))
    {
        $resR[] = $row;
    };

    

    $date = 0;

        if ($resR == "") 
        {
            echo (json_encode(["SearchDZ", false]));
            return;     
        }

        for ($i = 1;$i< count($resR); $i++) 
        {
            if ($date < $resR[$i]["date"]) 
            {
                $date = $resR[$i]["date"];    
            }
            
        }

        echo (json_encode(["SearchDZ", $date]));
 }







// Функции формы

function GetForm($point, $lpoint)
 {
    global $mysqli;
    
    if ($point == "Факультет") 
    {
        $FacArr = array("GetForm", "Факультет");
        

        $res = $mysqli->query("SELECT * FROM Facultet;"); 
        $resR[] = array();
        while ($row = mysqli_fetch_object($res))
        {
            $resR[] = $row;
        };

            for ($i = 1;$i< count($resR); $i++) 
            {
                $FacArr[] = ($resR[$i]->Fac);
                $FacArr[] = ($resR[$i]->Fac_id);
            }

            echo (json_encode($FacArr));
    }

    if ($point == "Специальность") 
    {
        $SpecArr = array("GetForm", "Специальность");

        $res = $mysqli->query("select * from Special NATURAL JOIN Facultet WHERE Fac='".$lpoint."'"); 
        
        $resR[] = array();
        while ($row = mysqli_fetch_object($res))
        {
            $resR[] = $row;
        }; 
        
            for ($i = 1;$i< count($resR); $i++) 
            {
                $SpecArr[] = ($resR[$i]->Spec);
                $SpecArr[] = ($resR[$i]->Spec_id);
            }
            echo (json_encode($SpecArr));
    }

    if ($point == "Группа") 
    {
        $GroupArr = array("GetForm", "Группа");
        

        $res = $mysqli->query("select * from GROOP NATURAL JOIN Special WHERE Spec='".$lpoint."'");
        
        $resR[] = array();
        while ($row = mysqli_fetch_object($res))
        {
            $resR[] = $row;
        };

        for ($i = 1;$i< count($resR); $i++) 
            {
                $GroupArr[] = ($resR[$i]->Groop);
                $GroupArr[] = ($resR[$i]->Group_id);
            }
            echo (json_encode($GroupArr));

    }
    if ($point == "Предмет") 
    {
        $ObjArr = ["GetForm"];
        $ObjArr[1] = ["Предмет"];

        $res = $mysqli->query("select * from Object_study NATURAL JOIN Object WHERE Groop_id='".$lpoint."'"); 
        
        $resR[] = array();
        while ($row = mysqli_fetch_object($res))
        {
            $resR[] = $row;
        };

        for ($i = 1;$i< count($resR); $i++) 
            {
                $ObjArr[] = ($resR[$i]->obj);
                $ObjArr[] = ($resR[$i]->Obj_id);
            }

            echo (json_encode($ObjArr));
    }
    

 }

function CheckForm($result)
{
    global $mysqli;
    $Nfunc = $result[1];
    unset($result[0]);
    unset($result[1]);
    $checkP = array();

    $res = json_decode(json_encode($result), true);
    $checkP = array_values($res);

    
    try
    {
        $checkP[0] = (int)$checkP[0];
        $checkP[1] = (int)$checkP[1];
        $checkP[2] = (int)$checkP[2];
    }catch (Exception $e)
    {
        echo (json_encode(["Deny"]));
        return;
    };
    
    
    $res = $mysqli->query("SELECT EXISTS(SELECT * FROM Students AS d WHERE d.Fac_id=$checkP[0] AND d.Spec_id=$checkP[1] AND d.Groop_id=$checkP[2] AND d.Fname='$checkP[3]' AND d.Name='$checkP[4]');");
    $res = mysqli_fetch_array($res);
    
    $resarr = array("CheckAcces","Deny", $Nfunc);
    $resarr = array_merge($resarr, $checkP);
    

        if ($res[0] == true) 
        {
            $resarr[1] = "Acces";
            echo (json_encode($resarr));  
        }else echo (json_encode($resarr));

}

function AddStudent($result)
{
    global $mysqli;
    unset($result[0]);
    $checkP = array();

    for ($i = 0;$i < count($result);$i++) 
    {
        $checkP[] = ($result[$i]);
    }

    $res = $mysqli->query("INSERT INTO Students VALUES($checkP[0], $checkP[1], $checkP[2], $checkP[3], $checkP[4], '')"); 
       

    echo ("Acces");
    
}


 
 function GetObj() 
{
    global $mysqli;
    $res = $mysqli->query("select obj from Object_study NATURAL JOIN Object WHERE Groop_id=".$_SESSION["groop_id"].""); 
    $resR = array();

    while ($row = mysqli_fetch_object($res))
    {
        $resR[] = $row;
    };
    
    
    $arrObj = array("GetObj");

    
        for ($i = 1;$i< count($resR); $i++) 
        {
            $arrObj[] = ($resR[$i]->obj);
        }

        echo (json_encode($arrObj));
 }






?>