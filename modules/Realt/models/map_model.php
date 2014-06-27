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

class Map_model extends Base_model
{

	/**
	 * Model Constructor
	 *
	 * @access	public
	 */
	public  $type;
	public  $cityLat;
	public  $cityLng; 
	public  $cityZ;
	
	public $cityID;
    public $cityName;
    public $cityUri;
	public $cityNameIn;  
	   
	public function __construct( )
	{
	
	 
	
		parent::__construct();
 
		$this->set_table('realt_cityes');
		$this->set_pk_name('city_id');
	 	$this->type ='yandex';
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
	$CI =& get_instance();
	$this->cityID    = $id;
    $this->cityName = $this->get_Name($id);
    $this->cityUri = $this->get_Uri($id);
	$this->cityNameIn =$this->get_Name_in( $this->cityName);
	
	 $this->cityLat =  '27.56164';
	 $this->cityLng =  '53.902257' ; 
	 $this->cityZ =  11 ;
	 
	 
	  
	        $CI->db->select('*');
            $CI->db->from('realt_cityes');
            $CI->db->where ('city_id', $id);
			$CI->db->limit (1);
            $query = $CI->db->get();
 
            if ($query->num_rows() > 0) {
                 foreach ($query->result() as $row) {
				 if ($row->city_z !=0){
                 $this->cityLat =  $row->city_lat ;
				 $this->cityLng =  $row->city_lng ; 
				 $this->cityZ =  $row->city_z ;
				 }
                }
            }

   
	 
	 
	 
	
	return false;

	}
	

	 
    function get_Name($cityid)
    {
	
	// $CI =& get_instance();
	$this->cityidArr=isset($this->cityidArr)?$this->cityidArr:array();
	$this->citynameArr=isset($this->citynameArr)?$this->citynameArr:array();
	$this->cityuriArr=isset($this->cityuriArr)?$this->cityuriArr:array();
	
	
	
	$idarr= isset($this->cityidArr)?($this->cityidArr):array();
	$namearr=  isset($this->citynameArr)?($this->citynameArr):array();
	
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
	
	
function get_map_params($params){
//print_r($params);
$str='
<script>
m_params = {
description : "показаны  квартиры",
sity : "1",
rooms :  "01234",
prType :  "arenda",
formType :  "kv",';
//echo ('cat() =' . $cat);

if ($params['cat']==0){$str .='cat :  "0",';}
else{$str .='cat :  "'.$params['cat'].'",';}

$str .= 'priceMin :  "0",
priceMax :  "1000000000",
withcontent :  ""';

if ((int)$params['postdate']==0){
}else{
$str .= ', postdate :  "'.(int)$params['postdate'].'"';
}


 
$str .= '}</script>';
 
return $str;
}





function get_mapScript_code(){
if (!isset($CI)){$CI =& get_instance();}
 $cityid=$this->cityID;
 //$cityid=(int)$CI->data['citymapid'];
  
// echo("citymapid=" . $CI->data['citymapid'] );
 // echo("cityid=" .$cityid );
switch ($CI->data['mapType']){
case "google":
 $str = ' 
  <script src="http://neagent.by/themes/neagent_style/javascript/googleMapping.js" type="text/javascript"></script>
 <script src="http://neagent.by/themes/neagent_style/javascript/gmap.js" type="text/javascript"></script>
<script type="text/javascript"  src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">


 


</script>
<script type="text/javascript">
	window.onload = function () { initializeGM('.$this->cityLat.','.$this->cityLng.','.$this->cityZ.','.$cityid.');  }
 </script>



	';
break;

default:
 $str = ' 
	<script src="http://neagent.by/themes/neagent_style/javascript/map.js" type="text/javascript"></script>
	<script src="http://api-maps.yandex.ru/1.1/index.xml?key=ABlMIk0BAAAAFPsVKgIAchtJ0doEiLBrxOxaznCER6RZb7YAAAAAAAAAAAB1lE0vqNVR_jBPUVq7ogDg1I3nqA=="
	type="text/javascript"></script>
	<script type="text/javascript">
	window.onload = function () {  ShowMap(0,0,'.$cityid.');  }
    </script>
	';
 }
 return $str;
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
