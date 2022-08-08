function Dots(numdot)
{
    var DotsDiv = document.createElement("div");
    let ButerDiv = document.createElement("div");
    ButerDiv.setAttribute("id", "WrapperBut");
    DotsDiv.setAttribute("id", "dots");
    document.getElementsByTagName("article")[0].appendChild(ButerDiv);
    document.getElementById("WrapperBut").appendChild(DotsDiv);
    var sp;
    for (var i = 0; i < 20; i++) 
    {
        var arg;
        arg = i; 
        sp = document.createElement("span");
        sp.setAttribute("class", "dot");
        sp.innerHTML = '<a href="index.php?page=' + (i + 3)+'">'+(i + 1)+'</a>';
        DotsDiv.appendChild(sp);
    }


    
    var dots = document.getElementsByClassName("dot");
    for (var i = 0;i < dots.length;i++) 
    {
        if (i == (numdot - 1)) 
        {
            dots[i].className += " active";
        }else {dots[i].className = dots[i].className.replace("active","");}
        
    }
    

    var ButDiv = document.createElement("div");
    ButDiv.setAttribute("id", "ButDiv");
    document.getElementById("WrapperBut").appendChild(ButDiv);
    ButDiv.innerHTML = '<input class="but" type="button" value="Предыдущий" onClick="StepBut(0)"><input class="but" type="button" value="Вернутся к началу" onClick="document.location.href = ' + '\'index.php?page=23\'' +'"> <input class="but" type="button" value="Следующий" onClick="StepBut(1)">';
    
}


function StepBut(b)
{
    let actDot = document.getElementsByClassName("active")[0];
    let st = actDot.firstChild.getAttribute("href").replace("index.php?page=", "");

    if (st > 2 && st < 23)
    {
        if (b == 1)
        {
            st++;
        }else st--;
    }else return;

    document.location.href = "index.php?page=" + st;
}