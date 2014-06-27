<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	

$code=$_GET['code'];
$aid=$_GET['id'];
if (($_GET['action']=='verify'||$_GET['action']=='verifyuser') && strlen($code)>3 &&strlen($aid)>1){
//good do nothing
}
else{
$this->data['realt']= "Ошибка кода. Если в письме вам пришла эта ссылка для подтверждения, то сообщите об этом администратору.";
return;
}



/////////// Верификация пользователя 
if ($_GET['action']=='verifyuser'){




$CI =& get_instance();$CI->db->select('*');$CI->db->from ('users'); 
$CI->db->where ('salt',  $code );
$CI->db->where ('id_user',  $aid ); $CI->db->limit(1);
$query = $CI->db->get();//echo ($CI->db->last_query());
if ($query->num_rows() == 0 )
			{
$this->data['realt']= "Ошибка. Если в письме вам пришла эта ссылка для подтверждения, то сообщите об этом администратору.";
return;}
else{
foreach ($query->result() as $row){

if ($row->verified==1){
$this->data['realt']= "Этот email уже подтвержден.";
return;
}

else{
$ad_pending=$row->ad_pending;
$CI->db->where ('id_user',  $aid );
$CI->db->where ('salt',  $code );
$this->db->set("verified", 1);
$this->db->update("users");
$this->data['realt']= "Еmail  подтвержден. Спасибо за регистрацию.";
return;

}


}
}










}




////////// ВЕРИФИКАЦИЯ ОБЪЯВЛЕНИЯ  и заодно пользователя. 


$CI =& get_instance();$CI->db->select('*');$CI->db->from ('ads'); $CI->db->where ('m_confirm_code',  $code );
$CI->db->where ('ad_id',  $aid ); $CI->db->limit(1);
$query = $CI->db->get();//echo ($CI->db->last_query());
if ($query->num_rows() == 0 )
			{
$this->data['realt']= "Ошибка. Если в письме вам пришла эта ссылка для подтверждения, то сообщите об этом администратору.";
return;}
else{
foreach ($query->result() as $row){
if ($row->m_confirmed==1){
$this->data['realt']= "Этот email уже подтвержден. Если объявления все равно нет, возможно оно на модерации, или удалено. " .  "<div style='height:500px;'></div>";
return;
}
else{

///////////////////////
$ad_pending=$row->ad_pending;
$nowdate = date("Y-m-d H:i:s");
$CI->db->where ('ad_id',  $aid );
$CI->db->where ('m_confirm_code',  $code );
$this->db->set("m_confirmed", 1);
if ($ad_pending!=1){
$this->db->set("ad_show", 1);
}
$this->db->set("ad_postdate", $nowdate);
$this->db->update("ads");







$ad_catid	= (string)$row->ad_catid;
$ad_secretcode	= $row->ad_secretcode;
$ad_pending = $row->ad_pending;
$ad_email = $row->ad_email ;
$ad_url= $row->ad_url;
$subject_letter = "Ваше объявление на Neagent.by размещено";
switch ($ad_catid) {case '2':case '4':case '6':case '8':case '10':
$ad_fullurl="http://neagent.by/snimu/".$ad_url;break; 
case '1':case '3':case '5':case '7':case '11':
$ad_fullurl="http://neagent.by/sdayu/".$ad_url;break;
default:$ad_fullurl="http://neagent.by/sdayu/".$ad_url;}

$letterdata = array(
		'secret_code' => 	$row->ad_secretcode,
		'ad_moderate' => $row->ad_pending,
		'ad_url' => $ad_fullurl,
		'ad_id' =>$row->ad_id
	);

$message = $this->load->view('emails/ad_added_email', $letterdata, true);
$messagestr2 = "Вы отправили объявление на Neagent.by. Код объявления: " .   $ad_secretcode   . " . 
Сохраните этот код, с ним Вы сможете отредактировать или удалить Ваше обьявление. 
Для удаления объявления щелкните на его заголовке, перейдете на его страницу, 
сразу под ним будут ссылки для редактирования и удаления." ;

if ($ad_pending==1){$messagestr2 = $messagestr2 . " Ваше объявление появится на сайте после проверки модератором. " ;
}
$messagestr3="<br>Код объявления отправлен на ваш email.<br> " ;
}

$config['protocol'] = 'sendmail';$config['mailpath'] = '/usr/sbin/sendmail';$config['mailtype'] = 'html';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to($ad_email);
$CI->email->subject($subject_letter);
$CI->email->message($message);
$CI->email->send();

	$this->data['realt']="Ваше объявление опубликовано." . "Код объявления : " .   $ad_secretcode     . $messagestr3;
	if ($ad_pending==0){
	$this->data['realt']="Ваше объявление  появится на сайте после проверки модератором. Это может занять от получаса часа до трех часов. " . "Код объявления : " .   $ad_secretcode     . $messagestr3 . "<div style='height:500px;'></div>" ;
	}


}





}
























	
	
	
	
	
	