
<script>
 
window.onresize = function(event) {
searchform_resize();
}


function searchform_resize(){

b_height=108;


if  ($(".contactdiv")) {
 if ($(window).width() <1200){
$(".contactdiv").hide();
}else{
$(".contactdiv").show();
 }
 }

 
el_h=$('#choosedArea_nb_l').height();
$('#choosedArea_nb_w').height(b_height-el_h);


el_h=$('#postdate_l').height()+$('#kv_withcontent_l').height();
$('#kv_withcontent').height(b_height-el_h);
 



//$('#choosedArea_nb_label').height()
}




</script>







 
<? 


$sel1=$sel2=$sel3=$sel4="";

$formtype = isset($formtype)?$formtype:false;
$prtype= isset($prtype)?$prtype:false;
$k1 = isset($k1)?$k1:false;
$k2 = isset($k2)?$k2:false;
$k3 = isset($k3)?$k3:false;
$k4 = isset($k4)?$k4:false;
$k5 = isset($k5)?$k5:false;

switch ($cat) {
 
case '3' :	case '9' :case '10' : 
$sel2=" sel";
break;
case '11':  
$sel4=" sel";
break;
case '7':  case '8':  case '15':  case '16':  
$sel3=" sel";
break;
default: 
$sel1=" sel";
  }  

?>











<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/JsHttpRequest.js"></script>

<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/tools.js"></script>


 

<div id="search-banner"    > 


	<div class="center">
		<div class="menu rn" id="center_menu">

	    				<ul id="top_menu">
	    					<li class="nb<?=$sel1?>" id="li_nb">
	    						<a>Квартиры <? if ($cat!=10){?><?=$cityname_in?><?} ?></a>
	    					</li>
	    					<li  class="ar<?=$sel2?>" id="li_ar">
	    						<a>Комнаты</a>
	    					</li>
							<li  class="kn<?=$sel3?>" id="li_kn">
	    						<a>Комм. недвижимость</a>
	    					</li>
							<li  class="su<?=$sel4?>" id="li_su">
	    						<a><? if ($cat==10){?> Квартиры на сутки <?} else{ ?>На сутки<?} ?></a>
	    					</li>
    					</ul>
						
	    			<div id="commonmenu" style="float: right; margin-top: -18px; margin-right: 6px; ">
					<div class="contactdiv"><a href="http://neagent.by/contact">Как с нами связаться?</a></div>
                    <a href="http://neagent.by/" onclick="javascript: window.external.AddFavorite ('http://neagent.by/', 'neagent.by /  каталог недвижимости'); return false;"  rel="sidebar" title="neagent.by |  каталог недвижимости"><img src="http://neagent.by/themes/neagent_style/assets/images/icfavorite.gif" alt="Добавить neagent.by в избранное" title="Добавить neagent.by в избранное"/></a> |
    				<a href="/" title="На главную страницу neagent.by"><img src="http://neagent.by/themes/neagent_style/assets/images/ichome.gif" alt="На главную страницу neagent.by"/></a> |
    				<a href="mailto:info@neagent.by" title="Контактная информация"><img src="http://neagent.by/themes/neagent_style/assets/images/iccontacts.gif" alt="Контактная информация"/></a>
    				</div>
	    					    					    			
		</div>				
		<script	type="text/javascript"	src="http://neagent.by/themes/neagent_style/javascript/quickSearchObjectsForm.js"></script>	




<!--Квартиры  -->
    <div class="quick-search-nb">
    <form action="/board/" method="get"   id="newbuilding-form">
	
	
	<input type=hidden value="kv" name="formtype">
    <input type=hidden value="search" name="mode">
	<input type=hidden name="city"  value="<?=$cityid?>">
	<div class="quich-search-left">
   
  
<span style="label">Тип предложения:<span>
<select class ="hidselect" name="prtype">
<option value="arenda" <? if ($prtype=='arenda'&&$formtype=="kv"){?> selected <? }?>>Сдаю</option>
<option value="arendac" <? if ($prtype=='arenda'&&$formtype=="kvс"){?> selected <? }?>>Сдаю на время чемпионата</option>
<option value="snimu" <? if ($prtype=='snimu'&&$formtype=="kv"){?> selected <? }?>>Сниму </option>
<option value="prodam" <? if ($prtype=='prodam'&&$formtype=="kv"){?> selected <? }?>>Продам</option>
<option value="kuplu" <? if ($prtype=='kuplu'&&$formtype=="kv"){?> selected <? }?>>Куплю</option>
</select>
<br>

