<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ionize, creative CMS
 *
 * @package		Ionize
 * @author		Ionize Dev Team
 * @license		http://ionizecms.com/doc-license
 * @link		http://ionizecms.com
 * @since		Version 0.93
 */

// ------------------------------------------------------------------------

/**
 * FancyUpload Module Controller
 *
 * @package		Ionize
 * @subpackage	Modules
 * @category	Upload module
 * @author		Ionize Dev Team
 *
 */


class Transactions extends Base_Controller 
{
	var $mimes			= array();
    var $CI;

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
	

	    
	
		parent::__construct();
		header('Content-Type: text/html; charset=windows-1251');
		
		
		 $this->CI =& get_instance();
		 $this->CI->load->library('parser'); 
		
		//$this->load->model('Realt_model', 'realt');
	}


	// ------------------------------------------------------------------------

	/**
	 * No access to index()
	 *
	 */
	 
	 
	 
	function index()
	{
	echo ("Transactions");
	}
	

	
	
	function saveLog( $message){
         $filename='trans.log';
         
        $useragent=$_SERVER['HTTP_USER_AGENT'];
         


        $conf = $message . "; " ;

        $conf .= date("Y-m-d H:i:s",time()).  "; IP=" .  $_SERVER["REMOTE_ADDR"]  ;

        $this->CI->load->helper('file');
        $string = read_file($this->CI->config->item('module_path').'Transactions/config/' .$filename);
        $string .= "\n" . $conf;
        if ( ! write_file($this->CI->config->item('module_path').'Transactions/config/' .$filename, $string)){
            //echo "-saved";
        }

    }
	
	
	
 function test_ipay_transaction_start(){
	$this->ipay_transaction_start();
 }
 
 
 

function ipay_transaction_start(){
$_POST['XML'] = stripslashes($_POST['XML']);

$salt = 'nEagee54vs654v6sd84fcs<1';


						$config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                       $this->CI->load->library('email', $config);
                        $this->CI->email->set_newline("\r\n");
                        $this->CI->email->from('info@neagent.by');
                        $this->CI->email->to('sergej-minich@yandex.by');
                        $this->CI->email->subject(' XML '  );
                        $this->CI->email->message($_POST['XML']);
                        $this->CI->email->send();









//echo($_POST['XML']);
$this->send_mail( "start ipay transaction <br>" . $_POST['XML']);

	
$this->saveLog("start ipay transaction");
$this->saveLog($_POST['XML']);	
//$salt = 'gromyko';
$signature = '';
$matches = explode(" ", $_SERVER['HTTP_SERVICEPROVIDER_SIGNATURE']);  // подпись iPay в заголовке запроса
$signature = $matches[1];

$this->send_mail( "signature <br>" . $_SERVER['HTTP_SERVICEPROVIDER_SIGNATURE']);

if (strcasecmp(md5($salt . $_POST['XML']), $signature)&&0==1) ////////// """"""" УБРАТЬ 0=1 и исправить цифровую подпись проверку
{
//Неправильная цифровая подпись
//$template = file_get_contents("8.txt");
$template = $this->CI->parser->parse('signature_error', array(), false);
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
exit(0);
}
	
///////////////   скопировано с образца: 

preg_match("/<PersonalAccount>(.*)<\/PersonalAccount>/imU", $_POST['XML'],$prog);

///////////////
 
$this->saveLog('Ищем ' . $prog['1']);
$this->CI->db->select('*');
$this->CI->db->from ('fin_ipay_zakaz'); 
 
$this->CI->db->where ('invoice_number', $prog['1']);
$resul82 = $this->CI->db->get();

  
if(!$resul82) 
{ 
 echo "Возникла ошибка - ".mysql_error().""; 
 exit(); 
}

//echo $this->CI->db->_error_message();
//echo $this->CI->db->last_query();
$rows_array = $resul82->result_array();
//while($ro82=mysql_fetch_array($resul82))
//while($ro82=$resul82->result_array();)
foreach ($resul82->result() as $row) {
$ol='';
}

if (!isset($ol))
{
//Данного заказа не существует
//$template = file_get_contents("4.txt");

$template = $this->CI->parser->parse('no_zakaz', array(), false);
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
exit(0);
}


//////////////









//$resul83=mysql_query("select * from pay where ident='".$prog['1']."'");
///////////// что такое эта цифровая подпись


// проверяем не оплачен ли 
$this->CI->db->select('*');
$this->CI->db->from ('fin_ipay_zakaz'); 
$this->CI->db->where ('invoice_number', $prog['1']);
$this->CI->db->where  ('result', 'payd');
$resul83 = $this->CI->db->get();
//echo $this->CI->db->_error_message();
//echo $this->CI->db->last_query();
foreach ($resul83->result() as $row) {
//while($ro83=mysql_fetch_array($resul83))
//{
       // $template = file_get_contents("5.txt");
$template = $this->CI->parser->parse('already_paid', array(), false); 
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
exit(0);
}






$this->CI->db->select('*');
$this->CI->db->from ('fin_ipay_zakaz_temp'); 
$this->CI->db->where ('invoice_number', $prog['1']);
$resul11 = $this->CI->db->get();
//$resul11=mysql_query("select * from pay_temp where ident='".$prog['1']."'");

foreach ($resul11->result() as $row) {
$template = $this->CI->parser->parse('zakaz_in_process', array(), false); 
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
exit(0);
}






$data=array(
'invoice_number' => $prog['1'],
);

$this->CI->db->insert('fin_ipay_zakaz_temp', $data);

//mysql_query("insert into pay_temp values('', '".$prog['1']."', '0', '','','','','','')");

// Ответ на TransactionStart
$template = $this->CI->parser->parse('tr_id', array(), false);     // file_get_contents("2.txt");
$template = preg_replace('~%TRX_ID%~sim', $prog['1'], $template);

$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");

print($template);
exit(0);	
	
	
	
	
	
}	
	


