<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//$str_add .="<div><h1>Страница поиска тестируется.</h1>Возможны некоторые недоработки, связанные с переходом на новую версию сайта. В ближайшее время все будет исправлено.</div>";

 


///  ПОЛУЧАЕМ ПАРАМЕТРЫ 
$areasArray =isset($_GET['ar']) ? $_GET['ar'] : array();
$arr_values=array();
if (isset($_GET['ar'])){foreach ($areasArray as $i => $value) {
if ($value){array_push($arr_values,$value);}}}

$subareasArray =isset($_GET['subar']) ? $_GET['subar'] : array() ;
$subarr_values=array();
if (isset($_GET['subar'])){foreach ($subareasArray as $i => $value) {
if ($value){array_push($subarr_values,$value);}}}
$city=$_GET['city'];
if ( $city == ""){
$city=1;
} 

$sort=$_GET['sort'];



$k1=isset($_GET['k1']) ? $_GET['k1'] : false;
$k2=isset($_GET['k2']) ? $_GET['k2'] : false;
$k3=isset($_GET['k3']) ? $_GET['k3'] : false;
$k4=isset($_GET['k4']) ? $_GET['k4'] : false;
$k5=isset($_GET['k5']) ? $_GET['k5'] : false;
$k6=isset($_GET['k6']) ? $_GET['k6'] : false;
$k0=isset($_GET['k0']) ? $_GET['k0'] : false;
$k1=($k1=="on")?1:0;
$k2=($k2=="on")?1:0;
$k3=($k3=="on")?1:0;
$k4=($k4=="on")?1:0;
$k0=($k0=="on")?1:0;

$firstad=isset( $_GET['first'] ) ? $_GET['first']: false;

$priceMin=isset($_GET['priceMin'] ) ? $_GET['priceMin'] : false;
$priceMax=isset($_GET['priceMax'] ) ? $_GET['priceMax'] : false;

$withcontent=$_GET['withcontent'];
if ($withcontent==" "){$withcontent="";};

$postdate=isset($_GET['postdate']) ? (int)$_GET['postdate'] : 0 ;

$priceMinrequest=$priceMin;//
$priceMaxrequest=$priceMax;

$priceMin = (int)$priceMin;
$priceMax = (int)$priceMax;


if ($priceMax==0){$priceMax=500000000000;};

// выбираем категорию 
$formtype=isset($_GET['formtype']) ? $_GET['formtype'] : false;
$prtype=isset($_GET['prtype']) ? $_GET['prtype'] : false;
$komm_type=isset($_GET['komm_type']) ? $_GET['komm_type'] : false;



$nobject=isset($_GET['nobject']) ? $_GET['nobject'] : false;
$type=isset($_GET['type']) ? $_GET['type'] : false;









if ($this->data['mlev']==4) {
$this->data['debug'] .= "areasArray=" . count($areasArray);


 
}




//и формируем строку
$str_searched="";
$str_searched .="показаны ";
if ($formtype=="kom"){
$str_searched .="комнаты ";
}

if ($formtype=="kv"){


switch ($k1.$k2.$k3.$k4) {
case '0000':
$str_searched .="все квартиры "; break;
case '0001':
$str_searched .="4-комнатные "; break;
case '0010':
$str_searched .="3-комнатные "; break;
case '0011':
$str_searched .="3-4-комнатные "; break;
case '0100':
$str_searched .="2-комнатные "; break;
case '0101':
$str_searched .="2- и 4-комнатные "; break;
case '0110':
$str_searched .="2-3-комнатные "; break;
case '0111':
$str_searched .="2-4-комнатные "; break;
case '1000':
$str_searched .="1-комнатные "; break;
case '1001':
$str_searched .="1- и 4-комнатные "; break;
case '1010':
$str_searched .="1- и 3-комнатные "; break;
case '1011':
$str_searched .="1-,3- и 4-комнатные "; break;
case '1100':
$str_searched .="1-2-комнатные "; break;
case '1101':
$str_searched .="1-,2- и 4-комнатные "; break;
case '1110':
$str_searched .="1-3-комнатные "; break;
case '1111':
$str_searched .="все "; break;
}
if ($k1==1||$k2==1||$k3==1||$k4==1||$k5==1){
$str_searched .=" квартиры ";
}
}


