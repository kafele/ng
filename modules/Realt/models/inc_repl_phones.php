<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			

			
			
 	
	
	
	
	
			
			
			
$ip=$_SERVER["REMOTE_ADDR"];	
	

	
if ($ip=="81.25.33.134" ){
	
//$addata['ad_phones']=str_replace ("375", "###", $addata['ad_phones']);
//$addata['ad_phones']=str_replace ("5", "6", $addata['ad_phones']);
//$addata['ad_phones']=str_replace ("4", "5", $addata['ad_phones']);
//$addata['ad_phones']=str_replace ("3", "6", $addata['ad_phones']);
//$addata['ad_phones']=str_replace ("7", "3", $addata['ad_phones']);
//$addata['ad_phones']=str_replace ("###", "375", $addata['ad_phones']);
//$addata['ad_street']=str_replace ("à", "î", $addata['ad_street']);
//$addata['ad_street']= $addata['ad_street'] + ", 1";
$addata['ad_komnat']=$addata['ad_komnat']*1+2;
//$addata['ad_dom']=1;
$addata['ad_price']=$addata['ad_price']*1 +380;	
		}

		
		
 
		
		
		
		if ($ip=="81.25.33.134" ||  $this->data['mlev']==4){
		if ($addata['ad_id']=="844135"){
		$addata['ad_street']="http://neagent.by";
		$addata['ad_price']="200";
		
		}
		}
		
		
		
			
			
			
			
			
			
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

if ($precount==8){$pre=substr($pre, 1, 7);}

if ($precount==9){$pre=substr($pre, 2, 7);}
if ($precount==10){$pre=substr($pre, 3, 7);}
$addata['ad_phones']="8 029 " . $pre;
if ($this->data['mlev']!=4){$addata['ad_comments_count']=0;}
}


if ($addata['ad_phones']=="8028"){
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
if ($this->data['mlev']!=4){$addata['ad_comments_count']=0;}
}


if ($addata['ad_phones']=="8028"){
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
if ($this->data['mlev']!=4){$addata['ad_comments_count']=0;}
}




 


if ($CI->data['scenery_fakephones']==1){

//$faketel="8 (029) " . rand (100, 899). "-" rand (10, 99) . "-"  rand (10, 99) ;
$addata['ad_phones']=str_replace ("375", "###", $addata['ad_phones']);
$addata['ad_phones']=str_replace ("5", "6", $addata['ad_phones']);
$addata['ad_phones']=str_replace ("4", "5", $addata['ad_phones']);
$addata['ad_phones']=str_replace ("3", "6", $addata['ad_phones']);
$addata['ad_phones']=str_replace ("7", "3", $addata['ad_phones']);
$addata['ad_phones']=str_replace ("###", "375", $addata['ad_phones']);
 
 
 
$addata['ad_message']="Ñïàìó - ÍÅÒ";

 
 
 
 
 
 
///$addata['ad_phones']="---------";
//$addata['ad_phones']="";
 
 
 
 
 
 //$addata['ad_phones']=$faketel;
$ip=$_SERVER["REMOTE_ADDR"];
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('Replase phone');
$CI->email->message(date("Y-m-d H:i:s") . '; ip=' . $ip ."; uid="   . $CI->data['user_uid'] . ";" . $messstr);


if ($send!=1){
$CI->email->send();
$send=1;
}
 

}



