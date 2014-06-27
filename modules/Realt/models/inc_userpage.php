<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();	$ci =  &get_instance();		
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	$ci =  &get_instance();

$user = $this->CI->connect->get_current_user();

if (!$user){
$this->data['realt']= "<h2>Личный кабинет пользователя</h2>Для просмотра списка ваших объявлений войдите под своим логином!";
return;
}



$str="<h2> Личный кабинет пользователя</h2>";
 //print_r ($user);
$str .= "Ваш логин:   <b>". $user['username'] . "</b><br>";
$str .= "Ваш email:   <b>". $user['email'] . "</b><br>";

$group = isset($this->data['user']['id_group']) ? $this->data['user']['id_group'] : false;

switch ($group){
case 1:
$level ="админ";
break;

case 5:
$level ="простой";
break;
case 16:
$level ="клиент";

break;

default:


}



 


// $str .= "Ваш уровень:   <b>". $level . "</b> <a href='' onClick=\"$('#pr').show();return false;\">повысить уровень </a><br>";
// $str .='
// <div id="pr" style="display:none; border:1px solid grey; width:250px;padding:5px;"><form action="http://neagent.by/board/user" method="post">Если у вас есть приглашение, <br>скопируйте его сюда: <br>
// <textarea></textarea><br><input type="submit" value="Отправить">
// </form></div>
// ';



 
$str .= "<br> <a href='http://neagent.by/client'>Управление объявлениями НА СУТКИ</a> <br><br>";


$str .= get_user_ads_table($user['id_user']);









	
$this->data['realt']= $str;