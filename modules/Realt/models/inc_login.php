<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();

$CI->load->library('parser');
$ci =  &get_instance();

if ($this->data['wap_view']==1){
$return_url='http://neagent.by/wap/';
}
else{
$return_url='http://neagent.by/';
}

$act="";


if ($CI->input->post('email') != ''&&$CI->input->post('password') != ''){$act='login'; }


if ($CI->input->post('act') == 'logout' ){
$act='logout'; 
}



$CI->load->library('ion_auth');
$user = $CI->connect->get_current_user();
//echo('user');
//print_r($user);


if ($user['id_user'] >0 && $act!='logout'){

$this->data['realt'] ="<image src='http://neagent.by/themes/neagent_style/assets/images/user.png'>Вы вошли как <a href='http://neagent.by/board/user'><b style='color:#61ad49;'>" . $user['username'] . "</b> </a><br>";

if ($user['id_group'] ==16){
$this->data['realt']  .= "<a href='http://neagent.by/client/'>управление заказами<br>";
}

$this->data['realt']  .= "<form action='http://neagent.by/board/loginuser' method='POST'>
<input type='hidden' name='act' value='logout'>
<input type='submit' value='Выйти'> 
</form>";

 


}
	
	
else{	
	
	
	
	
switch	($act){
case 'logout':
$CI->connect->logout( );
$this->data['realt']=  '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL='.$return_url.'">';
return;
break;

case 'login':
$err="";
$email=$CI->input->post('email');
$pass=$CI->input->post('password');
$logg=array('username' => $email,'password' => $pass );
$remember = TRUE; // Запомнить пользователя
 //$CI->ion_auth->login($email, $pass, $remember);

 
        $identity = $CI->input->post('email');
		$password = $CI->input->post('password');
		
		$remember = TRUE; // remember the user
		// $CI->load->library('ion_auth');
		
		
     $id = 1;
		$data = array(
					'first_name' => 'admin',
					'last_name' => 'Edmunds',
					'password' => 'lufaulufau',
					 );
	//	$CI->ion_auth->update($id, $data);
		
 
                       if ($CI->connect->login($logg))
					
					//  if ($CI->ion_auth->login($identity, $password, $remember) )
					{
					$return_url = $CI->input->post('returnurl')?$CI->input->post('returnurl'):$return_url;
					$enter='<h2>Вход в систему.</h2> Выполняется вход. Если не хотите ждать, 
					<a href="http://neagent.by/client">нажмите здесь</a><br>
					
					<div id="logindiv" style="width:1px; background-color: #50b448; height:18px;"></div>
					<script>
					$("#logindiv").animate({
                    width: "100%"
                }, 4500);
					</script>
					<META HTTP-EQUIV="REFRESH" CONTENT="0;URL='.$return_url.'">';
					$this->data['realt']= $enter ;
					return ;
					
					
					
					}
					else
					{
					$this->data['realt']='Неправильный пароль. попробуйте еще раз.<br><br><br>';
					$addata['mlev']=$this->data['mlev'];
$this->data['realt'] .= $CI->parser->parse($this->data['view_prefix'] . 'realt_login_form', $addata);
					return ;
					}

break;
	
default:
$addata['mlev']=$this->data['mlev'];
if ($returnurl){
$addata['returnurl']=$returnurl;
}

$this->data['view_prefix']=isset($this->data['view_prefix'])?$this->data['view_prefix']:"";
$this->data['realt']=isset($this->data['realt'])?$this->data['realt']:"";


$this->data['realt'] .= $CI->parser->parse($this->data['view_prefix'] . 'realt_login_form', $addata);
	
}
	
	
	}
	
	
	
	