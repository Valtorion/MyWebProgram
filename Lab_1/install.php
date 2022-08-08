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





function PrintST($table)  // Вывод простых таблиц
{
    global $mysqli;
    $results = $mysqli->query("SELECT id, title FROM $table;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl" onclick="ModForm(this)">';
print '<table class="MySQLT" id="'.$table.'" border="1"';
print '<caption>Таблица '.$table.'</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr class="ttr" onclick="TRformActive(this)">';
        foreach($row as $key => $cell)
        {
            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';

}



function PrintTT($table, $id_fisrt, $id_sec)  // Вывод промежуточных таблиц
{
    global $mysqli;
    $results = $mysqli->query("SELECT id, $id_fisrt, $id_sec FROM $table;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl">';
print '<table class="MySQLT" id='.$table.' border="1"';
print '<caption>Таблица '.$table.'</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr>';
        foreach($row as $key => $cell)
        {
            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';

}


function MainT()
{
    global $mysqli;
    //MySqli Select Query
$results = $mysqli->query("SELECT id, id_pac AS 'Пациент', id_doctor AS 'Врач', date_priema AS 'Дата приема', Place AS 'Место приема', Predpicanie AS 'Предписание', Diagnos AS 'Диагноз' FROM Priem;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl" onclick="ModForm(this)">';
print '<table class="MySQLT" id="Priem" border="1"';
print '<caption>Таблица приемов у врачей</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr class="ttr" onclick="TRformActive(this)">';
        foreach($row as $key => $cell)
        {
            if ($key == "Пациент")
            {
                $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                
            }

            if ($key == "Врач")
            {
                $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Doctors WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                
            }

            if ($key == "Место приема")
            {
                $respac = $mysqli->query("SELECT id, title FROM Place WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }

            if ($key == "Предписание")
            {
                $respac = $mysqli->query("SELECT id, title FROM Predpicanie WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }

            if ($key == "Диагноз")
            {
                $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }
            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';




// Врачи


$results = $mysqli->query("SELECT id, Special AS 'Специальность', Stash  AS 'Стаж', Cabinet  AS 'Номер кабинета', Fname AS 'Фамилия', Name AS 'Имя', Mname AS 'Отчество', sex  AS 'Пол', Rdate  AS 'Дата рождения' FROM Doctors;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl" onclick="ModForm(this)">';
print '<table class="MySQLT" id="Doctors" border="1"';
print '<caption>Таблица врачей</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr class="ttr" onclick="TRformActive(this)">';
        foreach($row as $key => $cell)
        {

            if ($key == "Специальность")
            {
                $respac = $mysqli->query("SELECT id, title FROM Special WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }

            if ($key == "Пол")
            {
                $respac = $mysqli->query("SELECT id, title FROM Sex WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }

            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';

// Пациенты

$results = $mysqli->query("SELECT id, Fname AS 'Фамилия', Name AS 'Имя', Mname AS 'Отчество', sex  AS 'Пол', Date  AS 'Дата рождения', Home  AS 'Домашний адрес', Phone  AS 'Номер телефона' FROM Pacients;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl" onclick="ModForm(this)">';
print '<table class="MySQLT" id="Pacients" border="1"';
print '<caption>Таблица пациентов</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr class="ttr" onclick="TRformActive(this)">';
        foreach($row as $key => $cell)
        {

            if ($key == "Пол")
            {
                $respac = $mysqli->query("SELECT id, title FROM Sex WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }

            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';



// Лекарства


$results = $mysqli->query("SELECT id, title AS 'Название', Spocobpriema AS 'Способ приема', titleaction AS 'Применение' FROM Lecarstvo;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl" onclick="ModForm(this)">';
print '<table class="MySQLT" id="Lecarstvo" border="1"';
print '<caption>Таблица лекарств</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr class="ttr" onclick="TRformActive(this)">';
        foreach($row as $key => $cell)
        {

            if ($key == "Способ приема")
            {
                /*
                if(!$mysqli->query("SELECT id, title FROM SpocobPriema WHERE id = $cell;")) {
                    echo "Ошибка связывания параметров: " . mysqli_error($mysqli);
                    exit();
                  }
                  */
                $respac = $mysqli->query("SELECT id, title FROM SpocobPriema WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }

            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';






PrintST("Diagnoz");
PrintST("Iffect");
PrintST("Place");
PrintST("Predpicanie");
PrintST("Sex");
PrintST("Siptomi");
PrintST("Special");
PrintST("SpocobPriema");

PrintTT("LecarstvoIffect", "id_iffect", "id_lec");
PrintTT("LecarstvoPriem", "id_priem", "id_lec");
PrintTT("SiptomiPriem", "id_priem", "id_siptom");


$mysqli->close();

}










function MainR()
{
    global $mysqli;
    //MySqli Select Query

    // 1. Список пациентов по количеству обращений к врачу по убыванию


    $results = $mysqli->query("SELECT COUNT(*) AS 'Количество больных', Priem.id_pac, Pac.Fname AS 'Фамилия', Pac.Name AS 'Имя', Pac.Mname AS 'Отчество' FROM Priem JOIN Pacients AS Pac ON Pac.id = Priem.id_pac GROUP BY Priem.id_pac ORDER BY 'Количество больных' DESC;");

    $keys = array_keys($results->fetch_assoc());

    print '<div class="MySQLTl">';
    print '<table class="MySQLT" border="1"';
    print '<caption>1. Список пациентов по количеству обращений к врачу по убыванию</caption>';
    print '<tr>';
    foreach($keys as $key)
    {
        print '<td>'.$key.'</td>';
    }

    print '</tr>';
    $results->data_seek(0);

    while($row = $results->fetch_assoc()) 
        {
            print '<tr>';
            foreach($row as $key => $cell)
            {
                /*
                if ($key == "Пациент")
                {
                    $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                    
                }

            

                if ($key == "Диагноз")
                {
                    $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['title']);
                    
                }
                */
                print '<td>'.$cell.'</td>';
            }
            print '</tr>';

        }
    print '</table>';
    print '</div>';



        // 2. Количество больных с различным диагнозом, зафиксированных в течение последнего месяца

    $results = $mysqli->query("SELECT COUNT(*) AS 'Количество больных', Diagnos AS 'ID диагноза', D.title AS 'Диагноз' FROM Priem JOIN Diagnoz AS D ON D.id= Priem.Diagnos WHERE 10 = MONTH(date_priema) GROUP BY Diagnos;");

    $keys = array_keys($results->fetch_assoc());

    print '<div class="MySQLTl">';
    print '<table class="MySQLT" border="1"';
    print '<caption>2. Количество больных с различным диагнозом, зафиксированных в течение последнего месяца</caption>';
    print '<tr>';
    foreach($keys as $key)
    {
        print '<td>'.$key.'</td>';
    }

    print '</tr>';
    $results->data_seek(0);

    while($row = $results->fetch_assoc()) 
        {
            print '<tr>';
            foreach($row as $key => $cell)
            {
                /*
                if ($key == "Пациент")
                {
                    $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                    
                }

            

                if ($key == "Диагноз")
                {
                    $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['title']);
                    
                }
                */
                print '<td>'.$cell.'</td>';
            }
            print '</tr>';

        }
    print '</table>';
    print '</div>';




    // 3. Количество пациентов, которое было у каждого врача различные месяцы в течение года

    $results = $mysqli->query("SELECT COUNT(Priem.id_pac) AS 'Количество пациентов', MONTH(Priem.date_priema) AS 'Месяц приема', Priem.id_doctor AS 'ID доктора', Doc.Fname AS 'Фамилия', Doc.Name AS 'Имя', Doc.Mname AS 'Отчество'  FROM Priem JOIN Doctors AS Doc ON Priem.id_doctor = Doc.id WHERE YEAR(Priem.date_priema) = 2020 GROUP BY id_doctor, MONTH(date_priema) ORDER BY MONTH(date_priema);");

    $keys = array_keys($results->fetch_assoc());

    print '<div class="MySQLTl">';
    print '<table class="MySQLT" border="1"';
    print '<caption>3. Количество пациентов, которое было у каждого врача различные месяцы в течение года</caption>';
    print '<tr>';
    foreach($keys as $key)
    {
        print '<td>'.$key.'</td>';
    }

    print '</tr>';
    $results->data_seek(0);

    while($row = $results->fetch_assoc()) 
        {
            print '<tr>';
            foreach($row as $key => $cell)
            {
                /*
                if ($key == "Пациент")
                {
                    $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                    
                }

            

                if ($key == "Диагноз")
                {
                    $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['title']);
                    
                }
                */
                print '<td>'.$cell.'</td>';
            }
            print '</tr>';

        }
    print '</table>';
    print '</div>';




    // 4. Сведения о пациентах, которые обслуживались на дому в течение последнего месяца 

    $results = $mysqli->query("SELECT id, Fname AS 'Фамилия', Name AS 'Имя', Mname AS 'Отчество', sex  AS 'Пол', Date  AS 'Дата рождения', Home  AS 'Домашний адрес', Phone  AS 'Номер телефона' FROM Pacients AS Pac, (SELECT id_pac FROM Priem WHERE Place = 1 AND MONTH(Priem.date_priema) = 10) AS A WHERE Pac.id = A.id_pac;");

    $keys = array_keys($results->fetch_assoc());

    print '<div class="MySQLTl">';
    print '<table class="MySQLT" border="1"';
    print '<caption>4. Сведения о пациентах, которые обслуживались на дому в течение последнего месяца</caption>';
    print '<tr>';
    foreach($keys as $key)
    {
        print '<td>'.$key.'</td>';
    }

    print '</tr>';
    $results->data_seek(0);

    while($row = $results->fetch_assoc()) 
        {
            print '<tr>';
            foreach($row as $key => $cell)
            {
                /*
                if ($key == "Пациент")
                {
                    $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                    
                }

            

                if ($key == "Диагноз")
                {
                    $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['title']);
                    
                }
                */
                print '<td>'.$cell.'</td>';
            }
            print '</tr>';

        }
    print '</table>';
    print '</div>';





    // 5. Сведения об диагнозаз, которые найболее часто ставятя в каждый месяц года

    $tquery = "
    SELECT a.Am AS 'Количество диагнозов', a.Amon AS 'Месяц', a.Bd AS 'ID диагноза', a.Dtitle AS 'Диагноз' FROM 
    (SELECT * FROM 
    
    (SELECT 0 AS Am, 1 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 2 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 3 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 4 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 5 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 6 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 7 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 8 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 9 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 10 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 11 AS Amon, 0 AS Bd, '-' AS Dtitle
    UNION SELECT 0 AS Am, 12 AS Amon, 0 AS Bd, '-' AS Dtitle) AS A
    
    WHERE A.Amon NOT IN 
    (SELECT DISTINCT m FROM
    (SELECT DISTINCT A.m AS 'Частота болезней', A.MON AS m, B.d, D.title FROM
    (SELECT MAX(A) AS m, A.MON AS MON FROM (SELECT COUNT(*) AS A, MONTH(Priem.date_priema) AS MON, Diagnos AS d FROM Priem WHERE YEAR(Priem.date_priema)= 2020 GROUP BY MONTH(Priem.date_priema), d) AS A GROUP BY A.MON) AS A,
    (SELECT COUNT(*) AS A, MONTH(Priem.date_priema) AS MON, Diagnos AS d FROM Priem WHERE YEAR(Priem.date_priema)= 2020 GROUP BY MONTH(Priem.date_priema), d) AS B JOIN Diagnoz AS D ON D.id = B.d WHERE B.A=A.m ORDER BY A.MON) AS A)
    
    UNION 
    (SELECT DISTINCT A.m AS 'Частота болезней', A.MON AS m, B.d, D.title FROM
    (SELECT MAX(A) AS m, A.MON AS MON FROM (SELECT COUNT(*) AS A, MONTH(Priem.date_priema) AS MON, Diagnos AS d FROM Priem WHERE YEAR(Priem.date_priema)= 2020 GROUP BY MONTH(Priem.date_priema), d) AS A GROUP BY A.MON) AS A,
    (SELECT COUNT(*) AS A, MONTH(Priem.date_priema) AS MON, Diagnos AS d FROM Priem WHERE YEAR(Priem.date_priema)= 2020 GROUP BY MONTH(Priem.date_priema), d) AS B JOIN Diagnoz AS D ON D.id = B.d WHERE B.A=A.m ORDER BY A.MON)) a ORDER BY a.Amon";

    
    $results = $mysqli->query($tquery);
    $keys = array_keys($results->fetch_assoc());

    print '<div class="MySQLTl">';
    print '<table class="MySQLT" border="1"';
    print '<caption>5. Сведения об диагнозаз, которые найболее часто ставятя в каждый месяц года</caption>';
    print '<tr>';
    foreach($keys as $key)
    {
        print '<td>'.$key.'</td>';
    }

    print '</tr>';
    $results->data_seek(0);

    while($row = $results->fetch_assoc()) 
        {
            print '<tr>';
            foreach($row as $key => $cell)
            {
                /*
                if ($key == "Пациент")
                {
                    $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                    
                }

            

                if ($key == "Диагноз")
                {
                    $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                    $cell = $respac->fetch_assoc();
                    $cell = ($cell['title']);
                    
                }
                */
                print '<td>'.$cell.'</td>';
            }
            print '</tr>';

        }
    print '</table>';
    print '</div>';



// 6. Количество различного лекарства, которое употребили все больные, зафиксированые в базе

$results = $mysqli->query("SELECT COUNT(*) AS 'Кол-во лекарств', L.id, L.title AS 'Название лекарства' FROM Lecarstvo AS L JOIN LecarstvoPriem AS LP ON LP.id_lec = L.id GROUP BY L.id;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl">';
print '<table class="MySQLT" border="1"';
print '<caption>6. Количество различного лекарства, которое употребили все больные, зафиксированые в базе</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr>';
        foreach($row as $key => $cell)
        {
            /*
            if ($key == "Пациент")
            {
                $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                
            }

        

            if ($key == "Диагноз")
            {
                $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }
            */
            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';



// 7. Количество больных, находящихся в каждой возрастной группе: от 1 до 6, от 7 до 17, от 18 до 25, от 25 до 45, от 45 и выше
$tquery = "
SELECT COUNT(DISTINCT A.age) AS 'от 1 до 6 лет', COUNT(DISTINCT B.age) AS 'от 7 до 17 лет', COUNT(DISTINCT C.age) AS 'от 18 до 25 лет', COUNT(DISTINCT D.age) AS 'от 25 до 45 лет', COUNT(DISTINCT E.age) AS 'от 45 и выше' FROM 
(SELECT (YEAR(CURRENT_DATE) - YEAR(Date)) -(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(Date, '%m%d')) AS age FROM Pacients GROUP BY age HAVING age >= 1 AND age <= 6) AS A,
(SELECT (YEAR(CURRENT_DATE) - YEAR(Date)) -(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(Date, '%m%d')) AS age FROM Pacients GROUP BY age HAVING age >= 7 AND age <= 17) AS B,
(SELECT (YEAR(CURRENT_DATE) - YEAR(Date)) -(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(Date, '%m%d')) AS age FROM Pacients GROUP BY age HAVING age >= 18 AND age <= 25) AS C,
(SELECT (YEAR(CURRENT_DATE) - YEAR(Date)) -(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(Date, '%m%d')) AS age FROM Pacients GROUP BY age HAVING age >= 26 AND age <= 45) AS D,
(SELECT (YEAR(CURRENT_DATE) - YEAR(Date)) -(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(Date, '%m%d')) AS age FROM Pacients GROUP BY age HAVING age >= 46) AS E
";
$results = $mysqli->query($tquery);

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl">';
print '<table class="MySQLT" border="1"';
print '<caption>7. Количество больных, находящихся в каждой возрастной группе: от 1 до 6, от 7 до 17, от 18 до 25, от 25 до 45, от 45 и выше</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr>';
        foreach($row as $key => $cell)
        {
            /*
            if ($key == "Пациент")
            {
                $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                
            }

        

            if ($key == "Диагноз")
            {
                $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }
            */
            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';








// 8. Количество различного лекарства, которое употребили все больные, зафиксированые в базе

$results = $mysqli->query("SELECT COUNT(*) AS 'Количество приемов', Priem.id_doctor, MONTH(Priem.date_priema) AS 'Месяц', D.Fname AS 'Фамилия', D.Name AS 'Имя', D.Mname AS 'Отчество' FROM Priem JOIN Doctors AS D ON D.id = Priem.id_doctor WHERE Priem.Predpicanie=1 GROUP BY MONTH(Priem.date_priema), Priem.id_doctor;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl">';
print '<table class="MySQLT" border="1"';
print '<caption>8. Сведения о том, как часто в течении какого-либо месяца какой-либо врач </caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr>';
        foreach($row as $key => $cell)
        {
            /*
            if ($key == "Пациент")
            {
                $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                
            }

        

            if ($key == "Диагноз")
            {
                $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }
            */
            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';




// 9. Список больных, обращавщихся к врачу более 2 раз в течение месяца

$results = $mysqli->query("SELECT COUNT(*) AS 'Количество обращений', Priem.id_pac AS 'ID пациента', Pac.Fname AS 'Фамилия', Pac.Name AS 'Имя', Pac.Mname AS 'Отчество', MONTH(Priem.date_priema) AS 'Месяц' FROM Priem JOIN Pacients AS Pac ON Priem.id_pac = Pac.id GROUP BY Priem.id_pac, MONTH(Priem.date_priema) HAVING COUNT(*) > 1;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl">';
print '<table class="MySQLT" border="1"';
print '<caption>9. Список больных, обращавщихся к врачу более 2 раз в течение месяца</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr>';
        foreach($row as $key => $cell)
        {
            /*
            if ($key == "Пациент")
            {
                $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                
            }

        

            if ($key == "Диагноз")
            {
                $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }
            */
            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';


// 10. Количество пациентов мужского и женского пола

$results = $mysqli->query("SELECT COUNT(*) AS 'Количество', Sex.title AS 'Название' FROM Pacients JOIN Sex ON Pacients.Sex= Sex.id GROUP BY Sex;");

$keys = array_keys($results->fetch_assoc());

print '<div class="MySQLTl">';
print '<table class="MySQLT" border="1"';
print '<caption>10. Количество пациентов мужского и женского пола</caption>';
print '<tr>';
foreach($keys as $key)
{
    print '<td>'.$key.'</td>';
}

print '</tr>';
$results->data_seek(0);

while($row = $results->fetch_assoc()) 
    {
        print '<tr>';
        foreach($row as $key => $cell)
        {
            /*
            if ($key == "Пациент")
            {
                $respac = $mysqli->query("SELECT id, Fname, Name, Mname FROM Pacients WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['Fname'].' '.$cell['Name'].' '.$cell['Mname']);
                
            }

        

            if ($key == "Диагноз")
            {
                $respac = $mysqli->query("SELECT id, title FROM Diagnoz WHERE id = $cell;");

                $cell = $respac->fetch_assoc();
                $cell = ($cell['title']);
                
            }
            */
            print '<td>'.$cell.'</td>';
        }
        print '</tr>';

    }
print '</table>';
print '</div>';

    $mysqli->close();
}


?>