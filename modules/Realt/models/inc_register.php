<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	$ci =  &get_instance();


 


if ($CI->input->post('email') != ''&&$CI->input->post('pass') != ''){
$act='step1'; 
}

	
switch	($act){

case 'step1':

$err="";
$email=$CI->input->post('email');

$inblack = inEmailBlackList($email);
if ($inblack==2) {
$this->data['realt'] = "<h2>Такой Email-сервер заблокирован. </h2><i> Почта $email , которую вы ввели , запрещена, т.к. этот почтовый сервер загажен спамерами и агентами. Заведите почту в другом месте. </i>"   ;
return;
}







$pass=$CI->input->post('pass');


 $regerr="";

if ($err=="") {
$usr=array(
id_group => 5, //pending
join_date => date('Y-m-d H:i:s'),
username => $email,
screen_name  => $email,
password => $pass,
email =>  $email
//'salt' => $ci->connect->get_salt()
);
 

$id ="";
// Если пользователь не существует то его создать, это для всех и всег да пока
					if ( ! $ci->base_model->exists(array('username' => $usr['username']), "users"))
					{
						if ( ! $ci->base_model->exists(array('email' => $usr['email']), "users"))
						{
						
						
							if (!$ci->connect->register($usr))
							{
								$ci->usermanager_functions->additional_err['register'] = $ci->connect->error;
								
								//$data = $ci->usermanager_functions->prepare_register_output();
							} else {
							// Зрегистрирован
$id = $ci->db->insert_id();
$CI->db->where("id_user", $id);
$CI->db->set("id_group", "5");
$CI->db->update("users");


							}
						}
						else
						{ $regerr .="Такой email уже зарегистрирован. Воспользуйтесь восстановлением пароля, если вы его забыли.";
							$ci->usermanager_functions->additional_err['register'] = lang("module_usermanager_error_email_exists");
						}
					}
					else
					{
					$regerr .="Такой email уже зарегистрирован. Воспользуйтесь восстановлением пароля, если вы его забыли!";
						$ci->usermanager_functions->additional_err['register'] = $config['usermanager_email_as_username'] == true ? lang("module_usermanager_error_email_exists") : lang("module_usermanager_error_username_exists");
					}
//echo ("Пользователь зарегистрирован, ID пользователя:" . $id);
if ($id==""){
$regerr .="<br>Пользователь не зарегистрирован";
}
}
else {
// если есть ошибки 
// echo ($err);
//return ;
}
//конец регистрации нового клиента


if ($regerr!="") {
$this->data['realt']=$regerr;
return  ;
}
else
{
/////зарегистрирован 


$data=array(
 	user_id	=>	 $id	, 	 	 	 	 	 
 	uid	=>		$CI->data['user_uid'] ,	 	 	 	 	 	 
 	ip	    =>	 	$_SERVER["REMOTE_ADDR"]	 	 	 	 
)	;

 //if ($this->data['mlev']==4) {print_r($data);}  


$CI->db->insert('realt_users_uids', $data);




 
}





////////////////////
$CI->db->select('*');
$CI->db->where ('id_user', "".$id ."");
$CI->db->limit(1);
$CI->db->from ('users');
$query = $CI->db->get();
if ($query->num_rows() == 0 )
			{
				//$this->data['realt']='Не найдено объявление.';break;
			}
			else
			{
			 
				foreach ($query->result() as $row){
		
$ad_salt = $row->salt; 

}
}
/////////////////////





	$letterdata = array(
		'salt' => $ad_salt,
		'id' =>$id,
	);
		

 
$subject_letter = "Пожалуйста, подтвердите ваш email на neagent.by ";
 
$message = $this->load->view('emails/ad_register_email', $letterdata, true);


  
 $config['mailtype'] = 'html';
 $config['protocol'] = 'sendmail';
 $config['mailpath'] = '/usr/sbin/sendmail';
 $CI->load->library('email', $config);
 $CI->email->set_newline("\r\n");
 $CI->email->from('info@neagent.by');
 $CI->email->to($email);
 $CI->email->subject($subject_letter);
 $CI->email->message( $message);
 $CI->email->send();


 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 /////////// вход 
 $logg=array('username' => $email,'password' => $pass );
					if ($CI->connect->login($logg))
					{
 
					
					}
					else
					{
 
					}
 
 
 
 
 


$addata['email']=$email;
$this->data['realt']= $CI->parser->parse('realt_register', $addata);


break;
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
	
	
	
	
	
	
	