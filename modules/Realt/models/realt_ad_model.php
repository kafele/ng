<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Realt_ad_model extends Base_model  {

	var $fields = array();
	var $settings = array('notify_admin' => 'Y', 'style' => 'blue');
	var $error_string			= '';
	
	
	public function __construct()
	{
		parent::__construct();
		$this->set_table('ads');
		$this->set_pk_name('id_page');
		$this->set_lang_table('page_lang');
		$this->extend_field_table = 'extend_field';
		$this->extend_fields_table = 'extend_fields';
		 
		 
		
		//echo('enter К ad model');	
		
		
		// parent::Base_model ();
		 $this->table = 'ads';
		 $this->fields2 = array(
		 	$this->table => array(
		 		'ad_id'  => '',
		 		'ad_title'  => '',
		 		'ad_message'  => '',
				'ad_price' => ''
			)
		);
		 $this->get_settings();	
		
		
			
		
	}
	
		public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		//  Только для того что вводит пользователь!!! 
		return  array(
               array(
                     'field' => 'message', 
                     'label' => 'Текст объявления', 
                     'rules' => 'trim|min_length[2]'
                  ),
				  array(
                     'field' => 'komnat',
                     'label' => 'Количество комнат', 
                     'rules' => 'trim|required|numeric'
                  ),
				  array(
                     'field' => 'content',
                     'label' => 'Текст объявления', 
                     'rules' => 'trim|required|min_length[5]'
                  ),
				  array(
                     'field' => 'komnat',
                     'label' => 'Количество комнат', 
                     'rules' => 'trim|required|numeric'
                  ),
				   array(
                     'field' => 'pl_o',
                     'label' => 'Общая площадь', 
                     'rules' => 'trim|numeric'
                  ),
				   array(
                     'field' => 'pl_z',
                     'label' => 'Жилая площадь', 
                     'rules' => 'trim|numeric'
                  ),
				   array(
                     'field' => 'pl_k',
                     'label' => 'Площадь кухни', 
                     'rules' => 'trim|numeric'
                  ),
				   array(
                     'field' => 'etaz',
                     'label' => 'Этаж', 
                     'rules' => 'trim|numeric'
                  ),
				   array(
                     'field' => 'etazej',
                     'label' => 'Этажей', 
                     'rules' => 'trim|numeric'
                  ),
				  array(
                     'field' => 'price',
                     'label' => 'Цена', 
                     'rules' => 'trim|required'
                  ),
				
            );
	}
	
	
	public function rules2() // дополнительные параметры валидации - мои 
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		//  Только для того что вводит пользователь!!! 
		return  array(
               array(
                     'field' => 'phones', 
                     'label' => 'Телефоны', 
                     'rules' => 'trim|valid_phone'
                  ),
				  array(
                     'field' => 'price',
                     'label' => 'Цена', 
                     'rules' => 'trim'
                  ),

            );
	}
	
	
