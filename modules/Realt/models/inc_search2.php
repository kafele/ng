<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$str_add .="<h1>Страница поиска тестируется.</h2>Возможны некоторые недоработки, связанные с переходом на новую версию сайта. В ближайшее время все будет исправлено.";

 
if ($this->data['mlev']==4) {
echo ("ПОИСК v.2");
}


$areasArray =$_GET['ar'];
$arr_values=array();
if ($_GET['ar']){foreach ($areasArray as $i => $value) {
if ($value){array_push($arr_values,$value);}}
}



$subareasArray =$_GET['subar'];
$subarr_values=array();
if ($_GET['subar']){foreach ($subareasArray as $i => $value) {
if ($value){array_push($subarr_values,$value);}}
}




$k1=($_GET['k1']=="on")?1:0;
$k2=($_GET['k2']=="on")?1:0;
$k3=($_GET['k3']=="on")?1:0;
$k4=($_GET['k4']=="on")?1:0;
$k5=($_GET['k5']=="on")?1:0;
$k0=($_GET['k0']=="on")?1:0;


$priceMin=$_GET['priceMin'];
$priceMax=$_GET['priceMax'];

$withcontent=$_GET['withcontent'];
if ($withcontent==" "){$withcontent="";};


$postdate=(int)$_GET['postdate'];


$priceMinrequest=$priceMin;//
$priceMaxrequest=$priceMax;

$priceMin = (int)$priceMin;
$priceMax = (int)$priceMax;
if ($priceMax==0){$priceMax=5000000;};

// выбираем категорию 
$formtype=$_GET['formtype'];
$prtype=$_GET['prtype'];

/// показываем  форму поиска  заполненную


/// показываем  форму поиска  заполненную

/// показываем  форму поиска  заполненную
//и формируем строку
$str_searched .="показаны ";
if ($formtype=="kom"){
$str_searched .="комнаты ";
}



