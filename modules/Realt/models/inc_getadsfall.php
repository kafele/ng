<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	


	
	
	

	
switch	($CI->uri->segment(4)){

 case 'all': case'allmy':
$showtype="all";
 
 
 $ad_id=$CI->uri->segment(5);
 
 
 $CI->db->limit(1);
			
			$CI->db->where('ad_id', $ad_id);
			$CI->db->from("ads");
			$CI->db->where('ad_show', 1);
			$query = $CI->db->get();

			if ($query->num_rows() == 0 )
			{
				$ad_uid = "";
			}
			else
			{
				foreach ($query->result() as $row){
			
				$ad_uid = $row->ad_uid;
				
				}
			}
 
 
 
 
$uid=$ad_uid;





if ($uid=="") {	echo "не найдено  ";	return;	}
 

 break;
  
  
  case 'ip':
  $showtype="ip";
	$ip=$CI->uri->segment(5);
	if ($uid=="") {	echo "не задан ip ";	return;
  	}
	default:

	
	}
	
	
	
	
	
	
	
	
$table="ads";
$catrow="ad_catid";
		
		




	$CI->load->library('pagination');

	  switch	($CI->uri->segment(4)){
      case 'kvartira':	
	  case 'komnata':
	  case 'dom':
	  case 'office':
	  $config['base_url'] = "http://neagent.by/" . ($CI->uri->segment(4)."/".$CI->uri->segment(5)) ; //
	  $config['uri_segment'] = 6;
	  break;
	  default:
	  $config['uri_segment'] = 4;
	  $config['base_url'] = "http://neagent.by/board" ; //
	  
	  }

	  
	  
	  
		$config['total_rows'] = $CI->db->count_all($table);//$CI->db->count_all('ads'); //   было $CI->$config['total_rows'] = $CI->db->count_all('records'); // 
		$config['per_page'] =    (config_item('realt_ads_per_page')>0)?config_item('realt_ads_per_page'): 20;   //  выводить на страницу
		$config['num_links'] = 6;    //  количество ссылок - косметический параметр
		$config['padding'] = 1;
	    
		//$config['uri_segment'] = 2;  //  
		$config['first_link'] = 'В начало';
		 


		
$cat_id=(int)$cat_id;

//if ($cat_id>0)	{if ($table=="ads"){$CI->db->where('ad_catid', $cat_id);};


$CI->db->from("ads");

 if ($showtype=="ip"){
 $CI->db->where("ad_ip", $ip);
 }
 if ($showtype=="all"){
 $CI->db->where("ad_uid", $uid);
 }
$CI->db->where('ad_show', 1);

$allresults=$CI->db->count_all_results();

if ($allresults==0){
echo "не найдено в базе таких объявлений";
return;
}

//echo ("найдено " . $allresults) ;
$str_add .="<b> Поскольку на сайте нет регистрации, показаны объявления, которые  даны с одного и того же компьютера (по данным параметров cookies). </b><br>";
$str_add .="<p> Возможно они даны разными людьми с использованием одной машины (например, в компьютерном клубе). </p>";

$config['total_rows']= $allresults;
//echo ("count:".$config['total_rows'].";");
//$config['total_rows'] = $CI->db->count_all('ads');



$firstad=(int)($CI->uri->segment($config['uri_segment']) +0); // +1 потому чт онулевое объявление уже показано 

//echo ("firstad=" . $firstad . ";");
$lastad=$firstad+	$config['per_page']-1;
if ($lastad >$allresults){$lastad=$allresults;};
//ТУТ СДЕЛАТЬ ПРОВЕРКУ
//
		
//	продолжаем pagination
$config['full_tag_open'] ='<div class="pagination"><div class="page_numbers"><span class="page-first">'.lang('module_realt_pagination_page').'</span>';
$config['full_tag_close']='</div><p class="page_items">'.$firstad. lang('module_realt_pagination_tire').$lastad.lang('module_realt_pagination_from').$allresults.lang('module_realt_pagination_ads').'</p></div>';
$config['cur_tag_open'] = '<span class="selected">';
$config['cur_tag_close'] = '</span>';
//
	

	
	
