
<script src="http://neagent.by/themes/neagent_style/javascript/neagent_form.js" type="text/javascript"></script>
<script src="http://neagent.by/themes/neagent_style/javascript/tools.js" type="text/javascript"></script>
<script src="http://neagent.by/themes/neagent_style/javascript/jquery.autocomplete.js" type="text/javascript" charset="utf-8"></script>
 
<script type="text/javascript">
	$(document).ready(function(){
	  $("#street").autocompleteArray([
	    "Ангарская, ул.",
	   "Независимости, пр-т"
	    ],
	    {
	    delay:10,
	    minChars:1,
	    matchSubset:1,
	    autoFill:true,
	    maxItemsToShow:10
	    }
	  );
	});
</script>

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




</style>










 <? if (!$client){?>

Подача объявления → <span style="background:#dfe19d;">Платежная информация</span> → Проверка заказа → Оплата → Активация
<h2>Шаг 2: платежная информация</h2>

<div style="background-color: rgb(224, 255, 224); padding: 1px 10px;margin-top:20px;">
	<p><strong>Объявления "на сутки" платные. Заполните данные, необходимые для выставления счета.</strong><br> Ознакомиться с условиями размещения можно <a href="http://neagent.by/sutki-polisy" target='_blank'>здесь</a> (ссылка откроется в новом окне).
	</p>
	</div>



<BR>

<?} ?>




<FORM style=" width:790px; "  method="post"  action="ad-form"  onsubmit="return checkForm(this);" >
  
	<? if (!$client){   //нормальный порядок ?>
	<INPUT type="hidden"  name="act"  value="check" >
	<? }else{ 

	//для клиентов, проверки нет ?>
<INPUT type="hidden"  name="act"  value="invoice" >
<INPUT type="hidden"  name="client_id"  value="<?= $client_id;?>" >
<INPUT type="hidden"  name="id_user"  value="<?= $id_user;?>" >
	
	<? }?>
	
    <INPUT type="hidden"  name="pend_id"  value="<?= $ad_pending_id;?>" >
	<INPUT type="hidden"  name="ad_postdate"  value="<?= $ad_postdate;?>" >
	
    <FIELDSET>
    <LEGEND>платежная информация</LEGEND>
      
	  
	  
	













	<? if ($client){?>
	<div style="padding:18px; background-color:white;">
	Проверьте ваши данные, если они изменились, напишите администратору.  <br> 
	Наименование: <b> <?=$firmname?></b> <br>
	УНП <b> <?=$unp?></b><br>
	Email для отправки счета: <b> <?=$email?></b>
	<br>
	</div>
	<?}  else {?>
	
	    
        <SPAN class="mainli"  id="li_firmname" >
        <LABEL class="desc" >Название организации или  Фамилия Имя Отчество индивидуального предпринимателя</LABEL>
         
        <INPUT name="firmname"  id="firmname"  class=" " type="text" size="20"  maxlength="90" >
        <BR class="clear" >
        </SPAN>
        <LABEL id="li_firmname_comment"  style="display: none"  class="comment" > Например, ООО "Квартиры", ИП Иванов А.А. </LABEL>
        <BR class="clear" >
	  
	  
	   <SPAN class="mainli"  id="li_unp" >
        <LABEL class="desc" >УНП</LABEL>
         
        <INPUT name="unp"  id="unp"  class=" " type="text" size="20"  maxlength="90" >
        <BR class="clear" >
        </SPAN>
        <LABEL id="li_unp_comment"  style="display: none"  class="comment" > Учетный номер налогоплательщика </LABEL>
        <BR class="clear" >
	  
	  
	  
	  
	  <SPAN class="mainli"  id="li_juraddress" >
        <LABEL class="desc" >Юридический адрес (для ИП - домашний адрес)</LABEL>
         
        <INPUT name="juraddress"  id="juraddress"  class=" " type="text" size="20"  maxlength="90" >
        <BR class="clear" >
        </SPAN>
        <LABEL id="li_juraddress_comment"  style="display: none"  class="comment" > Юридический адрес</LABEL>
        <BR class="clear" >
	  
	  
	  
	  <SPAN class="mainli"  id="li_postaddress" >
        <LABEL class="desc" >Почтовый адрес </LABEL>
         
        <INPUT name="postaddress"  id="postaddress"  class=" " type="text" size="20"  maxlength="90" >
        <BR class="clear" >
        </SPAN>
        <LABEL id="li_postaddress_comment"  style="display: none"  class="comment" > Почтовый адрес для корреспонденции </LABEL>
        <BR class="clear" >
	  
	  
	  <?}?>
	  
	  
	  
	 <SPAN id="li_sposob"  class="mainli" >
        <LABEL class="desc" >Способ оплаты</LABEL>
	  <DIV style="border:1px solid #fff; overflow: hidden; float:left;" >
          <SELECT id="sposob"  name="sposob"  onchange="komdiv();" >
            <OPTION value="0" >выберите</OPTION>
            <OPTION value="1" >С расчетного счета</OPTION>
			<OPTION value="2" >Через сберкассу</OPTION>
          </SELECT>
        </DIV>
      </SPAN><br>
      <LABEL id="li_sposob_comment"  style="display: none"  class="comment" >выберите </LABEL>
       
      <BR class="clear" >
	  
	  
	  
	  
  <DIV id="komdiv"  class="hide"  style="display:none;" >
	  
	  
	  
	  <SPAN class="mainli"  id="li_account" >
        <LABEL class="desc" >Расчетный счет</LABEL>
         
        <INPUT name="account"  id="account"  class=" " type="text" size="20"  maxlength="90" >
        <BR class="clear" >
        </SPAN>
        <LABEL id="li_account_comment"  style="display: none"  class="comment" >Только цифры</LABEL>
        <BR class="clear" >
	  
	  
	  
	  	  <SPAN class="mainli"  id="li_bank" >
        <LABEL class="desc" >Название и адрес банка</LABEL>
         
        <INPUT name="bank"  id="bank"  class=" " type="text" size="20"  maxlength="90" >
        <BR class="clear" >
        </SPAN>
        <LABEL id="li_bank_comment"  style="display: none"  class="comment" >  </LABEL>
        <BR class="clear" >
	  
	  
	  
	    <SPAN class="mainli"  id="li_kod" >
        <LABEL class="desc" >Код банка</LABEL>
         
        <INPUT name="kod"  id="kod"  class=" " type="text" size="20"  maxlength="90" >
        <BR class="clear" >
        </SPAN>
        <LABEL id="li_kod_comment"  style="display: none"  class="comment" >Только цифры </LABEL>
        <BR class="clear" >
	  
	  
