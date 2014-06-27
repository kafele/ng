<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$ci=$CI =& get_instance();
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	$ci =  &get_instance();


if ($CI->input->post('email') != ''&&$CI->input->post('password') != ''){$act='login'; }


 
if ($CI->input->post('act') == 'send' ){$act='send'; }

	
switch	($act){
case 'logout':
$CI->connect->logout($logg);
$this->data['realt']=  '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=http://neagent.by/">';
return;
break;


case 'send':
$err="";
$email=$CI->input->post('email');
$temp_pass=generate_password(22);
//$CI->load->library('ion_auth');
//$forgotten = $CI->ion_auth->forgotten_password($email);
//echo("=" . $forgotten);
//if ($forgotten) { //if there were no errors
//					$this->session->set_flashdata('message', $this->ion_auth->messages());
//					//redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
//					
//				}
//				else {
//					$this->session->set_flashdata('message', $CI->ion_auth->errors());
//					//redirect("auth/forgot_password", 'refresh');
//				}
				
				
// генерировать временный пароль

$CI->db->select('id_user');
$this->db->from('users');
$CI->db->where('email',  $email);
$query = $this->db->get();


if ($query->num_rows() != 0){
	foreach ($query->result() as $row){
		$id_user = $row->id_user;
	}
}
//  Тут можно добавить, чт отакой пользователь не найден
else{
$this->data['realt']= "Пользователя с таким электронным ящиком не существует.";
return;
}





$now=date("Y-m-d H:i:s",time());


$data=array(
 	'user_id'		=>	 $id_user	, 	 	 	 	 	 
 	'pass'	    =>		$temp_pass ,	 	 	 	 	 	 
 	'date'	    =>	 	$now 
)	;
$CI->db->insert('users_temp_pass', $data);


//записать его в базу

//отправить пользователю

$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to($email);
$CI->email->subject('Восстановление пароля');
$CI->email->message('Вы запросили восстановление пароля на neagent.by. Перейдите по этой ссылке, чтобы задать новый пароль : http://neagent.by/board/resetpassword/' . $temp_pass);
$CI->email->send();



$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to('dakh2008@mail.ru');
$CI->email->subject('КОПИЯ МНЕ Восстановление пароля' . $email);
$CI->email->message('Вы запросили восстановление пароля на neagent.by. Перейдите по этой ссылке, чтобы задать новый пароль : http://neagent.by/board/resetpassword/' . $temp_pass);
$CI->email->send();





 saveLog('sendpass.txt', 'Вы запросили восстановление пароля на neagent.by. Перейдите по этой ссылке, чтобы задать новый пароль : http://neagent.by/board/resetpassword/' . $temp_pass .  $this->user['id_user']  . " | " .  $_SERVER['HTTP_USER_AGENT'] . " | "   . $email   );



//$CI->email->print_debugger();
 //$this->data['realt']= $CI->email->print_debugger();
$this->data['realt']  = "Ссылка для восстановления пароля отправлена на email  " . $email;

if   (strpos($email, 'tut.by') > -1) {
$this->data['realt'] .= "<br>Вы используете почту tut.by. Если письма нет в папке <b>входящие</b>, проверьте, не попадает ли оно в папку <b>СПАМ</b> <br><img src='http://img1.neagent.by/s/tut_by_spam.jpg'><br>Если это так, нажмите на кнопу 'не спам' или переместите письмо в папку 'входящие'";
}




break;
 

 
	
	
default:
$addata['mlev']=$this->data['mlev'];
$this->data['realt']= $CI->parser->parse('realt_sendpassword_form', $addata);
	
}
	
	
	
	
	
	
	