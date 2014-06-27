<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model handling database interacions for the Connect library.
 */
//  CI 2.0 Compatibility
if(!class_exists('CI_Model')) { class CI_Model extends Model {} }

class Realt_route_model extends CI_Model 
{

    public $mysegments = array();
	public $error = false;
	public $model = false;
	public $controller = false;
	public $page_segment = false;
	public $base_url = false;
	public  $pagination_base_url =false;
	
	public $layout = false;
	public $sity = false;
	public $segmentcat = false;
	public $segmentsubcat = false;
	
	public $action = 'no';
	public $data;
	/**
	 * The table to store users in.
	 *
	 * @var string
	 */
	public $users_table = 'users';
	
	/**
	 * The table to store groups in.
	 *
	 * @var string
	 */
	public $groups_table = 'user_groups';
	
	/**
	 * Users table's PK
	 *
	 * @var string
	 */
	public $users_pk = 'user_id';
	
	/**
	 * Groups table's PK
	 *
	 * @var string
	 */
	public $groups_pk = 'group_id';
	
	/**
	 * The table storing the access attempt data.
	 *
	 * @var string
	 */
	public $tracker_table = 'login_tracker';
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Contructor
	 *
	 */
	function __construct()
    {
        parent::__construct();
		
		
		
		
		
		include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
        $this->data['cityidArr'] = $config['realt_cityes_id'];
        $this->data['citynameArr'] = $config['realt_cityes_name'];
        $this->data['cityuriArr'] = $config['realt_cityes_uri'];
		
		$this->data['cityArr'] = $config['realt_cityes_array'];
		$this->data['cityesIndex'] = $config['realt_cityes_index'];
		$this->data['cityesCount'] = $config['realt_cityes_count'];
		 
		 
        $this->data['regionsArr'] = $config['realt_cityes_region'];
        $this->data['realt_subcats'] = $config['realt_subcats'];
        $this->data['realt_cats'] = $config['realt_cats'];

         
		
		
		
		
		
		
		
		
		// Загрузить какие то настройки наверно 
        $this->define();
		
		
		//$this->load->config('connect');

		//$this->users_table 	= config_item('users_table');
		//$this->users_pk 	= config_item('users_table_pk');
		
		//$this->groups_table = config_item('groups_table');
		//$this->groups_pk 	= config_item('groups_table_pk');

    }
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Finds a user.
	 *
	 * @param $identification An array or string that identifies the user
	 *        Like array('email' => 'the email') or just the username
	 * @return object
	 */
	 