<div style="margin-top:0px;">
 	<span>Комнат: </span>
    <input type="checkbox" name="k1"  <? if ($k1!=0||$formtype!="kv"){?> checked="checked"<? }?>  class="kom"/><span> <noindex>1&nbsp;</noindex> </span> 
	<input type="checkbox" name="k2" <? if ($k2!=0||$formtype!="kv"){?>checked="checked"<? }?>  class="kom"/><span > <noindex>2&nbsp;</noindex> </span> 
	<input type="checkbox" name="k3"  <? if ($k3!=0||$formtype!="kv"){?>checked="checked"<? }?>  class="kom"/><span > <noindex>3&nbsp;</noindex>  </span> 
	<input type="checkbox" name="k4"  <? if ($k4!=0||$formtype!="kv"){?>checked="checked"<? }?> class="kom"/><span > <noindex>4+</noindex> </span> 
</div>	 
	 
	 

	<br style="clear:both;">
 
 
 
<div style="margin-top:2px;">
	<span  >Цена</span>
    <input type="text" class="input_price" name="priceMin" value='<? if ($formtype=="kv"){?><?=$priceMin?><? }?>' /> &ndash; 
    <input type="text" class="input_price"name="priceMax" value='<? if ($formtype=="kv"){?><?=$priceMax?><? }?>' />
    <span class="price-text">$</span>
</div>	  
	 

    </div>
	
	
	
	
	
	 <div class="quich-search-submit">
	   <label>Выберите параметры <br>и нажмите кнопку</label>
      <div id ="preview-quick-objects-count_nb" class="preview-quick-objects-count"><strong><span class="count"  id="count_nb"></span></strong></div>
      <div class="button"><span></span>
                  <div>

				<div id="buttonem_nb">
				<div id="buttonful_nb">
                    <input type="submit" value=" " class="searchButton"/>
				 
				</div>
				</div>
					
			<style>
			
</style>			
			<div class="searchtip">Увидите&nbsp;агента,&nbsp;сообщайте!</div>		
                  </div>
                  </div>
    </div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	
	
  <div id="box"    >	
	
  <div class="quich-search-center"  id="qsc1">
	
<span class="searchParams">
	<div id="choosedArea_nb_l">
	<span>Район </span><span id="chooseArea"><a onclick="return area_up()" href="#">выбрать</a></span> 
	<br>
	</div>
	<div id="choosedArea_nb_w">
	<textarea id="choosedArea_nb"  onclick="return area_up()"  readonly style="height:100%"></textarea>
	</div>
	

	
	
<style>

</style>

 
</span>	
	
	</div>
	
	
	
	
    <div class="quich-search-right">
     
	 <div class="s_move" id="resizable">  </div>
	 
	 
	 
	 
	 <style>

	</style>
	
	

	 
	 <span class="searchParams2">
	 
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
		
		
		
	</span>	
	
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
    </div>
	
	
	
	
	
    <!--Квартиры и комнаты-->
    <div class="quick-search-ar">
     <form action="/board/" method="get"   id="apartments-form">
	  
	  <input type=hidden value="kom" name="formtype">
	      <input type=hidden value="search" name="mode">
		  <input type=hidden name="city"  value="<?=$cityid?>">
   <div class="quich-search-left">
     

 

 <span>Тип предложения:<span>
<select class ="hidselect" name="prtype">
<option value="arenda" <? if ($prtype=='arenda'&&$formtype=="kom"){?> selected <? }?>>Сдаю комнату</option>
<option value="podselenie_pr" <? if ($prtype=='podselenie_pr'&&$formtype=="kom"){?> selected <? }?>>Возьму на подселение</option>
<option value="podselenie_spr" <? if ($prtype=='podselenie_spr'&&$formtype=="kom"){?> selected <? }?>>Подселюсь</option>
</select><br>
 
 
 
 
 
	 <span  >Цена</span>
      <input type="text" class="input_price" name="priceMin" value="<? if ($formtype=="kom"){?><?=$priceMin?><? }?>" /> &ndash; 
      <input type="text" class="input_price"name="priceMax" value="<? if ($formtype=="kom"){?><?=$priceMax?><? }?>" />
      <span class="price-text">$</span>
	  
	 

    </div>
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
    <div class="quich-search-submit">
	  <label>Выберите параметры <br>и нажмите кнопку</label>
	 
      <div id ="preview-quick-objects-count_ar" class="preview-quick-objects-count"><strong><span class="count" id="count_ar"></span></strong></div>
      <div class="button"><span></span>
                 <div id="buttonem_ar">
				<div id="buttonful_ar">
                    <input type="submit" value="ghhh" class="searchButton"/>
				 
				</div>
			<div class="searchtip">Увидите&nbsp;агента,&nbsp;сообщайте!</div>		
				</div>
                </div>
				
				
				
    </div>
	
	
	
	
	
	<div id="box"    >
	
	
  <div class="quich-search-center">
	
	<span class="searchParams">
	 
	 <span>Количество отдельных комнат: </span><br>
	    
    <input type="checkbox" name="k1"  <? if ($k1!=1||$formtype!="kom"){?> checked="checked"<? }?>     /><span class="k1"> <noindex>1&nbsp;</noindex> </span> 
	 <input type="checkbox" name="k2"  <? if ($k1!=2||$formtype!="kom"){?> checked="checked"<? }?>    /><span class="k2"> <noindex>2&nbsp;</noindex> </span> 
	 <input type="checkbox" name="k3"  <? if ($k1!=3||$formtype!="kom"){?> checked="checked"<? }?>    /><span class="k3"> <noindex>3&nbsp;</noindex>  </span> 
	 <input type="checkbox" name="k0"  <? if ($k1!=0||$formtype!="kom"){?> checked="checked"<? }?>   /><span class="k0"> <noindex>4+</noindex> </span> 
	  
	 
	 
 
	 <br style="clear:both;">
	 

	
	 