</div>	 
	  
	   
     
      <BR>
    </FIELDSET>
    <DIV class="fieldset_separator" ></DIV>
    <FIELDSET>
      <LEGEND>Информация о заказе</LEGEND>
     
	 
	 
	 
	 
	 <SPAN id="li_srok"  class="mainli" >
        <LABEL class="desc" >Тип размещения</LABEL>
	  <DIV style="border:1px solid #fff; overflow: hidden; float:left;" >
          <SELECT id="srok"  name="srok"  onchange="lkomdiv();" >
           
            <OPTION value="31" >Спецпредложение (1 позиция - свободно) - 1 200 000 руб.</OPTION>
			<OPTION value="32" >Спецпредложение (2 позиция - свободно) - 900 000 руб.</OPTION>
			<OPTION value="33" >Спецпредложение (3 позиция - свободно) - 800 000 руб.</OPTION>
            <OPTION value="2" >"Премиум объявление" - 350 000 руб.</OPTION>
			
		    <OPTION value="1" selected='selected'>Простое объявление - 100 000 руб.</OPTION>
 			<OPTION value="4" >"баннер". - 1 200 000 руб.</OPTION>
			
          </SELECT>
        </DIV>
      </SPAN><br>
      <LABEL id="li_srok_comment"  style="display: none"  class="comment" >выберите пункт </LABEL>
       
      <BR class="clear" >
	  
	  <b> Срок размещения - 1 месяц. </b>  
	  <b> Цены указаны для Минска. Для объектов в других городах Беларуси счет будет выставлен со скидкой 40%.  </b> 
	  
	  
	  
	  
	  
	  
	  
	  
	<div style="clear:both;">  
	<b>Стандартное размещение</b> - объявление показывается, как обычно. <br><b>"Премиум"</b> - объявление показывается 
	на одной из 10 верхних позиций, выделено фоновым цветом,  в объявлении можно разместить ссылку на  свой сайт. 	 
    Также одно из "премиум"-объявлений (в случайном порядке) показывается на главной странице neagent.by
	<br> <b>СПЕЦПРЕДЛОЖЕНИЕ</b> - первые 3 позиции в списке. 
	 <br><b>Тип объявления "баннер"</b> - означает, что в списке вместо текстового объявления вы можете разместить flash-баннер. (тех.требовния уточняйте у
администратора).
<br>
<a href="http://neagent.by/sutki-polisy" target="_blank"> ПРАВИЛА РАЗМЕЩЕНИЯ И РАСЦЕНКИ ПОДРОБНЕЕ</a> (откроется в новом окне)
	
	 </div>
	 
	 
	 <? if (!$client){?>
	 
	  	<SPAN class="mainli"  id="li_phone" >
        <LABEL class="desc" >Как с вами связаться?</LABEL>
         
        <INPUT name="phone"  id="phone"  class=" " type="text" size="20"  maxlength="90" >
        <BR class="clear" >
        </SPAN>
        <LABEL id="li_phone_comment"  style="display: none"  class="comment" > Введите первые буквы названия, а затем выберите из списка нужную улицу </LABEL>
        <BR class="clear" >
      
	  <? }?>
	  
	  
     


   



   </FIELDSET>
    <DIV class="fieldset_separator" ></DIV>

    <DIV class="fieldset_separator" ></DIV>
    <DIV class="fieldset"  style="  font-size:16px;" >
     
     
      
      <BR>
      <B>
       
        <BR>
      </B>
	  <? if (!$client){?>
      Агентам публикация частных объявлений ЗАПРЕЩЕНА.
	  <BR>
      <BR>
	  
<?} ?>	  
      
      <INPUT type="Submit"  onclick="javascript: fillul(); "  value="Следующий шаг"  class="button" >
    </DIV>
	
	<input type="hidden" id="public_input" name="public" value="allow"/>

 </FORM>

 
 
 
  