if ($priceMin == 0 && $priceMax==500000000000){
$str_searched .=" по любой цене ";
}

if ($priceMin == 0 && $priceMax!=500000000000){
$str_searched .=" по цене до " . $priceMax . " $";
}

if ($priceMin !=0 && $priceMax==500000000000){
$str_searched .=" по цене от " . $priceMin . " $";
}

if ($priceMin !=0 && $priceMax!=500000000000){
$str_searched .=" по цене " . $priceMin . "-" . $priceMax .  " $";
}

 
 
 
if (count($arr_values) >0 || count($subarr_values) >0){
 $str_searched .=" в выбранных районах  " ;
 }
 else{
  $str_searched .=" во всех районах  " ;
 
 }
 
 

if ($withcontent !="")
 {
 $str_searched .=" с текстом «". $withcontent  .  "»";
 }

 
if ($postdate !=0)
{
 $str_searched .=" за последние ". $postdate  .  " дней";
}









/// показываем  форму поиска  заполненную
if ($priceMin==0){$priceMinForm="";}else{$priceMinForm=$priceMin;};
if ($priceMax==0){$priceMaxForm="";}else{$priceMaxForm=$priceMax;};
 $addata = array(
 'priceMin' => $priceMinForm,
 'priceMax' => $priceMaxForm,
 'k1' => $k1,
 'k2' => $k2,
 'k3' => $k3,
 'k4' => $k4,
 'k0' => $k0,
 'withcontent' =>$withcontent,
 'formtype' =>$formtype,
 'prtype' =>$prtype,
 'postdate' =>$postdate,
 
   
 'areasArray'  => $areasArray,
 'subareasArray'  =>$subareasArray
 
 );
 
 
 
 
 
 
 $this->data['searchform']= $CI->parser->parse($this->data['$searchform_view'], $addata);
 
 
if ($this->data['wap_view']==1){
 $this->data['searchform']="<div style='display:none;'>" .  $this->data['searchform'] ."</div>";
 }
 
 
 
 
 
if ( $formtype==false && $nobject!=false){
 
  $table ="ads"; // по умолчанию. на сутки переопределяется ниже 
switch($nobject . "/" . $type){
			case '1/1':$cat_id=1; break;
			case '1/2':$cat_id=2; break;
			case '1/5':$cat_id=13; break;
			case '1/6':$cat_id=14; break;
            case '2/1':$cat_id=3; break;
			case '2/2':$cat_id=4; break;
			case '2/4':$cat_id=9; break;
			case '2/3':$cat_id=10; break;
			case '4/1':$cat_id=7; break;
			case '4/2':$cat_id=8; break;
			case '4/5':$cat_id=15; break;
			case '4/6':$cat_id=16; break;
			case '1/7':$cat_id=11; $table="sutki" ; break;
			 
			default: $cat_id=1; break;
			 }
 
 
} 
 else{


$table ="ads"; // по умолчанию. на сутки переопределяется ниже 
switch($formtype . "/" . $prtype){
			case 'kv/arenda':$cat_id=1; break;
			case 'kv/arendac':$cat_id=30; break;
			case 'kv/snimu':$cat_id=2; break;
			case 'kv/prodam':$cat_id=13; break;
			case 'kv/kuplu':$cat_id=14; break;
            case 'kom/arenda':$cat_id=3; break;
			case 'kom/podselenie_pr':$cat_id=9; break;
			case 'kom/podselenie_spr':$cat_id=10; break;
			case 'kn/sdam':$cat_id=7; break;
			case 'kn/snimu':$cat_id=8; break;
			case 'kn/prodam':$cat_id=15; break;
			case 'kn/kuplu':$cat_id=16; break;
			case 'su/su_kv':$cat_id=11; $table="sutki" ; break;
			case 'kv/arenda':$cat_id=1; break;
			default: $cat_id=1; break;
			 }

}			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			
$limit=77;
$from=0;