if  ($this->data['mlev']==4){
$config['full_tag_open'] ='<div class="pagination"><div class="page_numbers"><span class="page-first">'.lang('module_realt_pagination_page').'</span>';
$config['full_tag_close']='</div><p class="page_items">'.$firstad. lang('module_realt_pagination_tire').$lastad.lang('module_realt_pagination_from').$allresults.lang('module_realt_pagination_ads').'</p></div>';
$config['cur_tag_open'] = '<span class="selected">';
$config['cur_tag_close'] = '</span>';

$sortlink="";
$config['full_tag_close']='</div><div class="pagination_sort">сортировать: <a href="$sortlink">по дате</a></div><p class="page_items">'.$firstad. lang('module_realt_pagination_tire').$lastad.lang('module_realt_pagination_from').$allresults.lang('module_realt_pagination_ads').'</p></div>';


$str_add .= "
<style>
div.pagination ,  div.pagination page_numbers, div.pagination p.page_items, div.page_numbers span.selected {border:0; margin:0px; ;padding:0px; padding-bottom:0px; padding-top:0px; position:relative; top:baseline;}

div.pagination{width:100%; }


div.pagination .page_numbers .selected { 
background-position: 50% 0%;
background-repeat: repeat-x;
border-bottom-color: #b4b4b4;
border-bottom-style: solid;
border-bottom-width: 1px;
border-left-color: #b4b4b4;
border-left-style: solid;
border-left-width: 1px;
border-right-color: #b4b4b4;
border-right-style: solid;
border-right-width: 1px;
border-top-color: #b4b4b4;
border-top-style: solid;
border-top-width: 1px;
padding-bottom: 0px;
padding-left: 0px;
padding-right: 0px;
padding-top: 0px;
}









div.pagination .page_numbers, div.pagination .page_numbers a { 
color: #505050;
font-size: 11px;
line-height: 18px;
padding-bottom: 0px;
padding-left: 0px;
padding-right: 0px;
padding-top: 0px;
}

div.pagination { 
bottom: 0px;
clear: both;
float: right;
height: 18px;
padding-bottom: 0px;
padding-left: 0px;
padding-right: 0px;
padding-top: 0px;
position: relative;

}
 
 
 
 
div.pagination{
width:100%; overflow:hidden; margin-top:18px;margin-bottom:18px;border-bottom:1px dotted #62a5d5;}


div.pagination div.page_numbers { float:left;
padding-left:9px; overflow:hidden;
width:240px; background-color:#ececdc;}


div.pagination .page_numbers a { 
padding-left:2px;padding-right:2px;
}

div.pagination .page_numbers span.selected {padding-left:9px;padding-right:9px;}

div.pagination_sort{float:left;padding-left:0px; background-color:#efcdd9;}
div.pagination_sort a{border-bottom:1px dotted #62a5d5; }


div.pagination p.page_items{float:right; padding-right:9px;};



</style>










";













}	 
	




	
	
	
	  $CI->pagination->initialize($config);
      $data['pager']=$CI->pagination->create_links();
      //echo ($data['pager']);
      $from=($CI->uri->segment($config['uri_segment']));
	  if (!$from){$from=0;
	  }
	   
	   
	  
	  
	   // echo ($from."00");
	   //echo ($limit);


	   
	
$params = array(
    'cat_id' => $cat_id,
	'ad_show'=> '1' ,	
    'order'=> 'date',
	'ordertype'=> 'desc',
	'ad_uid' => $uid
            );	
 //echo $cat_id;


			

			
			
			
$cat_id=$params['cat_id'];
$ad_url=$params['ad_url'];
$cat_id =  (int)$cat_id;
$CI->db->select('*');
$CI->db->limit($limit,$from);
 
 
 if ($showtype=="ip"){
 $CI->db->where("ad_ip", $ip);
 }
 if ($showtype=="all"){
 $CI->db->where("ad_uid", $uid);
 }
 
 
$order=$params['order'];
$ordertype=$params['ordertype']; 

$ad_show=$params['ad_show'];
$this->db->order_by("ad_id", "desc");
$CI->db->from ('ads');

	

$query = $CI->db->get();






//echo ($CI->db->last_query() );








if  ($this->data['mlev']!=4){$str_add .= "<div style='height:25px;'>";}
 

$str_add .= $data['pager'];
if  ($this->data['mlev']!=4){$str_add .= "</div>";}

switch($table) 
	    { case 'sutki':
// начата обработка объявлений 
foreach ($query->result() as $row)
{
$addata = array(
 'sutki_title' => $row->sutki_title,
            'sutki_message' => $row->sutki_message,
			'sutki_price' => $row->sutki_price,
			'sutki_phones' => $row->sutki_phones,
			'sutki_contactname' => $row->sutki_contactname,
			'sutki_date' => $row->sutki_date,
			'sutki_email' => $row->sutki_email,
			'sutki_pictures' => $row->sutki_pictures,
			'sutki_komnat' => $row->sutki_komnat,
            );
			
$delayed=false;

if (strlen($addata['ad_pictures'])>2) {
}
 else
{
 $addata['ad_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/nopic.gif' width='60' height='50'   />";
// firstpic="<img src=""themes/neagent/images/pic.gif"" width=""60"" height=""50""   />"
} 
$str_add .= $CI->parser->parse('realt_sutkiad', $addata);
}
// Обработка всех объявлений закончена
break;
 
 
 
 
 
 
 
case 'ads':
$alt=1;
// начата обработка объявлений 
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
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_postdate' => $row->ad_firstdate,
			  
			'ad_firstdate' => $row->ad_firstdate,
			'ad_up_date' => $row->ad_up_date,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures,
			'ad_area' => $row->ad_area,
			'ad_subarea' => $row->ad_subarea,
			'ad_street' => $row->ad_street,
			'ad_url' => $row->ad_url,
			'ad_komnat' => $row->ad_komnat,
			'ad_komnat' => $row->ad_komnat,
			'itemalt' => $itemalt,
			'ad_uid' => $row->ad_uid,
			'ad_ip' => $row->ad_ip,
			'ad_cref' => $row->ad_cref,
			'ad_show' => $row->ad_show,
			'ad_pending' => $row->ad_pending,
			'ad_showpolitic' => $row->ad_showpolitic,
			'ad_comments_count' => $row->ad_comments_count,
			 'ad_fakefor' => $row->ad_fakefor
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


$addata['ad_isup']='';
///////////// Если поднято, установить маркер
if ($addata['ad_up_date']!="0000-00-00 00:00:00"){
///////////// Если удалено уже, то обнулить поднятие
if ($addata['ad_show']==0){
$CI->db->where("ad_id", $row->ad_id);
$CI->db->set("ad_up_date", "0000-00-00 00:00:00");
$CI->db->update("ads");
}
$addata['ad_isup']=' ^';
}




$addata['ad_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/kvartira.gif' width='60' height='50'  alt='Квартира' />";
// привести дату в нормальный вид
$addata['ad_postdate']= $addata['ad_postdate'];

if ($addata['ad_show']==0){
$addata['ad_showpolitic']=="true";
}


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




if ($this->data['mlev']==4) {
//echo ("ad_postdate" . $addata['ad_postdate']);
//echo ("ad_uid" . $addata['ad_uid']);
}




//if ($this->data['mlev']==4) {

//$str_add .= $CI->parser->parse('realt_ad2', $addata);

//}



if ($addata['ad_showpolitic']=="true"||$addata['ad_showpolitic']=="combi"||$addata['ad_showpolitic']=="true2"){

   if ($this->data['userstatus']!="active"&&$this->data['userstatus']!="allowed"){
   $addata['ad_phones']="скрыт. <a href='http://neagent.by/board/access'>Как увидеть телефон?</a>";
   }
}

//// сокрытие телефона если рано еще

$pdata=$row->ad_firstdate;
$nowdate = date("Y-m-d H:i:s");
$date_time_string = $nowdate;
$dt_elements = explode(' ',$date_time_string);
$date_elements = explode('-',$dt_elements[0]);
$time_elements =  explode(':',$dt_elements[1]);
$nn = mktime($time_elements[0], $time_elements[1],$time_elements[2], $date_elements[1],$date_elements[2], $date_elements[0]);
$obdate = $pdata;
$date_time_string = $obdate;
$dt_elements = explode(' ',$date_time_string);
$date_elements = explode('-',$dt_elements[0]);
$time_elements =  explode(':',$dt_elements[1]);
$oo = mktime($time_elements[0], $time_elements[1],$time_elements[2], $date_elements[1],$date_elements[2], $date_elements[0]);
$diff=$nn-$oo;
$minutsForShow=(int)config_item('realt_post_delay');
$sekForShow=$minutsForShow*60;
$sekost =($minutsForShow*60- $diff) ; // осталось секунд 
$minsh = floor($sekost /60); // осталось минут
//echo ("`".$minsh);
$seksh=$sekost-$minsh*60;
//echo ("`".$seksh);
if (($minsh) >3) {$ostalos ="Будет доступен через " . $minsh . "мин. ";
}else{$ostalos ="Будет доступен через " . $minsh . "мин. " . $seksh. "сек.";
}
if($diff<($minutsForShow*60)&&$diff>-1){
$addata['ad_phones']= $ostalos;
}

////////



//else{
$str_add .= $CI->parser->parse('realt_ad', $addata);
//}



}
// Обработка всех объявлений закончена


break;

default:
$str_add .="no table";
break;


}






$str_add .= "<br style='clear:both;'><div style='clear:both;height:25px;'>";
 $str_add .= $data['pager'];
$str_add .= "</div>";
 

$this->data['realt']=$str_add;
//echo ($str_add);
//echo ("<textarea>".$CI->data['realt']."</textarea>");
return ;










		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		


	
	
	
	
	
	
	