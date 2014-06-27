<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo("inc");
$str_add .="<h1>Страница поиска тестируется.</h2>Возможны некоторые недоработки, связанные с переходом на новую версию сайта. В ближайшее время все будет исправлено.";
//if ($_GET['mode']=='search')
//if ($this->data['mlev']==4){

 
if ($this->data['mlev']==4) {
echo ("-". $this->data['mlev']  ."-");
}


$k1=$_GET['k1'];
$k2=$_GET['k2'];
$k3=$_GET['k3'];
$k4=$_GET['k4'];
$k0=$_GET['k0'];
$k1=($k1=="on")?1:0;
$k2=($k2=="on")?1:0;
$k3=($k3=="on")?1:0;
$k4=($k4=="on")?1:0;
$k0=($k0=="on")?1:0;

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

//k1=request("k1")
//if  k1 = "on" then k1=true
//k2=request("k2")
//if  k2 = "on" then k2=true
//k3=request("k3")
//if  k3 = "on" then k3=true
//k0=request("k0")
//if  k0 = "on" then k0=true
//priceMin=request("priceMin")
//priceMax=request("priceMax")


 
// выбираем категорию 
$formtype=$_GET['formtype'];
$prtype=$_GET['prtype'];

switch($formtype . "/" . $prtype){
			case 'kv/arenda':$cat_id=1; break;
            case 'kom/arenda':$cat_id=3; break;
			case 'kom/podselenie_pr':$cat_id=9; break;
			case 'kom/podselenie_spr':$cat_id=10; break;
			default:echo ("error"); case 'kv/arenda':$cat_id=1; break;}

$limit=77;
$from=0;

//$query= $this->getAds($table, $from, $config['per_page'], $params );
// Это функция getads - то же по ходу

$order="ad_postdate";
$ordertype='desc'; 
$ad_show=1; // сделать в зависимости от mlev


/////$cat_id=$params['cat_id'];
//////$ad_url=$params['ad_url'];
/////$cat_id =  (int)$cat_id;
$table ="ads";

$CI =& get_instance();
$CI->db->select('*');
$CI->db->from ($table); 
$CI->db->limit($limit,$from);
$CI->db->where ('ad_catid', $cat_id);
$CI->db->where ('ad_show',  $ad_show );

$condition=""; $cand="";   
if ($k1 !=0){ $condition= $condition .  $cand . '`ad_komnat`=1'  ;  $cand=" or ";  }
if ($k2 !=0){ $condition= $condition .   $cand . '`ad_komnat`=2'  ;  $cand=" or ";  }
if ($k3 !=0){ $condition= $condition .   $cand .'`ad_komnat`=3'  ;  $cand=" or ";  }
if ($k4 !=0){ $condition= $condition .   $cand .'`ad_komnat`=4'  ;  $cand=" or ";  }
if ($k0 !=0){ $condition= $condition .   $cand .'`ad_komnat`=0'  ;  $cand=" or ";  }
if ($this->data['mlev']==4) {
echo ("-". $condition   ."-");
}



 if ($postdate !=0){
$datest="DATE_SUB(CURDATE(),INTERVAL $postdate DAY) <=ad_postdate";
 $CI->db->where(  $datest  );
 } 



 
if ($withcontent !=""){ 
//$withcontent = iconv("cp1251","utf-8",$withcontent);
//$withcontent =chkString($withcontent,"SQLString");// функция лежит в realt_model
$withcontentSQL =  "(`ad_message` like '%$withcontent%' or `ad_phones` like '%$withcontent%'   or `ad_street` like '%$withcontent%'  or `ad_email` like '%$withcontent%')";
$CI->db->where("(".$withcontentSQL.")"); 
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
if ($priceMin !=0){ $CI->db->where ('ad_price >',  $priceMin-1 );}
if ($priceMax !=0){ $CI->db->where ('ad_price <',  $priceMax+1 );}
if ( $condition!="") { 
 
 $CI->db->where( '('. $condition . ')' );  
} 
$CI->db->order_by($order, $ordertype);

if ($this->data['mlev']==4) {
echo ("-". $condition   ."-");
}


//pagination
$CI->load->library('pagination');
$countresults=$CI->db->count_all_results();


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

$CI->pagination->initialize($config);
$data['pager']=$CI->pagination->create_links();
$str_add .= "<div style='height:25px;'>";
$str_add .= $data['pager'];
$str_add .= "</div>";







//////////// 'n оповторение всего сверху
$CI->db->select('*');
$CI->db->from ($table); 
$CI->db->limit($limit,$from);
$CI->db->where ('ad_catid', $cat_id);
$CI->db->where ('ad_show',  $ad_show );

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
$withcontentSQL =  "(`ad_message` like '%$withcontent%' or `ad_phones` like '%$withcontent%'   or `ad_street` like '%$withcontent%'  or `ad_email` like '%$withcontent%')";
$CI->db->where("(".$withcontentSQL.")"); 
//$CI->db->like('ad_message', '$withcontent', 'both');
}

 if ($postdate !=0){
$datest="DATE_SUB(CURDATE(),INTERVAL $postdate DAY) <=ad_postdate";
 $CI->db->where(  $datest  );
 } 


//$condition="'dede'=6";
//echo ("=" .$condition. "=");
if ($priceMin !=0){ $CI->db->where ('ad_price >',  $priceMin-1 );}
if ($priceMax !=0){ $CI->db->where ('ad_price <',  $priceMax+1 );}
if ( $condition!="") { 
$CI->db->where("(".$condition.")");  } 
$CI->db->order_by($order, $ordertype);





$query = $CI->db->get();




switch($table) 
	    { case 'sutki':

 
 
 break;
 
 
 
case 'ads':
// начата обработка объявлений 
foreach ($query->result() as $row)
{
$addata = array(
'ad_id' => $row->ad_id,
'ad_catid' => $row->ad_catid,
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
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