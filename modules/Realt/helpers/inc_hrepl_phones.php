<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			

			
			
 	
	
	
	
	
			
			
			
$ip=$_SERVER["REMOTE_ADDR"];	
	

	
 
		
		
 
		
 
		
		
		
			
			
			
			
			
			
//			
			
			

//fake
//$scode=$row->ad_secretcode;



 


 


if ($addata['ad_phones']=="8029"){
$ad_uid=$CI->data['user_uid'];
$ad_uic=(int)$_COOKIE["uic"];
$ad_cref=$CI->data['user_cref'];
$ad_ip=$_SERVER["REMOTE_ADDR"];
$pre = str_replace (".", "", $ad_ip);


$precount=strlen($pre);
if ($precount==5){$pre="99" . $pre . "";}

if ($precount==6){$pre="9" . $pre . "";}

if ($precount==8){$pre=substr($pre, 0, 7);}

if ($precount==9){$pre=substr($pre, 0, 7);}
if ($precount==10){$pre=substr($pre, 0, 7);}
$addata['ad_phones']="8 029 " . $pre;
 
}




 




