<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');




if (!function_exists('get_user_ads_table')) {
    function get_user_ads_table($userid)
    {

$CI =& get_instance();




$CI->db->where('ad_user', $userid);
$query = $CI->db->get('ads');
	$adinfo="";	
		  if ($query->num_rows() > 0)
		  {
		$adinfo .="<h2 style='width:100%; background-color:#336699; color:white;margin-bottom:18px;'>Ваши объявления и реклама</h2> ";
		$adinfo .='<table class="client_table"><tr class="client_table_header"><td>Код объявления</td>';
		$adinfo .='<td>Статус</td><td>Дата </td>
		<td>Текст</td>
		<td>Срок окончания</td>
		<td>Дополнительно</td></tr>';
		    foreach ($query->result() as $row)
		    {

			$ad_title =$row->ad_title;
			$ad_message =$row->ad_message;
			$ad_id =$row->ad_id;
			$ad_price =$row->ad_price;
			$ad_firstdate =$row->ad_firstdate;
			$ad_enddate =$row->ad_enddate;
			$ad_url =$row->ad_url;
			$ad_type =$row->ad_type;
			$ad_show =$row->ad_show;
			$ad_hits =$row->ad_hits;
			$do=$row->ad_enddate;
			$up=$row->ad_up_date;
			 $ad_pending =$row->ad_pending;
            $ad_message =$row->ad_message;

//nowdate = date("Y-m-d H:i:s");
			//$diff = strtotime($do) - strtotime($nowdate);
			//$secleft =  cldate_diff($do, $nowdate);
			//$days = FLOOR (($diff  / 60 / 60/24)*10)/10;
			//$daysleft = seconds2times($diff);
			
			
			
			$status="";
			if ($ad_show==0){
			
			if ($ad_pending==1){
			$status = "  на модерации " ;
			}
			else{
			$status = "  удалено " ;
			}
			
			}
			else{
			$status = "  активно " ;
			}
			$adinfo .='<tr> <td>100'.$ad_id  . '</td>';
			$adinfo .='<td>'. $status . '</td>';
			  
			$adinfo .='<td class="center">' . $ad_firstdate . '</td>' ;
			$adinfo .='<td class="center">' . $ad_message . '</td>' ;
			$adinfo .='<td class="center">' . $ad_enddate . '</td>' ;
			$adinfo .='<td class="center"><a href='.  $CI->realt_route_model->base_url . "snimu/" . $ad_url . ' target="_blank"> перейти </a></td></tr>' ;
			 
		     
		  }	
		  $adinfo .='</table>';

   }
	   
	  


$user_id = isset($user_id)? $user_id : false;
$info = getClientInfoByUserId($user_id);
//$info['id']=86;
$adinfo="";
if (isset($info['id'])){
 

$CI->db->where('ad_client', $info['id']);
$query = $CI->db->get('sutki');
		
		  if ($query->num_rows() > 0)
		  {
		$adinfo .="<h2 style='width:100%; background-color:#336699; color:white;margin-bottom:18px;'>Ваши объявления и реклама на сутки</h2> ";
		$adinfo .='<table class="client_table"><tr class="client_table_header"><td>Код объявления</td>';
		$adinfo .='<td>Статус</td><td>Дата </td>
		<td>Текст</td>
		<td>Срок окончания</td>
		<td>Дополнительно</td></tr>';
		    foreach ($query->result() as $row)
		    {

			 
			$ad_message =$row->ad_message;
			$ad_id =$row->ad_id;

			$ad_postdate =$row->ad_postdate;
			$ad_enddate =$row->ad_enddate;
			$ad_url =$row->ad_url;
			$ad_type =$row->ad_type;
			$ad_show =$row->ad_show;
			$ad_hits =$row->ad_hits;
			$up=$row->ad_up_date;
			 
            $ad_message =$row->ad_message;

//nowdate = date("Y-m-d H:i:s");
			//$diff = strtotime($do) - strtotime($nowdate);
			//$secleft =  cldate_diff($do, $nowdate);
			//$days = FLOOR (($diff  / 60 / 60/24)*10)/10;
			//$daysleft = seconds2times($diff);
			$status="";
			if ($ad_show==0){
			$status = "  не активно " ;
			}
			else{
			$status = "  активно " ;
			}
			
			$adinfo .='<tr> <td>200'.$ad_id   . '</td>';
			$adinfo .='<tr><td>'. $status . '</td>';
			

			  
			$adinfo .='<td class="center">' . $ad_firstdate . '</td>' ;
			$adinfo .='<td class="center">' . $ad_message . '</td>' ;
			$adinfo .='<td class="center">' . $ad_enddate . '</td>' ;
			$adinfo .='<td class="center"><a href='. $CI->realt_route_model->base_url .  "nasutki/" . $ad_url . ' target="_blank"> перейти </a></td></tr>' ;
			 
		     
		  }	

	$adinfo .='</table>';	  
		  
		  
}


} // if isset



	  
	   
	   
	   
        return $adinfo;


    }
}


if ( ! function_exists('getClientInfoByUserId'))  // точная копия функции с client_helper
{
function getClientInfoByUserId($user_id){
$info=array();
$CI =& get_instance();
$CI->db->limit(1,0);
$CI->db->where('user_id', $user_id);
$query = $CI->db->get('fin_clients');
if ($query->num_rows() == 0){}
if ($query->num_rows() > 0)
		  {
foreach ($query->result() as $row)
		    {
			$info['id'] = $row->id;
			$info['user_id'] = $row->user_id;
			$info['name'] = $row->firmname;$info['firmname'] = $row->firmname;
			$info['unp'] = $row->unp;
			$info['phone'] = $row->phone;
			$info['cc_id'] = $row->cc_id;
}
}
return $info;
}
}

