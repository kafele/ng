<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




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
$CI->cidbcriteria->build();
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