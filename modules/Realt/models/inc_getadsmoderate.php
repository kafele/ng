<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   $CI = $this->CI =& get_instance();	
 //print_r ($this->CI);
 //$user = $this->CI->connect->get_current_user();
 //$this->user = $user;

 //if (($user['group']['group_name']) == 'Super Admins') {
 //$this->data['mlev'] = 4;
    //   echo('mlev=4');   
 //$this->CI->data['page_view'] = "default/wap_page";
 //} else {
// echo('mlev=0'); 
 //$this->data['mlev'] = 0;
 //} ;
 
 
 
 //print_r ($this->CI);
 
 
 
 
 
 
 
	if  ($this->data['mlev']!=4 ){
	$this->data['realt']="запрещено";
	return $this->data['realt'];
	}
	else{
	$this->data['realt']="разрешено";
	//return $this->data['realt'];
	}

$limit=40;	
$from=0;
$showtype="moderate";
$table="ads";
$catrow="ad_catid";
		
$this->CI->load->library('pagination');
 
	  switch	($this->CI->uri->segment(4)){
      case 'kvartira':	
	  case 'komnata':
	  case 'dom':
	  case 'office':
	  $config['base_url'] = "http://neagent.by/" . ($this->CI->uri->segment(4)."/".$this->CI->uri->segment(5)) ; //
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
$CI->db->where("ad_pending", 1);




$allresults=$CI->db->count_all_results();
if ($allresults==0){
$this->data['realt']="нет объявлений на модерации";
return $this->data['realt'];
}


 
//return;


$config['total_rows']= $allresults;


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
	'ad_show'=> '0' ,	
    'order'=> 'date',
	'ordertype'=> 'desc',
            );	
 //echo $cat_id;

		
			
$cat_id=$params['cat_id'];
$ad_url=$params['ad_url'];
$cat_id =  (int)$cat_id;
$CI->db->select('*');
$CI->db->limit($limit,$from);
$CI->db->where("ad_pending", 1);
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
	    { 
 
case 'ads':
$alt=1;
// начата обработка объявлений 
foreach ($query->result() as $row)
{
 //echo('о ');
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
			'ad_evc' => $row->ad_evc,
			'ad_ip' => $row->ad_ip,
			'ad_cref' => $row->ad_cref,
			'ad_show' => $row->ad_show,
			'ad_pending' => $row->ad_pending,
			'ad_secretcode' => $row->ad_secretcode,
			 'ad_imgtitle' => $this->data['short_keywords'],
			 'ad_imgalt' => $this->data['short_keywords'],
			 'ad_showpolitic' => $row->ad_showpolitic,
			 'ad_confirmed' => $row->m_confirmed
            );
$delayed=false;

//echo ("- ");

 //echo($row->ad_message);

$addata['ad_description'] =getAdDescription($addata['ad_id'], "ads");
$addata['ad_message'] = $addata['ad_message']  . "<div style='color:red;'>" . $addata['ad_description'] . "</div>"; 


if ($addata['ad_confirmed']!='1'){
$addata['ad_email']="" .$addata['ad_email'] . "[?]";
}

//include 'inc_repl_phones.php';


 $complaints=getUIDComplaints($row->ad_uid);
 $addata['ad_message'] .= $complaints;
 
 
 
 
if ($this->data['labels_flag']==1){
$addata['labels_flag']=1;
$labelmark=getlabelmark($row->ad_id); // возвращает прямо строчку которую нужно вставить 
$addata['labelmark']=$labelmark;
}


 
if (strlen($addata['ad_pictures'])>1) {
$ad_pictures= explode("; ", $addata['ad_pictures']);
$addata['ad_pictures']=$ad_pictures;
$addata['ad_thumbs']=$ad_pictures;
$addata['pic_folder']="http://neagent.by/modules/Realt/files/";
$addata['ad_mainpic']="http://neagent.by/modules/Realt/files/" . "t_".  $ad_pictures[0];
}
else
{ $addata['ad_pictures']=array();
$addata['ad_mainpic']="http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";}


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
}
 else
{
 $addata['sutki_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/nopic.gif' width='60' height='50'   />";
} 




if ($this->data['wap_view']==1) {
//echo("globals");
//print_r ($CI->globals);
echo ($CI->page);
$str_add .= $CI->parser->parse('wap_realt_ad_moderate', $addata);
}
else{
//echo("globals2");

$str_add .= $CI->parser->parse('realt_ad', $addata);


}











}
// Обработка всех объявлений закончена


break;

default:
$str_add .="no table";
break;


}


//echo($str_add);


$str_add .= "<br style='clear:both;'><div style='clear:both;height:25px;'>";
$str_add .= $data['pager'];
$str_add .= "</div>";
 

$this->data['realt']=$str_add;
//echo ($str_add);
//echo ("<textarea>".$CI->data['realt']."</textarea>");
return  $this->data['realt'];










		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		


	
	
	
	
	
	
	