<script src="./JS/bigimage.js"></script>
<script src="./JS/Chart.min.js"></script>
<h1>График потребляемой мощности</h1>

<div id="envelope" class="envelope">
        <h1>Добавить данные в базу данных</h1>
        
		<form id="form2">
            <select id="param1">
                <option selected value="1">Мошьность</option>
                <option selected value="2">Сила тока</option>
                <option selected value="3">Напряжение</option>
            </select>
            <label>Начало<input type="date" id="bdata"></label>
            <label>Конец<input type="date" id="edata"></label>

            <input type="button" class="but" value="Добавить данные" onclick="CreateData();">
            <input type="button" class="but" value="Назад" onclick="document.getElementById('envelope').style.display='none';document.getElementById('fade').style.display='none'">
                
        </form>
	    </div>
       <div id="fade" class="black-overlay"></div>


  
	<form id="form1">

    <h3>Основные функции</h3>
    <div>
      <select id="param">
          <option selected value="1">Мощность</option>
          <option value="2">Сила тока</option>
          <option value="3">Напряжение</option>
      </select>
      <input type="button" class="but" value="Показать данные" onclick="AlllData();">
      <input type="button" class="but" value="Добавить данные" onclick="DataAdd();">
      <input type="button" class="but" value="Удалить все данные" onclick="DelData();">
    </div>


        <label id="but11">Дополнительные функции</label>
      <div id="but1">
      <input type="button" disabled class="but1" id="Max" value="Максимальное значение" onclick="ARGfunc(this);">
      <input type="button" disabled class="but1" id="Min" value="Минимальное значение" onclick="ARGfunc(this);">
      <input type="button" disabled class="but1" id="avg" value="Среднее значение" onclick="ARGfunc(this);">
      </div>

    </form>


    

<canvas id="myChart"></canvas><script src="./JS/Chart.js"></script>