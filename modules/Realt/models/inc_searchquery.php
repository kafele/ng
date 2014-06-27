<?
$CI->db->select('*');
$CI->db->from ($table); 
$CI->db->where ('ad_city', $city);

//areas
//echo ("case0");



// if (count($arr_values)>0&&count($subarr_values)>0){
// array_push($arr_values, 0);
// array_push($subarr_values, 0);
// $arr_valuesStr=join(",",$arr_values);
// $subarr_valuesStr=join(",",$subarr_values);
// $CI->db->where("(ad_area in ($arr_valuesStr) OR ad_subarea in ($subarr_valuesStr))");
// $CI->db->order_by('ad_area', 'DESC');
// $CI->db->order_by('ad_subarea', 'DESC');
// }




// if (count($arr_values)>0&&count($subarr_values)==0){
// array_push($arr_values, 0);
// $CI->db->where_in('ad_area', $arr_values);
// $CI->db->order_by('ad_area', 'DESC');
// }

// if (count($arr_values)==0&&count($subarr_values)>0){
// array_push($subarr_values, NULL);
// $CI->db->where_in('ad_subarea', $subarr_values);
// $CI->db->order_by('ad_subarea', 'DESC');
// }




$CI->db->limit($limit,$from);
$CI->db->where ('ad_catid', $cat_id);
//$CI->db->where ('ad_city', $sity);



$params['ad_fakefor']="UID=" . $CI->data['user_uid'] . ";" ;


if ($this->data['mlev']!=4){

//$CI->db->where ('ad_show',  $ad_show );
$CI->db->where ("(ad_show=" . $ad_show . " or ad_fakefor LIKE '%" . $params['ad_fakefor'] . "%' ) " );


}

if ($this->data['mlev']==4 && $table=="sutki"){

//$CI->db->where ('ad_show',  $ad_show );
$CI->db->where ("(ad_show=" . 1 . " ) " );


}



$condition=""; $cand="";   
if ($k1 !=0){ $condition= $condition .  $cand . '`ad_komnat`=1'  ;  $cand=" or ";  }
if ($k2 !=0){ $condition= $condition .   $cand . '`ad_komnat`=2'  ;  $cand=" or ";  }
if ($k3 !=0){ $condition= $condition .   $cand .'`ad_komnat`=3'  ;  $cand=" or ";  }
if ($k4 !=0){ $condition= $condition .   $cand .'`ad_komnat`=4'  ;  $cand=" or ";  }
if ($k0 !=0){ $condition= $condition .   $cand .'`ad_komnat`=0'  ;  $cand=" or ";  }


// Дата 
if ($postdate !=0){$datest="DATE_SUB(CURDATE(),INTERVAL $postdate DAY) <=ad_postdate";$CI->db->where(  $datest  );} 


 
if ($withcontent !=""){ 
$withcontentSQL =  "`ad_message` like '%$withcontent%' or `ad_phones` like '%$withcontent%'   or `ad_street` like '%$withcontent%'  or `ad_email` like '%$withcontent%'";
$CI->db->where("(".  $withcontentSQL .")" ); 
}


if ($formtype =="kn"){ 
$CI->db->where("ad_komm_type",  $komm_type ); 
}


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


 
$CI->db->order_by("ad_up_date", "desc");
$CI->db->order_by("ad_postdate", "desc");
//$CI->db->order_by($order, $ordertype);
 




if ($this->data['mlev']==4) {

$this->data['debug'] .="-". $condition   ."-";
 
}