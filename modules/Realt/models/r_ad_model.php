<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class R_ad_model extends Base_model  {

	var $fields = array();
	var $settings = array('notify_admin' => 'Y', 'style' => 'blue');
	
	
	
	public function __construct()
	{
		parent::__construct();
		$this->set_table('page');
		$this->set_pk_name('id_page');
		$this->set_lang_table('page_lang');
		$this->extend_field_table = 'extend_field';
		$this->extend_fields_table = 'extend_fields';
		 
		
		
		//echo('enter Ê ad model');	
		
		
		// parent::Base_model ();
		 $this->table = 'ads';
		 $this->fields = array(
		 	$this->table => array(
		 		'ad_id'  => '',
		 		'ad_title'  => '',
		 		'ad_message'  => '',
				'ad_price' => ''
			)
		);
		 $this->get_settings();	
		
		
			
		
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

}


