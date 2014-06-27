<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Realt_search_model extends Base_model
{
    public $CI;
    public $searchdata;
	public $params;
    public $user;
    public $route;
	public $inival;
	public $results_per_page;
	public $total_searched;
	public $search_time;
	public $error_message; 
	public $search_pattern;
	
	
    public function __construct()
    {
        parent::__construct();
		if(!$this->CI){
        $this->CI =& get_instance();
        //$this->CI->load->library('parser');
        }
		 $this->inival="vallllll";
		 $this->searchdata ='0780707';
		
		
    }

	/*
	$params['search']=true;
	$params['cat']['index']=true;
	$params['cat']['name']=true;
	$params['komnat']=1,2,3,4;
	$params['street']=1,2,3,4;
	$params['street']=1,2,3,4;
	
	
	*/
	
	public function ini()
	{
	
	if ($_GET['mode'] == 'search'){
	//$this->params['search']=true;
    $formtype=$_GET['formtype'];
    $prtype=$_GET['prtype'];
	//echo($formtype . $prtype);
    $catArr= $this->getSearchCat($formtype, $prtype );
	$this->params['cat']['id'] = $catArr['id'];
	$this->params['cat']['name'] = $catArr['name'];
	$this->params['cat']['name'] = $catArr['name'];
	
	
$komnatArr=array();


$k1=(isset($_GET['k1']) && $_GET['k1']=="on")?1:0;
$k2=(isset($_GET['k2']) &&$_GET['k2']=="on")?1:0;
$k3=(isset($_GET['k3']) &&$_GET['k3']=="on")?1:0;
$k4=(isset($_GET['k4']) &&$_GET['k4']=="on")?1:0;
$k5=(isset($_GET['k5']) &&$_GET['k5']=="on")?1:0;
$k6=(isset($_GET['k6']) &&$_GET['k6']=="on")?1:0;
$k0=(isset($_GET['k0']) &&$_GET['k0']=="on")?1:0;



if ($k1==1){array_push($komnatArr, 1);}if ($k2==1){array_push($komnatArr, 2);}if ($k3==1){array_push($komnatArr, 3);}
if ($k4==1){array_push($komnatArr, 4);}if ($k5==1){array_push($komnatArr, 5);}if ($k6==1){array_push($komnatArr, 0);}
$this->params['komnat']=$komnatArr;


//$this->params['sort']=$_GET['sort'];
$_GET['sort']=isset($_GET['sort'])?$_GET['sort']:false;
$this->params['sort']=chkString($_GET['sort'], "SQLString");
if ($this->params['sort']==" " ){$this->params['sort']="ad_postdate";}
///////chkString($CI->input->post('pl_o'), "SQLString");

$this->params['priceMin']= isset($_GET['priceMin'])? (int)$_GET['priceMin'] : 0 ;
$this->params['priceMax']=isset($_GET['priceMax'])? (int)$_GET['priceMax'] : 0 ;

$priceMinrequest=isset($priceMin)? $priceMin : false ;//
$priceMaxrequest=isset($priceMax)? $priceMax : false ;
 
 $_GET['withcontent'] = isset($_GET['withcontent'])?$_GET['withcontent']:false;
$this->params['text']=chkString($_GET['withcontent'], "SQLString");
if ($this->params['text']==" "){$this->params['text']="";};
if ($this->params['text']==""){unset ($this->params['text']);};

$formtype=$_GET['formtype'];
$prtype=$_GET['prtype'];
$komm_type=isset($_GET['komm_type'])? $_GET['komm_type']:false;
$nobject=isset($_GET['nobject'])? $_GET['nobject']:false;   
$type=isset($_GET['type'])? $_GET['type']:false;   
 
 


  //print_r(  $this->params );


	
	
	
	
	
	
	
	}
	
	
	
	
	//echo('00000');
	//echo ($_GET['formtype']);
	return '0';
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('invoicenumber, invoiceamount ', 'required'),
		//	array('invoicenumber, invoiceamount', 'safe'), 
		 	//array('status', 'in', 'range'=>array(1,2,3)),
		 	//array('title', 'length', 'max'=>128),
		//	array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
		//	array('tags', 'normalizeTags'),

		//	array('title, status', 'safe', 'on'=>'search'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'invoiceamount' => 'Invoice Amount',
			'invoicenumber' => 'Invoice number',
			'invoicedate' => 'Invoice date',
			 
		);
	}
	
	
    public function getRegionsPage()
    {
        $this->load->helper('realt');
        $region =  $CI->city_model->cityID;
            $addata = array(
			'names' => $this->CI->city_model->citynameArr,
            'uri' => $this->CI->city_model->cityuriArr,
            'id' =>$this->CI->city_model->cityidArr,
			'regions' => $this->CI->city_model->regionsArr ,
			'index' => $this->CI->city_model->cityesIndex ,
			'count' =>$this->CI->city_model->cityesCount ,
            );
            $str_add = $this->CI->parser->parse('realt_regions', $addata);
            $this->data['realt'] = "" . $str_add;
            return;
    }

	
	

	
	
	
public function getSearchCat($formtype , $prtype)
    {	
	 switch($formtype . "/" . $prtype){
			case 'kv/arenda':$ind=1; $name='Сдам квартиру'; break;
			case 'kv/arendaс':$ind=30; $name='Сдам квартиру'; break;
			case 'kv/snimu':$ind=2;  $name='Сниму квартиру'; break;
			case 'kv/prodam':$ind=13; $name='Продам квартиру'; break;
			case 'kv/kuplu':$ind=14; $name='Куплю квартиру'; break;
            case 'kom/arenda':$ind=3; $name='Сдам комнату'; break;
			case 'kom/podselenie_pr': $ind=9; $name='Возьму на подселение'; break;
			case 'kom/podselenie_spr':$ind=10; $name='Подселюсь'; break;
			case 'kn/sdam':$ind=7; $name='Сдам нежилое помещение'; break;
			case 'kn/snimu':$ind=8; $name='Сниму нежилое помещение'; break;
			case 'kn/prodam':$ind=15; $name='Продам нежилое помещение'; break;
			case 'kn/kuplu':$ind=16; $name='Куплю нежилое помещение'; break;
			case 'su/su_kv':$ind=11; $table="sutki" ; $name='Сдам квартиру на сутки';break;
			default: $ind=1; $name='Сдам квартиру'; break;
			 } 
		$data = array(
            'id' => $ind,
			'name' => $name
         );	 
		 return $data;
}	
	
	
	
	
	
	
	
	
	

}
 