$mapview =$this->data['map_view'];

if ($this->data['wap_view']!=1){

if ($this->data['showmap'] && $mapview==1){
$mparams = array(
	'city' => 1,
	'postdate' => '0',
	'cat' =>  -1
            );
	$str_add .= get_map_params($mparams); //получает параметры для передачи в карту
	$str_add .= get_map_code();   //получает код вставки карты
	}
 
 
 
 
 
 $currentpageUrl=$_SERVER['REQUEST_URI'];
$str_add .= get_detailTab_code($currentpageUrl , $this->data['map_view']);
 
 
 
 
}











 


















if ($table=="ads"){ 
$realt_currency_rate=config_item('realt_currency_rate');
$priceMin = (int)$realt_currency_rate[1] * $priceMin;
$priceMax = (int)$realt_currency_rate[1] * $priceMax;
}



if ($sort!=false){

//echo ('sore=' . $sort); ////

//echo(''); ////
switch ($sort) {
case '1':
$order="ad_up_date";
$ordertype='desc'; break;
case '2':
$order="ad_price";
$ordertype='acs';break;
case '3':
$order="ad_price";
$ordertype='desc';break;
default:
$order="ad_date";
$ordertype='desc';break;
}


//echo (' order=' . $order); ////


}
else{

$order="ad_up_date";
$ordertype='desc'; 
}







$ad_show=1; // сделать в зависимости от mlev

$CI =& get_instance();

///////////// начало  создания запроса  
include 'inc_searchquery.php';
//  конец создания запроса





//pagination
$CI->load->library('pagination');
$countresults=$CI->db->count_all_results();
$allresults=$countresults;
$config['total_rows'] = $CI->db->count_all_results();
$config['per_page'] =    (config_item('realt_ads_per_page')>0)?config_item('realt_ads_per_page'): 25;   //  выводить на страницу

if ($table == "sutki") {
     $config['per_page'] = (config_item('realt_ads_per_page_sutki') > 0) ? config_item('realt_ads_per_page_sutki') : $config['per_page']; //  выводить на страницу сутки
}



		
		$config['num_links'] = 6;    //  количество ссылок - косметический параметр
		$config['padding'] = 1;
		$config['first_link'] = 'В начало';
		$config['last_link'] = 'В конец';
$limit=$config['per_page'];


if ($this->data['mlev']==4) {
$this->data['debug'] .= $this->db->last_query();
}





if ($countresults==0){
$str_add .= "<br><br><h2>По вашему запросу ничего не найдено</h2> <i>Попробуйте расширить условия поиска.</i>";
$str_searched = "<br><br><h2>По вашему запросу ничего не найдено</h2> <i>Попробуйте расширить условия поиска.</i>";
}
else{
if ($this->data['mlev']==4) {
$str_add .=  "<br><b>" . $str_searched . "</b>";
}
}



 



$firstad=(int)($firstad);
//13
$lastad=$firstad +	$config['per_page']-1;
//25
if ($lastad >$allresults){$lastad=$allresults;};
$search_qs=(string)$_SERVER['QUERY_STRING'];
$from=$firstad;

$config['total_rows']= $countresults;
$config['uri_segment'] = 4;
// удалем из строки  per_page 
$search_qs = str_replace("&per_page=".$firstad, "", $search_qs);

if ($firstad!=0){
// заменяем  first 
//echo("<!-- ");
//echo( 'до замены  ='. $search_qs . ";    ");
 

$search_qs = str_replace("first=". $firstad, "first=". ($lastad+1) , $search_qs);
//echo( 'после замены  ='. $search_qs . ";    ");
//echo(" -->");
}
else{

//$search_qs = $search_qs . "&". "" .  "first=" . $lastad+1;
$search_qs = $search_qs .  "&first=" . (string)($lastad+1);
}
//echo("<!-- ");
//echo( 'firstad ='. $firstad . ";    ");
// echo( ' lastad ='. $lastad . ";    ");
//echo( $search_qs );
//echo(" -->");
if ($this->data['mlev']==4){

$this->data['debug'] .= $search_qs;
 
}