	 	public function define( )
	{	
// адрес может быть  neagent.by/[board]/[wap]/[vitebsk]/segment1/segment2

 $CI =& get_instance();
 $page_segment=4;
$wapmarker="";
$citymarker="";		  
        $this->mysegments[0]=$CI->uri->segment(3); // board
		$this->mysegments[1]=$CI->uri->segment(4); // 1 вап или 0  обычное
		$this->mysegments[2]=$CI->uri->segment(5); // города id 
		$this->mysegments[3]=$CI->uri->segment(6); //  строка категория
        $this->mysegments[4]=$CI->uri->segment(7);  //  строка подкатегория 
		
		
		$basesegments =""; // board
		$pagination_base_url='http://neagent.by';
		//echo("<hr>---------------------- ini  1");
		//print_r($this->mysegments);
		
		if($this->mysegments[0] == 'page'){
		$pagination_base_url=$pagination_base_url . "/page/";
		}
		 
		if($this->mysegments[1] == false){
		 
		$pagination_base_url=$pagination_base_url . "/page/";
		}
		
		
 //echo("s--". "<br>");
		 //		
		
		
		//
		  
		  
		if ($this->mysegments[0] != 'board' ){
		//echo('/not board/');
		array_unshift(  $this->mysegments, 'board' );
		}
		else{
		 
		$basesegments .= "/" . $this->mysegments[0];  // Если в строке боард то оставляем его в пути.  
		}
		
		
		 //
		
		
		
		//echo("<hr>---------------------- afetr 1");
		//print_r($this->mysegments);
		
		
		
		if ($this->mysegments[1] != 'wap'){
		//echo('/not wap/');
		array_unshift(  $this->mysegments, 'board' );
		$this->mysegments[1]='web';
		}
		else{
		$wapmarker="wap/";
		$basesegments .= "/" .  $this->mysegments[1]; 
        //$page_segment=$page_segment+1;		
		}
		
		
		//
		
		/*
		  echo("--a2--". "<br>");
		  echo($this->mysegments[0] . "<br>");
		   echo($this->mysegments[1]. "<br>");
		    echo($this->mysegments[2]. "<br>");
		echo($this->mysegments[3]. "<br>");
		  echo("--");
		*/
		
		//echo("<hr>---------------------- afetr 2");
		//print_r($this->mysegments);
		
        $s= $this->isCity($this->mysegments[2]);
		// echo("<hr>-------------- " . $this->mysegments[2] . " --------iss" . $s);
		
		if (!$s){
		$this->mysegments[0]=$this->mysegments[1]; // вап
		$this->mysegments[1]='1'; // МИНСК  
		array_unshift(  $this->mysegments, 'board' );

		
		}
		else{
		
		$citymarker=($wapmarker=='')?  ("board/" . $this->mysegments[2] . "/") : ("" . $this->mysegments[2] . "/");
		
		
		
		$page_segment=$page_segment+1;
		$basesegments .= "/" . $this->mysegments[2]; 
		$this->mysegments[2]=$s;
		}
		
		
//echo("this->mysegments[3]" . $this->mysegments[3] );	
if (!is_numeric($this->mysegments[3]) && !$this->mysegments[3]==""){	
$basesegments .= "/" . $this->mysegments[3];
}
//echo("this->mysegments[4]" . $this->mysegments[4] );
if (!is_numeric($this->mysegments[4]) && !$this->mysegments[4]==""){
$basesegments .= "/" . $this->mysegments[4];
}		
		/*
		  echo("--a3--". "<br>");
		  echo($this->mysegments[0] . "<br>");
		   echo($this->mysegments[1]. "<br>");
		    echo($this->mysegments[2]. "<br>");
		echo($this->mysegments[3]. "<br>");
		  echo("--");
		  */
		 
//echo("<hr>---------------------- afetr 3");
//print_r($this->mysegments);

		$this->base_url = "http://neagent.by/" . $basesegments . "/";
		$this->base_url= str_replace("/page/" , "/", $this->base_url);
		$this->base_url= str_replace("/board/" , "/", $this->base_url);
		$this->base_url= str_replace("://" , ":--", $this->base_url);
        $this->base_url= str_replace("//" , "/", $this->base_url);
		$this->base_url= str_replace(":--" , "://", $this->base_url);
		//echo("00-" . $this->base_url); 
		

//
$pagination_base_url="http://neagent.by" . $basesegments . "/";
 //echo("s==" .$this->mysegments[3]);
 
 //echo($this->mysegments[3]  . "%%" .$this->mysegments[4] );
 switch ($this->mysegments[3]) {
 			case 'kvartira' :  // ОДНИМ ЛОВОМ РУБРИКА
            case 'komnata':
            case 'office': case 'dom':
			case 'snimu':
			case 'sdaju':case 'regions':
			$page_segment=$page_segment+2;
			 //echo("do" .$pagination_base_url );
			$pagination_base_url= str_replace("/board/" , "/", $pagination_base_url);
			//echo("после" .$pagination_base_url );
			$this->base_url = "http://neagent.by/";
			//$page_segment=$page_segment-1;
}

$this->base_url = "http://neagent.by/" . $wapmarker  .  $citymarker ;

 



	
	
	
	 //echo ("%%%%%%%%%" .  $this->mysegments[3]);		

 switch ($this->mysegments[3]) {
 
		
			
			
			
			
            case 'snimu' :
            case 'sdayu':
            case 'nasutki':
			$this->action = 'getSingleAd';
			//echo('getSingleAd');
            // вызываем функцию показа объявлений
            break;

			
            case 'ad_form' :
            $this->action = 'getAddFormPage'; // вызываем функцию показа объявлений
            break;

            case 'my_ad' :
            $this->action = 'getMyAdsPage'; // вызываем функцию показа объявлений
            break;

            case 'saveuser' :
            $this->action = 'register'; // вызываем функцию показа объявлений
            break;
            case 'register' :
            $this->action = 'register2'; // вызываем функцию показа объявлений
            break;
            case 'user' :
            $this->action = 'userpage'; // вызываем функцию показа объявлений
            break;
            case 'agent' :
            $this->action = 'agent'; // вызываем функцию показа объявлений
            break;

            case 'loginuser' :
            case 'login' :
            $this->action = 'login'; // вызываем функцию показа объявлений
            break;

            case 'sendpassword' :
            $this->action = 'sendpassword'; // вызываем функцию отправки пароля
            break;

            case 'resetpassword' :
            $this->action = 'resetpassword'; // вызываем функцию отправки пароля
            break;

			case 'add' :
            $this->action = 'getAddFormPage'; // вызываем функцию отправки пароля
            break;
			
			case 'regions' :
            $this->action = 'getRegionsPage'; // вызываем функцию отправки пароля
            break;
			
			case 'up' :
            $this->action = 'up'; // вызываем функцию показа объявлений
            break;
			
            default:
			// echo('def');
            $this->action = 'getAdsPage'; // вызываем функцию показа объявлений
        }

        //$this->data['debug'] .= " CAT -   " . "board/" . $this->segment_cat;

		
		
// 

 
//echo( $this->mysegments[3]);
            switch ("board/" . $this->mysegments[3]) {
            case "board/access":
// Если страница Access
$this->action = 'accessPage';
          //  include 'inc_access.php';
            return;
            break;

            case "board/verification":
// Если страница Verification
            $this->action = 'verificationPage';
            include 'inc_verification.php';
            return;
            break;

            case "board/regions":
            if (isset($this->data['newregion']) && $this->data['newregion'] != 1) {
            $this->action = 'getRegionsPage';
            return;
            }
            break;

            case "board/uid":
//////////////////////////
            
			$this->action = 'uidPage';
   //include 'inc_getadsfuid.php';
               
             
			
			return;
			
            break;

            case "board/label":
                include 'inc_getadsfuid.php';
                return;
                break;
/////////////////////////////////

            case "board/moderate":
			    $this->action = 'moderationPage';
			//echo("модерация");
                include 'inc_getadsmoderate.php';
                return;
                break;

/////////////////////////////////

            case "board/mcomments":
			$this->action = 'commentsModerationPage';
                
                return;
                break;

//////////////////////////
            case "board/all":
			 $this->action = 'allPage';
                //include 'inc_getadsfall.php';
                return;
                break;
//////////////////////////

            case "board/userads":
                include 'inc_getadsuser.php';
                return;
                break;

//////////////////////////
            case "board/evc":
                if ($this->data['mlev'] == 4) {
                    include 'inc_getadsfevc.php';
                }
                return;
                break;

            case "board/adid":
               $this->action = 'adidPage';
                 
                return;
                break;
        }
		 //echo(   ">>" . $this->mysegments[6] ); 
		 //echo(   " -->"   ); 
		 
		 $this->pagination_base_url = $pagination_base_url;
		 $this->page_segment= $page_segment;
		 // echo(  " * " .  $this->pagination_base_url  . " * " ); 
	return;

	}
	
	
	public function isCity($str){  // Есть ли строка в массиве городов
	//echo("dat");
	//echo($this->data['cityuriArr']);
	
	     for ($k = 0; $k < count($this->data['cityuriArr']); $k++) {
            if ($str == $this->data['cityuriArr'][$k]) {
               return $this->data['cityidArr'] [$k];
                 
            }
        }
	return false;
	}
	
	
	
	
	public function find_user($identification)
	{		
		if( ! is_array($identification))
		{
			$identification = array('username' => $identification);
		}

		// return false if there are no conditions
		if( ! $this->num_conds($identification))
		{
			$this->error = $this->connect->set_error_message('connect_parameter_error', 'Connect_model::find_user()');
		}

		$identification = array_merge($identification, array('limit' => 1));

		$result = $this->get_users($identification);

		if(empty($result))
		{
			return false;
		}

		return array_shift($result);
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Finds an arbitrary amount of users.
	 * 
	 * @param  array  The conditions to filter by, also limit, offset and order by
	 *                limit, offset and order_by are sent to the IgnitedQuery methods
	 *                with the same name
	 * @return array  Array with User_records in it (groups are also stored in the user record)
	 */
	public function get_users($cond = array())
	{		
		foreach(array('limit', 'offset', 'order_by') as $key)
		{
			if(isset($cond[$key]))
			{
				call_user_func(array($this->db, $key), $cond[$key]);
				unset($cond[$key]);
			}
		}
		
		$this->db->join($this->groups_table, $this->users_table.'.'.$this->groups_pk.' = '.$this->groups_table.'.'.$this->groups_pk, 'left');
		
		$query = $this->db->get_where($this->users_table, $cond);

		$result = array();

		foreach($query->result_array() as $row)
		{
			$result[] = $this->split_user_group($row);
		}

		return $result;
	}
	
	
	// --------------------------------------------------------------------
	
	
	public function save_user($user_data = array())
	{
		return $this->db->insert($this->users_table, $user_data);
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Bans a user.
	 * 
	 * @param  int   The user id
	 * @return bool
	 */
	public function ban_user($user_id)
	{		
		// don't allow the current user to ban himself by id, let him use the direct method instead:
		// Access()->get_current_user()->ban();
		if($this->connect->get_current_user() && $this->connect->get_current_user()->user_id == $user_id)
		{
			$this->error = $this->connect->set_error_message('connect_cannot_ban_yourself');
		}
		
		$query->select('group_id')
			  ->from($this->groups_table)
			  ->where('slug', $this->connect->banned_user_group);
		
		return $this->db->update($this->users_table, array('group_id' => $query), array('user_id' => $user_id), 1);
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Finds a certain group.
	 * 
	 * @param  int|array  id or condition
	 * @return Group_record
	 */
	public function find_group($id)
	{
		if( ! is_array($id))
		{
			$id = array($this->groups_pk => $id);
		}

		$query = $this->db->get_where($this->groups_table, $id, 1);

		if( ! $query->num_rows())
		{
			return false;
		}

		return $query->row_array();
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Finds an arbitary amount of groups.
	 * 
	 * @param  array  The conditions to filter by, also limit, offset and order by
	 *                limit, offset and order_by are sent to the IgnitedQuery methods
	 *                with the same name
	 * @return array  Array with Group_records in it
	 */
	public function get_groups($cond = array())
	{
		foreach(array('limit', 'offset', 'order_by') as $key)
		{
			if(isset($cond[$key]))
			{
				call_user_func_array(array($this->db, $key), (Array) $cond[$key]);
				unset($cond[$key]);
			}
		}
		
		$query = $this->db->get_where($this->groups_table, $cond);

		$result = $query->result_array();

		return $result;
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Counts the identification values because empty may enable fetching of any user -
	 * a potential security vulnerability.
	 * 
	 * @param  mixed
	 * @return int
	 */
	private function num_conds($conds = array())
	{
		$num_conds = 0;
		foreach((Array) $conds as $key => $row)
		{
			if( ! empty($row) && ! empty($key))
			{
				$num_conds++;
			}
		}
		
		return $num_conds;
	}
	
	
	// --------------------------------------------------------------------
	
	
	function check_duplicate($str, $type)
	{
		return $this->db->select('1', false)->where($type, $str)->get($this->users_table)->num_rows;
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Splits the group and user data into separate objects, user->group = group object.
	 *
	 * @param $data the data
	 * @return object
	 */
	private function split_user_group($data)
	{
		$g_data = array();

		foreach(array($this->groups_pk, 'slug', 'level', 'group_name') as $col)
		{
			$g_data[$col] = $data[$col];
			unset($data[$col]);
		}

		$data[$this->groups_pk] = $g_data[$this->groups_pk];
		$data['group'] = $g_data;

		return $data;
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Sets the group for a user.
	 * 
	 * @param  int|string|array  String = slug, int = group_id
	 * @return void
	 */
	public function set_group($group = null)
	{		
		if(is_numeric($group))
		{
			$this->group_id = $group;
		}
		elseif(is_array($group))
		{
			$this->group_id = $group[$this->groups_pk];
		}
		else
		{
			if( ! empty($group) && $g = $this->find_group(array('slug' => $group)))
			{
				$this->group_id = $g[$this->groups_pk];
			}
			else
			{
				// just assign the lowest level of access, subquery
				$this->db
					->select('slug')
					->from($this->groups_table)->order_by('level', 'asc');
				
				$this->group_id =& $query;
			}
		}
		
		return $this->group_id;
	}
	
	
	// --------------------------------------------------------------------
	
	
	/**
	 * Updates the last visit counter.
	 * 
	 * @param  string  Date string formatted like 'Y-m-d H:i:s'
	 * @return void
	 */
	public function update_last_visit($user, $date = false)
	{
		$last_visit = $date ? $date : date('Y-m-d H:i:s');
		
		return $this->db->where($this->users_pk, $user[$this->users_pk])
					->update($this->users_table, array('last_visit' => $last_visit));
	}
	
	
	// --------------------------------------------------------------------
	
	
	public function save_tracker($tracker)
	{
		// update : No client IP : Set it ! 
		if ( empty($tracker['ip_address']) )
		{
			$tracker['ip_address'] = $this->input->ip_address();
			return $this->db->insert($this->tracker_table, $tracker);
		}
		else
		{
			return $this->db->where('ip_address', $this->input->ip_address())
					->update($this->tracker_table, $tracker);
		}
	}

}


/* End of file connect_model.php */
/* Location: ./application/libraries/connect_model.php */