 <style>
 
label{
 
display:block;color: #339900;
 font-size:1em;
 margin-bottom:0.4em;
 }
 
 
 input, select, textarea{
 border:1px solid #cccccc;
 margin-bottom:0.8em;
  width:98%;
 }
 form, legend,fieldset{
 border:none;
  max-width:100%;
 
 
 }
 
 
 div.submit_div{
 width:100%;
 text-align:center;
 }
 
 .submit_btn{
 height:3em;
 padding:1em;
 color:white;
 background-color:#339900;
 border:none;
 width:auto;
 }
 
 
 </style>
 
 <fieldset>
   <table><tr><td>
  <form action="/wap/" method="get" class="form">
  <input type="hidden" value="search" name="mode">
      <input type="hidden" name="dosearch" id="dosearch" value="1">
	  <label>Рубрика</label>

	  <select name="nobject" id="object_objecttype_id">
        <option value="1">Квартиры</option>
        <option value="2">Комнаты</option>
        <option value="3">Дома</option>
        <option value="4">Нежилые помещения</option>

      </select><br>

      <label>Я хочу</label>

      <select name="type" id="object_deal_id">
	    <option value="1">Снять</option> <!--Сдаю  -->
		<option value="2">Сдать</option> <!--  сниму -->
		<option value="3">Взять на подселение</option> <!-- подселюсь  -->
		<option value="4">Подселиться</option> <!-- возьму на  -->
		<option value="5">Купить</option> <!-- продам -->
		<option value="6">Продать</option> <!-- куплю -->
		 <option value="7">Снять на сутки</option> <!--Сдаю  -->
      </select>
      <br>
	  
      <label>по адресу:</label>
      <select name="city" id="object_region_id">
		<option value="1">Минск</option>
		<option value="2">Брест</option>
		<option value="3">Витебск</option>
        <option value="4">Гомель</option>
        <option value="5" >Гродно</option>
        <option value="6">Могилев</option>
        <option value="7">Новополоцк</option>
      </select>
      
      <br>
      <label>с характеристиками:</label>
   
Цена от: &nbsp;
<input id="object_p_from2" value="" onkeyup="this.value=regular(this.value);" size="5" name="priceMin">
      
до:&nbsp;
      <input id="object_p_to2" value="" onkeyup="this.value=regular(this.value);" size="5" name="priceMax">
      <select id="object[currency_id]" name="object[currency_id]">
	    <option value="4">Долларов</option>
        
      </select>
      <br>
	  
	  
	    <label>Сортировать по:</label>
      <select name="sort" id="object_region_id">
		<option value="1">новизне</option>
		<option value="2">цене (сначала дешевые)</option>
		<option value="3">цене (сначала дорогие)</option>
 
      </select>
	  
	  <br>
	  
	  
	  
	  
	  
	  <div class='submit_div'>
      <input type="submit" class='submit_btn' value="Найти объекты" name="commit">
	  </div>
	  
	  
	  
    </form>
</td></tr></table>
</fieldset>

 