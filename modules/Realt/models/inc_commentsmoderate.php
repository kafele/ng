<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI = $this->CI =& get_instance();		






	if  ($this->data['mlev']!=4 ){
	$this->data['realt']="запрещено";
	return;
	}

$limit=80;	
$from=0;
$showtype="moderate";
$table="realt_ads_comments";
$catrow="ad_catid";
		
$CI->load->library('pagination');

	 
	  $config['uri_segment'] = 4;
	  $config['base_url'] = "http://neagent.by/board" ; //
	  

	  
	  
		$config['total_rows'] = $CI->db->count_all($table);//$CI->db->count_all('ads'); //   было $CI->$config['total_rows'] = $CI->db->count_all('records'); // 
		$config['per_page'] =    (config_item('realt_ads_per_page')>0)?config_item('realt_ads_per_page'): 20;   //  выводить на страницу
		$config['num_links'] = 6;    //  количество ссылок - косметический параметр
		$config['padding'] = 1;
	    
		//$config['uri_segment'] = 2;  //  
		$config['first_link'] = 'В начало';
		 


		
$cat_id=(int)$cat_id;

//if ($cat_id>0)	{if ($table=="ads"){$CI->db->where('ad_catid', $cat_id);};
$CI->db->from("realt_ads_comments");
//$CI->db->where("ad_pending", 1);




$allresults=$CI->db->count_all_results();
if ($allresults==0){
$this->data['realt']="нет комментариев на модерации";
return;
}


 
//return;


$config['total_rows']= $allresults;

$firstad=(int)($CI->uri->segment($config['uri_segment']) +0); // +1 потому чт онулевое объявление уже показано 

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
	   





		
			
$CI->db->from("realt_ads_comments");
$CI->db->limit(400);
$CI->db->where("comment_state", 0);

$CI->db->orderby("comment_id", "desc");
$query = $CI->db->get();






//echo ($CI->db->last_query() );








if  ($this->data['mlev']!=4){$str_add .= "<div style='height:25px;'>";}
 

$str_add .= $data['pager'];
if  ($this->data['mlev']!=4){$str_add .= "</div>";}

 
 if ($query->num_rows() == 0  )
 {
 
 $str_add .= "Нет комментариев";
 $this->data['realt']=$str_add;
				 return;
 }
 
$alt=1;
// начата обработка объявлений 
foreach ($query->result() as $row)
{
 
if ($alt==1){$alt=0;}else{$alt=1;}
$itemalt=($alt==1)?" itemalt" :"";

$addata = array(
'mlev' => $this->data['mlev'],
'comment_id' => $row->comment_id,
'comment_text' => $row->comment_text,
'comment_ad' => $row->comment_ad,
'comment_date' => $row->comment_date,
'comment_user' => $row->comment_user,
'comment_show' => $row->comment_show,
            );
$delayed=false;


  

  

//else{
$str_add .= $CI->parser->parse('realt_ad_comment_moderate', $addata);
//}



}
// Обработка всех объявлений закончена


 
 






$str_add .= "<br style='clear:both;'><div style='clear:both;height:25px;'>";
 $str_add .= $data['pager'];
$str_add .= "</div>";


$str_add .= $CI->parser->parse('realt_ad_comment_moderate_script', $addata);

$this->data['realt']=$str_add;
//echo ($str_add);
//echo ("<textarea>".$CI->data['realt']."</textarea>");


return $this->data['realt'];





 
	
	
	
	
	
	