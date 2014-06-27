<!-- content div start -->
<script src="scripts/jquery-1.2.6.js" type="text/javascript"></script>
<script src="scripts/neagent_form.js" type="text/javascript"></script>





<style>
#content {width:790px;}
.holder {border:1px solid white; margin:0; padding:0;}
.holder  {width:200px;border:1px solid green;z-index:2000; } 
</style>
<!--[if IE 6]> 
<style type="text/css">
fieldset textarea {
width:333px;
}
</style>
<![endif]-->


<link rel="stylesheet" href="test.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
<script src="scripts/mootools-beta-1.2b1.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/textboxlist.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/test.js" type="text/javascript" charset="utf-8"></script>
<div  style="  width:790px;  ">
<form  style=" width:790px; "  method="post" action="tolk-add-form">
<INPUT type="hidden"  name="act"  value="post" >
<input type="hidden" name="cat" value="<?=$gb_cat;?>">


<? if ($tolk_parent){ ?>
<input type="hidden" name="parent" value="<?=$tolk_parent;?>">
<?
$legend="Ответ на сообщение";
}
else{
$legend="Новое сообщение на толкучку";
}?>

<fieldset>
   <LEGEND><?=$legend;?></LEGEND>




<? if (!$tolk_parent){ ?>
<SPAN id="li_type"  class="mainli" >
        <LABEL class="desc" >Я хочу *</LABEL>
        <DIV style="border:1px solid #fff; overflow: hidden; float:left;" >
          <SELECT id="cat"  name="tolk_action"  onchange="komdiv();" >
            <OPTION value="0" >-выберите-</OPTION>
            <OPTION value="1" >Купить</OPTION>
			<OPTION value="2" >Продать</OPTION>
            <OPTION value="3" >Принять в дар</OPTION>
            <OPTION value="4" >Отдать даром</OPTION>
          </SELECT>
        </DIV>
      </SPAN><br>
      <LABEL id="li_type_comment"  style="display: none"  class="comment" >выберите рубрику для объявления </LABEL>
       
      <BR class="clear" >


	  
 <span class="mainli"  id="li_name">
    <LABEL class="desc" >Заголовок*</LABEL> <input name="tolk_title" id="tolk_name" class=" "  size="20"  maxlength="90" />
    <BR class="clear" >
  </span>
   <label class="comment" id = "li_name_comment" style="display: none">Укажите имя</label> <BR class="clear" >
	  
	  
	  

<SPAN class="mainli diff"  id="li_komn" >
        <LABEL class="desc short2 alignr" >Цена </LABEL>
        
        <INPUT name="price" id="xxx" type="text" class="short"  size="20"  maxlength="90" >  
        <LABEL class="desc short2 alignr" ></LABEL>
         
        <!--
		<SELECT id="tolk_currency"  class="short" name="tolk_action"  onchange="komdiv();" >
            <OPTION value="0" >-выберите-</OPTION>
            <OPTION value="1" >Бел.руб</OPTION>
			<OPTION value="11" >Долларов</OPTION>
            <OPTION value="2" >Евро</OPTION>
        </SELECT>
		-->
		
		
		
		
		
		<br>
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment2"  id="li_komn_comment"  style="display: none" >количество комнат в квартире и цена в долларах</LABEL>
       
      <BR class="clear" >



<? }?>
	  
	  

<span class="mainli diff" id="li_kdesc">
    <LABEL class="desc alignr" >Текст сообщения 
	  (Максимум 400 символов)  <input style="width:30px;" readonly="readonly" name="remainingChar" size="3" maxlength="3" value="  " type="text" disabled="disabled">  
	</LABEL> 
	<textarea name="tolk_message" rows="10" cols="50"  onkeydown="textCounter(this.form.content,this.form.remainingChar);" onkeyup="textCounter(this.form.content,this.form.remainingChar);"></textarea >

    <BR class="clear" >
  </span>
  <label class="comment" id = "li_kdesc_comment" style="display: none"> Текст должен быть до 400 символов </label> <BR class="clear" >
 <br />



 
 <span class="mainli"  id="li_name">
    <LABEL class="desc" >Имя</LABEL> <input name="tolk_name" id="tolk_name" class=" "  size="20"  maxlength="90" />
    <BR class="clear" >
  </span>
   <label class="comment" id = "li_name_comment" style="display: none">Укажите имя</label> <BR class="clear" >


   
 <? if (!$tolk_parent){ ?>  

    <SPAN class="mainli"  id="li_phones" >
        <LABEL class="desc" >Телефон </LABEL>
         
        <INPUT name="tolk_phones"  class=" "  size="20"  maxlength="90" >
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment2"  id="li_phones_comment"  style="display: none" > С кодом города, через запятую (например 8 029 888-88-88) </LABEL>
       
      <BR class="clear" > 
   
   
   
   
   


  <span class="mainli"  id="li_email">
    <LABEL class="desc" >E-mail</LABEL> <input name="tolk_email" class=" "  size="20"  maxlength="90" />
    <BR class="clear" >
  </span>
   <label class="comment2" id = "li_email_comment" style="display: none">Введите электронный адрес, если желаете получить ответ</label> <BR class="clear" >
 
 


<? } ?>
 





 
 
 
 
 
 
 
 
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
select=document.getElementById('cat');
cat=select.options[select.selectedIndex].value;

if (cat==1) {
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






</script>
 
 
 
 
 
 
 
 
 
 
 </fieldset>
 
<div class="fieldset_separator"></div>

<div class="fieldset" style="  font-size:16px;">

<input type="Submit"   value="Добавить сообщение" class="button">
 <br><br></div> 
 
 
 
 
 
 
 
 
 
 </form>



</div>





















 		
	
	
	
			
	

  



	
<!-- content div end-->