<script language="javascript" type="text/javascript">
<!-- Begin
function textCounter(field, count) {
  count.value = field.value.length;
	if (count.value >= 401) {
		document.getElementById('charCountError').innerHTML = "<br/><font color='red'>Вы достигли предела в 400 символов</font>";
	}
	else {
		document.getElementById('charCountError').innerHTML = "";
	}
}
// End -->



function komdiv(){
select=document.getElementById('sposob');
sp=select.options[select.selectedIndex].value;
if ((sp==1)) {document.getElementById('komdiv').style.display = "block";}
else{ document.getElementById('komdiv').style.display = "none";}
}





function komdiv2(){
select=document.getElementById('cat');
cat=select.options[select.selectedIndex].value;
if (cat==1) {

document.getElementById('komdiv').slideDown('fast').show();
}
else{
  document.getElementById('komdiv').slideUp('slow');
}

}











function showdiv(divname){
select=document.getElementById('cat');
cat=select.options[select.selectedIndex].value;
if ((cat==1)||(cat==3)) {
//$('#komdiv').removeClass('hide');
document.getElementById('komdiv').style.display = "block";
}
else{
//$('#komdiv').addClass('hide');
 document.getElementById('komdiv').style.display = "none";
}
//
//document.getElementById('komdiv').style.display = "none";
}


























function screenHeight(){
return  jQuery.browser.opera? window.innerHeight : jQuery(window).height();
}


function alert_up(text) {

if (jQuery('#alert_mess')) {
 //alert("am");
    jQuery('#alert_mess').html(text);
	}
	
	
if (jQuery('#alert_panel')) {
 //alert("ap");
	var scrollY = (window.scrollY) ? window.scrollY : document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
	
	sh=screenHeight()
	scrollY = scrollY + sh/2-150;
 jQuery('.alert_panel').css( {'margin-top': scrollY} ); //для IE 

}


	if (!jQuery('#alert_pop')) {
	//alert("apop");
	return false;
	}
	
					//$('#area_pop').className = 'up';
	jQuery('#alert_pop').addClass('up');
	alert(jQuery('#alert_pop'));
	jQuery('#alert_pop').removeClass('dn')
					//$('#area_pop').className = 'up';
					//.addClass(className) 
	 if (isIE6==true){
	 jQuery('#alert_pop').css( {'display': 'block'} ); //для IE 
	 jQuery('.hidselect').css( {'visibility': 'hidden'} );  //для IE 
	 }
	 
	return false;
}




