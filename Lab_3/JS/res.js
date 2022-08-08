var nowData = new Date();
var dz_id;
var Groop_id;


var xhr = new XMLHttpRequest();
xhr.open("POST", "./PHP/server.php");


var FacP = document.getElementById('Fac'),
    SpecP = document.getElementById("Spec"),
    GroupP = document.getElementById("Group"),
    ObjP = document.getElementById("Obj");

    SpecP.options[0].selected = true;
    GroupP.options[0].selected = true;
    

    var Facs = [],
        Specs = [],
        Groups = [],
        Objs = [];


PreLoader();

SwitchElem();

/*
var SendXML = function(data) {
    if(!ws.readyState){
        setTimeout(function (){
            SendXML(data);
        },100);
    }else{
        SendXML(data);
    }
};
*/

function SendXML($dataS)
{
        xhr.open("POST", "./PHP/server.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send($dataS);
}


function IsJsonString(str) 
{
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


    SendXML(JSON.stringify(["Groop_id"]));


    xhr.onreadystatechange = function () 
    {
    
        if (xhr.readyState === 4 && xhr.status === 200) 
        {
            result = JSON.parse(xhr.response);


            if (result[0] == "Acces")
            {
                Acces = true;
                AccesCheck = true;
            }

            if (result[0] == "Deny")
            {
                Acces = false;
                AccesCheck = true;
            }

            
            if (result[0] == "CreateTable") 
            {
                delete result[0];
                CreateTable(result);
                return;
            }

            if (result[0] == "GetForm") 
            {
                delete result[0];
                GetForm(result[1], result); 
                return;   
            }

            if (result[0] == "AddDZ") 
            {
                AddDZ(result); 
                return;   
            }

            if (result[0] == "ChancheDZ") 
            {
                ChancheDZ(result); 
                return;   
            }

            if (result[0] == "GetObj") 
            {
                SwitchElem(result);
            }

            if (result[0] == "SearchDZ") 
            {
                SearchDZ(result);
            }

            if (result[0] == "DeleteDZ") 
            {
                DeleteDZ(result);
            }

            if (result[0] == "Groop_id")
            {
                Groop_id = result[1];
                CreateTable("");
            }
        }

            
}

xhr.onerror = function() 
{
    alert("Запрос не удался");
};



function CreateTable(result)
{
    var days = ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Cуббота"];
    var month = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

    
    if (result == "") 
    {
        var strT = [];
        strT.push("CreateTable");
        strT.push(nowData.getDate() + "/" + (nowData.getMonth()+1) + "/" + nowData.getFullYear());
        strT.push(Groop_id);
        
        SendXML(JSON.stringify(strT));
    }else
    {
        var table1 = document.getElementById("tb1");
        var table2 = document.getElementById("tb2");
        var varTable = table1;

        table1.innerHTML = "";
        table2.innerHTML = "";


        for (let i = 1; i <= 12; i++) 
        {
            
            var tb1 = document.createElement("table");
            var etr = document.createElement("tr");
            var eth = document.createElement("tr")

            varTable.appendChild(tb1);
            tb1.appendChild(eth);
            tb1.appendChild(etr);

            var dateT = new Date(result[i][0]);

            var strH = "<th colspan='2'>" + days[dateT.getDay()] + " " + "<span id='data'>"+ dateT.getDate() + " " + month[dateT.getMonth()] + " " + dateT.getFullYear() +"</span></th>";

            eth.innerHTML = strH;

            
                
                var etd1 = document.createElement("td");
                var etd2 = document.createElement("td");

                if (result[i][1] == "") 
                {
                    etr.appendChild(etd1);
                    etd1.innerHTML = "<textarea class='dz' disabled='disabled' name='dz'>" + "Нет задания" + "</textarea>";
                }else
                {

                    for (let j = 0; j < result[i][1].length; j++) 
                    {
                        etr = document.createElement("tr");
                        etd1 = document.createElement("td");
                        etd2 = document.createElement("td");

                        tb1.appendChild(etr);
                        
                        etr.appendChild(etd1);
                        etd1.innerHTML = result[i][1][j]["obj"];

                        etr.appendChild(etd2);
                        etd2.innerHTML = "<textarea id='" + result[i][1][j]["dz_id"] + "'class='dz' name='dz' onclick=\"GetDZid(" + result[i][1][j]["dz_id"] + ")\">" + result[i][1][j]["dz"] + "</textarea>";
                        
                    }
                    
                }

                

                if (i == 6) 
                {
                    varTable = table2;    
                }
            
        }


    }

}





function GetForm(point, result) 
    {   
        var NewFP;


        if (point == "Факультет") 
        {
            delete result[1];
            Facs = result;

            FacP.innerHTML = "";

            NewFP = document.createElement("option");
            FacP.appendChild(NewFP);

            NewFP.innerHTML = "Выберите факультет";
            

            for (let i = 2; i < Facs.length; i+= 2) 
            {
                NewFP = document.createElement("option");
                FacP.appendChild(NewFP);
                NewFP.setAttribute("value", Facs[i + 1]);

                NewFP.innerHTML = Facs[i]; 
                
            }
        }



        if (point == "Специальность" && result != "") 
        {
            delete result[1];
            Specs = result;

            SpecP.innerHTML = "";

            NewFP = document.createElement("option");
            SpecP.appendChild(NewFP);

            NewFP.innerHTML = "Выберите cпециальность";

            for (let i = 2; i < Specs.length; i+= 2)
            {
                NewFP = document.createElement("option");
                SpecP.appendChild(NewFP);
                NewFP.setAttribute("value", Specs[i + 1]);

                NewFP.innerHTML = Specs[i]; 
            }
        }else
        {
            if (point == "Специальность" && result == "") 
            {
                var ind = FacP.options.selectedIndex;

                if (ind != 0)
                {
                    SendXML(JSON.stringify(["GetForm", "Специальность", FacP.options[ind].text]));
                }
                
            } 
        }





        if (point == "Группа" && result != "") 
        {
            delete result[1];
            Groups = result;

            GroupP.innerHTML = "";

            NewFP = document.createElement("option");
            GroupP.appendChild(NewFP);

            NewFP.innerHTML = "Выберите группу";

            for (let i = 2; i < Groups.length; i+= 2)
            {
                NewFP = document.createElement("option");
                GroupP.appendChild(NewFP);
                NewFP.setAttribute("value", Groups[i + 1]);

                NewFP.innerHTML = Groups[i]; 
            }

        }else
        {
            if (point == "Группа" && result == "") 
            {
                var ind = SpecP.options.selectedIndex;

                if (ind != 0)
                {
                    SendXML(JSON.stringify(["GetForm", "Группа", SpecP.options[ind].text]));
                }
            }
        }



        if (point == "Предмет" && result != "") 
        {
            delete result[1];
            Objs = result;

            ObjP.innerHTML = "";

            NewFP = document.createElement("option");
            ObjP.appendChild(NewFP);

            NewFP.innerHTML = "Выберите предмет";

            for (let i = 2; i < Objs.length; i+= 2)
            {
                NewFP = document.createElement("option");
                ObjP.appendChild(NewFP);
                NewFP.setAttribute("value", Objs[i + 1]);

                NewFP.innerHTML = Objs[i]; 
            }

        }else
        {
            if (point == "Предмет" && result == "") 
            {
                var ind = GroupP.options.selectedIndex;

                if (ind != 0)
                {
                    SendXML(JSON.stringify(["GetForm", "Предмет", GroupP.options[ind].value]));
                }
            }
        }
        

    }
    



    function GetDataForm() 
    {
        var UniValue = {};
        var form = document.getElementById("form1");
        var check = true;

        var ind = FacP.options.selectedIndex;
        UniValue["Fac"] = FacP.options[ind].value;
        if (FacP.options[ind].text == "Выберите факультет") 
        {
            check = false;
        }

        ind = SpecP.options.selectedIndex;
        UniValue["Spec"] = SpecP.options[ind].value;
        if (SpecP.options[ind].text == "Выберите cпециальность") 
        {
            check = false;
        }

        ind = GroupP.options.selectedIndex;
        UniValue["Groop"] = GroupP.options[ind].value;
        if (GroupP.options[ind].text == "Выберите группу") 
        {
            check = false;
        }

        ind = ObjP.options.selectedIndex;
        UniValue["Obj"] = ObjP.options[ind].text;
        if (ObjP.options[ind].text == "Выберите предмет") 
        {
            check = false;
        }

        let date = new Date(form.date.value);
        UniValue["date"] = date.getFullYear() + "/" + (date.getMonth() + 1) + "/" + date.getDate();
        if (form.date.value == null) 
        {
            check = false;
        }

        UniValue["DZtext"] = form.DZtext.value;
        if (form.DZtext.value == "") 
        {
            check = false;
        }

        if (check == true) 
        {

            return UniValue;

        }else return false;
        
    }


function ChancheBut() 
{
    if (dz_id == null) 
    {
        alert("Выберите запись"); 
        return;   
    }

    var title = document.getElementById("titleF1");
    var sendB = document.getElementById("send-message");
    var points = document.getElementById("points");
    var textA = document.getElementById(dz_id).value;
    var DZtext = document.getElementById("DZtext");

    title.innerHTML = "Изменить домашнее задание ";
    sendB.setAttribute("onclick", "ChancheDZ()");
    DZtext.innerHTML = textA;
    points.remove();


    ShowForm();
}


function ChancheDZ(result) 
{
    if (result !== undefined) 
    {
    
        if (result[1] == true) 
        {
            alert("Домашнее задание изменено");
            document.getElementById('envelope').style.display='none';
            document.getElementById('fade').style.display='none';
            PreLoader();
            CreateTable("");
            return;    
        }
    }
    
    var UniValue = [];

    UniValue[0] = "ChancheDZ";
    UniValue.push(document.getElementById("DZtext").value);
    UniValue.push(dz_id);


    SendXML(JSON.stringify(UniValue));
    return;
}

function AddDZ(result) 
{
    if (result !== undefined) 
    {
        if (result[1] == false) 
        {
            alert("Такое задание уже есть");
            document.getElementById('envelope').style.display='none';
            document.getElementById('fade').style.display='none';
            PreLoader();

            CreateTable("");
            return;
        }

        if (result[1] == true) 
        {
            alert("Домашнее задание добавлено");
            document.getElementById('envelope').style.display='none';
            document.getElementById('fade').style.display='none';
            PreLoader();
            CreateTable("");
            return;    
        }
    }
    
    
    var UniValue = GetDataForm();
    
    if (UniValue == false)
    {
        alert("Не верный ввод данных." + "\n" + "Попробуйте ещё раз.");
        return;
    }

    UniValue[0] = "AddDZ";


    SendXML(JSON.stringify(UniValue));
    return;
}

function DeleteDZ(result) 
{
    if (result !== undefined)
    {
        if (result[1] == true) 
        {
            alert("Удаление произошло успешно");
            PreLoader();
            SendXML(JSON.stringify(["CreateTable"]));
            return;    
        }
    }    
    var arrDel = ["DeleteDZ"];

    if (dz_id == null) 
    {
        alert("Выберите запись");
        return;    
    }

    arrDel.push(dz_id);

    SendXML(JSON.stringify(arrDel));
    
}


function ShowForm()
{
    document.getElementById('envelope').style.display='block';
    document.getElementById('fade').style.display='block';

    SendXML(JSON.stringify(["GetForm", "Факультет", ""]));
}


function SwitchElem(result)
{
    
    var choise = document.getElementById("opt");
    var inE = document.getElementById("in");

    if (result != undefined) 
    {
        if (result[0] == "GetObj") 
        {
    
            for (let i = 1; i < result.length; i++) 
            {
                var NewFP = document.createElement("option");
             
                inE.appendChild(NewFP);
                NewFP.innerHTML = result[i]; 
                
            }
    
            return; 
        } 
    }
    

    if (choise.options[choise.selectedIndex].text == "По предмету") 
    {
        inE.remove();

        var inE = document.createElement("select");

        choise.before(inE);
        inE.setAttribute("id", "in");

        SendXML(JSON.stringify(["Obj"]));
    }else
    {
        inE.remove();

        var inE = document.createElement("input");

        choise.before(inE);
        inE.setAttribute("id", "in");
        inE.setAttribute("type", "date");
        
    }

}


function SearchDZ(result) 
{
    if (result != undefined) 
    {
        if (result[1] == false) 
        {
            alert("Ничего не найдено");
            return;
        }

        nowData = new Date(result[1]);
        PreLoader();
        CreateTable("");
        return;
        
    }
    var inE = document.getElementById("in");
    var choise = document.getElementById("opt");
    
    if (choise.options[choise.selectedIndex].text == "По предмету")
    {
        var arrRes = ["SearchDZ"];
        arrRes.push(inE.options[inE.selectedIndex].text);

        SendXML(JSON.stringify(arrRes));

    }else
    {
        
        if (inE.value == "") 
        {
            alert("Выберите дату!");
            return;    
        }

        nowData = new Date(inE.value);
        PreLoader();
        CreateTable("");
    }
}



function GetDZid(id)
{
    var choisen = document.getElementById(id);
    var prevCh = document.getElementById(dz_id);

    

    if (dz_id == null) 
    {
        choisen.className += " active";
        dz_id = id;
        return;
    }
    
    prevCh.className = prevCh.className.replace("active", "");
    choisen.className += " active";

    dz_id = id;
}


function Prev()
{
    nowData.setDate(nowData.getDate() - 7);
    PreLoader();
    CreateTable("");
    dz_id = null;
    
}

function Next()
{
    nowData.setDate(nowData.getDate() + 7);
    CreateTable("");
    PreLoader();
    dz_id = null;
}