$config['base_url'] = "http://neagent.by/board/?".$search_qs ;
$config['full_tag_open'] ='<div class="pagination"><div class="page_numbers"><span class="page-first">'.lang('module_realt_pagination_page').'</span>';
$config['full_tag_close']='</div><p class="page_items">'.$firstad. lang('module_realt_pagination_tire').$lastad.lang('module_realt_pagination_from').$allresults.lang('module_realt_pagination_ads').'</p></div>';
$config['cur_tag_open'] = '<span class="selected">';
$config['cur_tag_close'] = '</span>';
$config['first_tag_close'] = '';
$config['next_tag_close'] = '';
$config['prev_tag_open'] = '';
$config['num_tag_open'] = '';
$config['next_tag_open'] = '';
$config['prev_tag_open'] = '';
$config['prev_tag_close'] = '';
$config['prev_tag_open'] = '';
$config['page_query_string'] = TRUE;
$CI->pagination->initialize($config);
$data['pager']=$CI->pagination->create_links();


$config['base_url'] = "http://neagent.by/wap/?".$search_qs ;
$config['padding'] = 10;

$config['full_tag_open'] ='<div class="pagination"><div class="page_numbers"><span class="page-first">'.lang('module_realt_pagination_page').'</span>';

$config['full_tag_open'] ='';
 $config['display_pages'] = FALSE;
$config['full_tag_close']='</div><p class="w_page_items">Показано '.$firstad. lang('module_realt_pagination_tire').     $lastad  . " <br> " .   lang('module_realt_pagination_from') .   $allresults.lang('module_realt_pagination_ads').'</p></div>';
$config['num_links'] = 1;
$config['page_query_string'] = TRUE;
$CI->pagination->initialize($config);

$pp=$config['per_page'];
 //echo ("c=" . $pp);


$base_query=str_replace("&per_page=".$pp, "", $search_qs);
$base_query=str_replace("&first=".$firstad, "", $base_query);

$cleanurl = "http://neagent.by/wap/?".$base_query ;



$nextlink=$cleanurl . "&first=". (string)($lastad+1) . "&per_page=" . $config['per_page'];


if ($firstad>$config['per_page']-1){
$prevlink=$cleanurl . "&first=". (string)($firstad - $config['per_page']) . "&per_page=" . $config['per_page'];
$prevlinkblock="<a href='".$prevlink."'><img src='http://img1.neagent.by/s/w_prev.gif'></a>";
 }
 else{
$prevlink="";
$prevlinkblock=" <img src='http://img1.neagent.by/s/w_prev_noactive.gif'> ";
}
 
$data['pagerwap']="";
$data['pagerwap'] .="<table width='100%'><tr><td width='45px'>";
$data['pagerwap'] .=$prevlinkblock;
$data['pagerwap'] .=" </td><td style='text-align:center; font-size:0.8em'>";
$data['pagerwap'] .=$config['full_tag_close'];
$data['pagerwap'] .=" </td><td width='45px'>";
$data['pagerwap'] .="<a href='".$nextlink."'><img src='http://img1.neagent.by/s/w_next.gif'></a>";
$data['pagerwap'] .="</td></tr></table>";

 










if ($this->data['wap_view']!=1){
$str_add .= "<div style='height:25px;'>". $data['pager'] . "</div>";
}
else{


$str_add .= "<code class='pager'>". $data['pagerwap'] . "</code>";


}




//////////// Начало создания запроса 2
include 'inc_searchquery.php';
//////// конец создания запроса2

$query = $CI->db->get();
 

if ($this->data['mlev']==4){

//echo ($this->db->last_query());
}
//echo ($this->db->last_query());