public function afterModelCreate() // после установки всех fields
{ 	


}

	
public function beforeSet($mkey, $value)
{ // обработка данных введенных пользователем перед сохраниеем в модель 

if ($mkey =="ad_pictures"){
                                if (strlen($value) > 1) {
                                    $ad_pictures = explode("; ", $value);
                                    $value = $ad_pictures;
                                    $this->fields['ad_thumbs'] = $ad_pictures;
                                    $this->fields['pic_folder'] = "http://neagent.by/modules/Realt/files/";
                                    $this->fields['ad_mainpic'] = "http://neagent.by/modules/Realt/files/" . "t_" . $ad_pictures[0];
                                } else {
                                    $value = array();
									$this->fields['pic_folder'] = "http://neagent.by/modules/Realt/files/";
                                    $this->fields['ad_mainpic'] = "http://neagent.by/themes/neagent_style/assets/images/kvartira.gif";
                                }
return $value; // значение возможно изменилось , если   было с черточкой  
}


if ($mkey =="ad_mainpic"){
$value="http://neagent.by/modules/Realt/files/" . $value;

                               
return $value; // значение возможно изменилось , если   было с черточкой  
}



if ($mkey =="ad_url"){

if ($this->table='sutki'){
return "http://neagent.by/nasutki/". $value;
}

return "http://neagent.by/sdayu/". $value;



}

if ($mkey =="ad_komnat"){
				if (strpos($value, "-")) {
                    $ad_komnat_Arr = explode("-", $value);
                    $this->fields["ad_komnat_min"] = $ad_komnat_Arr[0];
                    $this->fields["ad_komnat_max"] = $ad_komnat_Arr[1];
                    if ($this->fields["ad_komnat_min"] > $this->fields["ad_komnat_max"]) {
                        $this->error_string .= '<li>Неверное значение количества комнат.</li>';
                    }
                    if (!is_numeric($this->fields["ad_komnat_min"])) {
                        $this->error_string .= '<li>Неверное значение количества комнат.</li>';
                    }
                    if (!is_numeric($this->fields["ad_komnat_max"])) {
                        $this->error_string .= '<li>Неверное значение количества комнат.</li>';
                    }
                    $value = $this->fields["ad_komnat_min"]; // для совместимости. Потом поле ad_komnat вобще лучше удалить 
                } else {
                    if (!is_numeric($value)) {
                        $this->error_string .= '<li>Не выбрано количество комнат</li>';
                    }
                    $this->fields["ad_komnat_min"] = $this->fields["ad_komnat_max"]=  $value;
                }
return $value; // значение возможно изменилось , если   было с черточкой  
}

if ($mkey =="ad_price"){
				if (strpos($value, "-")) {
                   // echo(1);
                    $ad_price_Arr = explode("-", $value);
                    $this->fields["ad_price_min"] = $ad_price_Arr[0];
                    $this->fields["ad_price_max"] = $ad_price_Arr[1];
                    if ($this->fields["ad_price_min"] > $this->fields["ad_price_max"]) {
                        $this->error_string .=  '<li>Неверное значение дапазона цен.</li>';
                    }
                    if (!is_numeric($this->fields["ad_price_min"])) {
                       $this->error_string .=  '<li>Неверное значение дапазона цен.</li>';
                    }
                    if (!is_numeric($this->fields["ad_price_max"])) {
                        $this->error_string .=  '<li>Неверное значение дапазона цен.</li>';
                    }
                    $value = $this->fields["ad_price_min"]; // для совместимости. Потом поле ad_komnat вобще лучше удалить 
                } else {
                   // echo(2);
                    if (!is_numeric($value)) {
                        $this->error_string .= '<li>Неверное значение цены.</li>';
                    }
                    $this->fields["ad_price_min"]  = $this->fields["ad_price_max"] =$value;  
                }
				

if(is_numeric($this->fields["ad_price_min"])&&	is_numeric($this->fields["ad_price_max"])&&is_numeric($value) ){	
//echo("000");		
$realt_currency_rate = config_item('realt_currency_rate');
$ad_currency = chkString($_POST['currency'], "SQLString");
if (!is_numeric($ad_currency)) {
$ad_currency = 2; // Редактировать. Пока валюта устанавливается в доллары
                }
				
$this->fields["ad_default_price"] = defaultPrice($ad_currency, $this->fields["ad_price"], $realt_currency_rate); // формируем цену по умолчанию - для поиска 
$this->fields["ad_default_price_min"] = defaultPrice($ad_currency, $this->fields["ad_price_min"], $realt_currency_rate);
$this->fields["ad_default_price_max"] = defaultPrice($ad_currency, $this->fields["ad_price_max"], $realt_currency_rate);				
}
else{
//echo($this->error_string );
//echo("999");
$this->error_string .= '<li>Неверное значение цены.</li>';
}
				
				
return $value; // значение возможно изменилось , если   было с черточкой  
}


return $value;
}
	
	
	 
	
	public function attributeLabels() // ненужное 
	{
		return array(
		 'ad_type' =>  array( 'label' => 'type', 'var'=>''), // 
		     'ad_id' =>  array( 'label' => 'ID', 'var'=>'1'), // 
			 'ad_city' =>  array( 'label' => 'Город', 'var'=>'ad_city'),
			 'ad_catid' =>  array( 'label' => 'Категория', 'var'=>'catid'),
			 'ad_message' =>  array( 'label' => 'Текст объявления', 'var'=>'content'),
			 'ad_komnat' =>  array( 'label' => 'Количество комнат', 'var'=>'komnat'),
			 'ad_etazh' =>  array( 'label' => 'Этаж', 'var'=>'etazh'),
			 'ad_etazhej' =>  array( 'label' => 'Этажей', 'var'=>'etazhej'),
			 'ad_isolated' =>  array( 'label' => 'Изолированных комнат', 'var'=>'isolated'),
			 'ad_material' =>  array( 'label' => 'Материал дома', 'var'=>'material'),
			 'ad_sanuzel' =>  array( 'label' => 'Тип санузла', 'var'=>'sanuzel'),
			 'ad_otdelka' =>  array( 'label' => 'Отделка', 'var'=>'otdelka'),
			 'ad_pl_o' =>  array( 'label' => 'Общая площадь', 'var'=>'pl_o'),
			 'ad_pl_z' =>  array( 'label' => 'Жилая плошадь', 'var'=>'pl_z'),
			 'ad_pl_k' =>  array( 'label' => 'Площадь кухни', 'var'=>'pl_k'),
			 'ad_balkon' =>  array( 'label' => 'Балкон', 'var'=>'balkon'),
			 'ad_komm_type' =>  array( 'label' => 'Тип коммерческой недвижимости', 'var'=>'komm_type'),
			 'ad_srok' =>  array( 'label' => 'Срок размещения объявления', 'var'=>'srok'),
			 'ad_price' =>  array( 'label' => 'Цена', 'var'=>'price'),
			 'ad_price_min' =>  array( 'label' => 'Цена от', 'var'=>'price_min'),
			 'ad_price_max' =>  array( 'label' => 'Цена от', 'var'=>'price_max'),
			 'ad_price_object' =>  array( 'label' => 'Цена за..', 'var'=>'price_object'),
			 'ad_postdate' =>  array( 'label' => 'Дата обновления', 'var'=>'postdate'),
			 'ad_firstdate' =>  array( 'label' => 'Дата публикации', 'var'=>'firstdate'),
			 'ad_enddate' =>  array( 'label' => 'Дата окончания публикации', 'var'=>'enddate'),
			 'ad_email' =>  array( 'label' => 'Электронный адрес', 'var'=>'email'),
			 'm_confirmed' =>  array( 'label' => 'Email подтвержден', 'var'=>''), // ненадо лэйба. Это ведь не вводится
			 'm_confirm_code' =>  array( 'label' => 'Email подтвержден', 'var'=>''), // ненадо лэйба. Это ведь не вводится
			 'ad_contactname' =>  array( 'label' => 'Контактное имя', 'var'=>'contactname'),
			 'ad_phones' =>  array( 'label' => 'Телефоны', 'var'=>'phones'),
			 'ad_show' =>  array( 'label' => 'показывать', 'var'=>'show'),
			 'ad_showpolitic' =>  array( 'label' => 'политика показа', 'var'=>'showpolitic'),
			 'ad_pending' =>  array( 'label' => 'на модерации', 'var'=>'pending'),
			 'ad_fakefor' =>  array( 'label' => 'fakefor', 'var'=>'fakefor'),
			 'ad_ip' =>  array( 'label' => 'ip', 'var'=>'ip'),
			 'ad_uid' =>  array( 'label' => 'uid', 'var'=>'uid'),
			 'ad_evc' =>  array( 'label' => 'evc', 'var'=>'evc'),
			 'ad_cref' =>  array( 'label' => 'cref', 'var'=>'cref'),
			 'ad_hideemail' =>  array( 'label' => 'hideemail', 'var'=>'hideemail'),
			 'ad_street' =>  array( 'label' => 'Улица', 'var'=>'street'),
			  'ad_dom' =>  array( 'label' => 'Дом', 'var'=>'dom'),
			  'ad_korpus' =>  array( 'label' => 'Корпус', 'var'=>'korpus'),
			   'ad_area' =>  array( 'label' => 'район', 'var'=>'area'),
			    'ad_city' =>  array( 'label' => 'город', 'var'=>'city'),
				'longitude' =>  array( 'label' => 'longitude', 'var'=>'longitude'),
				'latitude' =>  array( 'label' => 'latitude', 'var'=>'latitude'),
				'ad_pictures' =>  array( 'label' => 'pictures', 'var'=>'pictures'),
				'ad_secretcode' =>  array( 'label' => 'secretcode', 'var'=>''),
				'ad_url' =>  array( 'label' => 'url', 'var'=>''),
				'ad_subarea' =>  array( 'label' => 'subarea', 'var'=>'subarea'),
				'ad_currency' =>  array( 'label' => 'валюта', 'var'=>'currency'),
				'ad_default_price' =>  array( 'label' => 'цена в белорусских', 'var'=>''),
				'ad_default_price_min' =>  array( 'label' => 'цена в белорусских мин ', 'var'=>'defprice'),
				'ad_default_price_max' =>  array( 'label' => 'цена в белорусских макс', 'var'=>''),
				'ad_comments_count' =>  array( 'label' => 'цена в белорусских макс', 'var'=>''),
				'ad_delete_reason' =>  array( 'label' => 'цена в белорусских макс', 'var'=>''),
				'ad_hits' =>  array( 'label' => 'hits', 'var'=>''),
				'phone_verified' =>  array( 'label' => 'phone_verified', 'var'=>''),
				'ad_user' =>  array( 'label' => 'ad_user', 'var'=>'userid'),
				'ad_icons' =>  array( 'label' => 'ad_icons', 'var'=>'ad_icons'),
			 //'ad_catid', 'label' =>'Рубрика', 'var'=>''),
			 //'ad_title', 'label' =>'Заголовок', 'var'=>''),
			 //'ad_message', 'label' =>'Текст объявления', 'var'=>'message'),
			 //'ad_komnat', 'label' =>'Комнат', 'var'=>'komnat'),
			 //'ad_etazh','label' => 'Этаж', 'var'=>'etazh'),
 
			
		);
	}
	
	
	public function setdata($mkey, $value){  // mkey - это имя колонки в таблице
	$value = $this->beforeSet($mkey, $value);
	$value = chkString($value,  "SQLString");
	$this->fields[$mkey]=$value;
	}
	
	
	
	public function setdataArr($arr ){// mkey - это имя колонки в таблице
	foreach ($arr as $key => $value){
	$value = $this->beforeSet($key, $value);
	$value = chkString($value,  "SQLString");
	$this->fields[$key]=$value;
	}
	}
	
	
	
	//function Guestbook_model()
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
	
	//echo("saving");
		$this->db->set($data);
		
		//$this->cache->remove_group($this->table);
		return $this->db->insert($this->table);
	}
	
	
	
	
	function save___($data, $dataLang) 
	{
		// New ad : Created field
		if( ! $data['adid'] )
			$data['created'] = $data['updated'] = date('Y-m-d H:i:s');
		// Existing ad : Update date
		else
			$data['updated'] = date('Y-m-d H:i:s');


		// Dates
		$data['publish_on'] = ($data['publish_on']) ? getMysqlDatetime($data['publish_on']) : '0000-00-00';
		$data['publish_off'] = ($data['publish_off']) ? getMysqlDatetime($data['publish_off']) : '0000-00-00';
		$data['comment_expire'] = ($data['comment_expire']) ? getMysqlDatetime($data['comment_expire']) : '0000-00-00';
			

		// ad saving
		return parent::save($data, $dataLang);
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
	//	$query = $this->db->get('realt_settings');
		
		// if ($query->num_rows() > 0)
		//  {
		//    foreach ($query->result() as $row)
		//    {
		//	echo  ($row->value );
		// 	  $this->settings[$row->name] = $row->value;
		//    }
		//  }	
		 
	}
	
	
	
	
	function save_settings($name, $value)
	{	
		//update only if changed
		if (!isset($this->settings[$name])) {
			$this->settings[$name] = $value;
			$this->db->insert('guestbook_settings', array('name' => $name, 'value' => $value));
		}
		elseif ($this->settings->$name != $value) 
		{
			$this->settings->$name = $value;
			$this->db->update('guestbook_settings', array('value' => $value), "name = '$name'");
		}
	}

	
	
	
	 public function modelFromRow($row)
    {

$m =  get_instance();	
$m =  new $this;
foreach($row as $key => $value) {
//echo(" rkey=" . $key . " rval=" .$value );	
//$mkey = attributeSearch($ad->attributeLabels(),  "var", $key);
//if ($mkey){
 $m->setdata($key, $value);  
//}		
 
	
	}
	
	
return 	$m ;
	
	
	}
	
	 public function search()
    {
	
$CI =& get_instance();	
	
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        //$criteria=new CDbCriteria;
        
        //$criteria->compare('id',$this->id);
        //$criteria->compare('username',$this->username,true);
       // $criteria->compare('password',$this->password);
        
foreach($this->fields as $key => $value) {

//$labels=$ad->attributeLabels();
//$mkey = attributeSearch($ad->attributeLabels(),  "var", $key);

$CI->db->where($key , $value);
		
}
		
$CI->db->from($this->table);	
//echo($this->table);


		//$CI->db->where("ad_show" , 1);
        
$query = $CI->db->get();

return $query->result();
		 
		 
		 
//echo($CI->db->last_query());
if ($query->num_rows() == 0) {
return false;
 
} else {

$models=array();

foreach ($query->result() as $row) {

$mm=$this->modelFromRow($row);
if ($mm){
array_push($models, $mm); 			
}
           


		   }
};






return $models;
	
		
		
        
    }
	
	
	
	
	
	
	
	
	
	
	
	
 public function modelsFromQuery($query)
{
$models = array();
//print_r ($query);
//$CI =& get_instance();	
//echo($CI->db->last_query());
if ($query->num_rows() == 0) {
return array();
} else {

//echo ("ROWS=" . $query->num_rows() );

$models=array();
foreach ($query->result() as $row) {
//echo ("ROW %"    );
$mm=$this->modelFromRow($row);
if ($mm){
//echo ("добавлено"    );
array_push($models, $mm); 			
}
}
};
//print_r($models);





return $models;
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	 public function find($criteria)
    {
	
	
	
$CI =& get_instance();	




	}
	
	
	
	
	
	
}


