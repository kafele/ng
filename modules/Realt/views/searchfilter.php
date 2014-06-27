<h2>Уточнить поиск</h2>

<form action="/board/" method="get"   id="newbuilding-form">
	
<input type=hidden  name="mode" value="search">
<input type=hidden value="kv" name="formtype">
<input type=hidden value="search" name="mode">
<input type=hidden name="city"  value="<?=$cityid?>">

 <span style="label">Объект:<span>
<select class ="hidselect" name="prtype">
<option value="arenda" <? if ($prtype=='arenda'&&$formtype=="kv"){?> selected <? }?>>Квартира</option>
<option value="snimu" <? if ($prtype=='snimu'&&$formtype=="kv"){?> selected <? }?>>Комната</option>
<option value="prodam" <? if ($prtype=='prodam'&&$formtype=="kv"){?> selected <? }?>>Дом</option>
<option value="kuplu" <? if ($prtype=='kuplu'&&$formtype=="kv"){?> selected <? }?>>Куплю</option>
</select>
 
<span style="label">Тип предложения:<span>
<select class ="hidselect" name="prtype">
<option value="arenda" <? if ($prtype=='arenda'&&$formtype=="kv"){?> selected <? }?>>Сдаю</option>
<option value="snimu" <? if ($prtype=='snimu'&&$formtype=="kv"){?> selected <? }?>>Сниму </option>
<option value="prodam" <? if ($prtype=='prodam'&&$formtype=="kv"){?> selected <? }?>>Продам</option>
<option value="kuplu" <? if ($prtype=='kuplu'&&$formtype=="kv"){?> selected <? }?>>Куплю</option>
</select>
 

<div style="margin-top:0px; float:left;">
<span>Комнат: </span>
<input type="checkbox" name="k1"  <? if ($k1!=0||$formtype!="kv"){?> checked="checked"<? }?>  class="kom"/><span> <noindex>1&nbsp;</noindex> </span> 
<input type="checkbox" name="k2" <? if ($k2!=0||$formtype!="kv"){?>checked="checked"<? }?>  class="kom"/><span > <noindex>2&nbsp;</noindex> </span> 
<input type="checkbox" name="k3"  <? if ($k3!=0||$formtype!="kv"){?>checked="checked"<? }?>  class="kom"/><span > <noindex>3&nbsp;</noindex>  </span> 
<input type="checkbox" name="k4"  <? if ($k4!=0||$formtype!="kv"){?>checked="checked"<? }?> class="kom"/><span > <noindex>4+</noindex> </span> 
</div>	 

 
 
<div style="margin-top:2px;">
	<span  >Цена</span>
    <input type="text" class="input_price" name="priceMin" value='<? if ($formtype=="kv"){?><?=$priceMin?><? }?>' /> &ndash; 
    <input type="text" class="input_price"name="priceMax" value='<? if ($formtype=="kv"){?><?=$priceMax?><? }?>' />
    <span class="price-text">$</span>
</div>	  
	 

    
	
	
	
	
	

    
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	
	
	
	

	

	<div id="choosedArea_nb_l">
	<span>Район </span><span id="chooseArea"><a onclick="return area_up()" href="#">выбрать</a></span> 
	<br>
	</div>
	<div id="choosedArea_nb_w">
	<textarea id="choosedArea_nb"  onclick="return area_up()"  readonly style="height:100%"></textarea>
	</div>
	

	
	
<style>

</style>

 

	

	
	
	
	
   
     
	 
	 
	 
	 
	 
	 <style>

	</style>
	
	

	 
	
	 
	 <div id="kv_withcontent_l">
	  <span>Содержит текст: </span><br>
	  </div>
	  
	<textarea style='height:18px ;'class="input_content" id="kv_withcontent" name="withcontent" ><? if ($formtype=="kv"){?><?=$withcontent?><? }?></textarea>	


		<div id="postdate_l">
		<span  >За последние</span>
		<select name="postdate" class ="hidselect" >
    <option value="">-</option>
	<option value="1" <? if ($postdate=="1"&&$formtype=="kv"){?>selected<? }?>>1</option>
	<option value="3" <? if ($postdate=="3"&&$formtype=="kv"){?>selected<? }?>>3</option>
	<option value="14" <? if ($postdate=="14"&&$formtype=="kv"){?>selected<? }?>>14</option>
  	<option value="30" <? if ($postdate=="30"&&$formtype=="kv"){?>selected<? }?>>30</option>		    					
  					

				</select>	
					
      <span class="price-text">дней</span>
		</div>
		
		
		
	
	
   
	
	
		
	   
      <div id ="preview-quick-objects-count_nb" class="preview-quick-objects-count"><strong><span class="count"  id="count_nb"></span></strong></div>
      <div class="button"><span></span>
                  <div>

				<div id="buttonem_nb-">
				<div id="buttonful_nb-">
                    <input type="submit" value="Уточнить" class="searchButton"/>
				 
				</div>
				</div>
					
			<style>
			
</style>			
			 		
                  </div>
                  </div>
	
	
	
<div class="dn" id="area_pop_nb"  >-</div> 
	
	
<script type="text/javascript">
var  isIE6=false;
</script> 
<!--[if lte IE 6.5]>
<script type="text/javascript">
  isIE6=true;
</script>
<style> 
 .quich-search-right{margin-left:10px;
      	  			width:155px;}
</style>
<![endif]-->
	
	
	
   
    </form>	