///if ($this->data['mlev']==4){
///$dat['empty']=9;
///$str_add .= $CI->parser->parse('realt_order', $dat);
///$this->data['debug'] .=$this->db->last_query();

///}


switch($table) 
	    { case 'sutki':

// начата обработка объявлений 

$alt=1;// начата обработка объявлений 
foreach ($query->result() as $row){
if ($alt==1){$alt=0;}else{$alt=1;}
$itemalt=($alt==1)?" itemalt" :"";



$addata = array(
'ad_id' => $row->ad_id,
'ad_catid' => $row->ad_catid,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_price2' => $row->ad_price2,
			'ad_price3' => $row->ad_price3,
			'ad_period2' => $row->ad_period2,
			'ad_period3' => $row->ad_period3,
			'ad_currency' => $row->ad_currency,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_postdate' => $row->ad_postdate,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures,
			'ad_area' => $row->ad_area,
			'ad_subarea' => $row->ad_subarea,
			
			'ad_street' => $row->ad_street,
			'ad_url' => $row->ad_url,
			'ad_komnat' => $row->ad_komnat,
			'ad_komnat' => $row->ad_komnat,
			'itemalt' => $itemalt,
			'ad_sp_mest' => $row->ad_sp_mest,
			'ad_mainpic' => $row->ad_mainpic,
			'ad_show' => $row->ad_show,
			'ad_type' => $row->ad_type,
			'ad_comments_count' => $row->ad_comments_count
			             );
$delayed=false;

// замена телефонов
//include 'inc_repl_phones.php';


$addata['ad_mainpic']="http://neagent.by/modules/Realt/files/" . $addata['ad_mainpic'];





if ($addata['ad_type']==1) {$addata['itemalt']="vip";}

$addata['ad_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/kvartira.gif' width='60' height='50'  alt='Квартира' />";
// привести дату в нормальный вид
if (config_item('realt_modify_date')=='1'){$addata['ad_postdate']=modifier_dat2post($addata['ad_postdate']);}//модификатор дат
$addata['ad_komnat_txt']=getKomnatString($addata['ad_komnat']);
$addata['mlev']=$this->data['mlev']; // помечаем админа или кого еще чтобы в объявлении можно было видеть
if (strlen($addata['ad_url'])<2) {$addata['ad_url']=$addata['ad_id'];}
// добавляем у url начало snimu или sdayou


$addata['ad_url']="http://neagent.by/nasutki/".$addata['ad_url'];


//switch ($addata['ad_catid']) {
//case '2':case '4':case '6':case '8':case '10':
//$addata['ad_url']="http://neagent.by/snimu/".$addata['ad_url'];break; 
//case '1':case '3':case '5':case '7':case '11':
//$addata['ad_url']="http://neagent.by/sdayu/".$addata['ad_url'];break;
// }
 
 
$addata['sutki_pictures'] = isset($addata['sutki_pictures']) ? $addata['sutki_pictures'] : "";
if (strlen($addata['sutki_pictures'])>2) {
//imagesArr=split(pictures, ",")
//firstpic="<a rel=""pics_" & strAdId & """ href=""" & "uploads/n_" & imagesArr(0) & """><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""50""   />" 
//firstpic="<a   href=""default.asp?ad_id=" &  strAdId &"""><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""60""   />" 
}
 else
{
 $addata['sutki_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/nopic.gif' width='60' height='50'   />";
// firstpic="<img src=""themes/neagent/images/pic.gif"" width=""60"" height=""50""   />"
} 

if ($this->data['mlev']==4) {
$str_add .= $CI->parser->parse('realt_sutki_ad', $addata);
}

else{
$str_add .= $CI->parser->parse('realt_sutki_ad', $addata);
}



}
// Обработка всех объявлений закончена






		
 
 
 
 
 
 
 
 
// конец вывода на сутки  
break;
case 'ads':
$alt=1;// начата обработка объявлений 
$adcounter=0;
$js_points ="var map_points=Array();";

$this->load->helper('file');
$string_ad = read_file($this->config->item('module_path').'Realt/views/realt_ad.php');



$otbivka="";

// начата обработка объявлений 
$alt=1;

include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
foreach ($query->result() as $row)
{
$adcounter=$adcounter+1;

if (($adcounter==5||$adcounter==10 ) && $this->data['wap_view']!=1){
$str_add .='<div style="background-color:#f4f3e5;margin-top:18px;margin-bottom:18px;"><script type="text/javascript"><!--<![CDATA[
/* (c)AdOcean 2003-2011 */
/* PLACEMENT: smartcode.neagent.by.468_60 */
if(location.protocol.substr(0,4)==\'http\')document.write(unescape(\'%3C\')+\'script id="smartcode.neagent.by.468_60" src="\'+location.protocol+\'//by.adocean.pl/_\'+(new Date()).getTime()+\'/ad.js?id=M2AMhFoG7YcmAb3TJ3W8x4S9bPBSQ2bxyWWoW.qgb.f.B7/x=\'+screen.width+\'/y=\'+screen.height+\'" type="text/javascript"\'+unescape(\'%3E%3C\')+\'/script\'+unescape(\'%3E\'));
//]]>--></script></div>
';

}
if ($alt==1){$alt=0;}else{$alt=1;}
$itemalt=($alt==1)?" itemalt" :"";

$addata = createAdData($row , $this->data);

//echo("-" . $addata['ad_pl_o'] );

 $addata['ad_city'] = getCityName($addata['ad_city'], $config['realt_cityes_id'], $config['realt_cityes_name']);





if ($this->data['wap_view']==1){

$str_add .= $CI->parser->parse('wap_realt_ad', $addata);
}
else{
$str_add .= $CI->parser->parse('realt_ad', $addata);

}




//echo $string_ad;


//$str_add .= $CI->parser->parse_string($string_ad, $addata);

}
// Обработка всех объявлений закончена


break;

default:
$str_add .="no table";
break;


}


if ($this->data['map_view']==1){
$this->data['css'] .= "<script>mapview=1;" . $js_points . "</script>";
}





if ($this->data['wap_view']!=1){
$str_add .= "<div style='height:25px;'>";
$str_add .= $data['pager'];
$str_add .= "</div>";
}
else{

$str_add .= $data['pagerwap'];
}






	//##################################ПОСТРОЕНИЕ НАВИГАЦИИ ПО СТРАНИЦАМ 
	
//
// if search=true then
//  urlstr="&amp;mode=search"
//  if  k1 = true then urlstr=urlstr & "&amp;k1=on" 
// if  k2 = true then urlstr=urlstr & "&amp;k2=on" 
// if  k3 = true then urlstr=urlstr & "&amp;k3=on" 
// if  k0 = true then urlstr=urlstr & "&amp;k0=on" 
// urlstr=urlstr & "&amp;priceMin=" & priceMinrequest	
// urlstr=urlstr & "&amp;priceMax=" & priceMaxrequest
//'priceMin=request("priceMin")
//'priceMax=request("priceMax")
//'priceMin=request("priceMin")
	
// if  noprice = true then  urlstr=urlstr & "&amp;noprice=on" 
//backlink="default.asp?page=" & iPageCurrent - 1 &  urlstr
//forwardlink ="default.asp?page=" & iPageCurrent + 1 &  urlstr 
//p_link="default.asp?" & "pg=0" &urlstr 
// else
// backlink="default.asp?page=" & iPageCurrent - 1 & "&amp;order=" & Server.URLEncode(strOrderBy) & "&amp;cat_id=" & cat 
// forwardlink="default.asp?page=" & iPageCurrent + 1 & "&amp;order=" & Server.URLEncode(strOrderBy) & "&amp;cat_id=" & cat 
// p_link="default.asp?order=" & Server.URLEncode(strOrderBy) & "&amp;cat_id=" & cat 
// end if
 









return;