function test_ipay_transaction_result(){
$this->ipay_transaction_result();
}

 

function ipay_transaction_result(){

$pos=  iconv( "WINDOWS-1251", "UTF-8", $_POST['XML']);
$salt = 'nEagee54vs654v6sd84fcs<1';



						$config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                       $this->CI->load->library('email', $config);
                        $this->CI->email->set_newline("\r\n");
                        $this->CI->email->from('info@neagent.by');
                        $this->CI->email->to('sergej-minich@yandex.by');
                        $this->CI->email->subject(' XML transaction_result'  );
                        $this->CI->email->message($pos);
                        $this->CI->email->send();


if(strpos($_POST['XML'],'ErrorText'))
{
preg_match("/<PersonalAccount>(.*)<\/PersonalAccount>/imU", $_POST['XML'],$prog);

 
						$config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                       $this->CI->load->library('email', $config);
                        $this->CI->email->set_newline("\r\n");
                        $this->CI->email->from('info@neagent.by');
                        $this->CI->email->to('sergej-minich@yandex.by');
                        $this->CI->email->subject(' XML transaction_result ОШИБКА  '  );
                        $this->CI->email->message($pos);
                        $this->CI->email->send();


//mysql_query("delete from pay_temp where ident='".$prog['1']."'");
$this->CI->db->where('invoice_number', $prog['1']);
$this->CI->db->delete('fin_ipay_zakaz_temp');

 


if(strpos($_POST['XML'],'<ErrorText>Операция отменена'))
{

$config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                       $this->CI->load->library('email', $config);
                        $this->CI->email->set_newline("\r\n");
                        $this->CI->email->from('info@neagent.by');
                        $this->CI->email->to('sergej-minich@yandex.by');
                        $this->CI->email->subject(' XML transaction_result refused!!!  '  );
                        $this->CI->email->message($pos);
                        $this->CI->email->send();
$template = $this->CI->parser->parse('refused', array(), false);
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template  );
exit(0);
}

 
//ВНИМАНИЕ! Заказ просрочен!
//$template = file_get_contents("7.txt");
$template = $this->CI->parser->parse('zakaz_timed_out', array(), false);
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
exit(0);

}


// Ответ на TransactionResult
//$template = file_get_contents("3.txt");

//  ТУТ ДОБАВИТЬ ОТВЕТ ПО ЗАКАЗУ - ваше объявление поднято или размещено или до какого времени размещено. 
//  и также сбросить на электронку письмо клиенту

$template = $this->CI->parser->parse('success', array(), false);