function alert_dn() {
//alert ("dn");
//alert ($('#area_pop_ar'));
 
	if (!jQuery('#alert_pop')) return false;
	jQuery('#alert_pop').addClass('dn');
	if (isIE6==true){
	jQuery('#alert_pop').css( {'display': 'none'} );  //для IE 
	jQuery('.hidselect').css( {'visibility': 'visible'} );  //для IE 
	}
	//$('#area_pop_nb').child().addClass('dn');
	return false;
}












function  getDigits(sText) {
digitsCount=0;
var ValidChars = "0123456789";
var Char;
for (jj = 0; jj < sText.length; jj++) 
      { 
	   Char = sText.charAt(jj); 
	 // alert ( Char)
     
      if (IsNumeric(Char) == true) 
         {
        digitsCount=digitsCount+1;
         }
      }
 return  digitsCount;
}












function IsNumeric(sText)
{
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   }



   


function unlElements(){
// jQuery("#li_komn").attr('className',jQuery("#li_komn").attr('className').replace(' redborder', ''));
 // jQuery("#li_phones").attr('className',jQuery("#li_komn").attr('className').replace(' redborder', ''));

if (jQuery("#li_komn")){ 
jQuery("#li_komn").removeClass(' redborder');
}
if (jQuery("#li_phones")){ 
jQuery("#li_phones").removeClass(' redborder');
}
if (jQuery("#li_type")){ 
jQuery("#li_type").removeClass(' redborder');
}

if (jQuery("#li_kdesc")){
jQuery("#li_kdesc").removeClass(' redborder');
}


//alert  (  jQuery("#li_kdesc").attr('className') );
}


   
 function hlElement(elem){
 // alert (("#"+ elem) + jQuery("#"+ elem));


 if ( jQuery("#"+ elem)){
  //jQuery("#"+ elem).attr('className',jQuery("#li_komn").attr('className')+ " redborder" );
  //jQuery("#"+ elem).className +=" redborder"
  jQuery("#"+ elem).addClass(" redborder");
  // alert  (  jQuery("#"+ elem).attr('className') );
  //jQuery("#"+ elem).css("border","1px solid red");
 }
} 









