<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	$ci =  &get_instance();

$str="<h2> Сдавай агентов и зарабатывай баллы!</h2>";
if (!$this->data['user']['id_user']>0){




 $str .= "Чтобы зарабатывать баллы, сначала войдите, или зарегистрируйтесь!";
 $str .= "<br><br><a href='http://neagent.by/board/loginuser'>Войти</a>" ;

$this->data['realt']= $str ;

return;
}


if ($CI->input->post('act') == 'agent' ){$act='agent'; }

switch	($act){
case 'agent':

$phone=$CI->input->post('phone');
$name=$CI->input->post('name');
$company=$CI->input->post('company');
$type=$CI->input->post('type');
$other=$CI->input->post('other');
$info=$CI->input->post('info');
$user=$this->data['user']['id_user'];

$mess .= "; тел  " . $phone ;
$mess .= "; name  " . $name ;
$mess .= "; company  " . $company ;
$mess .= "; type  " . $type ;
$mess .= "; other  " . $other ;
$mess .= "; info  " . $info ;
$mess .= "; info  " . $info ;
$mess .= "; user  " . $user ;
 
 
 $config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('Агент сдан');
$CI->email->message($mess );
$CI->email->send();

$str=  'Спасибо! После проверки вам будут начислены баллы!  <br> <br><a href="http://neagent.by/board/agent">Сдать еще одного агента</a> ';

break;

 default:


$addata['email']=$email;
$str = $CI->parser->parse('realt_agentpage', $addata);



}

 


	
$this->data['realt']= $str;