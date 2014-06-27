<script src="http://neagent.by/themes/neagent_style/javascript/neagent_form.js-" type="text/javascript"></script>
<script src="http://neagent.by/themes/neagent_style/javascript/tools.js" type="text/javascript"></script>
<script src="http://neagent.by/themes/neagent_style/javascript/jquery.autocomplete.js" type="text/javascript" charset="utf-8"></script>
 


<!--[if IE 6]> 
<style type="text/css">
fieldset textarea {
 width:333px;
 }
</style>
<![endif]-->


<script type="text/javascript">var  isIE6=false;</script> 
<!--[if lte IE 6.5]>
<script type="text/javascript">isIE6=true;</script>
<![endif]-->


  
<style>
.ac_results {
	padding: 0px;
	border: 1px solid WindowFrame;
	background-color: Window;
	overflow: hidden;
}

.ac_results ul {
	width: 100%;
	list-style-position: outside;
	list-style: none;
	padding: 0;
	margin: 0;
}

.ac_results iframe {
	display:none;/*sorry for IE5*/
	display/**/:block;/*sorry for IE5*/
	position:absolute;
	top:0;
	left:0;
	z-index:-1;
	filter:mask();
	width:3000px;
	height:3000px;
}

.ac_results li {
	position:relative;
    margin: 0px;
	padding: 2px 5px;
	cursor: pointer;
	display: block;
	width: 100%;
	font: menu;
	font-size: 12px;
	overflow: hidden;
}

.ac_loading {
	background : Window url('autocomplete_indicator.gif') right center no-repeat;
}

.ac_over {
	background-color: Highlight;
	color: HighlightText;
}


#alert_pop{    text-align:center;
z-index:300; position:absolute;   
border:0px; min-height:100% !important; 
height:100%;   width: 100%; 
left: 0; top: 0px !important;  
height: expression((document.body.clientHeight - 10) + "px");
width: expression((document.body.clientWidth - 10) + "px");
position:absolute; width:100%; border:0px; min-height:100% !important; height:100%; 

}

 
#alert_pop.up , up{ }
#alert_pop.dn,   dn{display:none;}
.shadow{  margin:0 auto; width:100%; height:100%; position:absolute;top:0; left:0; z-index:254; font-size:1px; line-height:1px; background:#000; -moz-opacity:0.40; -khtml-opacity:0.40; opacity:0.40; filter:alpha(opacity=40);}
.canvas{ width:100%; height:100%; position:absolute;  top:0;left:0; z-index:955;}
div.alert_panel{ text-align:left; width:300px;margin:0 auto;background:#fff;border:2px solid #cacaca; margin-top:25px; }
div.alert_panel  {padding:5px 10px; font-size:12px;}
div.alert_panel h2  {font-size:18px; padding-tiop:8px; line-height:20px; padding-bottom:6px; padding-left:73px; height:69px; background:url(http://neagent.by/themes/neagent_style/assets/images/alert.gif) 1px 5px no-repeat;}
div.alert_panel .cbtn { 
text-align: center;
}

FIELDSET b { background:#fff;}
FIELDSET h2 { font-size:18px; padding:18px 0;}

</style>




	
	 

Подача объявления → Платежная информация → <span style="background:#dfe19d;">Проверка заказа</span> → Оплата → Активация


<h2>Шаг 3: проверка заказа</h2>

<div style="background-color: rgb(224, 255, 224); padding: 1px 10px;margin-top:20px;">
	
			<p>Пожалуйста, проверьте введенную информацию.</p>
	</div>




<BR>

<FORM style=" width:790px; "  method="post" action="ad-form"   onsubmit="return checkForm(this);" >
   
  


  
    <FIELDSET>
    <LEGEND>платежная информация</LEGEND>
      
	  
	  
	  
	  
	  
	  <div style='padding-top:18px;'>
	  
	  
	  		<h2> Объявление</h2> 
		
		<b>Категория:</b>	<?=$ad_catid;?>  <br>
        <b>Объявление:</b>   <?=$ad_message;?><br>
		<b>Цена:</b>	<?=$ad_price;?><br>
		<b>Телефоны:</b>	<?=$ad_phones;?><br>
		<b>Имя:</b>	<?=$ad_contactname;?><br>
		<b>Email:</b>	<?=$ad_email;?><br>
		<b>Фотографии:</b>	[можно загрузить позже]	<br>	
		
	<h2> Платежная информация</h2> 	
  
	<b>Название организации, ИП:</b> <?=$firmname;?> <br> 	 	 	 	 	 
 	<b>УНП:</b> <?=unp;?>  	 	 	 	 	<br> 
 	<b>Юридический адрес:</b> <?=$juraddress;?> <br>	 	 	 	 
 	<b>Почтовый адрес:</b> <?=$postaddress;?>  <br>	 	 	 	 
 	
	
	<? if ($sposob==1){ ?>
	<b>Способ оплаты:</b> С расчетного счета <br>
   <b>Рассчетный счет:</b> <?=$account;?> 	<br>
 	<b>Банк:</b><?=$bank;?>  	 	 	 	 <br>
 	<b>Код банка:</b><?=$kod;?> 	 	 	 	 <br>
   <?  } ?>
   <? if ($sposob==2){ ?>
   <b>Способ оплаты:</b> Через сберкассу <br>
   
    <?  } ?>
   
   
	
 	 	 	 	 
 	<b>Контактный телефон:</b> <?=$phone;?> 	 	<br> 	
	  
	  
	  </div>
	  
	  
	  
	  
	  
	   <INPUT type="hidden"  name="act"  value="invoice" >
    <INPUT type="hidden"  name="client_id"  value="<?= $client_id;?>" >
	<INPUT type="hidden"  name="pend_id"  value="<?= $pend_id;?>" >
	<INPUT type="hidden"  name="srok"  value="<?=$srok;?>" >
	<INPUT type="hidden"  name="sposob"  value="<?=$sposob;?>" >
	  
	  
	  
	  
	  
	    
      
	  
	  
	  
    
	 
	 
	 
   



   </FIELDSET>
    <DIV class="fieldset_separator" ></DIV>

    <DIV class="fieldset_separator" ></DIV>
    <DIV class="fieldset"  style="  font-size:16px;" >
     
     
      
      <BR>
      <B>
       
        <BR>
      </B>
      После оплаты счета вышлите копию платёжки на email: info@neagent.by; 
      <BR>
      <BR>
	  
      <INPUT type="Submit"  onclick="javascript: fillul(); "  value="Выписать счет на оплату"  class="button" >
    


   </DIV>
	
	<input type="hidden" id="public_input" name="public" value="allow"/>

 </FORM>
<br><br><br><br><br><br><br><br><br><br><br><br>
 
 































