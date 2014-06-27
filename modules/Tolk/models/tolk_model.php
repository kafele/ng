<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tolk_model extends Base_model  {

	//var $fields = array();
	//var $settings = array('notify_admin' => 'Y', 'style' => 'blue');
	public $CI;
	public $data;
	public $paginationConfig;
	
	
	public function __construct()
	{
		parent::__construct();
$CI =& get_instance();
 $CI->load->library('parser'); 	
$user = $CI->connect->get_current_user();
		if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
		

		
	}
	
	
	


	
	
	
	



function getPage(){


 $CI =& get_instance(); 
$CI->load->library('pagination');
$this->setPaginationConfig();


$this->saveClientInfoToLog(); // записали в длог 


$allresults=isset($allresults)?$allresults:100;

$config['uri_segment']=0;
$config['per_page']=isset($config['per_page'])?$config['per_page']:10;

$firstad=(int)($CI->uri->segment($config['uri_segment'])+1);
$lastad=$firstad+	$config['per_page']-1;
if ($lastad >$allresults){$lastad=$allresults;};
$CI->pagination->initialize($config);
$data['pager']=$CI->pagination->create_links();
$from=($CI->uri->segment($config['uri_segment']));
	 
//return "from=".$from.";";
 
// параметры для передачи в функцию 	   
$params = array(
            'tolk_cat_id' => 0
            );	

$query= $this->getEntries($from, $config['per_page'], $params );
 

$str_add  = $data['pager'];  

if ($query->num_rows() == 0 )
			{	
			$result =  false;
			
	$this->data['tolk']="<p></p><p>Объявлений не найдено. Будете первым?</p>";	
return;	
			}






foreach ($query->result() as $row)
{

$row->tolkposter_ip=isset($row->tolkposter_ip)?$row->tolkposter_ip:"";
$tolkdata = array(
            'tolk_message_id' => $row->tolk_message_id,
            'tolk_action' => $row->tolk_action,
			'tolk_title' => $row->tolk_title,
			'tolk_price' => $row->tolk_price,
			'tolk_message' => $row->tolk_message,
			'tolk_email' => $row->tolk_email,
			'tolk_contactname' => $row->tolk_contactname,
			'tolk_show' => $row->tolk_show,
			'tolk_postdate' => $row->tolk_postdate,
			 'tolk_phones' => $row->tolk_phones,
			'tolk_poster_uid' => $row->tolk_poster_uid,
			'tolk_poster_ip' => $row->tolkposter_ip,
			 
            );
	
$delayed=false;
	   

	   
switch ($row->tolk_action) {
case '1':
$tolkdata['tolk_action']="Куплю";
 break;
case '2':
$tolkdata['tolk_action']="Продам";
  break;
case '3':
$tolkdata['tolk_action']="Приму в дар";
 break;
case '4':
$tolkdata['tolk_action']="Подарю";
 break;
default:
$tolkdata['tolk_action']=" ";
	}
	   
	   
	   
	   
	$tolkdata['mlev'] = $this->data['mlev'] ;  
	   
	  
	   
	   
	   
if (isset($tolkdata['tolk_poster_id']) && $tolkdata['tolk_poster_id']==1) {
$tolkdata['tolk_image_url'] = 	base_url()."themes/neagent_style/assets/images/gb_admin.png";  
}
else{	   
$tolkdata['tolk_image_url'] = 	base_url()."themes/neagent_style/assets/images/gb_post.gif";  
}

	  
$str_add .= $CI->parser->parse('tolk_entry', $tolkdata);
//echo ($str_add);













//////////////////////////////////
//ответы на сообщение вывести
$params = array(
            'tolk_r_parent' => $tolkdata['tolk_message_id']
			
            );
			
			
$query2= $this->getReplies($from, $config['per_page'], $params );

if ($query2->num_rows() == 0 ){
$str_add .="<div style='margin-bottom:5px; padding-left:100px; padding-bottom:12px; border-bottom:1px solid #015b9a;'>
</div>
";
}

else{
$i=1;
foreach ($query2->result() as $row)
{
$repldata = array(
            'tolk_r_message_id' => $row->tolk_r_message_id,
            'tolk_r_message' => $row->tolk_r_message,
			'tolk_r_contactname' => $row->tolk_r_contactname,
			'tolk_r_show' => $row->tolk_r_show,
			'tolk_r_post_date' => $row->tolk_r_post_date,
			'tolk_r_poster_id' => $row->tolk_r_poster_id,
			'tolk_r_poster_uid' => $row->tolk_r_poster_uid,
			'tolk_r_poster_ip' => $row->tolk_r_poster_ip,
			'tolk_r_fakefor' => $row->tolk_r_fakefor,
            );
	
//echo("--" . $query2->num_rows());	
if ($query2->num_rows()==$i){$repldata['lastReply']=1;}
if ($i==1){$repldata['firstReply']=1;}else{$repldata['firstReply']=0;}
$i++;
			
	
$delayed=false;
	   

if ($gbdata['gb_poster_id']==1) {
$repldata['gb_image_url'] = 	base_url()."themes/neagent_style/assets/images/gb_admin.png";  
}
else{	   
$repldata['gb_image_url'] = 	base_url()."themes/neagent_style/assets/images/gb_post.gif";  
}
$str_add .= $CI->parser->parse('tolk_reply', $repldata);
}
}











}


$this->data['tolk']=$str_add;
return $str_add;




}





	
	




	
public function getEntries($from,$limit,$params){

$CI =& get_instance();
$CI->load->library('parser');
$tolk_cat_id=$params['tolk_cat_id'];


$tolk_cat_id =  (int)$tolk_cat_id;
$CI->db->limit($limit,$from);
 
$CI->db->select('*');
if ($tolk_cat_id>0){
$CI->db->where ('tolk_cat_id', "".$tolk_cat_id."");
};
$CI->db->from ('tolk');
$CI->db->order_by ('tolk_message_id', 'desc');
$query = $CI->db->get();
//echo $CI->db->last_query();

// Ниже показана переменная, сколько на странице объявлений.
//echo (config_item('tolk_ads_per_page')."iii");
return $query;
	
}




function setPaginationConfig(){
$firstad=0;
$lastad=50;
 $CI =& get_instance(); 
$config['base_url'] = site_url('/gbook/'); //  
       $config['total_rows'] = $CI->db->count_all('tolk');//$CI->db->count_all('ads'); //   было $CI->$config['total_rows'] = $CI->db->count_all('records'); // 
       $config['per_page'] =    (config_item('tolk_entries_per_page')>0)?config_item('tolk_entries_per_page'): 20;   //  выводить на страницу
       $config['num_links'] = 6;    //  количество ссылок - косметический параметр
       $config['padding'] = 1;
	   $config['uri_segment'] = 4;   // сегмент -указать
//$cat=(int)$cat;

$cat=0;

//$allresults=$CI->db->count_all('tolk');
$allresults=60;

$config['total_rows'] = $allresults;
//	продолжаем pagination
$config['full_tag_open'] ='<div class="pagination"><div class="page_numbers"><span class="page-first">'.lang('module_tolk_pagination_page').'</span>';
$config['full_tag_close']='</div><p class="page_items">'.$firstad. lang('module_tolk_pagination_tire').$lastad.lang('module_tolk_pagination_from').$allresults.lang('module_tolk_pagination_entryes').'</p></div><br style="clear:both;">';
$config['cur_tag_open'] = '<span class="selected">';
$config['cur_tag_close'] = '</span> ';
//
$paginationConfig=$config;
}



public function getReplies($from,$limit,$params){
$CI =& get_instance();
$CI->load->library('parser');
$tolk_cat_id=isset($params['tolk_cat_id'])?$params['tolk_cat_id']:false;
$tolk_r_parent=$params['tolk_r_parent'];


$tolk_r_parent =  (int)$tolk_r_parent;
//$CI->db->limit(1000,0);
$CI->db->select('*');

$CI->db->where ('tolk_r_parent', "".$tolk_r_parent."");

$CI->db->from ('tolk_replies');
//$CI->db->order_by ('tolk_reply_message_id', 'asc');
$query = $CI->db->get();

//echo($CI->db->last_query());

// Ниже показана переменная, сколько на странице объявлений.
//echo (config_item('tolk_ads_per_page')."iii");
return $query;	
}









///////////////////////////////////////////
// перемещение 
function moveMessage(){

$CI =& get_instance();	

$user = $CI->connect->get_current_user();
if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
$mlev=$this->data['mlev']; 

//echo($user['group']['group_name']);
if ($mlev !=4) {
echo ("перемещение запрещено");
return;
}

		

		$gb_parent=(int)$CI->input->post('par');
		$gb_message_id =(int)$CI->input->post('mess_id');
				//echo $CI->input->post('parent');

	//проверить на спам 	
		
		
		
if ($gb_parent>0){
	//echo ("1-".$CI->input->post('parent'));
	
	//echo ("gb_parent>0");
	
	
	

	
$CI->db->select('*');
$CI->db->where ('gb_message_id', "".$gb_message_id."");
$CI->db->from ('tolk');
$query = $CI->db->get();	
//echo ($CI->db->last_query());

foreach ($query->result() as $row){
$gbdata = array(
'gb_reply_parent'	=> $row->gb_parent ,
 	'gb_reply_cat_id'		=>	 $row->gb_cat_id, 	 	 	 	 	 
 	'gb_reply_message'	    =>	 	$row->gb_message,	 	 	 	 
 	'gb_reply_email'		=>	 	$row->gb_email, 	 	 	 	 
 	'gb_reply_contactname'	=>		$row->gb_contactname ,	 	 	 	 	 	 
 	'gb_reply_show'			=>		$row->gb_show,	 	 	 	 	 
 	'gb_reply_poster_uid'	=>		$row->gb_poster_uid	 	 	 
            );

	}
	
//echo ($gbdata['gb_reply_message']);	
	
		
	
// это   сообщение  -ответ
$gb_contactname=$gbdata['gb_reply_contactname'];
$gb_email=$gbdata['gb_reply_email'];
$gb_show=$gbdata['gb_reply_show'];
$gb_message=$gbdata['gb_reply_message'];

$data=array(
	gb_reply_parent	=> $gb_parent ,
 	gb_reply_message	    =>	 	$gb_message ,	 	 	 	 
 	gb_reply_email		=>	 	$gb_email 	, 	 	 	 	 
 	gb_reply_contactname	=>		$gb_contactname ,	 	 	 	 	 	 
 	gb_reply_show			=>		$gb_show 	 	 	 	 	 	 
)	;	
$CI->db->insert('tolk_replies', $data);
		//echo ($CI->db->last_query());
		
		
		
$CI->db->where ('gb_message_id', "".$gb_message_id."");
$this->db->delete('tolk');	
		
		
		
		
		
		
		
		
	
}	
else{
echo("не указан Parent");
}






}
























	
///////////////////////////////////////////

 function addMessage(){

$CI =& get_instance();	
 $now=time();
 //$CI->load->database();
		$gb_cat_id=chkString($CI->input->post('cat'),"SQLString");
		$gb_message=chkString($CI->input->post('content'),"SQLString");
		$gb_email=chkString($CI->input->post('gb_email'),"SQLString");
		//echo $CI->input->post('parent');
		//echo $gb_message=$CI->input->post('content');

		$gb_parent=(int)$CI->input->post('parent');
				//echo $CI->input->post('parent');

	//проверить на спам 	
if  (chkSpam($gb_message)) {
echo ("<h2>К сожалению, подача Вашего объявления запрещена.</h2>
<i>Ваше сообщение определено системой, как нежелательное. <br> 
Скорее всего оно нарушает правила сайта или содержит рекламу. Публикация ссылок на другие ресурсы запрещена.
<br></i>");
return; 
break;
}		
		
		
		
		
if ($tolk_parent>0){
	//echo ("1-".$CI->input->post('parent'));

// это   сообщение  -ответ
$gb_contactname=chkString($CI->input->post('gb_name'),"SQLString");
$gb_show=1;
$gb_title='';
$gb_post_date='';
$gb_poster_id='';
$gb_poster_uid='';
$gb_poster_ip='';
$gb_fakefor	='';
$data=array(
gb_reply_parent	=> $gb_parent ,
	gb_reply_message_id	=> $gb_reply_message_id , 	 	 	 	 	 	 
 	gb_reply_cat_id		=>	 $gb_cat_id	, 	 	 	 	 	 
 	gb_reply_title	    =>		$gb_title ,	 	 	 	 	 	 
 	gb_reply_message	    =>	 	$gb_message ,	 	 	 	 
 	gb_reply_email		=>	 	$gb_email 	, 	 	 	 	 
 	gb_reply_contactname	=>		$gb_contactname ,	 	 	 	 	 	 
 	gb_reply_show			=>		$gb_show 	 ,	 	 	 	 	 
 	gb_reply_post_date	=>		$gb_post_date ,	 	 	 	 	 	 
 	gb_reply_poster_id	=>		$gb_poster_id ,	 	 	 	 	 	 
 	gb_reply_poster_uid	=>		$gb_poster_uid 	, 	 	 	 	 	 
 	gb_reply_poster_ip	=>		$gb_poster_ip 	, 	 	 	 	 	 
 	gb_reply_fakefor      =>     $gb_fakefor,
)	;	
$CI->db->insert('tolk_replies', $data);
		//echo ($CI->db->last_query());
	
}	
	else{	
		//echo ("2-".$CI->input->post('parent'));
	// это новое сообщение в толкучку	
		
//$gb_contactname=chkString($CI->input->post('gb_name'),"SQLString");
$tolk_show=1;
$tolk_title='';
$tolk_post_date='';
$tolk_poster_id='';
$tolk_poster_uid='';
$tolk_poster_ip='';
$tolk_fakefor	='';
$data=array(
	gb_message_id	=> $tolk_message_id , 	 	 	 	 	 	 
 	gb_cat_id		=>	 $tolk_cat_id	, 	 	 	 	 	 
 	gb_title	    =>		$tolk_title ,	 	 	 	 	 	 
 	gb_message	    =>	 	$tolk_message ,	 	 	 	 
 	gb_email		=>	 	$tolk_email 	, 	 	 	 	 
 	gb_contactname	=>		$tolk_contactname ,	 	 	 	 	 	 
 	gb_show			=>		$tolk_show 	 ,	 	 	 	 	 
 	gb_post_date	=>		$tolk_post_date ,	 	 	 	 	 	 
 	gb_poster_id	=>		$tolk_poster_id ,	 	 	 	 	 	 
 	gb_poster_uid	=>		$tolk_poster_uid 	, 	 	 	 	 	 
 	gb_poster_ip	=>		$tolk_poster_ip 	, 	 	 	 	 	 
 	gb_fakefor      =>     $tolk_fakefor,
)	;	
$CI->db->insert('tolk', $data);
		
}
echo $CI->db->last_query();

		
//echo $sql;		
		
		

 //echo ("konf" . config_item('tolk_send_email_to'));

if (strpos(config_item('tolk_send_email_to'), "@") >0){
///если в настройках посылать письмо, то
$emailto=config_item('tolk_send_email_to');
//echo ("pos" . strpos($config['tolk_send_email_to'], "@");

$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from($emailto);
$CI->email->to($emailto);
$CI->email->subject('Новое сообщение в гостевую');
$CI->email->message('Сообщение=' . $gb_message );
$CI->email->send();




}  









		
		
		
		
		
       // $sql = 'INSERT INTO ads(ad_message, ad_komnat, ad_price) VALUES ("'.$post_message.'", '.$post_komnat.', '.$post_price.')';
        //$bindings = array ($listing['id'], $CI->tank_auth->get_user_id(), set_value('feedback'));
        
		//$CI->db->query($sql, $bindings);
		return 3;
}	
	
	
	
	
	
	
	
	//function Tolk_model()
	//{
			

	//}


	function get($params = array())
	{
		$default_params = array
		(
			'order_by' => 'id DESC',
			'limit' => 1,
			'start' => null,
			'where' => null,
			'like' => null,
		);

		foreach ($default_params as $key => $value)
		{
			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];
		}
		$hash = md5(serialize($params));
		if(!$result = $this->cache->get('get' . $hash, $this->table))
		{
			if (!is_null($params['like']))
			{
				$this->db->like($params['like']);
			}
			if (!is_null($params['where']))
			{
				$this->db->where($params['where']);
			}
			$this->db->order_by($params['order_by']);
			$this->db->limit(1);
			//$this->db->select('');
			$this->db->from($this->table);

			$query = $this->db->get();

			if ($query->num_rows() == 0 )
			{
				$result =  false;
			}
			else
			{
				$result = $query->row_array();
			}

			$this->cache->save('get' . $hash, $result, $this->table, 0);
		}

		return $result;


	}

	function get_list($params = array())
	{
		$default_params = array
		(
			'order_by' => 'id DESC',
			'limit' => null,
			'start' => null,
			'where' => null,
			'like' => null,
		);

		foreach ($default_params as $key => $value)
		{
		
			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];
		 
		}
		$hash = md5(serialize($params));
		
		//echo ($hash);
		//if(!$result = $this->cache->get('get_list' . $hash, $this->table))
		//{
  		if (!is_null($params['like']))
		{
			$this->db->like($params['like']);
		}
		if (!is_null($params['where']))
			{
				$this->db->where($params['where']);
			}
			$this->db->order_by($params['order_by']);
			$this->db->limit($params['limit'], $params['start']);
		$this->db->select('');
			$this->db->from($this->table);

			$query = $this->db->get();

			if ($query->num_rows() == 0 )
			{
				$result =  false;
			}
			else
			{
				$result = $query->result_array();
			}

 			// $this->cache->save('get_list' . $hash, $result, $this->table, 0);
		// }

		
		
		return $result;


	}

	function get_total($params = array())
	{
		$default_params = array
		(
			'order_by' => 'id DESC',
			'limit' => null,
			'start' => null,
			'where' => null,
			'like' => null,
		);

		foreach ($default_params as $key => $value)
		{
			$params[$key] = (isset($params[$key]))? $params[$key]: $default_params[$key];
		}
		$hash = md5(serialize($params));
	//	if(!$result = $this->cache->get('get_total' . $hash, $this->table))
		//{
			if (!is_null($params['like']))
			{
				$this->db->like($params['like']);
			}
			if (!is_null($params['where']))
			{
				$this->db->where($params['where']);
			}
			$this->db->order_by($params['order_by']);

			$this->db->select('count(id) as cnt');
			$this->db->from($this->table);

			$query = $this->db->get();

			$row = $query->row_array();

			$result = $row['cnt'];

			//$this->cache->save('get_total' . $hash, $result, $this->table, 0);
		//}

		return $result;

	}

	function delete($params = array())
	{
		$this->db->where($params['where']);
		$this->db->delete($this->table);
		$this->cache->remove_group($this->table);
	}

	function save($data = array())
	{
		$this->db->set($data);
		
		//$this->cache->remove_group($this->table);
		return $this->db->insert($this->table);
	}

	function update($where = array(), $data = array(), $escape = true)
	{
		$this->db->where($where);
		$this->db->set($data, null, $escape);
		$this->db->update($this->table);
		$this->cache->remove_group($this->table);
	}

	function get_params($id)
	{
		if($params = $this->cache->get($id, 'search_' . $this->table))
		{
			return $params;
		}
		else
		{
			return false;
		}
	}

	function save_params($params)
	{
		$id = md5($params);
		if($this->cache->get($id, 'search_' . $this->table))
		{
			return $id;
		}
		else
		{

			$this->cache->save($id, $params, 'search_' . $this->table, 0);
			return $id;
		}
	}

	function get_settings()
	{
	
	
 	
		 $query = $this->db->get('tolk_settings');
		// пусто выдало
		//echo  ($query);
		// echo  ("query");
		  if ($query->num_rows() > 0)
		  {
		
		    foreach ($query->result() as $row)
		    {
			//echo  ($row->value );
		 	  $this->settings[$row->name] = $row->value;
		    }
		  }	
		 
	}
	
	
	
	
	function save_settings($name, $value)
	{	
		//update only if changed
		if (!isset($this->settings[$name])) {
			$this->settings[$name] = $value;
			$this->db->insert('tolk_settings', array('name' => $name, 'value' => $value));
		}
		elseif ($this->settings->$name != $value) 
		{
			$this->settings->$name = $value;
			$this->db->update('tolk_settings', array('value' => $value), "name = '$name'");
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
public function getAddFormPage(){
//работа с отправкой объявления
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	

if ($this->data['mlev']==4) {
echo ("addf");
} 

//echo ("-".$this->data['mlev']);



// определить, переданы ли данные? в зависимости от этого устанавливаем модэ 
$act=($_POST['act'] != '') ? $_POST['act'] : "default";




 //if ($this->data['mlev']==4) {echo("act=" . $act);} 
switch ($act) {
case 'post':

//СОХРАНЕНИЕ ОБЪЯВЛЕНИЯ
 if ($this->data['mlev']==4) {echo("POST");} 
$tolk_catid = chkString($CI->input->post('tolk_cat'),"SQLString");if (!is_numeric($ad_catid)){  $err_mess='<li>Не выбрана категория объявления</li>'; } 
$tolk_action = chkString($CI->input->post('tolk_action'),"SQLString");if (!is_numeric($tolk_action)){  $err_mess='<li>Не выбрана категория </li>'; } 
$tolk_price = chkString($CI->input->post('price'),"SQLString");
$tolk_message = chkString($CI->input->post('tolk_message'),"SQLString");
$tolk_phones = chkString($CI->input->post('tolk_phones'),"SQLString");
$tolk_contactname = chkString($CI->input->post('tolk_name'),"SQLString");
$tolk_email = chkString($CI->input->post('tolk_email'),"SQLString");
$tolk_title = chkString($CI->input->post('tolk_title'),"SQLString");
$tolk_postdate = date("Y-m-d H:i:s");
$tolk_enddate = date("Y-m-d H:i:s");
$tolk_show = 1;
 
$tolk_parent = chkString($CI->input->post('parent'),"SQLString");
 
 
 
 if ($this->data['mlev']==4) {echo("POST2");} 
 

 
 
////////////проверяем на спам-слова
if  (chkSpam($ad_message)) {
$this->data['tolk']="<h2>К сожалению, подача Вашего объявления запрещена.</h2>
<i>Ваше объявление определено системой, как нежелательное. <br> 
Скорее всего оно нарушает правила сайта или содержит рекламу.
Возможно также, что этот телефон как-то связан с агентствами, или заблокирован за нарушения. <br></i>";
			return; 
			break;
}
 
 
 $tolk_uid=$CI->data['user_uid'];
 $tolk_cref=$CI->data['user_cref'];

  if ($this->data['mlev']==4) {echo("parent=".$tolk_parent);} 

  $tolk_parent=(int)$tolk_parent;
  
  
  
 if ($tolk_parent!=0){
 
 $tolk_parent=(int)$tolk_parent;
 if ($tolk_parent==0){ return "произошла ошибка";}
 
 // ВСТАВКА В БАЗУ  ответов 
$data=array(
	tolk_r_parent	    =>		$tolk_parent ,	  	 	 	 	 
 	tolk_r_message	    =>		$tolk_message ,	 	 	 	 	 	 
 	tolk_r_contactname	=>		$tolk_contactname ,	 	 	 	 	 	 

 	tolk_r_show	=>		$tolk_show 	, 	 	 	 	 	 
 	tolk_r_poster_id      =>     $tolk_ip,
	tolk_r_poster_uid      =>     $tolk_uid,
)	;

 

	
$CI->db->insert('tolk_replies', $data);	
if ($this->data['mlev']==4) {
echo($CI->db->last_query());
} 

 }
 else{


// ВСТАВКА В БАЗУ 
$data=array(
	tolk_action	=> $tolk_action , 	 	 	 	 	 	 
 	tolk_title		=>	 $tolk_title	, 	 	 	 	 	 
 	tolk_message	    =>		$tolk_message ,	 	 	 	 	 	 
 	tolk_price		=>	 	$tolk_price 	, 	 	 	 	 
 	tolk_postdate	=>		$tolk_postdate ,
 	tolk_enddate			=>		$tolk_enddate 	 ,	 	 	 	 	 
 	tolk_email	=>		$tolk_email ,	 	 	 	 	 	 
 	tolk_contactname	=>		$tolk_contactname ,	 	 	 	 	 	 
 	tolk_phones	=>		$tolk_phones 	, 	 	 	 	 	 
 	tolk_show	=>		$tolk_show 	, 	 	 	 	 	 
 	tolk_ip      =>     $tolk_ip,
	tolk_uid      =>     $tolk_uid,
)	;

if ($CI->data['mlev']==4) {print_r($data);}  

	
$CI->db->insert('tolk', $data);	 



}





//отправляем письмо пользователю
//////// ВЫРУБЛЕНО ОНО 
if (strlen($ad_email)>3) {
$messagestr2 = "Вы отправили объявление на Neagent.by. Код объявления: " .   $ad_secretcode   . " . 
Сохраните этот код, с ним Вы сможете отредактировать или удалить Ваше обьявление. 
Для удаления объявления щелкните на его заголовке, перейдете на его страницу, 
сразу под ним будут ссылки для редактирования и удаления." ;
if ($CI->data['scenery_moderate']==1){
$messagestr2 = $messagestr2 . " Ваше объявление появится на сайте после проверки модератором. " ;
}
$messagestr3="<br>Код объявления отправлен на ваш email.<br> " ;
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('info@neagent.by');
$CI->email->to($ad_email);
$CI->email->subject('Ваше объявление на Neagent.by');
$CI->email->message($messagestr2);
$CI->email->send();
}
//////////////////













if (config_item('realt_post_delay')	>0){ $this->data['realt']="Ваше объявление опубликовано. Доступно к просмотру оно станет через ".  config_item('realt_post_delay') . " минут. " . "Код объявления : " .   $ad_secretcode     . $messagestr3;	 
}else {
$this->data['tolk']="Ваше объявление опубликовано. </br></br><a href='http://neagent.by/tolk'>Вернуться в толкучку</a>" ;
if ($CI->data['scenery_moderate']==1){
$this->data['tolk']="Ваше объявление  появится на сайте после проверки модератором. Это может занять от получаса часа до трех часов. " . "Код объявления : " .   $ad_secretcode     . $messagestr3;
}



} 
	 

break;
case 'edit':
//

$this->data['tolk']='Редактирование объявления недоступно.';
break;













default:



if ($this->data['mlev']==4) {
echo ("-def-");
} 


$addata['tt']="jj";// это чтоб пустой параметр не передавать 



$tolk_parent = chkString($CI->input->post('parent'),"SQLString");
$tolk_parent=(int)$tolk_parent;



if ($tolk_parent!=0){
// Это если ответ
if (!is_numeric($tolk_parent)){  return "Произошла ошибка"; } 
$data = array(
'tolk_parent' => $tolk_parent,
);
				 
if ($CI->data['mlev']==4) {print_r($data);}  				 
			 
$data['mlev']= $this->data['mlev'];
$str_add .= $CI->parser->parse('tolk_add_form', $data);
$this->data['tolk']=$str_add;

}

else{ // 'n оесли новое сообщение
$data = array('ad_id' => "-",'mlev' => 0);
if ($CI->data['mlev']==4) {print_r($addata);}  				 
$data['mlev']= $this->data['mlev'];
$str_add .= $CI->parser->parse('tolk_add_form', $data);
$this->data['tolk']=$str_add;

}


}













}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function saveClientInfoToLog(){

	   //$conf .= "\$config['".$key."'] = '".$val."';\n";
		
		$CI =& get_instance();	
			$uid=$_COOKIE["uid"];
			$uic=$_COOKIE["uic"];
			$useragent=$_SERVER['HTTP_USER_AGENT'];
			$page=$_SERVER['QUERY_STRING'];
			$page=$CI->uri->uri_string(). "/" . $page;
			$pagetitle="";
			$conf =date("Y-m-d H:i:s",time()).  "; uid=" .   $uid . "; uic=" .   $uic . "; IP=" .  $_SERVER["REMOTE_ADDR"] .  "; useragent=" . $useragent . "; page=" . $page;
				$this->load->helper('file');
				$string = read_file($this->config->item('module_path').'Tolk/config/log.txt');
				$string .= "\n" . $conf;
				if ( ! write_file($this->config->item('module_path').'Tolk/config/log.txt', $string)){
				//echo "-saved";
				}
				
				
				
				
}
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
//////// конец класса	

}















function ChkString($fString,$fField_Type){ //## Types - name, password, title, message, url, urlpath, email, number, list
	$fString = rtrim(trim($fString));
	if ($fString == ""){ 
	$fString = " ";
	};

	
	//if fField_Type = "refer" then
	//		fString = Replace(fString, "&#", "#")
	//		fString = Replace(fString, """", "&quot;")
	//		fString = HTMLEncode(fString)
	//		ChkString = fString
	//		exit function
	//end if
	//if fField_Type = "decode" then
	//		fString = HTMLDecode(fString)
	//		ChkString = fString
	//		exit function
	//end if
	//if fField_Type = "urlpath" then
	//		fString = Server.URLEncode(fString)
	//		ChkString = fString
	//		exit function
	//end if
	
	if ($fField_Type == "SQLString") {
	
			$fString = str_replace( "'", "''", $fString);
			$fString = str_replace( ";", "", $fString);
			//$fString = str_replace( "\", "\\", $fString);
            $path=str_replace('\"',"\\",$path);			
 			$fString = HTMLEncode($fString);
			
		return $fString;
	}
	
	
	
	//if fField_Type = "JSurlpath" then
	//	fString = Replace(fString, "'", "\'")
	////	fString = Server.URLEncode(fString)
	//	ChkString = fString
	//	exit function
	//end if
	//if fField_Type = "edit" then		
	//	if strAllowHTML <> "1" then			
	//		fString = HTMLEncode(fString)		
	//	end if		
	//	fString = Replace(fString, """", "&quot;")
	//	ChkString = fString		
	//	exit function	
	//end if
	//if fField_Type = "display" then
	//	if strAllowHTML <> "1" then
	//		fString = HTMLEncode(fString)
	//	end if
	//	if strBadWordFilter = "1" then
	//		fString = chkBadWords(fString)
	//	end if
	//	fString = replace(fString,"+","&#043;")
	//	fString = replace(fString, """", "&quot;")
    //    	ChkString = fString
	//	exit function
	//elseif fField_Type = "message" then
	//		if strAllowHTML <> "1" then
	//			fString = HTMLEncode(fString)
	//		end if
	//elseif fField_Type = "hidden" then
	//	fString = HTMLEncode(fString)
	////end if
	//if fField_Type = "displayimage" then
	//	fString = Replace(fString, " ", "")
	//	fString = Replace(fString, """", "")
	//	fString = Replace(fString, "<", "")
	//	fString = Replace(fString, ">", "")
	//	chkString = fString
	//exit function
	//end if
	//
	//if strAllowForumCode = "1" and fField_Type <> "signature" then
	//	fString = doCode(fString, "[marquee]", "[/marquee]", "<marquee>", "</marquee>")
	//	fString = doCode(fString, "[sup]", "[/sup]", "<sup>", "</sup>")
	//	fString = doCode(fString, "[sub]", "[/sub]", "<sub>", "</sub>")
	//	fString = doCode(fString, "[tt]", "[/tt]", "<tt>", "</tt>")
	//	fString = doCode(fString, "[hl]", "[/hl]", "<span style='background-color: #FFFF00'>", "<b></b></span>")
	//	fString = doCode(fString, "[pre]", "[/pre]", "<pre><font size=" & strDefaultFontSize & " face=""" & strDefaultFontFace & """>", "</font></pre>")
	//	fString = replace(fString, "[hr]", "<hr>", 1, -1, 1)
	//	fString = doCode(fString, "[b]", "[/b]", "<b>", "</b>")
	//	fString = doCode(fString, "[s]", "[/s]", "<s>", "</s>")
	//	fString = doCode(fString, "[strike]", "[/strike]", "<s>", "</s>")
	//	fString = doCode(fString, "[u]", "[/u]", "<u>", "</u>")
	//	fString = doCode(fString, "[i]", "[/i]", "<i>", "</i>")
	//	if fField_Type <> "title" then
	//		fString = doCode(fString, "[font=Andale Mono]", "[/font=Andale Mono]", "<font face='Andale Mono'>", "</font id='Andale Mono'>")
	//		fString = doCode(fString, "[font=Arial]", "[/font=Arial]", "<font face='Arial'>", "</font id='Arial'>")
	//		fString = doCode(fString, "[font=Arial Black]", "[/font=Arial Black]", "<font face='Arial Black'>", "</font id='Arial Black'>")
	//		fString = doCode(fString, "[font=Book Antiqua]", "[/font=Book Antiqua]", "<font face='Book Antiqua'>", "</font id='Book Antiqua'>")
	//		fString = doCode(fString, "[font=Century Gothic]", "[/font=Century Gothic]", "<font face='Century Gothic'>", "</font id='Century Gothic'>")
	//		fString = doCode(fString, "[font=Courier New]", "[/font=Courier New]", "<font face='Courier New'>", "</font id='Courier New'>")
	//		fString = doCode(fString, "[font=Comic Sans MS]", "[/font=Comic Sans MS]", "<font face='Comic Sans MS'>", "</font id='Comic Sans MS'>")
	//		fString = doCode(fString, "[font=Georgia]", "[/font=Georgia]", "<font face='Georgia'>", "</font id='Georgia'>")
	//		fString = doCode(fString, "[font=Impact]", "[/font=Impact]", "<font face='Impact'>", "</font id='Impact'>")
	//		fString = doCode(fString, "[font=Tahoma]", "[/font=Tahoma]", "<font face='Tahoma'>", "</font id='Tahoma'>")
	//		fString = doCode(fString, "[font=Times New Roman]", "[/font=Times New Roman]", "<font face='Times New Roman'>", "</font id='Times New Roman'>")
	//		fString = doCode(fString, "[font=Trebuchet MS]", "[/font=Trebuchet MS]", "<font face='Trebuchet MS'>", "</font id='Trebuchet MS'>")
	//		fString = doCode(fString, "[font=Script MT Bold]", "[/font=Script MT Bold]", "<font face='Script MT Bold'>", "</font id='Script MT Bold'>")
	//		fString = doCode(fString, "[font=Stencil]", "[/font=Stencil]", "<font face='Stencil'>", "</font id='Stencil'>")
	//		fString = doCode(fString, "[font=Verdana]", "[/font=Verdana]", "<font face='Verdana'>", "</font id='Verdana'>")
	//		fString = doCode(fString, "[font=Lucida Console]", "[/font=Lucida Console]", "<font face='Lucida Console'>", "</font id='Lucida Console'>")

	//		fString = doCode(fString, "[red]", "[/red]", "<font color=red>", "</font id=red>")
	//		fString = doCode(fString, "[green]", "[/green]", "<font color=green>", "</font id=green>")
	//		fString = doCode(fString, "[blue]", "[/blue]", "<font color=blue>", "</font id=blue>")
	//		fString = doCode(fString, "[white]", "[/white]", "<font color=white>", "</font id=white>")
	//		fString = doCode(fString, "[purple]", "[/purple]", "<font color=purple>", "</font id=purple>")
	//		fString = doCode(fString, "[yellow]", "[/yellow]", "<font color=yellow>", "</font id=yellow>")
	//		fString = doCode(fString, "[violet]", "[/violet]", "<font color=violet>", "</font id=violet>")
	//		fString = doCode(fString, "[brown]", "[/brown]", "<font color=brown>", "</font id=brown>")
	//		fString = doCode(fString, "[black]", "[/black]", "<font color=black>", "</font id=black>")
	//		fString = doCode(fString, "[pink]", "[/pink]", "<font color=pink>", "</font id=pink>")
	//		fString = doCode(fString, "[orange]", "[/orange]", "<font color=orange>", "</font id=orange>")
	//		fString = doCode(fString, "[gold]", "[/gold]", "<font color=gold>", "</font id=gold>")
//
	//		fString = doCode(fString, "[beige]", "[/beige]", "<font color=beige>", "</font id=beige>")
	//		fString = doCode(fString, "[teal]", "[/teal]", "<font color=teal>", "</font id=teal>")
	//		fString = doCode(fString, "[navy]", "[/navy]", "<font color=navy>", "</font id=navy>")
	//		fString = doCode(fString, "[maroon]", "[/maroon]", "<font color=maroon>", "</font id=maroon>")
	//		fString = doCode(fString, "[limegreen]", "[/limegreen]", "<font color=limegreen>", "</font id=limegreen>")
//
	//		fString = doCode(fString, "[h1]", "[/h1]", "<h1>", "</h1>")
	//		fString = doCode(fString, "[h2]", "[/h2]", "<h2>", "</h2>")
	//		fString = doCode(fString, "[h3]", "[/h3]", "<h3>", "</h3>")
	//		fString = doCode(fString, "[h4]", "[/h4]", "<h4>", "</h4>")
	//		fString = doCode(fString, "[h5]", "[/h5]", "<h5>", "</h5>")
	//		fString = doCode(fString, "[h6]", "[/h6]", "<h6>", "</h6>")
	//		fString = doCode(fString, "[size=1]", "[/size=1]", "<font size=1>", "</font id=size1>")
	//		fString = doCode(fString, "[size=2]", "[/size=2]", "<font size=2>", "</font id=size2>")
	//		fString = doCode(fString, "[size=3]", "[/size=3]", "<font size=3>", "</font id=size3>")
	//		fString = doCode(fString, "[size=4]", "[/size=4]", "<font size=4>", "</font id=size4>")
	//		fString = doCode(fString, "[size=5]", "[/size=5]", "<font size=5>", "</font id=size5>")
	//		fString = doCode(fString, "[size=6]", "[/size=6]", "<font size=6>", "</font id=size6>")
	//		fString = doCode(fString, "[list]", "[/list]", "<ul>", "</ul>")
	//		fString = doCode(fString, "[list=1]", "[/list=1]", "<ol type=1>", "</ol id=1>")
	//		fString = doCode(fString, "[list=a]", "[/list=a]", "<ol type=a>", "</ol id=a>")
	//		fString = doCode(fString, "[*]", "[/*]", "<li>", "</li>")
	//		fString = doCode(fString, "[left]", "[/left]", "<div align=left>", "</div id=left>")
	//		fString = doCode(fString, "[center]", "[/center]", "<center>", "</center>")
	//		fString = doCode(fString, "[centre]", "[/centre]", "<center>", "</center>")
	//		fString = doCode(fString, "[right]", "[/right]", "<div align=right>", "</div id=right>")
	//		fString = doCode(fString, "[code]", "[/code]", "<pre id=code><font face=courier size=" & strDefaultFontSize & " id=code>", "</font id=code></pre id=code>")
	//		fString = doCode(fString, "[quote]", "[/quote]", "<BLOCKQUOTE id=quote><font size=" & strFooterFontSize & " face=""" & strDefaultFontFace & """ id=quote>quote:<hr height=1 noshade id=quote>", "<hr height=1 noshade id=quote></BLOCKQUOTE id=quote></font id=quote><font face=""" & strDefaultFontFace & """ size=" & strDefaultFontSize & " id=quote>")
	//		fString = replace(fString, "[br]", "<br>", 1, -1, 1)
	//		if strIMGInPosts = "1" then
	//			fString = ReplaceImageTags(fString)
	//		end if
	//	end if
	//end if
	//if strIcons = "1" and _
	//fField_Type <> "title" and _
	//fField_Type <> "hidden" then
	//	fString= smile(fString)
	//end if
	//if fField_Type = "preview" then
	//	if strAllowHTML <> "1" then
	//		fString = HTMLEncode(fString)
	//	end if
	//end if
	//if fField_Type <> "hidden" and _
	//fField_Type <> "preview" then
	//	fString = Replace(fString, "'", "''")
	//end if
	//ChkString = fString

}


function HTMLEncode($fString){
    
	
	$fString = rtrim(trim($fString));
	if ($fString == ""){ 
	$fString = " ";
	};


    if (rtrim(trim($fString)) == ""){
		return " ";
		}
	else{
	$fString = str_replace( ">", "&gt;", $fString);
	$fString = str_replace( "<", "&lt;", $fString);
	return  $fString;
	}
	
}


 function getKomnatString($str){

switch ($str) {
case '1':return "1-комн"; 
case '2':return "2-комн"; 
case '3':return "3-комн"; 
case '4':return "4-комн";
case '0':return "Комната"; 
default:
    return "Не указано"; 
	};
}; 




function chkSpam ($str){
$str=" ".$str;
$spwords = split("\|", trim(config_item('tolk_spamwords')));

for ($i = 0; $i<(count($spwords)); $i++){
    if (strlen($spwords[$i])>2){
	if (strpos(strtolower($str), strtolower($spwords[$i]))) {

$ip=$_SERVER["REMOTE_ADDR"]; 	
$refer=strtolower($_SERVER['HTTP_REFERER']);	
$CI =& get_instance();
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$CI->load->library('email', $config);
$CI->email->set_newline("\r\n");
$CI->email->from('dakh@mail.ru');
$CI->email->to('dakh@mail.ru');
$CI->email->subject('spam detected');
$CI->email->message('спам=' . $spwords[$i]."; текст=" . $str . "; uid=" . $CI->data['user_uid'] . "; ip=". $ip . "refer=$refer; new_uid=". $CI->data['new_uid'] . "; uic=" . $CI->data['user_uic'] );
$CI->email->send();
	
	return true;}
    }
}

return false;
}











