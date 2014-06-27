<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	$ci =  &get_instance();


if ($CI->input->post('email') != ''&&$CI->input->post('password') != ''){$act='login'; }
if ($CI->input->post('act') == 'reset' ){$act='reset'; }

	
switch	($act){
case 'logout':
$CI->connect->logout($logg);
$this->data['realt']=  '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=http://neagent.by/">';
return;
break;


case 'reset':
$err="";
 
$temp_pass=$CI->input->post('temp');
$pass1=$CI->input->post('pass1');
$pass2=$CI->input->post('pass2');

if ($pass1 != $pass2){
  $this->data['realt']= "Введенные пароли не совпадают.";
  return;
}


$timeout=date("Y-m-d H:i:s",time()-( (1*24*60*60)));
$CI->db->select('user_id');
$CI->db->from('users_temp_pass');
$CI->db->where('pass',  $temp_pass);
$CI->db->where('date >',  $timeout); // только за последние сутки
$CI->db->order_by("id", "desc"); 
$CI->db->limit(1, 0);

$query = $CI->db->get();
//echo 	($CI->db->last_query());
if ($query->num_rows() != 0){
	foreach ($query->result() as $row){
	$user_id = $row->user_id;
	}
}
else{
  $this->data['realt']= "Ссылка устарела, попробуйте запросить восстановление пароля еще раз.";
  return;
}



//$user_id и пароли записаны. 
//осталось изменить 
$identification = array('id_user' => $user_id);


$user=$CI->connect->get_user($identification);
//print_r ($user);
$newpass=$CI->connect->encrypt($pass1, $user);
//echo("<br>");
//echo("newpass=" . $newpass);
//echo("<br>");


 
 

$CI->db->where("id_user", $user_id);
$CI->db->set("password", $newpass);
$CI->db->update("users");
//echo($CI->db->last_query());


  saveLog('sendpass.txt', 'ПАРОЛЬ ИЗМЕНЕН user='  .  $user_id  . " | " .  $_SERVER['HTTP_USER_AGENT'] . " | "     );

 
$this->data['realt']= "Пароль изменен.";

break;
 

 
	
	
default:


$pass=$CI->uri->segment(5);
$timeout=date("Y-m-d H:i:s",time()-( (1*24*60*60)));

//echo($pass);

$CI->db->select('');
$CI->db->from('users_temp_pass');
$CI->db->where('pass',  $pass);
$CI->db->where('date >',  $timeout); // только за последние сутки
$CI->db->order_by("id", "desc"); 
$CI->db->limit(1, 0);

$query = $CI->db->get();



if ($query->num_rows() != 0){

	foreach ($query->result() as $row){
	$user_id = $row->user_id;
	$username = $row->username;	
	//echo("найден юзер " . $username);	
		
	}
}
else{
  $this->data['realt']= "Ссылка устарела, попробуйте запросить восстановление пароля еще раз.";
  return;
}




$CI->db->select('');
$CI->db->from('users');
$CI->db->where('id_user',  $user_id);
$CI->db->limit(1, 0);

$query = $CI->db->get();

if ($query->num_rows() != 0){
	foreach ($query->result() as $row){
	$username = $row->username;	
	//echo("найден юзер " . $username);	
		
	}
}



$addata['mlev']=$this->data['mlev'];
$addata['pass']=$pass;
$addata['username']=$username;
$this->data['realt']= $CI->parser->parse('realt_resetpassword_form', $addata);
	
}
	
	
	
	
	
	
	