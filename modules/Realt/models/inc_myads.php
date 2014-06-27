<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	


$act=($_POST['act'] != '') ? $_POST['act'] : "default";

	
switch	($act){
case 'checkuser':

$phone=$_POST['number'];
$day=$_POST['day'];
$month=$_POST['month'];
$code=$_POST['code'];
$userUid=$CI->data['user_uid'];

//echo ("--". $userUid);
//strtotime(2010-10-10);
$data=strtotime("2011-" . $month . "-".  $day);
//echo ($day ." " . $month . " 2011" );
//echo ("data=" . $data);
$result=checkSecretcode($data, $code);


switch	($result){
case '0':
$this->data['realt']="Такого объявления не найдено";
break;

case '1':


$ad_id=getAdidFromCode($code);


$postdate = date("Y-m-d H:i:s");
$addata = array(
	uid	=> $userUid , 	 	 	 	 	 	 
	date =>  $postdate,
	enddate =>  $postdate,
	ad_id=> $ad_id,
	description=> "ввел код " . $code,
	ip =>  $_SERVER["REMOTE_ADDR"] 
            );
$CI->db->insert('realt_rights', $addata);

//echo $CI->db->_error_message();
	// echo $CI->db->last_query();

$this->data['realt']="Теперь с этого компьютера видны все телефоны";
break;

case '2':
$this->data['realt']="К сожалению ваше объявление еще недоступно. После  проверки модератором  оно станет доступно на сайте.";
break;

case '3':
$this->data['realt']="Это объявление устарело.";
break;

case '4':
$this->data['realt']="Это объявление удалено.";
break;

}

//0 не найдено 
//return "2"; // на модерации
//return "4"; // не показано, удалено 
//return "3"; // старое очень более 15 дней
//return "1"; // свсё ок











break;

case 'ip':
  $showtype="ip";
	$ip=$CI->uri->segment(5);
	if ($uid=="") {	echo "не задан ip ";	return;
  	}
	default:
$addata['mlev']=$this->data['mlev'];
$this->data['realt']= $CI->parser->parse('realt_myads', $addata);
	
	}
	
	
	
	
	
	
	