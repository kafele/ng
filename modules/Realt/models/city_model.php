<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ionize
 *
 * @package		Ionize
 * @author		Ionize Dev Team
 * @license		http://ionizecms.com/doc-license
 * @link		http://ionizecms.com
 * @since		Version 0.91
 */

// ------------------------------------------------------------------------

/**
 * Ionize Fancyupload Model
 *
 * @package		Ionize
 * @subpackage	Models
 * @category	Module Model
 * @author		Ionize Dev Team
 *
 */

class City_model extends Base_model
{

	/**
	 * Model Constructor
	 *
	 * @access	public
	 */
	   public $cityID;
	   public $cityName;
	   public $cityNameIn;
	   public $cityUri;
	   
	   
	   public $cityidArr;
	   public $citynameArr;
	   public $cityuriArr;
	   
	   public $cityArr;
	   public $cityesIndex;
	   public $cityesCount;
	   
	   
	   public $regionsArr;
	   public $realt_subcats;
	   
	   
	   
	public function __construct( )
	{
	
	 //echo(44444);
	
		parent::__construct();
 
		$this->set_table('realt_cityes');
		$this->set_pk_name('city_id');
		 
		include $_SERVER['DOCUMENT_ROOT'] . '/modules/Realt/config/realtcash.php';
        $this->cityidArr  = $config['realt_cityes_id'];
        $this->citynameArr  = $config['realt_cityes_name'];
        $this->cityuriArr  = $config['realt_cityes_uri'];
		
		$this->cityArr  = $config['realt_cityes_array'];
		$this->cityesIndex  = $config['realt_cityes_index'];
		$this->cityesCount  = $config['realt_cityes_count'];
        $this->regionsArr  = $config['realt_cityes_region'];
     
	 
	}


	// ------------------------------------------------------------------------


	/**
	 * Saves one email
	 *
	 * @param		array		Email data array
	 * @returns		boolean		true if success, false if fails
	 *
	 */
	public function set_City($id)
	{
	//echo('setted siti' . $id);
	$this->cityID    = $id;
     $this->cityName = $this->get_Name($id);
 //echo('setted sitiname' . $this->cityName);
     $this->cityUri = $this->get_Uri($id);
	 $this->cityNameIn =$this->get_Name_in( $this->cityName);
	
		
		
	return false;
	
	
	}
	

	 
    function get_Name($cityid)
    {
	
	 
	$idarr=$this->cityidArr;
	$namearr=$this->citynameArr;
	
        $name = "М";
        if (is_array($idarr)) {
            foreach ($idarr as $key => $value) {
                if ($value == $cityid) {
                    $name = $namearr[$key];
                }
            }
        }
        return $name;
    }
	
    function get_Uri($cityid)
    {
	
	$idarr=$this->cityidArr;
	$namearr=$this->cityuriArr;
	
        $uri = "";
        if (is_array($idarr)) {
            foreach ($idarr as $key => $value) {
                if ($value == $cityid) {
                    $uri = $namearr[$key];
                }
            }
        }
        return $uri;
    }
	
	  function get_Name_in($cityname)
    {
        switch ($cityname) {
            case 'Минск':
            case 'Брест':
            case 'Витебск':
            case 'Новополоцк':
            case 'Могилев':
            case 'Минск':
                $cityname .= "е";
                break;
            case 'Гомель':
                $cityname = "Гомеле";
                break;
            default:
        }
        return $cityname;
    }
	
	
	

	/**
	 * Saves one email list and returns the number of items inserted
	 *
	 * @param	Array	Emails array
	 * @return	Int		Inserted elements
	 *
	 */
	function save_email_list($data, $confirmed, $group=false)
	{
		// Get all users in a table
		$users = array();
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0) 
		{
			foreach($query->result() as $row)
				$users[] = $row->email;
		}
		$query->free_result();

		$i = 0;
		foreach($data as $email)
		{
			if (!in_array($email, $users))
			{
				$this->db->set('email', $email);
				$this->db->set('confirmed', $confirmed);
				$this->db->set('join_date', date('Y-m-d H:i:s'));
				
				$this->db->insert($this->table);
				
				$id_user = $this->db->insert_id();

				/*				
				if ($group)
				{
					$this->attachUserToGroup($id_user, $group);
				}
				*/
				
				$i ++;
			}
		}

		return $i;
	}

}
/* End of file emailrecord_model.php */
/* Location: ./modules/EmailRecord/models/emailrecord_model.php */