preg_match("/<PersonalAccount>(.*)<\/PersonalAccount>/imU", $_POST['XML'],$prog);


/////mysql_query("insert into pay values('', '".$prog['1']."', '1', '','','','','','')");
$data = array(
               'result' => 'payd',
			   'payment_date' => date("Y-m-d H:i:s",time()),
            );

//print_r ($prog);
			
$this->db->where('invoice_number', $prog['1']); // хотя было почему то id 
$this->db->update('fin_ipay_zakaz', $data);

//echo $this->CI->db->_error_message();
//echo $this->CI->db->last_query();


/////mysql_query("delete from pay_temp where ident='".$prog['1']."'");
$this->CI->db->where('invoice_number', $prog['1']);
$this->CI->db->delete('fin_ipay_zakaz_temp');


//echo $this->CI->db->_error_message();
//echo $this->CI->db->last_query();

$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");

print($template);
exit(0);


}


function test_ipay_service_info(){
$this->ipay_service_info();
}




function ipay_service_info(){

$postxml = stripslashes($_POST['XML']);


$salt = 'nEagee54vs654v6sd84fcs<1';




						$config['protocol'] = 'sendmail';
                        $config['mailpath'] = '/usr/sbin/sendmail';
                       $this->CI->load->library('email', $config);
                        $this->CI->email->set_newline("\r\n");
                        $this->CI->email->from('info@neagent.by');
                        $this->CI->email->to('sergej-minich@yandex.by');
                        $this->CI->email->subject(' serv inf '  );
                        $this->CI->email->message($postxml);
                        $this->CI->email->send();











$this->send_mail( "start ipay transaction <br>" . $postxml);
$this->saveLog("start service_info");
$this->saveLog($postxml);


preg_match("/<PersonalAccount>(.*)<\/PersonalAccount>/imU", $_POST['XML'],$prog);
//$resul10=mysql_query("select * from users where ID='".$prog['1']."'");

$this->CI->db->select('*');
$this->CI->db->from ('fin_ipay_zakaz'); 
//$this->CI->db->where ('id', $prog['1']);
$this->CI->db->where ('invoice_number', $prog['1']);
$results=$this->CI->db->count_all_results();
//echo ($this->CI->db->last_query());	

 
if ($results >0) {

	}
else{
// нет такого заказа
$template = $this->CI->parser->parse('no_zakaz', array(), false);


$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
exit(0);
}
 
 

///	 Удаляю из временных, если там есть и прошло более 20 минут . т.к. запрашивается инфо, счас будут платить. 
	
	// пока удалено  по требованию. 
  ///  $this->CI->db->where ('invoice_number', $prog['1']);
  ///   $this->CI->db->delete('fin_ipay_zakaz_temp');
	


///$resul55=mysql_query("select * from pay where ident='".$prog['1']."'");


$this->CI->db->select('*');
$this->CI->db->from ('fin_ipay_zakaz'); 
$this->CI->db->where ('invoice_number', $prog['1']);
$this->CI->db->where ('result', 'payd');
$resul55 = $this->CI->db->get();
 


foreach ($resul55->result() as $row) {
//while($ro55=mysql_fetch_array($resul55))
//{
//Заказ уже оплачен
//$template = file_get_contents("5.txt");
$template = $this->CI->parser->parse('already_paid', array(), false); 
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
exit(0);
}



$this->CI->db->select('*');
$this->CI->db->from ('fin_ipay_zakaz_temp'); 
$this->CI->db->where ('invoice_number', $prog['1']);
$resul98=$this->CI->db->get();

//echo $this->db->_error_message();
//echo $this->db->last_query();
					
					

//$resul98=mysql_query("select * from pay_temp where ident='".$prog['1']."'");
foreach ($resul98->result() as $row) {
//while($ro98=mysql_fetch_array($resul98))
//{
//Заказ в процессе оплаты
 
$template = $this->CI->parser->parse('zakaz_in_process', array(), false);

$template = preg_replace('~%NUMBER%~sim', $prog['1'] , $template);


                   $md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
exit(0);
}



//// Тут готовим ответ для сервера о заказе

// находим пользователя к этому заказу.


$this->CI->db->select('*');
$this->CI->db->from ('fin_ipay_zakaz'); 
$this->CI->db->where ('invoice_number', $prog['1']);
$resul15=$this->CI->db->get();

// echo $this->db->_error_message();
 //echo $this->db->last_query();

////////$resul15=mysql_query("select * from users_info where id_user='".$prog['1']."'");
 
if ($resul15->num_rows() == 0 )
			{
//echo(989898);			
			
$template = 'Нет данных о пользователе ' . $prog['1'];
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
print_r($prog);
exit(0);


			// echo 'Не найдено ';
			}

			
foreach ($resul15->result() as $row) {
//while($ro15=mysql_fetch_array($resul15))
//{
$userid=$row->userid;
$amount=$row->amount;
}			








$this->CI->db->select('*');
$this->CI->db->from ('fin_ipay_zakaz'); 
$this->CI->db->where ('invoice_number', $prog['1']);
$resul15=$this->CI->db->get();
//echo $this->db->_error_message();
//echo $this->db->last_query();

 
if ($resul15->num_rows() == 0 )
			{
$template = 'Нет данных о пользователе ' . $prog['1'];
$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");
print($template);
print_r($prog);
exit(0);
			// echo 'Не найдено ';
			}
			
			
			
foreach ($resul15->result() as $row) {
$name=$row->name;
$kurs="";
}





$name = iconv("UTF-8", "WINDOWS-1251", $name);
$kurs = iconv("UTF-8", "WINDOWS-1251", $kurs);
$city ="";
$k=explode(' ', $fio);
// Ответ на ServiceInfo
////$template = file_get_contents("1.txt");
$template = $this->CI->parser->parse('info', array(), false); 



$template = preg_replace('~%NUMBER%~sim', $prog['1'] , $template);
$template = preg_replace('~%AMOUNT%~sim', $amount, $template);
$template = preg_replace('~%NAME%~sim', $name, $template);
$template = preg_replace('~%SURNAME%~sim', $surname, $template);
$template = preg_replace('~%FIRSTNAME%~sim', $firstname, $template);
$template = preg_replace('~%PARTONYMIC%~sim', $k['2'], $template);
$template = preg_replace('~%CITY%~sim', $city , $template);
$template = preg_replace('~%STREET%~sim', '', $template);
$template = preg_replace('~%HOUSE%~sim', '', $template);
$template = preg_replace('~%BUILDING%~sim', '', $template);
$template = preg_replace('~%APARTAMENT%~sim', '', $template);

$md5 = md5($salt . $template);
header("ServiceProvider-Signature: SALT+MD5: $md5");

print($template);
exit(0);









}


