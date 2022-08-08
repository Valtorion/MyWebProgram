<html lang="ru">

<head>
<meta charset="utf-8">
<title>WI-FI СЧЕТЧИК ЭЛЕКТРОЭНЕРГИИ С ФУНКЦИЕЙ ЗАЩИТЫ И УПРАВЛЕНИЯ</title>
<link rel="stylesheet" href="./css/indcss.css">
<link rel="stylesheet" href="./css/tehstyle.css">
<link rel="stylesheet" href="./css/imgscale.css">
<link rel="shortcut icon" href="favicon.ico">
<script src="./JS/bigimage.js"></script>
<script src="./JS/dotnubr.js"></script>
</head>


<body>

<header><div id="outh"><img src="./Sorce/logo.png" width ="60" height ="60"><div id="title">WI-FI СЧЕТЧИК ЭЛЕКТРОЭНЕРГИИ С ФУНКЦИЕЙ ЗАЩИТЫ И УПРАВЛЕНИЯ</div></div></header>

<nav>
<ul id="nav">
    <li><a href="index.php">Главная |</a></li>
<li><a href="index.php?page=23">Тех. документация |</a></li>
<li><a href="index.php?page=2">Работа с датчиком |</a></li>
</ul>
</nav>


<article>

    <?php

        if (isset($_GET["page"]))
        {
            switch ($_GET["page"])
            {
                case 2:include("./Pages/indDat.php");break;
                case 3:include("./Pages/teh1.php");break;
                case 4:include("./Pages/teh2.php");break;
                case 5:include("./Pages/teh3.php");break;
                case 6:include("./Pages/teh4.php");break;
                case 7:include("./Pages/teh5.php");break;
                case 8:include("./Pages/teh6.php");break;
                case 9:include("./Pages/teh7.php");break;
                case 10:include("./Pages/teh8.php");break;
                case 11:include("./Pages/teh9.php");break;
                case 12:include("./Pages/teh10.php");break;
                case 13:include("./Pages/teh11.php");break;
                case 14:include("./Pages/teh12.php");break;
                case 15:include("./Pages/teh13.php");break;
                case 16:include("./Pages/teh14.php");break;
                case 17:include("./Pages/teh15.php");break;
                case 18:include("./Pages/teh16.php");break;
                case 19:include("./Pages/teh17.php");break;
                case 20:include("./Pages/teh18.php");break;
                case 21:include("./Pages/teh19.php");break;
                case 22:include("./Pages/teh20.php");break;
                case 23:include("./Pages/ved.php");break;

                default:include("./Pages/ind1.php");break;
            }
        }else include("./Pages/ind1.php");

    ?>
</article>
    
<footer>
Сделал студент группы ПС-81 Томаровский А. А.
<img src="/cnt/counter.php?cat=electroshet&amp;color=2&amp;id=c4a85f0ed446fb37314756804276fe37" alt="IT Counter" />
</footer>
<div id="overlay" onclick="DonwImg();"></div><div id="magnify" onclick="DonwImg();"><img src=""><div id="close-popup"><i></i></div></div>

</body>
</html>