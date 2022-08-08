
function ModForm(te)
{
    let modal = document.getElementById("dial");
    modal.style.display = "block";

    let tables = document.getElementsByClassName("active");
    for (let i = 0;i < tables.length;i++)
    {
        tables[i].className = tables[i].className.replace("active", "");
    }  
    
    te.className += " active";

    
};

function TRformActive(te)
{
    let tablesTR = document.getElementsByClassName("activeR");
    for (let i = 0;i < tablesTR.length;i++)
    {
        tablesTR[i].className = tablesTR[i].className.replace("activeR", "");
    }  

    te.className += " activeR";

}

function CloseModForm()
{
    document.getElementById('dial').style.display='none';

    let tables = document.getElementsByClassName("active");
    for (let i = 0;i < tables.length;i++)
    {
        tables[i].className = tables[i].className.replace("active", "");
    }  


    let tablesTR = document.getElementsByClassName("activeR");
    for (let i = 0;i < tablesTR.length;i++)
    {
        tablesTR[i].className = tablesTR[i].className.replace("activeR", "");
    }
}


function CreateForm(te)
{
    
    let t = document.getElementsByClassName('active');
    let nt = t[0].firstChild.nodeValue;
    let table = t[0].getElementsByTagName("table")[0];
    
    
    

    let r = new XMLHttpRequest;
    let body = "table=" + nt + "&action=" + te + "&tn=" + table.getAttribute("id");

    for (let cell of table.rows[0].cells)
    {
        body += "&title[]=" + cell.textContent;
    }

    

    if (document.getElementsByClassName('activeR')[0] == undefined)
    {
        alert("Отметье строку в таблице");
        return;
    }else body += "&id=" + document.getElementsByClassName('activeR')[0].cells[0].textContent;


    

    r.open("GET", "http://p96357hm.beget.tech/Form.html?"+body);
    r.send();

    CloseModForm();

    

    /*
    document.getElementById('envelope').style.display='block';
    document.getElementById('fade').style.display='block';
    */

    document.location.href = "http://p96357hm.beget.tech/Form.html?"+body;
}

function DopReqvest(te)
{

    let req = new XMLHttpRequest;
    let body = "body=";
    if (te == "Удалите из базы данных пациентов ни разу не обращавщихся за помощью к врачам.")
    {
        body += "1";
    }

    if (te == "Изменилась классификация диагнозов заболеваний.")
    {
        body += "2";
    }


    req.open("GET", 'http://lab3.ru/DopReqvest.php?' + body, true);
    req.send(body);

    document.location.href = 'http://p96357hm.beget.tech/DopReqvest.php?' + body;

}