if ($formtype=="kv"){



switch ($k1.$k2.$k3.$k4) {
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

 


if ($priceMin == 0 && $priceMax==5000000){
$str_searched .=" по любой цене ";
}

if ($priceMin == 0 && $priceMax!=5000000){
$str_searched .=" по цене до " . $priceMax . " $";
}

if ($priceMin !=0 && $priceMax==5000000){
$str_searched .=" по цене от " . $priceMin . " $";
}

if ($priceMin !=0 && $priceMax!=5000000){
$str_searched .=" по цене " . $priceMin . "-" . $priceMax .  " $";
}

 
 $str_searched .=" в выбранных районах  " ;
 

if ($withcontent !="")
 {
 $str_searched .=" с текстом «". $withcontent  .  "»";
 }

 
if ($postdate !=0)
{
 $str_searched .=" за последние ". $postdate  .  " дней";
}
 
 

 
 
 


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
 'prtype' =>$prtype
 );
 $this->data['searchform']= $CI->parser->parse('searchform', $addata);


 /// конец показа показываем  форму поиска  заполненную
 
 





if ($this->data['mlev']==4) {
echo ($str_searched);
//echo ($formtype . "/" . $prtype);
}


$table ="ads"; // по умолчанию. на сутки переопределяется нижу 
switch($formtype . "/" . $prtype){
			case 'kv/arenda':$cat_id=1; break;
            case 'kom/arenda':$cat_id=3; break;
			case 'kom/podselenie_pr':$cat_id=9; break;
			case 'kom/podselenie_spr':$cat_id=10; break;
			case 'su/su_kv':$cat_id=1; $table="sutki" ; break;
			default:echo ("error"); case 'kv/arenda':$cat_id=1; break;}

			
$limit=77;
$from=0;



if ($table=="ads"){ 
$realt_currency_rate=config_item('realt_currency_rate');
$priceMin = (int)$realt_currency_rate[1] * $priceMin;
$priceMax = (int)$realt_currency_rate[1] * $priceMax;
}




$order="ad_postdate";
$ordertype='desc'; 



$ad_show=1; // сделать в зависимости от mlev




$CI =& get_instance();
$CI->db->select('*');
$CI->db->from ($table); 





//areas




//echo ("case0");



if (count($arr_values)>0&&count($subarr_values)>0){

echo ("case2");
//array_push($arr_values, 0);
//array_push($subarr_values, 0);
$arr_valuesStr=join(",",$arr_values);
$subarr_valuesStr=join(",",$subarr_values);
$CI->db->where("(ad_area in ($arr_valuesStr) OR ad_subarea in ($subarr_valuesStr))");


//$CI->db->where("((ad_area in ($arr_valuesStr) and ad_subarea !=0) OR (ad_subarea in ($subarr_valuesStr) AND ad_area))");




$CI->db->order_by('ad_area', 'DESC');
$CI->db->order_by('ad_subarea', 'DESC');

}


if (count($arr_values)>0&&count($subarr_values)==0){
echo ("case3");
array_push($arr_values, 0);
$CI->db->where_in('ad_area', $arr_values);
$CI->db->order_by('ad_area', 'DESC');

//$CI->db->where_open(array('page_slug'=>$slug));
}

if (count($arr_values)==0&&count($subarr_values)>0){
echo ("case4");
array_push($subarr_values, 0);
$CI->db->where_in('ad_subarea', $subarr_values);
$CI->db->order_by('ad_subarea', 'DESC');
//$CI->db->where_open(array('page_slug'=>$slug));
}


///if (count($arr_values)>0){
///array_push($arr_values, 0);
///$CI->db->where_in('ad_area', $arr_values);
///$CI->db->order_by('ad_area', 'DESC');
///}



///if (count($subarr_values)>0){
///array_push($subarr_values, NULL);
///$CI->db->order_by('ad_subarea', 'DESC');


///if (count($arr_values)>0){
///$CI->db->or_where_in('ad_subarea', $subarr_values);
///}
///else{
///$CI->db->where_in('ad_subarea', $subarr_values);
///}

///}






$CI->db->limit($limit,$from);
$CI->db->where ('ad_catid', $cat_id);
if ($this->data['mlev']!=4){$CI->db->where ('ad_show',  $ad_show );}

$condition=""; $cand="";   
if ($k1 !=0){ $condition= $condition .  $cand . '`ad_komnat`=1'  ;  $cand=" or ";  }
if ($k2 !=0){ $condition= $condition .   $cand . '`ad_komnat`=2'  ;  $cand=" or ";  }
if ($k3 !=0){ $condition= $condition .   $cand .'`ad_komnat`=3'  ;  $cand=" or ";  }
if ($k4 !=0){ $condition= $condition .   $cand .'`ad_komnat`=4'  ;  $cand=" or ";  }
if ($k0 !=0){ $condition= $condition .   $cand .'`ad_komnat`=0'  ;  $cand=" or ";  }
//if ($this->data['mlev']==4) {
//echo ("-". $condition   ."-");
//}


// Дата 
if ($postdate !=0){$datest="DATE_SUB(CURDATE(),INTERVAL $postdate DAY) <=ad_postdate";$CI->db->where(  $datest  );} 



 
if ($withcontent !=""){ 
//$withcontent = iconv("cp1251","utf-8",$withcontent);
//$withcontent =chkString($withcontent,"SQLString");// функция лежит в realt_model
$withcontentSQL =  "`ad_message` like '%$withcontent%' or `ad_phones` like '%$withcontent%'   or `ad_street` like '%$withcontent%'  or `ad_email` like '%$withcontent%'";
$CI->db->where("(".  $withcontentSQL .")" ); 
//$CI->db->like('ad_message', '$withcontent', 'both');
}

if ($this->data['mlev']==4){
echo ("postdate=".$postdate.";");

 echo ($withcontentSQL);
 //echo ("" );
 //return;
}



//$condition="'dede'=6";
//echo ("=" .$condition. "=");



if ($table=="ads"){ 
if ($priceMin !=0){ $CI->db->where ('ad_default_price >',  $priceMin-1 );}
if ($priceMax !=0){ $CI->db->where ('ad_default_price <',  $priceMax+1 );}
}
else
{
if ($priceMin !=0){ $CI->db->where ('ad_price >',  $priceMin-1 );}
if ($priceMax !=0){ $CI->db->where ('ad_price <',  $priceMax+1 );}
}



if ( $condition!="") { 
 
 $CI->db->where( '('. $condition . ')' );  
} 
$CI->db->order_by($order, $ordertype);

if ($this->data['mlev']==4) {
echo ("-". $condition   ."-");
}


//pagination
$CI->load->library('pagination');
//$countresults=$CI->db->count_all_results();
$query = $CI->db->get();// это убрать


if ($this->data['mlev']==4) {
 echo ($this->db->last_query());

}




if ($countresults==0){

$str_add .= "<br><br><h2>По вашему запросу ничего не найдено</h2> <i>Попробуйте расширить условия поиска.</i>";

}






 

if ($this->data['mlev']==4){

echo ('countresults-'.$countresults.";");

 echo ($this->db->_error_message());
 echo ($this->db->last_query());
}



$firstad=(int)($CI->uri->segment($config['uri_segment']) +0);
$lastad=$firstad+	$config['per_page']-1;
if ($lastad >$allresults){$lastad=$allresults;};


//echo ($data['pager']);
$from=($CI->uri->segment($config['uri_segment']));
$config['total_rows']= $countresults;

$config['uri_segment'] = 4;
$config['base_url'] = "http://neagent.by/board/?".$_SERVER['QUERY_STRING'] ;
	  
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
$str_add .= "<div style='height:25px;'>";
$str_add .= $data['pager'];
$str_add .= "</div>";







//////////// 'n оповторение всего сверху
$CI->db->select('*');
$CI->db->from ($table); 
$CI->db->limit($limit,$from);


//areas
//areas





if (count($arr_values)>0&&count($subarr_values)>0){

echo ("указаны и area и subarea"); 
//array_push($arr_values, 0);
//array_push($subarr_values, 0);
$arr_valuesStr=join(",",$arr_values);
$subarr_valuesStr=join(",",$subarr_values);
$CI->db->where("(ad_area in ($arr_valuesStr) OR ad_subarea in ($subarr_valuesStr))");
$CI->db->or_where("(ad_area in (0) and ad_subarea in (0))");
//$this->db->or_where();
$CI->db->order_by('ad_area', 'DESC');
$CI->db->order_by('ad_subarea', 'DESC');
}


if (count($arr_values)>0&&count($subarr_values)==0){
echo ("case3");
array_push($arr_values, 0);
$CI->db->where_in('ad_area', $arr_values);
$CI->db->order_by('ad_area', 'DESC');

//$CI->db->where_open(array('page_slug'=>$slug));
}

if (count($arr_values)==0&&count($subarr_values)>0){
echo ("case4");
array_push($subarr_values, 0);
$CI->db->where_in('ad_subarea', $subarr_values);
$CI->db->order_by('ad_subarea', 'DESC');
//$CI->db->where_open(array('page_slug'=>$slug));
}























$CI->db->where ('ad_catid', $cat_id);
if ($this->data['mlev']!=4){$CI->db->where ('ad_show',  $ad_show );}
//echo ('a' . $ad_show );
$condition=""; $cand="";   
if ($k1 !=0){ $condition= $condition .  $cand . '`ad_komnat`=1'  ;  $cand=" or ";  }
if ($k2 !=0){ $condition= $condition .   $cand . '`ad_komnat`=2'  ;  $cand=" or ";  }
if ($k3 !=0){ $condition= $condition .   $cand .'`ad_komnat`=3'  ;  $cand=" or ";  }
if ($k4 !=0){ $condition= $condition .   $cand .'`ad_komnat`=4'  ;  $cand=" or ";  }
if ($k0 !=0){ $condition= $condition .   $cand .'`ad_komnat`=0'  ;  $cand=" or ";  }
$condition=$condition . $close;

if ($withcontent !=""){ 
//$withcontent = iconv("cp1251","utf-8",$withcontent);
//$withcontent =chkString($withcontent,"SQLString");// функция лежит в realt_model
$withcontentSQL =  "`ad_message` like '%$withcontent%' or `ad_phones` like '%$withcontent%'   or `ad_street` like '%$withcontent%'  or `ad_email` like '%$withcontent%'";
$CI->db->where("(".  $withcontentSQL .")" ); 
//$CI->db->like('ad_message', '$withcontent', 'both');
}

 if ($postdate !=0){
$datest="DATE_SUB(CURDATE(),INTERVAL $postdate DAY) <=ad_postdate";
 $CI->db->where(  $datest  );
 } 


//$condition="'dede'=6";
//echo ("=" .$condition. "=");
if ($table=="ads"){ 
if ($priceMin !=0){ $CI->db->where ('ad_default_price >',  $priceMin-1 );}
if ($priceMax !=0){ $CI->db->where ('ad_default_price <',  $priceMax+1 );}
}
else
{
if ($priceMin !=0){ $CI->db->where ('ad_price >',  $priceMin-1 );}
if ($priceMax !=0){ $CI->db->where ('ad_price <',  $priceMax+1 );}
}







if ( $condition!="") { 
$CI->db->where("(".$condition.")");  } 
$CI->db->order_by($order, $ordertype);





$query = $CI->db->get();



if ($this->data['mlev']==4){
$dat['empty']=9;
$str_add .= $CI->parser->parse('realt_order', $dat);

echo ('countresults-'.$countresults.";");
echo ($this->db->_error_message());
echo ($this->db->last_query());
}




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
			'ad_comments_count' => $row->ad_comments_count
			             );
