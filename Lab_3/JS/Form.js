
    var FacP = document.getElementById('Fac');
    var SpecP = document.getElementById("Spec");
    var GroupP = document.getElementById("Group");
    SpecP.options[0].selected = true;
    GroupP.options[0].selected = true;

    let xhr = new XMLHttpRequest();
    

    var Facs = [];
    var Specs = [];
    var Groups = [];
    
    var result;
    var already = false;
    var Acces = false;
    var AnswCheck = false;
    var AccesCheck = false;

    /*
    var ws = new WebSocket("ws://localhost:1337");
    
    var wsSend = function(data) {
        if(!ws.readyState){
            setTimeout(function (){
                wsSend(data);
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

    SendXML(JSON.stringify(["GetForm", "Факультет", ""]));

    function IsJsonString(str) 
    {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    
    xhr.onreadystatechange = function () 
    {
    
        if (xhr.readyState === 4 && xhr.status === 200) {

            result = JSON.parse(xhr.response);


            if (result[0] == "CheckAcces")
            {
                if (result[1] == "Acces")
                {
                    Acces = true;
                    AccesCheck = true;
                }else
                {
                    Acces = false;
                    AccesCheck = true;
                }

                result.splice(0,2);

                if (result[0] == "login") 
                {
                    delete result[0];
                    login(result);
                    return;    
                }

                if (result[0] == "AStudent") 
                {
                    delete result[0];
                    AddStudent(result); 
                    return;   
                }


            }
            

            if (result[0] == "FormAcces")
            {
                document.location.href = "result.html";
            }
        
        
            
    
            
            if (result[0] == "GetForm") 
            {
                delete result[0];
                GetForm(result[1], result); 
                return;   
            }
        }
    }

    xhr.onerror = function() 
    {
        alert("Запрос не удался");
    };

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


    }
    

    function GetDataForm() 
    {
        var UniValue = {};

        var ind = FacP.options.selectedIndex;
        UniValue["Fac"] = FacP.options[ind].value;

        ind = SpecP.options.selectedIndex;
        UniValue["Spec"] = SpecP.options[ind].value;

        ind = GroupP.options.selectedIndex;
        UniValue["Groop"] = GroupP.options[ind].value;

        UniValue["Fname"] = document.getElementById("fname").value;
        UniValue["Name"] = document.getElementById("name").value;

        return UniValue;
    }

    

    function login(UniValue)
    {
        if (Acces == true) 
        {
            
            UniValue[0] = "AccesForm";
            SendXML(JSON.stringify(UniValue));

        }else alert("Такого студента нет.");
        Acces = false;
        AccesCheck = false;

    }

    function AddStudent(UniValue) 
    {

        if (Acces == true) 
        {
            alert("Такой студент уже есть.");
            Acces = false;
            AccesCheck = false;
               
        }else{

            if (UniValue[1] == 0 || UniValue[2] == 0 || UniValue[3] == 0)
            {
                alert("Выбранны неверные параметры");
                return;
            }

            UniValue[0] = "AddStudent";

            SendXML(JSON.stringify(UniValue));

            alert("Студент успешно добавлен");
            
        }

    }


    function UniFunc(str)
    {
        
        var UniValue = GetDataForm();

        UniValue[0] = "CheckForm";
        UniValue[1] = str;
        SendXML(JSON.stringify(UniValue));  // Отправление запроса на прверку введённых данных

    }



