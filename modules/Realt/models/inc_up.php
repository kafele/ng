<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}
	
parse_str($_SERVER['QUERY_STRING'], $_GET);
$ad_id=$_GET['adid'];
$user_id=$_GET['pers_acc'];



 

 

if ($_POST['action']=='do'  ){
//good do nothing



// создать счет 
$ad_id=$_POST['ad_id'];
$surname=$_POST['surname'];
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];

$user_id=$this->user['id_user'];

$data = array(
'surname' => $surname ,
'firstname' => $firstname ,
'lastname' => $lastname ,
 );
 
 
if (!$user_id) { 
$user_id=0;
}
else
{
$CI->db->select('*');
$CI->db->where ('id_user', $user_id);
$CI->db->limit(1);
$CI->db->from('users_info');
$query = $CI->db->get();
if ($query->num_rows() == 0) {
				$data['id_user']=$user_id;	
				$CI->db->insert("users_info" , $data);
                } else {
				$CI->db->where ('id_user', $user_id);
				$CI->db->update("users_info" , $data);	
}
}

 // создаем счет :
$invoice_number=suggest_invoice_number();










$amount = 15000; 
$data = array(

'adid' =>$ad_id,
'name' => $surname . " " . $firstname . " " . $lastname,
'userid' => $user_id, 
'amount' => $amount,
'date'=> date("Y-m-d H:i:s", time()),
'invoice_number'=> $invoice_number, 
 
 );
 $CI->db->insert("fin_ipay_zakaz" , $data);
  //echo $this->db->_error_message();
   //                echo $this->db->last_query();


  $this->data['realt'] .='<h1>Заказ N <b>' . $invoice_number . '</b> создан.</h1> Сумма : 15000 р.  Его можно оплатить через систему <b>Ерип</b> (Интернет-сервисы -> neagent.by, указывайте номер заказа: N <b>' . $invoice_number . '</b>) <a href="http://raschet.by/main.aspx?guid=7451" target="_blank">где платить?</a>, <br><br> также можно оплатить через сервис I-pay (сумма будет списана с мобильного телефона), для этого перейдите по ссылке ниже: <br>'; 

 $this->data['realt'] .='<a href="https://oper.ipay.by:4443/pls/iPay/!iSOU.Login?srv_no=781&pers_acc=' . $invoice_number .'& amount=' .$amount . '&amount_editable=N" target="_blank">
 ПЕРЕЙТИ К ОПЛАТЕ ЧЕРЕЗ I-PAY</a>';

//$this->data['realt']= "Ошибка кода. Если в письме вам пришла эта ссылка для подтверждения, то сообщите об этом администратору.";
return;

}




if ($_GET['adid']>0  ){
 

 
$user_id=$this->user['id_user'];

               $addata = array(
                    'ad_id' => $ad_id,
                    'surname' => $surname ,
					'firstname' => $firtname ,
					'lastname' => $lastname ,
                );
				
				
 
                $CI->db->select('*');
                $CI->db->where ('id_user', $user_id);
                $CI->db->limit(1);
                $CI->db->from('users_info');

                $query = $CI->db->get();
                if ($query->num_rows() == 0) {
                    $addata['fio'] = '';
                     
                } else {
				
				
				
				foreach ($query->result() as $row) {

				$addata['surname'] = $row->surname;
				$addata['firstname'] = $row->firstname;
				$addata['lastname'] = $row->lastname;
				
				}
				
				
				
 }
 
 
 
 
 
 
 
 
 
                $this->data['realt'] .=   $CI->parser->parse('realt_up', $addata);


 

 
//$this->data['realt']= "Ошибка кода. Если в письме вам пришла эта ссылка для подтверждения, то сообщите об этом администратору.";
return;
}

 

 
 
 $this->data['realt'] .=  "неверные параметры страницы
";
 






	
	
	
	
	
	