function checkForm(form) {

//alert(0);
unlElements();
 // Заранее объявим необходимые переменные
 var el, // Сам элемент
 elName, // Имя элемента формы
 value, // Значение
 type; // Атрибут type для input-ов
 // Массив списка ошибок, по дефолту пустой
 var errorList = [];
 // Хэш с текстом ошибок (ключ - ID ошибки)
 var errorText = {
 1 : "Не заполнено поле 'Имя'",
 2 : "Не заполнено поле 'E-mail'",
 3 : "Не прикреплен файл",
 4 : "Вы не написали текст объявления",
 5 : "Не выбрано любимое время суток",
 6 : "Не выбрана рубрика",
 7 : "Не выбрано кол-во комнат",
 8 : "Поле кол-во комнат должно содержать только цифры",
 9 : "Не указана цена",
 10 : "Поле цена должно содержать только цифры",
 11 : "Не указан номер телефона",
 12 : "Телефоны должны начитаться в восьмерки, с кодом оператора, например 8 029 700-00-00",
 13 : "Вы не указали название и форму собственности организации или ИП",
 14 : "Вы не указали УНП",
 15 : "Вы не указали адрес"
 //13 : "Объявления о продаже договоров с агентствами запрещены. Отнеситесь с пониманием, это портит репутацию сайта neagent.by"
 }
 // Получаем семейство всех элементов формы
 // Проходимся по ним в цикле
 //alert(2);
 for (var i = 0; i < form.elements.length; i++) {
 el = form.elements[i];
 elName = el.nodeName.toLowerCase();
 value = el.value;
 if (elName == "input") { // INPUT
 // Определяем тип input-а
 type = el.type.toLowerCase();
 // Разбираем все инпуты по типам и обрабатываем содержимое
 switch (type) {
 case "text" :
 
 
 
 
if (el.name == "komnat" && value == "") {errorList.push(7); hlElement("li_komn")};
if (el.name == "komnat" && value != "" &&  IsNumeric(value)==false) {errorList.push(8); hlElement("li_komn")};
 
 
if (el.name == "price" && value == "") {errorList.push(9);hlElement("li_komn")};
if (el.name == "price" && value != "" &&  IsNumeric(value)==false) {errorList.push(10);hlElement("li_komn")};
 
if (el.name == "phones" && value == "") {errorList.push(11);hlElement("li_phones")};

if (el.name == "phones" && value != "" && getDigits(value)<11) {errorList.push(12);hlElement("li_phones")};
 
if (el.name == "firmname" && value == "") {errorList.push(13);hlElement("li_firmname")}; 
if (el.name == "unp" && value == "") {errorList.push(14);hlElement("li_unp")}; 
if (el.name == "postaddress" && value == "") {errorList.push(15);hlElement("li_postaddress")}; 
 //alert(3);
 
if (el.name == "email" && value == ""){ errorList.push(2)};
break;
case "file" :
if (value == "") errorList.push(3);
break;
case "checkbox" :
 // Ничего не делаем, хотя можем
break;
case "radio" :
 // Ничего не делаем, хотя можем
break;
default :
 // Сюда попадают input-ы, которые не требуют обработки
 // type = hidden, submit, button, image
 break;
 }
 } else if (elName == "textarea") { // TEXTAREA
 if (value == ""){ errorList.push(4); hlElement("li_kdesc")};
 

 //alert(4);
 
 
//проверка на соответствие рубрики
selectedCat=form.elements["cat"].value;
//alert (selectedCat);
var errorCatList = [];

var snimuArr = {
 1 : "сниму",
 2 : "снимет",
 3 : "снимем",
 4 : "снять"
 } 
val= value.toLowerCase()
for  (var k=0;k<4+1 ;k++){
dd = val.indexOf(snimuArr[k]);
if ((dd>-1) && ((selectedCat==1)||(selectedCat==3) ) ){
errorCatList.push("Вы пытаетесь дать объявление с текстом '" + snimuArr[k] +"' в рубрику 'сдаю'. Измените рубрику.");
hlElement("li_type");
}
}
 
 

 
 

 
 
 //alert(5);
 
 
 
 
// selectedCat=form.elements["cat"].value;
//alert (selectedCat);



 
 
 
 

 
 
 
 
 
 
 
 
 
//

 
 } else if (elName == "select") { // SELECT
if (el.name == "cat" && value == "0"){ errorList.push(6);hlElement("li_type")};
  
//if (value == 0) errorList.push(5);
} else {
// Обнаружен неизвестный элемент ;)
}
 }
 
 //alert ("77");
 // Финальная стадия
 // Если массив ошибок пуст - возвращаем true
 if ((!errorList.length)&&(!errorCatList.length)) return true;
 // Если есть ошибки - формируем сообщение, выовдим alert
 // и возвращаем false
 //alert ("88");
 
 var errorMsg = "<h2>При заполнении формы допущены следующие ошибки:</h2>";
 for (i = 0; i < errorList.length; i++) {
 errorMsg += errorText[errorList[i]] + "<br>";
 }
 
 //alert(6);
 //alert(errorMsg);
 //  сообщения о неверной рубрике
 //for (i = 0; i < errorCatList.length; i++) {
 //errorMsg += "<i style='color:#2972b5;'>" + errorCatList[i] + "</i><br>";
 //}
 
  alert ("Зполните, пожалуйста все поля");
 
 //alert_up(errorMsg);
 return false;
}








$(function() {
     //  var zIndexNumber = 1000;
       // Put your target element(s) in the selector below!
     //  $("div").each(function() {
    //           $(this).css('zIndex', zIndexNumber);
    //           zIndexNumber -= 10;
    //   });
});






</script>
 
 
 
 
 
 
 
 
 
<script language="javascript" type="text/javascript">
 //alert(jQuery(document));
jQuery(document).ready(function(){
 //alert("reasy");
var divTag = document.createElement("div");
        divTag.id = "div1";
        divTag.setAttribute("align","center");
        divTag.style.margin = "0px auto";
        divTag.className ="dynamicDiv";
        divTag.innerHTML = "<div class='dn' id='alert_pop'><div class='shadow' id='shadow'> </div> <div class='canvas' id='alert_canvas'> 	<div class='alert_panel'>	<div id='alert_mess'> </div>	<div class='cbtn'>	<a onclick='return alert_dn()' href='#'>    <img onmouseout='imgou(this)' onmouseover='imgov(this)' src='http://neagent.by/themes/neagent_style/assets/images/btn_close.gif' id='btn_choose'>	</a>	</div></div></div></div>";
        document.body.appendChild(divTag);
});



function fillul(){











 //alert($('bit-0').innerHTML)
 
 
//vv=$('bit-0').innerHTML;
//$('ul-demoinput').value=vv;
//$('ul-demo').value=vv;



// alert($('ul-demoinput').value)
}

</script>
 