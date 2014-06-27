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

class SearchParams_model extends  CI_Model
{

	/**
	 * Model Constructor
	 *
	 * @access	public
	 */
	public  $params;
	public  $qdelimiter;
	public  $qparams; // те же параметры но в виде массива для query
	public  $values;
	public $data;
	   
	public function __construct( )
	{
	
	 
	
		parent::__construct();
		 $this->qdelimiter="-";
		 $this->params = array();
		// parse_str($_SERVER['QUERY_STRING'], $_GET);
		$this->params['location'] = array();
		 $this->params['location']['id']='location';
         $this->params['location']['values']=array((int)$_GET['location']); 		 
		 //$this->params['location']['id']='location'];
		 
		 
 //$this->construct_params();
		//$this->set_table('realt_cityes');
		//$this->set_pk_name('city_id');
	 	//$this->type ='yandex';
	}


	// ------------------------------------------------------------------------


	/**
	 * Saves one email
	 *
	 * @param		array		Email data array
	 * @returns		boolean		true if success, false if fails
	 *
	 */
	 
	 
	  function get_params( ){
	  return $this->params;
	  }
	 
	 
	 
	 
	 function construct_params($cat)
 	    {
		
$CI =& get_instance();
	if ($CI->data['mlev']==4){
	echo($_GET['m']);
	}
	
 
		
 if ($_GET['m']=="s" || 1==1){
//  Это значит mode search  
$par=array();
$qpar=array();
$ptype=array(); //// на всякий  будет указываться тип параметра
$val=array();
if ($CI->data['mlev']==4){
 echo(" определен cat   " . $cat . "<br>");
}

$CI->db->select('*');
$CI->db->from ('board_params'); 
$CI->db->where ('param_subcat', $cat); //$cat - это текущая категория  
$query = $CI->db->get(); // выбрали все параметры для данной категории
if ($query->num_rows() == 0){ /// в категории параметров нету
}
else
{

foreach ($query->result() as $row){
// для каждого параметра в данной категории проверяем , не передан ли такой параметр GET
if ($CI->data['mlev']==4){
 echo(" ищем alias  " . $row->param_alias . "<br>");
}

if (  $_GET[$row->param_alias]  ){
if ($CI->data['mlev']==4){
 echo("  !!!$$$$$$$%%!!  передан параметр. " );
 echo(" ; param_alias=" .  $row->param_alias );
 echo(" ; значение="   );
 print_r ($_GET[  $row->param_alias]);
 echo(";  "  );
}
 
if (is_array($_GET[ $row->param_alias])){

if ($CI->data['mlev']==4){
 //echo(" МАССИВ!!!! " );
 //print_r ($_GET[  $row->param_alias]);
 //echo(" ; param_alias=" .  $row->param_alias );
 //echo("; значение_param_alias=" . $_GET[$row->param_alias]);
}

} 
 

$paramObj=array(
id	=> $row->param_id , 	 	 	 	 	 	 
alias		=>	 $row->param_alias	, 	 	 	 	 	 
name	    =>		$row->param_name ,
subcat=> 	$cat,
ismain	    =>		$row->param_ismain ,
isnumber	    =>		$row->param_isnumber ,
type	    =>	 	$row->param_type ,	 	 	 	 
);

$valArr= explode($this->qdelimiter , $_GET[$row->param_alias]);



 for ($b = 0; $b < count($valArr); $b++) {
  // перебор всех паратетров

 if (getValueId( $valArr[$b], $row->  param_id)<0 ){
  // удалить 
  $valArr[$b]=null;
 }
}


$valArr = array_filter($valArr, 'strlen'); // удаляет все нулль кроме значения 0 




//// неплохо бы проверить , чтоб было безопасно хотя бы
$paramObj['values']=$valArr;

//array_push($par, $paramObj);


//// Если массив значений пустой то продолжить следующий элемент

if ($CI->data['mlev']==4){
  echo(" массив значений   " .   count($valArr) );
  print_r ($valArr);
 
 
  
}



if (count($valArr) <1 ){

if ($CI->data['mlev']==4){
  echo(" пропускаем, т.к. нет параметров  " );
  
}
continue;
}



$par[$paramObj['id']] = $paramObj;
$valArrstr = implode($this->qdelimiter , $paramObj['values']);
$qpar[$row->param_alias] = $valArrstr;





///// вернуть массив парент значений.  
///$parentValArr = getParentTypeValues($valArr, $row->param_id);
$dop_Params = getChildParams($valArr, $row->param_id); 



if ($CI->data['mlev']==4){




 echo(" НАЙДЕНЫ ДОПОЛНИТЕЛЬНЕЫ ПАРАМЕТРЫ!!!! " );
 print_r ($dop_Params);
 echo("  <br><br> "   );
 
}

  


 foreach ($dop_Params as  $dopParam){

 $par[$dopParam['id']] = $dopParam;
 $valArrstr = implode($this->qdelimiter , $dopParam['values']);
 $qpar[$dopParam['alias']] = $valArrstr;
 
 
 }

//echo ("%<br><br>");








 
}



if (  $_GET["p" . $row->param_id]  ){
if ($CI->data['mlev']==4){
//echo("  param!!!!! " );
//print_r ($_GET["p" . $row->param_id]);
//echo("; param_id=" .  $row->param_id );
//echo("; значение_param_id=" . $_GET["p" . $row->param_id]);
}

 


$paramObj=array(
id	=> $row->param_id , 	 	 	 	 	 	 
alias		=>	 $row->param_alias	, 	 	 	 	 	 
name	    =>		$row->param_name ,
subcat=> 	$cat,
ismain	    =>		$row->param_ismain ,
isnumber	    =>		$row->param_isnumber ,
type	    =>	 	$row->param_type ,	 	 	 	 
);
$valArr= explode($this->qdelimiter , $_GET["p" . $row->param_id]);
//// неплохо бы проверить , чтоб было безопасно хотя бы
$paramObj['values']=$valArr;

$par[$paramObj['id']] = $paramObj;
$valArr = implode($this->qdelimiter , $paramObj['values']);
$qpar[$row->param_alias] = $valArr;
}

// параметр не может быть испарент. 
// будем проверять значения. Если значение испарент то тогда добавим параметр на лету. 


} // тут конец for each  param in cat 



///  если передан текст,




}    //  end else  -  в категории параметров нету или есть 


if ($_GET["t"]!=""){


$paramObj=array(
id	=> 't' , 	 	 	 	 	 	 
alias		=>	 't'	, 	 	 	 	 	 
name	    =>		't' ,
subcat=> 	$cat,
ismain	    =>		0 ,
isnumber	    =>		0 ,
type	    =>	 	0 ,	 	 	 	 
);

 //echo ("--loc--");
$text = str_replace("`", "", $_GET["t"]);
$text = str_replace("'", "", $text);
$text = str_replace('"', "", $text);
$t= array($text); 


//// неплохо бы проверить , чтоб было безопасно хотя бы !!!!!!!!!!!!!!
$paramObj['values']=$t;

//array_push($par, $paramObj);
$par[$paramObj['id']] = $paramObj;

////$valArr = implode($this->qdelimiter , $paramObj['values']);
$qpar['t'] = $text;
}

 if ($CI->data['mlev']==4){
//echo("  param!!!!! " );

echo("t передан ");
print_r($par);

}




/// добавить цену
$priceset=0;
if ( is_numeric($_GET["minprice"])){
 echo ("++  minprice set  ++");
$paramObj=array(
id	=> 'minprice' , 	 	 	 	 	 	 
alias		=>	 'minprice'	, 	 	 	 	 	 
name	    =>		'minprice' ,
subcat=> 	$cat,
ismain	    =>		0 ,
isnumber	    =>		0 ,
type	    =>	 	0 ,	 	 	 	 
);
$price= explode($this->qdelimiter , $_GET["minprice"]);
//// неплохо бы проверить , чтоб было безопасно хотя бы
$paramObj['values']=$price;
$par['minprice'] = $paramObj;
$qpar['minprice'] = $_GET["minprice"];
$priceset=1;
}


if ( is_numeric($_GET["maxprice"])){
//echo ("++loc++");
$paramObj=array(
id	=> 'maxprice' , 	 	 	 	 	 	 
alias		=>	 'maxprice'	, 	 	 	 	 	 
name	    =>		'maxprice' ,
subcat=> 	$cat,
ismain	    =>		0 ,
isnumber	    =>		0 ,
type	    =>	 	0 ,	 	 	 	 
);
$price= explode($this->qdelimiter , $_GET["maxprice"]);
//// неплохо бы проверить , чтоб было безопасно хотя бы
$paramObj['values']=$price;
$par['maxprice'] = $paramObj;
$qpar['maxprice'] = $_GET["maxprice"];
$priceset=1;
}


if ( $priceset == 1){
	if ( is_numeric($_GET["currency"])){
	$currency=$_GET["currency"];
	}
	else{
	$currency=6;
	}
//echo ("++loc++");
$paramObj=array(
id	=> 'currency' , 	 	 	 	 	 	 
alias		=>	 'currency'	, 	 	 	 	 	 
name	    =>		'currency' ,
subcat=> 	$cat,
ismain	    =>		0 ,
isnumber	    =>		0 ,
type	    =>	 	0 ,	 	 	 	 
);
$price= explode($this->qdelimiter , $_GET["currency"]);
//// неплохо бы проверить , чтоб было безопасно хотя бы
$paramObj['values']=$price;
$par['currency'] = $paramObj;
$qpar['currency'] = $_GET["currency"];
 
}
 

 



///  в конце добавитьгород и m=s 
 

$paramObj=array(
id	=> 'location' , 	 	 	 	 	 	 
alias		=>	 'location'	, 	 	 	 	 	 
name	    =>		'location' ,
subcat=> 	$cat,
ismain	    =>		0 ,
isnumber	    =>		0 ,
type	    =>	 	0 ,	 	 	 	 
);


if ( is_numeric($_GET["location"])){
//echo ("++loc++");

$loc=  explode($this->qdelimiter , $_GET["location"]);
}
else{
//echo ("--loc--");
$loc= explode($this->qdelimiter , "0");
}

//// неплохо бы проверить , чтоб было безопасно хотя бы
$paramObj['values']=$loc;
//echo("P=");
//print_r($valArr);
//array_push($par, $paramObj);

$par['location'] = $paramObj;

$valArr = implode($this->qdelimiter , $paramObj['values']);
$qpar['location'] = $valArr;

$qpar['m'] = 's';

$this->params = $par;
$this->data['params'] = $par;
$this->qparams = $qpar;




if ($CI->data['mlev']==4){
//echo("  param!!!!! " );

echo("<br><br><h2> par </h2><pre>");
print_r ($par);
echo("</pre><br><br><h2> qpar </h2>");
 print_r ($qpar);
 echo("<br><br> ");
//echo("; param_id=" .  $row->param_id );
//echo("; значение_param_id=" . $_GET["p" . $row->param_id]);
}









}
else

{


}
		
		
		
 	   


	   
		
		
		}


		
		public function buildQuery(){
		
		//return $this->qparams;
		//echo(678);
		//print_r($this->qparams);
		
		return http_build_query($this->qparams);
		//echo http_build_query($data) . "\n";
        //echo http_build_query($data, 'myvar_');

		}
		
		
public function buildQueryPlus($par, $val){
$CI =& get_instance();	
$params = $this->qparams;

if ($CI->data['mlev']==4){
echo(" with par =");
echo($par);
echo(" this->qparams=");
print_r($params);
}
  
  
$inivalue=$params[$par];
if ($CI->data['mlev']==4){
echo("+++init " . "of"  . $par . "=");
print_r($inivalue);
}
 
if ($inivalue!=""){ // если там значения есть уже и такой параметр задан

$valArr = explode($this->qdelimiter, $inivalue);
// сначала пробуем удалить по значению, чтоб небыло дубиката,  потом добавляем. 
if(($key = array_search($val, $valArr)) !== FALSE){ 
unset($valArr[$key]);
}
 

}
else{ // если это новый параметр
if ($CI->data['mlev']==4){
echo(" значение пробел  " );
}

$valArr =   array();
}

array_push($valArr , $val); 


 //print_r ($valArr);
 
 $params[$par] = implode ($this->qdelimiter , $valArr);
 
// перемещаем  location и  m
//if(($key = array_search('location', $params)) !== FALSE){

$t=$params['t'];
unset($params['t']);
$params['t'] = $t;

//echo(" keyparams "); 
$loc=$params['location'];
unset($params['location']);
$params['location'] = $loc;
//}
 
 
//if(($key = array_search('m', $params)) !== FALSE){ 
//echo(" keym "); 
$m=$params['m'];
unset($params['m']);
$params['m'] = $m;
//}
 
 
//echo("~~~");
//echo($params[$par]);
 
return http_build_query($params);

		}
		
		
		
		
		
		
		
public function paramPlus($par, $val){ 
$CI =& get_instance();	
$qparams = $this->qparams;
$params = $this->params;
if ($CI->data['mlev']==4){
echo(" with par =");
echo($par);
echo(" this->qparams=");
print_r($params);
}
  
  
$inivalueArr=$qparams[$par];


 if ($CI->data['mlev']==4) {
echo(" ############1############## ");
 
print_r ($params[$par] );
print_r ($inivalueArr );
echo(" ########################## ");
}


if(($key = array_search($val, $params[$par]['values'])) !== FALSE){ 
unset($params[$par]['values'][$key]);
}
array_push($params[$par]['values'] , $val); 

 if ($CI->data['mlev']==4) {
echo(" ###########2############### ");
 
print_r ($params[$par] );
print_r ($inivalueArr );
echo(" ########################## ");
}



 
 
return $params;

}		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		public function buildQueryMinus($par, $val){

$params = $this->qparams;
$params[$par]= str_replace ( $val , "" ,$params[$par]);
$params[$par]= str_replace ( $this->qdelimiter . $this->qdelimiter , $this->qdelimiter ,$params[$par]);	

if ($params[$par]==""){
	// если значение осталось пустым, то удалить и параметр
	unset($params[$par]);  
	
}	
		return http_build_query($params);

}
		
		
		
 public function buildQueryClear($par){
$params = $this->qparams;
 
	// если значение осталось пустым, то удалить и параметр
	unset($params[$par]);  
	
 	
		return http_build_query($params);
		}
		


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






}
/* End of file emailrecord_model.php */
/* Location: ./modules/EmailRecord/models/emailrecord_model.php */
