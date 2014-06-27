<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends Base_model
{
    public $CI;
    public $searchdata;
	public $params;
    public $user;
    public $route;
    public function __construct()
    {
        parent::__construct();
		if(!$this->CI){
        $this->CI =& get_instance();
        //$this->CI->load->library('parser');
        }
		 
		
		$this->searchdata ='0780707';
		
		
    }

	
	
	public function ini()
	{
	echo(00000);
	
	return 0;
	
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

	
	


}
 