function test(){

$template = $this->CI->parser->parse('testform', array(), false); 
	
}
	
	
	

function ad_options(){
	//header('Content-type: application/xml; charset=utf-8');
	

$header= "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head><meta http-equiv='content-type' content='text/html; charset=utf-8' /><link rel='stylesheet' href='http://neagent.by/themes/neagent_style/assets/css/style.css' type='text/css' media='screen, projection' /></head><body class='popframe'>";


	
	//////////////////////////////////////	  
	$userLevel="";
	if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	
	$user = $CI->connect->get_current_user();
	if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
    ///////////////////////////////////
	
	
	$ref=$_SERVER["HTTP_REFERER"];
	$USERIP = $_SERVER["REMOTE_ADDR"];
	$uid = "uid-not-set";
	$c_autor_type=$_COOKIE["IUser"];
	
	

	$aid= $_POST["aid"]; // foo bar 
	$complaint= $_POST["complaint"]; // baz
	$mtext = $_POST['report']; 
	$ajax = $_POST['ajax']; 
 
 	
 
$ad_id=(int)($CI->uri->segment(4));
$mode=$_POST['mode'];
$mode=$_POST['mode'];

switch($mode) 
	    {
	        case "checkcode":	
// проверка отправленного кода
			
//3DXxZRKh

$secretcode=$_POST['secretcode'];
$secretcode = rtrim(trim($secretcode));
$secretcode = str_replace( "'", "''", $secretcode);
$secretcode = str_replace( ";", "", $secretcode);
					
//echo ("secretcode" . $secretcode);

if ($secretcode =="" ){
echo ("
 $header

неправильный код. <br><a href='http://neagent.by/realt/ad_options/$ad_id'>< вернуться</a>");
return;
}

 $ad_id=(int)$_POST['ad_id'];
//echo ("ad_id=" . $ad_id." ");
        $CI->db->like('ad_secretcode', $secretcode);
		$CI->db->where('ad_id', $ad_id);
        $CI->db->from('ads');
        $co = $CI->db->count_all_results();
		//echo ("ad_id=" . $ad_id ." ");
		//echo ("ad_id=" . $secretcode ." ");
		//echo ("результат" . $co . " ");
		
		
		
if ($co >0) {
// УДАЛЯЕМ 




 $config['protocol'] = 'sendmail';
 $config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('удаляют объявление');
$CI->email->message('удаляют объявление' . $ad_id);
$CI->email->send();
 //echo $CI->email->print_debugger();
//End end that love letter

//$CI->db->update('ads', array('ad_show' => "0"), "ad_id = '$ad_id'");	
//echo $CI->db->_error_message();	
	
$data = array('ad_show' => "0" );
$CI->db->where('ad_id', $ad_id);
$CI->db->like('ad_secretcode', $secretcode);
$CI->db->update('ads', $data);
 echo ("$headerВаше объявление удалено");
 

 
 
 

}
else{
echo ("
 $header
неправильный код.<br><a href='http://neagent.by/realt/ad_options/$ad_id'>< вернуться</a>");
return;


 }









			
			case " ":
			
			$ctext = "агентство"; break;
			case 3:	 $ctext = "другое";	break;	
			default:	
			
			
			
			 echo("
 $header
<form action='http://neagent.by/realt/ad_options/' method='POST'>
<div class='popframe_text'>
<input type='hidden' name='mode' value='checkcode'>
<input type='hidden' name='ad_id' value='$ad_id'><h3>Удаление объявления</h3>Введите секретный код, который вы получили при подаче объявления<br>
<input type='text' name='secretcode' value=''>
</div>
<div class='popframe_bottom'>
<input type='submit' value='Удалить '>
 </div>
 
 </form>
 ");
			
			
			 break;	
	    }
 
 

 }
 
 
 
 
 
 
 
 







































	
	

	function upload()
	{
		// Upload folder
		$upload_path = config_item('realt_folder');
		
		// Upload result
		$return = array();

		/**
		 * Get the connected users data
		 * These data are encrypted through the CI Encryption library
		 *
		 */
		if ( empty($this->encrypt))
			$this->load->library('encrypt');

		$username = $this->encrypt->decode(rawurldecode($_POST['usrn']));
		$email = $this->encrypt->decode(rawurldecode($_POST['usre']));
		
		// Try to get the user
		$user = Connect()->get_user($username);
		
		// If we have an user and an upload path
		if ($user && $upload_path != false && $upload_path !='')
		{
			// Users group
			$usergroup = Connect()->get_group($user['id_group']);
			
			// Fancy upload upload allowed group
			$fancygroup = Connect()->get_group(config_item('realt_group'));
			
			/**
			 * If the users email and the users group has the right to upload,
			 * we can start uploading
			 *
			 */
			if ($user['email'] == $email && $usergroup['level'] >= $fancygroup['level'])
			{
				// Do we get a file ?
				if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name']))
				{
					$this->error(lang('module_realt_invalid_upload'));
				}
				else
				{
					// Before move : Clean the file name
					// and add user email to file name if defined

					$new_file_name = $this->_prep_filename($this->clean_file_name($_FILES['Filedata']['name']));
									
					if (config_item('realt_file_prefix') == '1')
					{
						$new_file_name = $email . '_' . $new_file_name;
					}				
				
					if ( ! @move_uploaded_file($_FILES['Filedata']['tmp_name'], config_item('realt_folder') . $new_file_name))
					{
						$return['status'] = '0';
					}
					else
					{
 						$return['status'] = '1';
 						
 						// Send an alert mail to the admin if the option is set.
 						if (config_item('realt_send_alert') == '1' && config_item('realt_email') != '')
 						{
 							$to = config_item('realt_email') ;
							
							$subject_admin = lang('realt_alert_mail_subject') . ' : ' . $user['screen_name'];

							// Email preparation
							$data = array(
								'username' => 		$user['username'],
								'screen_name' =>	$user['screen_name'],
								'email' =>			$user['email'],
								'filename' =>		$new_file_name,
								'upload_date' =>	date('d.m.Y H:i:s'),
								'upload_folder' =>	config_item('realt_folder')
							);
							
							// Email to Admin
							$message = $this->load->view('emails/realt_upload_admin_alert', $data, true);
							
							$this->send_mail($to, $message, $subject_admin);
 						}
					}
					$return['src'] = config_item('realt_folder') . $new_file_name;
				
				}
			}
			// The user mail is not corresponding to the saved mail or the user group level < authorized group : 
			// Not allowed to upload
			else
			{
				$this->error(lang('module_realt_no_right'));
				
			}
		}
		
		echo json_encode($return);
	}


	/**
	 * Return a JSON error message and stop the script
	 * 
	 * @param	String		Error message
	 *
	 */ 
	function error($message)
	{
		$return = array(
			'status' => '0',
			'error' => $error
		);
		echo $return;
		
		die();
	}


	// ------------------------------------------------------------------------


	/**
	 * Clean the file name for security
	 * 
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */		
	function clean_file_name($filename)
	{
		$bad = array(
						"<!--",
						"-->",
						"'",
						"<",
						">",
						'"',
						'&',
						'$',
						'=',
						';',
						'?',
						'/',
						"%20",
						"%22",
						"%3c",		// <
						"%253c", 	// <
						"%3e", 		// >
						"%0e", 		// >
						"%28", 		// (
						"%29", 		// )
						"%2528", 	// (
						"%26", 		// &
						"%24", 		// $
						"%3f", 		// ?
						"%3b", 		// ;
						"%3d"		// =
					);
					
		$filename = str_replace($bad, '', $filename);


		return stripslashes($filename);
	}
	
	
	// --------------------------------------------------------------------

	
	/**
	 * Prep Filename
	 * Copied from CI Upload lib as this lib is a Upload lib private one.
	 *
	 * Prevents possible script execution from Apache's handling of files multiple extensions
	 * http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 *
	 */
	function _prep_filename($filename)
	{
		if (strpos($filename, '.') === FALSE)
		{
			return $filename;
		}

		$parts		= explode('.', $filename);
		$ext		= array_pop($parts);
		$filename	= array_shift($parts);

		foreach ($parts as $part)
		{
			if ($this->mimes_types(strtolower($part)) === FALSE)
			{
				$filename .= '.'.$part.'_';
			}
			else
			{
				$filename .= '.'.$part;
			}
		}

		// file name override, since the exact name is provided, no need to
		// run it through a $this->mimes check.
		/*
		if ($this->file_name != '')
		{
			$filename = $this->file_name;
		}
		*/

		$filename .= '.'.$ext;
		
		return $filename;
	}


	// --------------------------------------------------------------------

	
	/**
	 * List of Mime Types
	 * Copied from CI
	 *
	 * This is a list of mime types.  We use it to validate
	 * the "allowed types" set by the developer
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */	
	function mimes_types($mime)
	{
		global $mimes;
	
		if (count($this->mimes) == 0)
		{
			if (@require_once(APPPATH.'config/mimes'.EXT))
			{
				$this->mimes = $mimes;
				unset($mimes);
			}
		}
	
		return ( ! isset($this->mimes[$mime])) ? FALSE : $this->mimes[$mime];
	}


	// ------------------------------------------------------------------------


	/**
	 * Prepare and sends the mails.
	 *
	 * @param  string
	 * @param  string
	 * @param  string
	 * @return bool	
	 */
	 private function send_mail( $message, $subject = 'Transactions log')
	 {
        $CI =& get_instance();
        
        if ( ! isset($CI->email))
			$CI->load->library('email');

        $CI->email->from("info@neagent.by");
		$CI->email->to("dakh@mail.ru");
        $CI->email->subject($subject);

		$CI->email->message($message);

		return $CI->email->send();
	 }




function streets(){
// header("Content-type: text/xml");
 
 echo '["Рокоссовсого, ул","Якубова, ул"]';
 
 
}


 





	 
} // конеw класса 













/* End of file fancyupload.php */
/* Location: ./modules/Fancyupload/controllers/fancyupload.php */