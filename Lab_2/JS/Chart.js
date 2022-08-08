function init(){ //функция начальной инициализации графикаmissing semicolon js что это
	var ctx= document.getElementById('myChart').getContext('2d');
	chart = new Chart ( ctx, { 
		type:"line",
		data:{
			datasets:[{
				label:"Мощность", 
				fill:false, 
				radius:3, 
				borderColor:'rgb(255, 0, 0)',
				backgroundColor:'rgb(200, 200, 200)', 
				lineTension:0.0,
				pointStyle: 'rect', 
				hoverBorderWidth:10
			}]                                   
		}, // Configuration options go here
		options: { 
			scales: { 
				xAxes: [{ 
					ticks: { 
						  // maxTicksLimit:10,
						  // maxRotation:90,
						  // minRotation:90   
					}
				}]
			},
			animation: {
				duration: 0 // general animation time  
			}, 
			hover: {
				animationDuration: 0// duration of animations when hovering an item
			},
			responsiveAnimationDuration: 0// animation duration after a resize  
		}
	}); 
    for (let i = 0; i < document.getElementsByClassName('but1').length;i++)
				{
					document.getElementsByClassName('but1')[i].setAttribute("disabled", "disabled");
				}
}


	

function AlllData()
{

	chart.destroy();
	init();


	let param = document.getElementById("param").options[document.getElementById("param").selectedIndex].value;
	let body = "param=" + param;

    chart.data.datasets[0].label = document.getElementById("param").options[document.getElementById("param").selectedIndex].innerHTML;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", './PHP/getData.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	xhr.send(body);

	let ans;
	let obj;
	xhr.onreadystatechange = function() { // Ждём ответа от сервера
		if (xhr.readyState == 4 && xhr.status == 200) { // Ответ пришёл
		  
			ans = xhr.responseText;

			if (ans == "Нет данных")
			{
				alert("Нет данных");
				for (let i = 0; i < document.getElementsByClassName('but1').length;i++)
				{
					document.getElementsByClassName('but1')[i].setAttribute("disabled", "disabled");
				}
				return;
			}
			
			obj = JSON.parse(ans);
			console.log(ans); // Выводим ответ сервера

			for(let i in obj)  { 
				chart.data.labels.push( obj[i]["datazamer"] );
				chart.data.datasets[0].data.push(  obj[i]["znachenie"] ) ; 
				
			}

			chart.update();

			for (let i = 0; i < document.getElementsByClassName('but1').length;i++)
			{
				document.getElementsByClassName('but1')[i].removeAttribute("disabled");
			}
			1
		  
		}
	  };	   
	  
	
}


function DataAdd()
	  {
		document.getElementById('envelope').style.display='block';
		document.getElementById('fade').style.display='block';

		
	  }


function CreateData()
{
	let form = document.getElementById("form1");

	let bdate = new Date(document.getElementById("bdata").value);
	let edate = new Date(document.getElementById("edata").value);
	let param = document.getElementById("param1").options[document.getElementById("param1").selectedIndex].value;

	
	let dur = edate.getDate() - bdate.getDate();

	if (dur <= 0)
	{
		alert("Не верный диапозон времени");
		return;
	}

	if (dur > 10)
	{
		alert("Слишком большой диапозон. Диапозон не должен превышать 10 дней");
		return;
	}

	
	sensor.generate_array(dur,25,7);
	
	myjson=JSON.stringify(sensor);
	
	recovered_sensor=JSON.parse(myjson); 


	let timer = bdate;
	let body = "param=" + encodeURIComponent(param);

	for(let i = 0;i < 10;i++)  { 

		body = body + "&lables[]=" + encodeURIComponent(timer.getFullYear() + "-" + timer.getMonth() + "-" + timer.getDate());
		body = body + "&Ddata[]=" + encodeURIComponent(recovered_sensor.data[i][1]);
		
		timer.setDate(timer.getDate() + 1);
		
	}


	var xhr = new XMLHttpRequest();
	xhr.open("POST", './PHP/sendBD.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	xhr.send(body);
	
	
	xhr.onreadystatechange = function() { // Ждём ответа от сервера
		if (xhr.readyState == 4 && xhr.status == 200) { // Ответ пришёл
		  
			ans = xhr.responseText;
			alert(ans);
			
		  
		}
	  };

}




function DelData()
{
	let a = confirm("Вы действительно хотите удалить данные ?");
	let param = document.getElementById("param").options[document.getElementById("param").selectedIndex].value;
	let body = "param="+param;
	


	if (a == true)
	{
		var xhr = new XMLHttpRequest();
		xhr.open("POST", './PHP/delData.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send(body);

		xhr.onreadystatechange = function() { // Ждём ответа от сервера
			if (xhr.readyState == 4 && xhr.status == 200) { // Ответ пришёл
			  
				ans = xhr.responseText;
				alert(ans);
			  
			}
		  };
	}
}


function ARGfunc(but)
{
	let param = document.getElementById("param").options[document.getElementById("param").selectedIndex].value;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", './PHP/agrfunc.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	let body = "param=" + param + "&d=";

	if (but.value == "Максимальное значение")
	{
		body += '1'; 
	}

	if (but.value == "Минимальное значение")
	{
		body += '2'; 
	}

	if (but.value == "Среднее значение")
	{
		body += '3'; 
	}

	xhr.send(body);

	xhr.onreadystatechange = function() { // Ждём ответа от сервера
		if (xhr.readyState == 4 && xhr.status == 200) { // Ответ пришёл
		  
			ans = xhr.responseText;
			console.log(ans);
			alert(ans);
		  
		}
	  };

}

sensor= { 
	name: "DHT22",
	object_id: 30,
	parameter:"Temperature",
	data: [],
	normal_rnd(mean,sigma)    {  
		return mean+sigma*Math.cos(2*Math.PI*Math.random())*Math.sqrt( -2*Math.log( Math.random() ) );
	},
	generate_array(quantity,mean,sigma)    { 
		for (let i=0; i<quantity; i++)  this.data[i] = []; 
		for (let i=0; i<quantity; i++){ 
			this.data[i][0]=i+1; 
			this.data[i][1]=this.normal_rnd(mean,sigma); 
		}
	}


	
}; 

//генерируем массив случайных чисел

sensor.generate_array(40,25,7);
 
//преобразуем в формат json
 
myjson=JSON.stringify(sensor);
 
//восстанавливаем из формата json
 
recovered_sensor=JSON.parse(myjson); 
//инициализируем график
 
init(); 
 
// разбираем данные

 
 


 
 
 
 
 
 