$delayed=false;

// замена телефонов
//include 'inc_repl_phones.php';


if (strlen($addata['ad_pictures'])>1) {
$ad_pictures= explode("; ", $addata['ad_pictures']);
$addata['ad_pictures']=$ad_pictures;
$addata['ad_thumbs']=$ad_pictures;
$addata['pic_folder']="http://neagent.by/modules/Realt/files/";
$addata['ad_mainpic']="http://neagent.by/modules/Realt/files/tmp/" . "t_".  $ad_pictures[0];
}
else
{$addata['ad_mainpic']="http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";}



$addata['ad_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/kvartira.gif' width='60' height='50'  alt='Квартира' />";
// привести дату в нормальный вид
$addata['ad_postdate']= $addata['ad_postdate'];
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

if ($this->data['mlev']==4) {}

//else{
$str_add .= $CI->parser->parse('realt_sutki_ad', $addata);
//}



}
// Обработка всех объявлений закончена






		
 
 
 
 
 
 
 
 
// конец вывода на сутки  
break;
case 'ads':



$this->load->helper('file');
$string_ad = read_file($this->config->item('module_path').'Realt/views/realt_ad.php');











$otbivka="";



// начата обработка объявлений 
$alt=1;
foreach ($query->result() as $row)
{
if ($alt==1){$alt=0;}else{$alt=1;}
$itemalt=($alt==1)?" itemalt" :"";
$addata = array(
'ad_id' => $row->ad_id,
'ad_catid' => $row->ad_catid,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_currency' => $row->ad_currency,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_postdate' => $row->ad_postdate,
			'ad_firstdate' => $row->ad_firstdate,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures,
			'ad_area' => $row->ad_area,
			'ad_subarea' => $row->ad_subarea,
			'ad_street' => $row->ad_street,
			'ad_url' => $row->ad_url,
			'ad_komnat' => $row->ad_komnat,
			'itemalt' => $itemalt,
			'ad_uid' => $row->ad_uid,
			'ad_ip' => $row->ad_ip,
			'ad_evc' => $row->ad_evc,
			'ad_cref' => $row->ad_cref,
			'ad_show' => $row->ad_show,
			'ad_pending' => $row->ad_pending,
			'ad_secretcode' => $row->ad_secretcode,
			'ad_showpolitic' => $row->ad_showpolitic,
			'ad_comments_count' => $row->ad_comments_count
            );
$delayed=false;
//if strpublishDelay >0  and mlev=4 then
//'response.write DateToStr(strPostDate)
//delay_time=DateToStr(dateadd("n",  -(strpublishDelay) ,strForumTimeAdjust))
//if DateToStr(strPostDate) > delay_time then 
//delayed=true
//end if
//end if
//echo (strlen($addata['ad_pictures']));









if ($this->data['mlev']==4) { 

if (count($arr_values)>0&&count($subarr_values)>0 && ($row->ad_area == 0) && ($row->ad_subarea == 0) && $otbivka=""){
// поиск по району и микрорайону
$str_add .= "выбор по району и микрорайону. Ниже варианты без указания района";


}


if (count($arr_values)>0&& count($subarr_values)==0){
// поиск по району только

}

if (count($arr_values)==0&& count($subarr_values)>0){
// поиск по  микрорайону только

}



$str_add .= "Район  " . $row->ad_area;
$str_add .= "Микрорайон  " . $row->ad_subarea;
if ($row->ad_area == 0){
$str_add .= "Район не указан";
}

if ($row->ad_subarea == 0){
$str_add .= "Микро район не указан";
}


if ($row->ad_area == '0' && $row->ad_subarea == '0'){
$str_add .= "!!Район не указан";
}








}



$addata['show_phones']= config_item('realt_show_phones');
$addata['newpage']= config_item('realt_newpage');


//fake
include 'inc_repl_phones.php';
if ($this->data['labels_flag']==1){

$labelmark=getlabelmark($row->ad_id); // возвращает прямо строчку которую нужно вставить 
$addata['labelmark']=$labelmark;
}

if (strlen($addata['ad_pictures'])>1) {
$ad_pictures= explode("; ", $addata['ad_pictures']);
$addata['ad_pictures']=$ad_pictures;
$addata['ad_thumbs']=$ad_pictures;
$addata['pic_folder']="http://neagent.by/modules/Realt/files/";
$addata['ad_mainpic']="http://neagent.by/modules/Realt/files/tmp/" . "t_".  $ad_pictures[0];
}
else
{$addata['ad_mainpic']="http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";}





//if ($this->data['mlev']==4){
//($addata['ad_message'] = $addata['ad_showpolitic']  . "+" . $addata['ad_message']);
//}


// настройки показа
if ($addata['ad_showpolitic']=="true"||$addata['ad_showpolitic']=="combi"||$addata['ad_showpolitic']=="true2"){

   if ($this->data['userstatus']!="active"&&$this->data['userstatus']!="allowed"){
   $addata['ad_phones']="скрыт. <a href='http://neagent.by/board/access'>Как увидеть телефон?</a>";
   }
}




$addata['ad_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/kvartira.gif' width='60' height='50'  alt='Квартира' />";
// привести дату в нормальный вид
$addata['ad_postdate']= $addata['ad_postdate'];


$addata['ad_komnat_txt']=getKomnatString($addata['ad_komnat']);
 

$addata['mlev']=$this->data['mlev']; // помечаем админа или кого еще чтобы в объявлении можно было видеть


if (strlen($addata['ad_url'])<2) {$addata['ad_url']=$addata['ad_id'];}

// добавляем у url начало snimu или sdayou







switch ($addata['ad_catid']) {
case '2':
case '4':
case '6':
case '8':
case '10':
$addata['ad_url']="http://neagent.by/snimu/".$addata['ad_url'];

break; 
case '1':
case '3':
case '5':
case '7':
case '11':
$addata['ad_url']="http://neagent.by/sdayu/".$addata['ad_url'];


break;
 
}





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

$str_add .= $CI->parser->parse('realt_ad', $addata);

//echo $string_ad;


//$str_add .= $CI->parser->parse_string($string_ad, $addata);

}
// Обработка всех объявлений закончена


break;

default:
$str_add .="no table";
break;


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