<div class="dn" id="area_pop_ar" style="position:absolute; width:100%; border:0px; min-height:100% !important; height:100%; ">
-
</div>
	
	
 
 
	</span>
	
	</div>
	
	
	
	
	
    <div class="quich-search-right">
     <span class="searchParams2">
	  <span>Содержит текст: </span><br>
	 <input type="text" class="input_content" name="withcontent" value="<? if ($formtype=="kom"){?><?=$withcontent?><? }?>" /> <br> <br>
		


		
		<span  >За последние</span>
		<select name="postdate">
    <option value="">-</option>
	<option value="1" <? if ($postdate=="1"&&$formtype=="kom"){?>selected<? }?>>1</option>
	<option value="3" <? if ($postdate=="3"&&$formtype=="kom"){?>selected<? }?>>3</option>
	<option value="14" <? if ($postdate=="14"&&$formtype=="kom"){?>selected<? }?>>14</option>
  	<option value="30" <? if ($postdate=="30"&&$formtype=="kom"){?>selected<? }?>>30</option>		    					
  					

				</select>	
					
      <span class="price-text">дней</span>
		
		
		
		
	</span>	
	
    </div>
	
	</div>
	
	
	
	
    </form>
    </div>
	
	
	
	
    <!--Коммерческая-->
    <div class="quick-search-kn">
     <form action="/board/" method="get"   id="apartments-form">
	  
	  <input type=hidden value="kn" name="formtype">
	      <input type=hidden value="search" name="mode">
		  <input type=hidden name="city"  value="<?=$cityid?>">
   <div class="quich-search-left">
     

 

 <span>Тип предложения:<span>
<select class ="hidselect" name="prtype" style="margin-bottom:0px;">
<option value="sdam" >Сдаю</option>
<option value="snimu" >Сниму</option>
<option value="prodam" >Продам</option>
<option value="kuplu" >Куплю</option>
</select>
 
 
 <span>Тип объекта:<span>
<select class ="hidselect" name="komm_type">
<option value="1" >Офис</option>
<option value="2" >Торговое помещение</option>
<option value="3" >Склад</option>
<option value="4" >Производственное помещение</option>
<option value="5" >Гараж</option>
<option value="6" >Земля</option>
</select><br>
 
 
	 <span  >Цена за м2</span>
      <input type="text" class="input_price" style="width:40px;" name="priceMin" value="<? if ($formtype=="kom"){?><?=$priceMin?><? }?>" /> &ndash; 
      <input type="text" class="input_price"name="priceMax" style="width:40px;" value="<? if ($formtype=="kom"){?><?=$priceMax?><? }?>" />
      <span class="price-text">$</span>
	  
	 

    </div>
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
    <div class="quich-search-submit">
	  <label>Выберите параметры <br>и нажмите кнопку</label>
	 
      <div id ="preview-quick-objects-count_ar" class="preview-quick-objects-count"><strong><span class="count" id="count_ar"></span></strong></div>
      <div class="button"><span></span>
                 <div id="buttonem_ar">
				<div id="buttonful_ar">
                    <input type="submit" value="ghhh" class="searchButton"/>
				 
				</div>
			<div class="searchtip">Увидите&nbsp;агента,&nbsp;сообщайте!</div>		
				</div>
                </div>
				
				
				
    </div>
	
	
	
	
	
	<div id="box"    >
	
	
  <div class="quich-search-center">
	
	<span class="searchParams">
	 
<div>
 При поиске цену указывайте в долларах за кв. метр
</div>
	    

	  
	 
	 
 
	 <br style="clear:both;">
	 

	
	 
