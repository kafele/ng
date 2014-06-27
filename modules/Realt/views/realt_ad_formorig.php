
--------------------------------
<?
function myErrorHandler($errno, $errstr, $errfile, $errline) {
 
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
        case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />\n";
		echo "   on line $errline in file $errfile";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}

 set_error_handler("myErrorHandler");
?>

<script src="http://neagent.by/themes/neagent_style/javascript/neagent_form.js-" type="text/javascript"></script>
<script src="http://neagent.by/themes/neagent_style/javascript/tools.js" type="text/javascript"></script>

 <?


$edit=isset($edit) ? $edit: false;
$cash=isset($cash) ? $cash: false;




 if (!$userid ){
 $userid=0;
 if ($id_user){
 $userid=$id_user;
 }
 
 
 
 }
 
 
 
 ?>



<script type="text/javascript">

<? if ($verification_cats){ ?>
 
var verification_cats = [<?=$verification_cats;?>];
<? }else{ ?>
var verification_cats = [];

<? } ?>


	$(document).ready(function(){
	
 

 

 
  

 

   

    // Initialize ajax autocomplete:
var options, a;

 //jQuery(function(){
 //   options = { serviceUrl:'http://neagent.by/realt/autocomplete' };
 //   a = $('#street').autocomplete(options);
 //});

    
  jQuery(function(){   
 var a = $('#street').autocomplete({
 serviceUrl:'http://neagent.by/realt/autocomplete',
 minChars:2,
 //delimiter: /(,|;)\s*/, // regex or character
  maxHeight:300,
 width:300,
 zIndex: 9999,
 lookupLimit:10,
 lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
 deferRequestBy: 30, //miliseconds
 params: { country:'Yes' }, //aditional parameters
 noCache: false, //default is false, set to true to disable caching
 // callback function:
 onSelect: function(value, data){ 
 //alert('You selected: ' + value + ', ' + data); 
 },
 // local autosugest options:
 //lookup: ['January', 'February', 'March', 'April', 'May'] //local lookup values
 });
 
 });
 
 
 
 
 jQuery(function(){   
var a = $('#phoneinput').autocomplete({
serviceUrl:'http://neagent.by/realt/autocompletephone',
minChars:2,
 //delimiter: /(,|;)\s*/, // regex or character
maxHeight:300,
width:300,
zIndex: 9999,
lookupLimit:10,
lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
deferRequestBy: 30, //miliseconds
params: { country:'Yes' }, //aditional parameters
noCache: false, //default is false, set to true to disable caching
 // callback function:
onSelect: function(value, data){ 
 //alert('You selected: ' + value + ', ' + data); 
 },
 // local autosugest options:
 //lookup: ['January', 'February', 'March', 'April', 'May'] //local lookup values
 });
 
 });


 
 
 
 
 
 
 
 
  
 
 
 
  });
 
 
 
 
 
 
function liFormat (row, i, num) {
 	  var result = row[1] + " <em class='qnt'>" +
 	  row[2] + "  </em>";
  	  return result;
 	}
 
 function selectItem(li) {
 
 if( li == null ) var sValue = 'Ничего не выбрано!';
 if( !!li.extra ) var sValue = li.extra[1] + " "+ li.extra[0];
 else var sValue = li.selectValue;
  $('#street').val(sValue);
 
 
 	 
 	   //alert("Выбрана запись с ID: " + sValue);
 	}


</script>





 
<style>
.autocomplete-suggestions { border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }

_i_nput { font-size: 28px; padding: 10px; border: 1px solid #CCC; display: block; margin: 20px 0; }
</style>





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










<? if ($id_user>0){?>
<div style="float:right;"><form action='http://neagent.by/client' method='post'>
<input type='submit' name='submit_form' value='Выйти' />
</form></div>
Вы вошли на сайт и подаете объявление как <b><?=$username?></b>   <div class="clear:both; margin-bottom:24px;"> </div>

<?} else{?>

<? if ($edit!=true){?>
<div class="addpage_info">
Это форма для подачи объявления о жилье, офисах, домах на длительный срок и на сутки.
<BR>
Для подачи объявления "на сутки" ознакомьтесь с <A href="sutki-polisy" >правилами</A>
<BR>
 
</div>
<?}?>



<?}?>




<FORM style=" width:790px; "  method="post"  id="form_item" action="http://neagent.by/ad-form"  <? if ($edit!=true){?>onsubmit="return checkForm(this);<? }?>    " >
   
   
   
   
<? if ($edit!=true){?>
   <INPUT type="hidden"  name="act"  value="post" >
   <? if ($id_user>0){?>   <INPUT type="hidden"  name="id_user"  value="<?=$id_user?>" > <?}?>
   
<? }?>
<? if ($edit==true){?>
	<INPUT type="hidden"  name="act"  value="doedit" > 
	<INPUT type="hidden"  name="ad_id"  value="<?=$ad_id?>" >
<INPUT type="hidden"  name="ad_tab"  value="<?=$table?>" > 	
<? }?>	
	
	
    <INPUT type="hidden"  name="info[ad_code]" >
    <INPUT type="hidden"  name="c"  value="1" >
    <INPUT type="hidden"  name="cl" >
    <INPUT type="hidden"  name="p"  value="1" >
	<INPUT type="hidden"  name="evc"  value="<?=$evc?>" > 
	<INPUT type="hidden"  name="email"  value="<?=$useremail?>" > 
	 
	<INPUT type="hidden"  name="userid"  value="<?=$id_user?>" >
	
    <FIELDSET>
      <LEGEND>Основная информация</LEGEND>
	  <div class="legend-margin"></div>
	  
	  
	  
	  
	  
	    <SPAN id="li_type"  class="mainli" >
        <LABEL class="desc" >город *</LABEL>
         
        <DIV style="border:1px solid #fff; overflow: hidden; float:left;" >
          <SELECT id="сity"  name="ad_city" >
		  <?=$cityes?>
          </SELECT>
        </DIV>
      </SPAN><br>
      <LABEL id="li_city_comment"  style="display: none"  class="comment" >выберите город </LABEL>
       
      <BR class="clear" >
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
      <SPAN id="li_type"  class="mainli" >
        <LABEL class="desc" >рубрика *</LABEL>
         
        <DIV style="border:1px solid #fff; overflow: hidden; float:left;" >
          <SELECT id="cat"  name="cat"  onchange="komdiv();" <? if ($edit==true||$cash==true){?> <? }?>>
           <? if ($edit==true){?><OPTION value="<?=$ad_catid?>" >-рубрику изменить нельзя-</OPTION><? }?>
		   <? if ($edit!=true){?>
		   <OPTION value="0" >-выберите рубрику-</OPTION>
		    <?=$cats?>
			<? }?>
          </SELECT>
        </DIV>
      </SPAN><br>
      <LABEL id="li_type_comment"  style="display: none"  class="comment" >выберите рубрику для объявления </LABEL>
       
      <BR class="clear" >
	  
	  
	  
	  
	  
	  
	  
	  	 <div id="komm_options" style="display:none;">
	 
	 <SPAN id="komm_type"  class="mainli" >
        <LABEL class="desc" >тип помещения*</LABEL>
         
        <DIV style="border:1px solid #fff; overflow: hidden; float:left;" >
          <SELECT id="komm_opt"  name="ad_kommtype" >
 <option value="1" >Офис</option>
<option value="2" >Торговое помещение</option>
<option value="3" >Склад</option>
<option value="4" >Производственное помещение</option>
<option value="5" >Гараж</option>
<option value="6" >Земля</option>

          </SELECT>
        </DIV>
      </SPAN><br>
      <LABEL id="li_city_comment"  style="display: none"  class="comment" >выберите город </LABEL>
       
      <BR class="clear" >
	 </div>
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
      <DIV id="komdiv"   <? if ($edit!=true){?>class="hide"  style="display:none;" <? }?>>
     

	 

	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	  <BR class="clear" >
      <SPAN class="mainli"  id="li_ul" >
        <LABEL class="desc" >Улица <? if ($edit==true||$cash==true){?> (для "сдам", "продам") <? }?></LABEL>
         
        <INPUT name="street"  id="street"  class=" " type="text" size="20"  maxlength="90"  <? if ($edit==true||$cash==true){?> value="<?=$ad_street?>" <? }?>>
        <BR class="clear" >
      </SPAN>

	 
	 
	 
	 
	  <SPAN class="mainli diff"  id="li_komn" >
        <LABEL class="desc short2 alignr" >Дом</LABEL>
        
        <INPUT name="dom" id="xxx" type="text" class="short_90"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_dom?>" <? }?>>  
        <LABEL class="desc short2 alignr" >Корпус</LABEL>
         
        <INPUT name="korpus"  class="short_90"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_korpus?>" <? }?>>
	

		
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment2"  id="li_komn_comment"  style="display: none" >количество комнат в квартире и цена в долларах</LABEL>
       
      <BR class="clear" >
	  
	  
	  
	  
	 
	 
	 
	  
	 <SPAN class="mainli diff"  id="li_etazh" >
        <LABEL  class="desc short2 alignr" >Площадь<span id="pl_ob_label">&nbsp;общ.</span>:</LABEL>
        <INPUT name="pl_o" id="xxx" type="text" class="short"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_etazh?>" <? }?>>  
<span id="pl_span">
		<LABEL class="desc short2 alignr" >жилая:</LABEL>
        <INPUT name="pl_z"  class="short"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_etazhej?>" <? }?>>
<LABEL class="desc short2 alignr" >кухня:</LABEL>
        <INPUT name="pl_k"  class="short"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_etazhej?>" <? }?>>
</span>		
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment2"  id="li_etazh_comment"  style="display: none" >Площадь</LABEL>
       
      <BR class="clear" >
	  
	  
	  
	  
	  
	  
	  
	  <SPAN class="mainli diff"  id="li_etazh" >
        <LABEL class="desc short2 alignr" >Этаж</LABEL>
        
        <INPUT name="etazh" id="xxx" type="text" class="short_90"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_etazh?>" <? }?>>  
        
		<LABEL class="desc short2 alignr" >/&nbsp;Этажей&nbsp;всего</LABEL>
         
        <INPUT name="etazhej"  class="short_90"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_etazhej?>" <? }?>>
	

		
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment2"  id="li_etazh_comment"  style="display: none" >Этаж и кол-во этвжей в доме</LABEL>
       
      <BR class="clear" >

              
       
     





	  
        <LABEL id="li_ul_comment"  style="display: none"  class="comment" > Введите первые буквы названия, а затем выберите из списка нужную улицу </LABEL>
         
        <BR class="clear" >
         
        <SPAN class="mainli"  id="li_rayon" >
          <LABEL class="desc" >район города</LABEL>
           
          <DIV style="border:1px solid #fff; overflow: hidden; float:left;" >
            <SELECT name="ar" >
              <OPTION value="0" >- </OPTION>
              <OPTION value="1" >Центральный р-н </OPTION>
              <OPTION value="2" >Советский р-н </OPTION>
              <OPTION value="3" >Первомайский р-н </OPTION>
              <OPTION value="4" >Партизанский р-н </OPTION>
              <OPTION value="5" >Заводской р-н </OPTION>
              <OPTION value="6" >Ленинский р-н </OPTION>
              <OPTION value="7" >Октябрьский р-н </OPTION>
              <OPTION value="8" >Московский р-н </OPTION>
              <OPTION value="9" >Фрунзенский р-н </OPTION>
            </SELECT>
          </DIV>
          <BR class="clear" >
        </SPAN>
        <LABEL id="li_rayon_comment"  style="display: none"  class="comment" >выберите район города из списка</LABEL>
         
        <BR class="clear" >
        <SPAN class="mainli"  id="li_subarea" >
          <LABEL class="desc" >микрорайон </LABEL>
           
          <DIV style="border:1px solid #fff; overflow: hidden; float:left;" >
            <SELECT name="subar" >
              <OPTION value="0" >- </OPTION>
              <OPTION value="1" >Ангарская </OPTION>
              <OPTION value="2" >Брилевичи </OPTION>
              <OPTION value="3" >Великий лес </OPTION>
              <OPTION value="4" >Веснянка </OPTION>
              <OPTION value="5" >Восток </OPTION>
              <OPTION value="6" >Грушевка </OPTION>
              <OPTION value="7" >Домбровка </OPTION>
              <OPTION value="8" >Дражня </OPTION>
              <OPTION value="9" >Запад </OPTION>
              <OPTION value="10" >Зелёный Луг </OPTION>
              <OPTION value="11" >Каменная Горка </OPTION>
              <OPTION value="12" >Красный Бор </OPTION>
              <OPTION value="13" >Кунцевщина </OPTION>
              <OPTION value="14" >Курасовщина </OPTION>
              <OPTION value="15" >Лошица </OPTION>
              <OPTION value="16" >Малиновка </OPTION>
              <OPTION value="17" >Масюковщина </OPTION>
              <OPTION value="18" >Михалово </OPTION>
              <OPTION value="19" >Новинки </OPTION>
              <OPTION value="20" >Петровщина </OPTION>
              <OPTION value="21" >Ржавец </OPTION>
              <OPTION value="22" >Северный поселок </OPTION>
              <OPTION value="23" >Серебрянка </OPTION>
              <OPTION value="24" >Сокол </OPTION>
              <OPTION value="25" >Сосны </OPTION>
              <OPTION value="26" >Степянка </OPTION>
              <OPTION value="27" >Сухарево </OPTION>
              <OPTION value="28" >Уручье </OPTION>
              <OPTION value="29" >Шабаны </OPTION>
              <OPTION value="30" >Чижовка </OPTION>
              <OPTION value="31" >Юго-Запад </OPTION>
            </SELECT>
          </DIV>
          <BR class="clear" >
        </SPAN>
        <LABEL id="li_subarea_comment"  style="display: none"  class="comment" >выберите микрорайон из списка</LABEL>
         
        <BR class="clear" >
        
      </DIV>
	  <br>
	  
	  
      <SPAN class="mainli diff"  id="li_komn" >
        <LABEL class="desc short2 alignr" >Комнат *</LABEL>
        
        <INPUT name="komnat" id="xxx" type="text" class="short"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_komnat?>" <? }?>>  
        <LABEL class="desc short2 alignr" >Цена *</LABEL>
         
        <INPUT name="price"  class="short_90"  size="30"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_price?>" <? }?>>
	

	
		
		<select name="currency" class="select_short">
		<option value="1" <? if ($edit==true||$cash==true && $ad_currency==1){?> selected <? }?> > Рублей  </option>
		<option value="2" <? if ($edit==true||$cash==true && $ad_currency==2){?> selected <? }?> <? if ($edit!=true){?> selected <? }?>> Долларов </option>
		<option value="3" <? if ($edit==true||$cash==true && $ad_currency==3){?> selected <? }?>> Евро </option>
		</select>
		
		<select name="priceobject" class="select_short" id="priceobject" style="width:65px;display:none">
		<option value="1" <? if ($edit==true||$cash==true && $priceobject==1){?> selected <? }?>> За м2  </option>
		<option value="0" <? if ($edit==true||$cash==true && $priceobject==0){?> selected <? }?>> За все </option>
		</select>
		
		
		<br>
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment2"  id="li_komn_comment"  style="display: none" >количество комнат в квартире и цена в долларах</LABEL>
       
      <BR class="clear" >
	  
	  
	  
	  
	  
	  <div id="price2_3" <? if (($edit!=true)||($edit==true||$cash==true&&$table!='sutki')){?>class="hide"  style="display:none;" <? }?> style="clear:both;"><div class="clear" style="width:450px;"></div>
	   Цены в зависимости от срока проживания <i>(рекомендуем указать более 2 суток, и более 5 суток):</i><BR class="clear" >
	        <SPAN class="mainli diff"  id="li_komn" >
        <LABEL class="desc short5 alignr" >Более</LABEL>
        <INPUT name="ad_period2" id="xxx" type="text" class="short"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_period2?>" <? }?>> 
        <LABEL class="desc short5 alignl" >суток:</LABEL><LABEL class="desc short5 alignr" >Цена *</LABEL>
        <INPUT name="ad_price2"  class="short_90"  size="30"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_price2?>" <? }?>>
	

		<select name="currency2" class="select_short">
		<option value="1" <? if ($edit==true||$cash==true && $ad_currency==1){?> selected <? }?>> Рублей  </option>
		<option value="2" <? if ($edit==true||$cash==true && $ad_currency==2){?> selected <? }?>> Долларов </option>
		<option value="3" <? if ($edit==true||$cash==true && $ad_currency==3){?> selected <? }?>> Евро </option>
		</select>
		<br>
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment2"  id="li_komn_comment"  style="display: none" >количество комнат в квартире и цена в долларах</LABEL>
       
      <BR class="clear" >
	  
	  
	  
	  
	  	  
	        <SPAN class="mainli diff"  id="li_komn" >
        <LABEL class="desc short5 alignr" >Более</LABEL>
        <INPUT name="ad_period3" id="xxx" type="text" class="short"  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_period3?>" <? }?>> 
         <LABEL class="desc short5 alignl" >суток:</LABEL><LABEL class="desc short5 alignr" >Цена *</LABEL>
        <INPUT name="ad_price3"  class="short_90"  size="30"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_price3?>" <? }?>>
	

		<select name="currency2" class="select_short">
		<option value="1" <? if ($edit==true||$cash==true && $ad_currency==1){?> selected <? }?>> Рублей  </option>
		<option value="2" <? if ($edit==true||$cash==true && $ad_currency==2){?> selected <? }?>> Долларов </option>
		<option value="3" <? if ($edit==true||$cash==true && $ad_currency==3){?> selected <? }?>> Евро </option>
		</select>
		
		
		
		
		<br>
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment2"  id="li_komn_comment"  style="display: none" >количество комнат в квартире и цена в долларах</LABEL>
       
      <BR class="clear" >
	  
	  
	  
	  
	  
	  </div><!-- komdiv2-->
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	    <DIV id="sutki_komdiv"  <? if (($edit!=true)||($edit==true||$cash==true&&$table!='sutki')){?>class="hide"  style="display:none;" <? }?>>
	   <SPAN class="mainli"  id="li_spmest" >
       <LABEL class="desc" >Кол-во спальных мест</LABEL>
       <INPUT name="ad_spmest"  id="ad_spmest"  class=" "  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_sp_mest?>" <? }?>>
       <BR class="clear" >
       </SPAN>
       <LABEL class="comment"  id="li_spmest_comment"  style="display: none" >Кол-во спальных мест, например 2+1 (двуспальная кровать и один диван)</LABEL>
       <BR class="clear" >
	   </div>
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
      <SPAN class="mainli diff"  id="li_kdesc" >
        <LABEL class="desc alignr" >
          Текст (без телефонов)* <br>   
          <INPUT style="width:30px; display:none;"  readonly="readonly"  name="remainingChar"  size="3"  maxlength="3"  value="  "  type="text"  disabled="disabled" >
           
        </LABEL>
         
        <TEXTAREA name="content"  rows="10"  cols="50"  onBlur="sL(this.value)"    onkeydown="textCounter(this.form.content,this.form.remainingChar);"  onkeyup="textCounter(this.form.content,this.form.remainingChar);" ><? if ($edit==true||$cash==true){?><?=$ad_message?><? }?></TEXTAREA>
        <BR class="clear" >
      </SPAN>
      <LABEL class="comment"  id="li_kdesc_comment"  style="display: none" > Текст должен быть до 400 символов </LABEL>
       
      <BR class="clear" >
      <BR>
    </FIELDSET>
    <DIV class="fieldset_separator" ></DIV>
    <FIELDSET>
      <LEGEND>Контактные данные</LEGEND><div class="legend-margin"></div>
     
	 
	 
	 
	 
	 <SPAN class="mainli"  id="li_phones" >
     <LABEL class="desc" >Тел., в междунар. формате *</LABEL>
     <INPUT name="phones"  id="phoneinput" class=" "  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_phones?>" <? }else{?> value="375" <?}?>>
     <BR class="clear" >
     </SPAN>
     <LABEL class="comment2"  id="li_phones_comment"  style="display: none" > С кодом города, через запятую   </LABEL>
     <BR class="clear" >
	 <div id="phone_verification_block">
	 
	 
	 <table ><tr>
	 <td colspan=2 style="background-color:#cef3c0; padding:12px; width:420px;" >
	  В связи с большим количеством ложных объявлений и объявлений от мошенников и агентов-нелегалов  на сайте введена проверка номера телефона.
	  Это бесплатно для вас, и занимает 2 секунды.   
	 
	 <td></tr>
	 <tr>
	 <td width=300 style=" padding:12px; " >
	 
	 Введите номер телефона, нажмите кнопку "получить код"  и к вам на телефон придет смс с кодом. Код нужно ввести в  поле ниже:
	 </td>
	 <td   style=" padding:12px; ">
	  <input type="button" id="button_sendphone" style="width:170px;" onclick="sendphone();"  value =' получить СМС с кодом'>
	 </td></tr>
	 </table>
	 
	 
	
	 </div>
	 
	 
	 
	 <div id="phonecheck_result"></div> 
	 <div id="codecheck_result"></div> 
	 <SPAN class="mainli diff"  id="li_code" >
     <LABEL class="desc" >введите код из СМС</LABEL>
     <INPUT name="code"  id="codeinput" class="short_90"  size="20"  maxlength="90"  value="" >
	 <input type="button"  id="button_sendcode"   style="width:170px;" onclick="sendcode();"  value ='ОК'>
     
	  
	<BR class="clear" >
     </SPAN>
     <LABEL class="comment2"  id="li_code_comment"  style="display: none" > С кодом города, через запятую (например 8 029 888-88-88) </LABEL>
     <BR class="clear" >
	 
	 
	 <style>
	  #button_sendphone, #button_sendcode , #codeinput{
	  border:1px solid black;
	  
	  }
	 </style>
<script>

var phoneok=false;

function sendphone()
{ 
//Получаем параметры
var data = $('#phoneinput').val();
var user = <?=$userid?>;
  // Отсылаем паметры
  
  // alert(11);
	 
       $.ajax({
                type: "POST",
				dataType : "json", 
                url: "http://neagent.by/realt/verify_phone",
                data: "phone=" + data  + "&user=" + user, 
                // Выводим то что вернул PHP
                success: function(data) {
				var obj = $.parseJSON(data);
				// alert(data);
				//  alert("stat1=" + data.status);
				
switch (data.status)
{
  case "error": 
  html=data.description.text;
  break;
  case "ok": 
  $('#button_sendphone').hide();
  html=data.description.text;
  break;
  
  case "ok-cheked": 
  $('#button_sendphone').hide();
  html=data.description.text;
  $('#button_sendphone').hide();
  $('#li_code').hide();
  $('#phone_verification_block').hide();
  phoneok = true;
  html = "<div style='background-color:#b3f29a'>" + html + "</div>";
  
  
  break;
  
  default:
  html="Неизвестная ошибка. Попробуйте еще раз или обратитесь к администратору";  
}

html = "<div style='background-color:yellow'>" + html + "</div>";
				
				
				
 //предварительно очищаем нужный элемент страницы
                        $("#phonecheck_result").empty();
//и выводим ответ php скрипта
                        $("#phonecheck_result").append(html);
						$("#phonecheck_result").show();
				 setTimeout(function(){$("#phonecheck_result").fadeOut('fast')},20000);  //30000 = 30 секунд	
						
						
						
						
                },
				
				error: function(data) {
				 sendLog("ОШИКА верификации" + data , " " );

				 //alert('err'); 
				 
				 }
				
				
				
				
        });
	//$('#button_sendphone').hide();
}

function sendcode()
{
//Получаем параметры
var code = $('#codeinput').val();
var data = $('#phoneinput').val();
var user = <?=$userid?>;
  // Отсылаем паметры
       $.ajax({
                type: "POST",
				dataType : "json", 
                url: "http://neagent.by/realt/do_verify_phone",
                data: "phone=" + data  + "&user=" + user   + "&code=" + code , 
                // Выводим то что вернул PHP
                success: function(data) {
				
				var obj = $.parseJSON(data);
				//alert(data);
				//alert("stat1=" + data.status);
				
switch (data.status)
{
  case "error": 
  html=data.description.text;
  html = "<div style='background-color:yellow'>" + html + "</div>";
 
  break;
  case "ok": 
  $('#button_sendphone').hide();
  $('#li_code').hide();
  $('#phone_verification_block').hide();
  phoneok = true;
  
  
  html=data.description.text;
  html = "<div style='background-color:#b3f29a'>" + html + "</div>";
  break;
  
  default:
  html="Неизвестная ошибка. Попробуйте еще раз или обратитесь к администратору"; 
  html = "<div style='background-color:yellow'>" + html + "</div>";
}




 //предварительно очищаем нужный элемент страницы
                        $("#codecheck_result").empty();
//и выводим ответ php скрипта
                        $("#codecheck_result").append(html);
						
						//setTimeout(function(){$("#codecheck_result").fadeOut('fast')},20000);  //30000 = 30 секунд
						
	
						
                }
        });
	
}
</script>	 
	 
	
	 
	 <SPAN class="mainli"  id="li_name" >
     <LABEL class="desc" >Имя </LABEL>
     <INPUT name="ad_name"  id="ad_name"  class=" "  size="20"  maxlength="90" <? if ($edit==true||$cash==true){?> value="<?=$ad_contactname?>" <? }?>>
     <BR class="clear" >
     </SPAN>
     <LABEL class="comment"  id="li_name_comment"  style="display: none" > Ваше имя для связи</LABEL>
     <BR class="clear" >
	  
      
	  <? if ($edit==true||$cash==true){?>
	  <? if ($mlev==$mlev){ ?>
	  
	 <SPAN class="mainli"  id="li_name" >
     <LABEL class="desc" >Email   </LABEL> <?=$ad_email?> 
     <BR class="clear" >
     </SPAN>
     
     <BR class="clear" >
	  
	  <?} ?>
	  <?} ?>
	  
    
       
      <BR class="clear" >
    </FIELDSET>
    <DIV class="fieldset_separator" ></DIV>

	
	
	
	
	
	
	
	
	
	 <?  if (4==4){?>
	<DIV id="showoptions"  class="hide"  style="display:none;" >
	 
    <FIELDSET>
    <LEGEND>Настройки показа (эксперимент)</LEGEND><div class="legend-margin"></div>
	Не хотите получить шквал звонков от агентов и любопытных? Настройте показ ваших объявлений. <br>
	Мы разрабатываем прототип этой функции, и ждем от вас предложений и пожеланий. <br>
    <input type="radio" name="showto" value="true" style="width:20px; border:0; margin:0; "><b>
	Показывать только тем, кто ищет такой вариант</b> 
	(лучше выберите этот пункт - тогда ваши телефоны не будут показаны каждому 
	 и вряд ли попадут в лапы и базы агентов <a id = "more1" href='#data_more1'>подробнее...</a>)<BR>
	
	<div style="display:none"><div id="data_more1" style="width:450px"><p>При выборе этой опции, ваш телефон будет показан только тем, кому, 
	 по мнению системы, можно доверять. Это те, кто разместил здесь объявление, а также зарегистрированные и проверенные 
	 пользователи. </p>
<p>Агенты, а также заблокированные по разным причинам пользователи  ваш номер не увидят.
</p>
<center><img src="http://neagent.by/themes/neagent_style/assets/images/neagent-howitworks2.gif"></center>
<a href="javascript:;" class="closetip" onclick="$.fancybox.close();">Закрыть</a></div></div>
	<input type="radio" name="showto" value="true2" style="width:20px;border:0; margin:0;"><b>
	Показывать В ПЕРВУЮ ОЧЕРЕДЬ тем, кто ищет такой вариант</b> 
	(сначала телефоны увидят реальные пользователи, которые ищут такой вариант. 
	Через несколько часов объявление переместится в открытый доступ. <a  id = "more2"  href='#data_more2'>подробнее...</a>)<BR>
	 
	 <div style="display:none"><div id="data_more2" style="width:450px">
	 <p>При выборе этой опции, ваш телефон будет показан, как и при выборе предыдущего пункта, только тем, кому мы доверяем.
	 но после нескольких часов оно станет доступно и всем остальным пользователям.</p>
	 <p>Таким образом, если вашим объявлением никто не заинтересовался сразу, 
	 оно становится доступным для всех, и у вас увеличиваются шансы найти желающего на ваше предложение. 	 
	 </p>
	 
	 
	 
	 <a href="javascript:;" class="closetip" onclick="$.fancybox.close();">Закрыть</a></div></div>
	
	
	<input type="radio" name="showto" value="all" style="width:20px;border:0; margin:0;"><b>Показывать всем</b> 
	(ваше объявление будет опубликовано, как обычно. 
	Берегитесь - агенты могут оборвать телефон звонками, их тут сотни).<BR> 
 
    
  

<script type="text/javascript">
		$(document).ready(function() {
		
		
		$("#more1").fancybox({
		'modal' : true,
		'width'   : 350
	});
		$("#more2").fancybox({
		'modal' : true,
		'width'   : 350
	});
		
		
		
		
		});
	</script>
	
	
	</FIELDSET>
	

	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<?} ?>
	
	
 
	<DIV id="author_tags"  class="hide"  style="display:none;" >
    <FIELDSET>
    <LEGEND>Добавить метки к объявлению</LEGEND><div class="legend-margin"></div>
	Добавьте метки, чтобы людям было легче найти ваше объявление <br>
	 
	 
	  
	
	
	</FIELDSET>
	

	</div>
	
	
	
	
	
	
	
	
	
	
	
    <DIV class="fieldset_separator" ></DIV>
	
	
	
	
	
	
	
 
 
	
<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/jquery.tools.js"></script>
<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/additem.js"></script>
<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/ajaxupload.js"></script>
<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/common.js"></script>
<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/jquery.bigframe.js"></script>
 
<link rel="stylesheet" href="http://neagent.by/themes/neagent_style/assets/css/additem.css" />
	
	
	
	
	
	<? if ($edit!=true){?>
	
	
	<div id="photo_alert" style="display:none; padding:9px; color:red;">Загрузите фотографии вашей квартиры! Это избавит и вас и желающих от пустых звонков, и скорее привлечет желающих! Лучше один раз увидеть!</div>
	
	
	
	
	
	
	
	            <div id="f_images">
                <label for="fld_images">Фотографии:</label>
                <input type="file" name="Filedata" id="fld_images" value="image" />
                <span id="fld_images_toomuch" style="line-height:22px;color: gray; font-style: italic; display: none;">Вы добавили максимально возможное количество фотографий</span>
            </div>
                        <div id="files" class="images" style="display:none">
                                <div id="progress" style="display: block;">
                    <table cellpadding="0" cellspacing="0"><tr><td>
                        <img alt="Идёт загрузка..." src="http://tolkuchka.by/themes/tolk/assets/images/ajax-loader.gif" /> Загрузка 
                    </td></tr></table>
                </div>
				
				
				  
				
				
				
            </div>
	
	 <? } else{?>
	
	
	     <div id="f_images">
                <label for="fld_images">Фотографии (редактирование) : <?=(count($ad_pictures));?></label>
                <input type="file" name="Filedata" id="fld_images" value="image" />
                <span id="fld_images_toomuch" style="line-height:22px;color: gray; font-style: italic; display: none;">Вы добавили максимально возможное количество фотографий</span>
            </div>
                 <div id="files" class="images" <? if (count($ad_pictures)==0){?> style="display:none" <?}?>>
                    
					<? if (count($ad_pictures)>0){?>
					<? foreach ($ad_pictures as $ad_picture) { ?>
					<div>
					<input type="hidden" name="images[]" value="<?=$ad_picture;?>" />
					<table cellpadding="0" cellspacing="0"><tr><td><img src="http://neagent.by/modules/Realt/files/t_<?=$ad_picture;?>" alt="" /></td></tr></table>
					<a class="aj delete" onclick="$(this).parent().remove();"><span>удалить</span></a>
					</div>
					
					<?}?>
					<?}?>
					
					<div id="progress" style="display: none;">
                    <table cellpadding="0" cellspacing="0"><tr><td>
                    <img alt="Идёт загрузка..." src="http://tolkuchka.by/themes/tolk/assets/images/ajax-loader.gif" /> Загрузка 
                    </td></tr></table>
                   </div>
				   
            </div>
	
	
	
	
	
	
	
	<script>
	  $('<div></div>')
            .append('<input type="hidden" name="images[]" value="'+<?=$ad_mainpic;?>+'" />')
            .append('<table cellpadding="0" cellspacing="0"><tr><td><img src="'+ <?=$ad_mainpic;?> +'" alt="" /></td></tr></table>')
            .append(
                $('<a class="aj delete"><span>удалить</span></a>').click(function(){
                    $(this).parent().remove();
                    
                    if ($('#files div').size() < 6)
                    {
                        $('#fld_images_toomuch').hide();
                        $('#fld_images').show();
                    }
                    
                    if ($('#files div').size() == 1)
                        $('#files').hide();
                    
                    return false;
                })
            ).insertBefore('#progress');
        
        if ($('#f_images .images a').size() == 5)
        {
            $('#fld_images').hide();
            $('#fld_images_toomuch').show();
        }
        
        if ($('#files div').size() > 5)
        {
            $('#fld_images').hide();
            $('#fld_images_toomuch').show();
        }
	</script>
	
	
	
	
	
	
	
	
	
	
	<? } ?>
	
	
	
    <DIV class="fieldset"  style="  font-size:16px;" >
     
    
	
<? if ($edit!=true){?>
	 
	 
	

      <B>
      Ваше объявление станет доступно для всеобщего просмотра не сразу, а через 12 минут. 
      <BR>
      </B>
      <br><b>Размещая объявление, вы подтверждаете, что не оказываете платных услуг по показу, подбору жилья, посреднических услуг в сфере недвижимости.</b>  
      <BR>
	  Объявления от агентств в настоящее время не публикуются. 
 


	  
<div style="padding-bottom:9px;padding-top:9px;">


<div id='sutkiinfo_komdiv' style = 'display:none;'>

Для объявлений "на сутки" вам будет выставлен счет на оплату в следующем окне.

</div> 
<div id='longterminfo_komdiv'>
Удалить через <input type="text" name='srok' style="width:40px;" value="14" > дней.</div>
</div> 


   
	 <? if ($mlev==4){?>
     <div>Для UID (шаблон UID=233444;IP=344444;)<input type="text" name='for' style="width:120px;" value="" > </div>
	 
	  <? }?> 
	  
	  <INPUT type="Submit"  id="frm_submit" onclick="javascript: fillul(); "  value="Опубликовать объявление"  class="button" >
	  <div id="submitAlert" style="color:#ffff33;  "></div>
	 <? }?>  
	 <? if ($edit==true){?> 
	 
<? if ($table=='sutki'){?>
	   
        При проблеме с загрузкой фотографий  сообщите на info@neagent.by. 
<BR><BR>       
	 <? }?>
	 
	 
	 <INPUT type="Submit"  onclick="javascript: fillul(); "  value="Сохранить изменения"  class="button" >
	  <? }?>  
	  
	  
	  
      
    </DIV>
	
	<input type="hidden" id="public_input" name="public" value="allow"/>

 </FORM>

 
 
  <small>

<BR>
При публикации объявлений на "Сниму" в рубрику "Сдаю"  все  объявления с этого IP адреса будут удалены и пользователь будет  забанен на срок 1 месяц.
      <BR>
При публикации номера телефона в тексте объявления, а не в специальном поле для телефонов,  объявление не будет напечатано.
	  <BR>
   
</small>
  


<script language="javascript" type="text/javascript">

<? if ($edit!=true){?>
document.getElementById('fld_images').disabled = true;
document.getElementById('frm_submit').disabled = true;
document.getElementById('submitAlert').innerHTML = "Вы не выбрали рубрику!";
<?} ?>

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

if ((cat==1)||(cat==3)||(cat==11)||(cat==13)||(cat==7)||(cat==8)||(cat==15)||(cat==16)) {
document.getElementById('komdiv').style.display = "block";
if ((cat!=7)||(cat!=8)||(cat!=15)||(cat!=16)){
document.getElementById('photo_alert').style.display = "block";
}

 
}
else{
 document.getElementById('komdiv').style.display = "none";
 document.getElementById('photo_alert').style.display = "none";
}



if ((cat==1)||(cat==3)) {
document.getElementById('showoptions').style.display = "block";
}
else{
document.getElementById('showoptions').style.display = "none";
}


if ((cat==7)||(cat==8)||(cat==15)||(cat==16)) {
 document.getElementById('komm_options').style.display = "block";
 document.getElementById('pl_span').style.display = "none";
 document.getElementById('pl_ob_label').style.display = "none";
 document.getElementById('priceobject').style.display = "inline";
 
}
else{
document.getElementById('komm_options').style.display = "none";
document.getElementById('pl_span').style.display = "inline";
document.getElementById('pl_ob_label').style.display = "inline";
 document.getElementById('priceobject').style.display = "none";
}




if ((cat==11)||(cat==12)) { //sytki
$uploadscript='http://neagent.by/realt/upload/sutki'; // если сутки
document.getElementById('sutki_komdiv').style.display = "block";
document.getElementById('price2_3').style.display = "block";
document.getElementById('sutkiinfo_komdiv').style.display = "block";
document.getElementById('longterminfo_komdiv').style.display = "none";
}
else{

$uploadscript='http://neagent.by/realt/upload/default'; // если обычная загрузка
document.getElementById('sutki_komdiv').style.display = "none";
document.getElementById('price2_3').style.display = "none";
document.getElementById('longterminfo_komdiv').style.display = "block";
document.getElementById('sutkiinfo_komdiv').style.display = "none";
}

document.getElementById('fld_images').disabled = false;
document.getElementById('frm_submit').disabled = false;
document.getElementById('submitAlert').innerHTML = "";

//





if (verification_cats.length>0) { 
if (("#" + verification_cats.join("#,#") + "#").search(cat) != -1) {
// verification need
  
  $('#button_sendphone').show();
  $('#li_code').show();
  $('#phone_verification_block').show();
  phoneok = false;
}
else{
  
  $('#button_sendphone').hide();
  $('#li_code').hide();
  $('#phone_verification_block').hide();
  phoneok = true;
}
}






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


































function screenHeight(){
return  jQuery.browser.opera? window.innerHeight : jQuery(window).height();
}


function alert_up(text) {

if (jQuery('#alert_mess')) {
    jQuery('#alert_mess').html(text);
	}
	
if (jQuery('#alert_panel')) {

 


	var scrollY = (window.scrollY) ? window.scrollY : document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
	
	sh=screenHeight()
	scrollY = scrollY + sh/2-150;
	 
	
	//alert (scrollY);
  
 jQuery('.alert_panel').css( {'margin-top': scrollY} ); //для IE 

}

	
	
	
 //alert("up")
  // alert('#area_pop_'+cur_form)
	if (!jQuery('#alert_pop')) return false;
					//$('#area_pop').className = 'up';
	jQuery('#alert_pop').addClass('up');
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
jQuery("#li_komn").removeClass(' redborder');
jQuery("#li_phones").removeClass(' redborder');
jQuery("#li_type").removeClass(' redborder');
//alert  (  jQuery("#li_kdesc").attr('className') );
jQuery("#li_kdesc").removeClass(' redborder');
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

 function sL(message){
 
 sendLog(" typed= " + message, "")
 
 }
 
 
 

function sendLog(errmessage, text){

//Получаем параметры
 
var user = <?=$userid?>;

  // Отсылаем паметры
       $.ajax({
                type: "POST",
				dataType : "json", 
                url: "http://neagent.by/realt/logError",
                data: "mess=" + errmessage  + "&user=" + user   + "&text=" + text , 
                // Выводим то что вернул PHP
                success: function(data) {
				
var obj = $.parseJSON(data);
//alert(data);
				//alert("stat1=" + data.status);
				
switch (data.status)
{
  case "error": 
  html=data.description.text;
  html = "<div style='background-color:yellow'>" + html + "</div>";
 
  break;
  case "ok": 
  //$('#button_sendphone').hide();
  //$('#li_code').hide();
  //$('#phone_verification_block').hide();
  //phoneok = true;
  
  
  html=data.description.text;
  html = "<div style='background-color:#b3f29a'>" + html + "</div>";
  break;
  
  default:
  //html="Неизвестная ошибка. Попробуйте еще раз или обратитесь к администратору"; 
  //html = "<div style='background-color:yellow'>" + html + "</div>";
}




 //предварительно очищаем нужный элемент страницы
                        $("#codecheck_result").empty();
//и выводим ответ php скрипта
                        $("#codecheck_result").append(html);
						
						//setTimeout(function(){$("#codecheck_result").fadeOut('fast')},20000);  //30000 = 30 секунд
						
	
						
                }
        });

}





function checkForm(form) {

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
 12 : "Телефоны должны быть в международном формате, например  375 29 7112233",
 13 : "Похоже, вы ошиблись с ценой или валютой, проверьте еще раз, таких цен не бывает.",
 14 : "Требуется подтверждение номера телефона"
 //13 : "Объявления о продаже договоров с агентствами запрещены. Отнеситесь с пониманием, это портит репутацию сайта neagent.by"
 }
 // Получаем семейство всех элементов формы
 // Проходимся по ним в цикле
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
 
 
 
 

 
 if (el.name == "price" && value != "" ) {
 selectedCurrency=form.elements["currency"].value;
 if (selectedCurrency==1&&value<10000){
  errorList.push(13); hlElement("li_komn");
 }
 

 
 };
 
 
 
if (el.name == "komnat" && value == "") {errorList.push(7); hlElement("li_komn")};
if (el.name == "komnat" && value != "" &&  (IsNumeric(value.trim())==false &&  value.indexOf("-")==-1 )) {
errorList.push(8); hlElement("li_komn")
};

if (el.name == "price" && value == "") {errorList.push(9);hlElement("li_komn")};

if (el.name == "price" && value != "" &&  (IsNumeric(value.trim())==false &&  (value.indexOf("-")==-1 )&&(value.indexOf("до")==-1) )) {
errorList.push(10); hlElement("li_price")
};


 
if (el.name == "phones" && value == "") {errorList.push(11);hlElement("li_phones")};
if (el.name == "phones" && value != "" && getDigits(value)<10) {errorList.push(12);hlElement("li_phones")};

 
if (el.name == "ad_email" && value == ""){ errorList.push(2)};
break;
case "file" :
//if (value == "") errorList.push(3);
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
 
//проверка на соответствие рубрики
selectedCat=form.elements["cat"].value;
//alert (selectedCat);
var errorCatList = [];

var snimuArr = {
 1 : "сниму",
 2 : "снимет",
 3 : "снимем",
 4 : "снять",
 5 : "своевременную оплату гарантируем"
} 
val= value.toLowerCase()
for  (var k=0;k<5+1 ;k++){
dd = val.indexOf(snimuArr[k]);
if ((dd>-1) && ((selectedCat==1)||(selectedCat==3) ) ){
errorCatList.push("Вы пытаетесь дать объявление с текстом '" + snimuArr[k] +"' в рубрику 'сдаю'. Измените рубрику на 'сниму'.<br> </i><b>При подаче объявления не в свою рубрику, я удалю все ваши объявления, и блокирую на 2 недели!</b><i>");
hlElement("li_type");
}
}
 
 
var podselenieArr = {
 1 : "на подселение",
 2 : "возьмем на подселение",
 3 : "подселюсь", 
 4 : "ищу на подселение"
 } 


for  (var k=0;k<4+1 ;k++){
dd = val.indexOf(podselenieArr[k]);
if ((dd>-1) && ((selectedCat!=9)&&(selectedCat!=10) ) ){
errorCatList.push("Вы пытаетесь дать объявление о подселении. Выберите рубрику 'Возьму на подселение' или 'подселюсь'");
hlElement("li_type");
}
}
 
// selectedCat=form.elements["cat"].value;
//alert (selectedCat);

var dogovorArr = {
 1 : "продам договор",
 2 : "продаю договор",
 3 : "продам документ",
 4 : "продам официальный документ",
 5 : "продам официальный до",
 6 : "отдам договор с аге"
 } 
 
 
val= value.toLowerCase()
for  (var k=0;k<6+1 ;k++){
dd = val.indexOf(dogovorArr[k]);
if (dd>-1) {
errorCatList.push("Объявления о продаже договоров с агентствами запрещены. Отнеситесь с пониманием, это портит репутацию сайта neagent.by. Такие объявления будут удаляться, а ваш телефон попадет в черный список.");
hlElement("li_type");
}
}
 
 
 
//

 
 } else if (elName == "select") { // SELECT
if (el.name == "cat" && value == "0"){ errorList.push(6);hlElement("li_type")};
  
//if (value == 0) errorList.push(5);
} else {
// Обнаружен неизвестный элемент ;)
}
 }
 
 
 if (phoneok==false){errorList.push(14); hlElement("li_phones")};
 
 
 
 // Финальная стадия
 // Если массив ошибок пуст - возвращаем true
 if ((!errorList.length)&&(!errorCatList.length)) return true;
 // Если есть ошибки - формируем сообщение, выовдим alert
 // и возвращаем false
 var errorMsg = "<h2>При заполнении формы допущены следующие ошибки:</h2>";
 for (i = 0; i < errorList.length; i++) {
 errorMsg += errorText[errorList[i]] + "<br>";
 }
 
 //  сообщения о неверной рубрике
 for (i = 0; i < errorCatList.length; i++) {
 errorMsg += "<i style='color:#2972b5;'>" + errorCatList[i] + "</i><br>";
 }
 
 
mess=form.elements["content"].value;
phones=form.elements["phones"].value; 
komnat=form.elements["komnat"].value;  
price=form.elements["price"].value; 

 
sendLog(errorMsg , " ТЕКСТ: " + mess +   "; КОМНАТ: " + komnat + "; ЦЕНА: " + price +  "; ТЕЛ: " + phones);
 
 
alert_up(errorMsg);
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



function TrimStr(s) {
  s = s.replace( /^\s+/g, '');
  return s.replace( /\s+$/g, '');
}


</script>
 
 
 
 
 
 
 
 
 
<script language="javascript" type="text/javascript">

$(document).ready(function(){
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
vv=$('bit-0').innerHTML;
$('ul-demoinput').value=vv;
$('ul-demo').value=vv;
// alert($('ul-demoinput').value)
}

</script>
 
 
 
 
 
 
 
 
 
 
 
 <br style="clear:both;"> <br> <br> <br> <br> <br> <br> <br >
 Предлагаем  также <a href="http://tolkuchka.by/podat-obyavlenie/" title="Подать объявление бесплатно">подать объявление  на tolkucka.by</a>  - злектронный базар Беларуси
 