<div class="dn" id="area_pop_ar" style="position:absolute; width:100%; border:0px; min-height:100% !important; height:100%; ">
-
</div>
	
	
 
 
	</span>
	
	</div>
	
	
	
	
	
    <div class="quich-search-right">
     <span class="searchParams2">
	  <span>Содержит текст: </span><br>
	 <input type="text" class="input_content" name="withcontent" value="<? if ($formtype=="kom"){?><?=$withcontent?><? }?>" /> <br> <br>
		


		
		<span  >За последние</span>
		<select name="postdate">
    <option value="">-</option>
	<option value="3" <? if ($postdate=="3"&&$formtype=="kom"){?>selected<? }?>>3</option>
	<option value="14" <? if ($postdate=="14"&&$formtype=="kom"){?>selected<? }?>>14</option>
  	<option value="30" <? if ($postdate=="30"&&$formtype=="kom"){?>selected<? }?>>30</option>		    					
  					

				</select>	
					
      <span class="price-text">дней</span>
		
		
		
		
	</span>	
	
    </div>
	
	</div>
	
	
	
	
    </form>
    </div>
	
	
	
	
	<!--Сутки  -->
    <div class="quick-search-su">
	 <form action="/board/" method="get"   id="apartments-form">
     
	  <input type=hidden value="su" name="formtype">
      <input type=hidden value="search" name="mode">
	  <input type=hidden name="city"  value="<?=$cityid?>">

	 <div class="quich-search-left">
     
<span>Тип предложения:<span>
<select class ="hidselect" name="prtype">
<option value="su_kv" >Квартиры </option>
<option value="su_kot" >Коттеджи </option>
</select><br>
 

	 <span  >Цена за сутки</span>
      <input type="text" class="input_price" style="width:35px;" name="priceMin" value=" " /> &ndash; 
      <input type="text" class="input_price" style="width:35px;"  name="priceMax" value=" " />
      <span class="price-text">$</span>
	  
	 

    </div>
	
	
	
	
		<div class="quich-search-submit">
		  <label>Выберите параметры <br>и нажмите кнопку</label>
      <div id ="preview-quick-objects-count_su" class="preview-quick-objects-count"><strong><span class="count" id="count_su"></span></strong></div>
      <div class="button"><span></span>
                  <div>
				  
				  
				<div id="buttonem_su">
				<div id="buttonful_su">
                    <input type="submit" value="ghhh" class="searchButton"/>
				 
				</div>
				</div>
					
			<style>		
</style>			
					
                  </div>
                  </div>
    </div>
	
	
	
	 <div id="box"    >
	
	
  <div class="quich-search-center"  >
	<span class="searchParams">
	
	
	 <span>Количество комнат: </span><br>
	    
<input type="checkbox" name="k1"   checked="checked"    /><span class="k1"> <noindex>1&nbsp;</noindex> </span> 
<input type="checkbox" name="k2"  checked="checked"      /><span class="k2"> <noindex>2&nbsp;</noindex> </span> 
<input type="checkbox" name="k3"  checked="checked"    /><span class="k3"> <noindex>3&nbsp;</noindex>  </span> 
<input type="checkbox" name="k4"  checked="checked"    /><span class="k0"> <noindex>4+</noindex> </span> 
	 
	 
	 
 
	 <br style="clear:both;">
	 
	 
	 <!--
	 <span>Район </span><span id="chooseArea"><a onclick="return area_up()" href="#">выбрать</a></span>
	<br>
	 <textarea id="choosedArea_su"  onclick="return area_up()"  readonly style="margin-top:5px;height:30px;  background-color:#82bde7; border:0; font:11px Arial;"></textarea>
	-->
	
	 
	<div class="dn" id="area_pop_su"  >
	-
	</div> 
	
	
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
	
	
	
	
	
 

 
	</span>
	
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    <div class="quich-search-right">
     <span class="searchParams">
	  <span>Содержит текст: </span><br>
	 <input type="text" class="input_content" name="withcontent" value="" /> <br> <br>
		


		
	 
		
		
		
		
	</span>	
	
    </div>
    
	</div>
	
	
	
	
	
    </form>
    </div>
	
	
	
	
	
	
	
	
	
	
    <!--Аренда-->
 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	





		
				
	

</div> <!--  center -->	
 	 			
</div>	
echo("<!-- cat-------" . <?=$cat?> . "-->");		
<script type="text/javascript">
<? 

switch ($cat) {
    case '1' : ?>
	var  cur_form="nb";
<?	
break;
case '3' :	case '2' : ?>
	var  cur_form="kn";
<?	break;
case '11': ?>
	var  cur_form="su";
<?	break;
default:?>
	var  cur_form="nb";
<? } ?>
//var cur_form="nb"; // текущая форма

 


getAreaByCityId(1, '', ''); 
 
 
//var cur_count=0; // текущее кол-во вариантов в рубрике
//cur_count=getCurCount(cur_form);

</script>			