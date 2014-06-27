<?php
/**
 * Ionize
 * FancyUpload tags
 *
 * @package		Ionize
 * @author		
 * @license		http://ionizecms.com/doc-license
 * @link		http://ionizecms.com
 * @since		Version 0.93
 *
 * 
 *
 *
 */


/**
 * FancyUpload TagManager 
 *
 */
class Realt_Tags
{
	/**
	 * Использование.
	 * <ion:realt mode="ini"/>  - тэг инициализации страницы. Вставляется до заголовков, ввреху страницы
	 *
	 * <ion:realt /> - эт особственно доска объявлений
	 *	<ion:realt type="add_form"/> выводит форму подачи объявления
	 *					 
	 *
	 */
	 
	
	
	
	
	//public $RealtApp;
	 public $CI;
public static function index(FTL_Binding $tag)
{
 
	 
 //* Связываемся с CI
if (!isset($CI)){$CI =& get_instance();$CI->load->library('parser');}	
$mode = (isset($tag->attr['mode']) ) ? $tag->attr['mode'] : false;

if ($mode=='ini'){ // ИНИЦИАЛИЗАЦИЯ 
$CI -> data['timestart'] = microtime();
// выполняем инициализацию
$CI->load->model('realt_model');
$contenttype = (isset($tag->attr['type']) ) ? $tag->attr['type'] : false;
switch ($contenttype) {
case 'add_form':
$CI->realt_model->getAddFormPage(); // вызываем функцию показа объявлений
break;
default:
$CI->realt_model->route();
}
 
$data=$CI->realt_model->data;

if ($data['meta_title']){$tag->locals->page['meta_title']=$data['meta_title'];}
else{
$tag->locals->page['meta_title']="Снять квартиру в Минске, сдать квартиру в Минске, сдать в аренду, объявления без посредников, аренда на сутки - Neagent.by.";
}
$tag->locals->page['meta_keywords']=$data['NAME'];
$tag->locals->page['meta_description']=$data['NAME'];
if ($data['meta_description']){$tag->locals->page['meta_description']=$data['meta_description'];}
return;
}








// Если есть данные , выдаем, если нет, то возвращаем ошибку.	 
if ($CI->realt_model->data['realt']){

$CI -> data['timeend'] = microtime();
$t= "<br><small>". ($CI -> data['timeend'] -  $CI -> data['timestart'])   . "</small>";
$contenttype = (isset($tag->attr['type']) ) ? $tag->attr['type'] : false;

switch ($contenttype) {
case 'add_form':
return ($CI->realt_model->data['realt'] .  $pppppt);
break; 
case 'topstart':
return ($CI->realt_model->data['realt_topstart'] .  $pppppt);
break;
case 'topend':
return ($CI->realt_model->data['realt_topend'] .  $pppppt);
break;
case 'sutki_vip':
return ($CI->realt_model->data['sutki_vip']);
break;
case 'searchform':
return ($CI->realt_model->data['searchform'] .  $pppppt);
break;
case 'footer':
return ($CI->realt_model->data['footer'] .  $pppppt);
break;
case 'infoblock':
return ($CI->realt_model->data['infoblock'] .  $pppppt);
break;
case 'context_ads':
return ($CI->realt_model->data['context_ads'] .  $pppppt);
break;

case 'labelsmenu':
return ($CI->realt_model->data['userlabelsMenu'] .  $pppppt);
break;
case 'registerform':
return ($CI->realt_model->data['registerform'] .  $pppppt);
break;
case 'css':
return ($CI->realt_model->data['css']);
break;
case 'region':
return ($CI->realt_model->data['regionMenu'] .  $pppppt);
break;

case 'debug':
 
if ($CI->realt_model->data['mlev']==4){
 
return ($CI->realt_model->data['debug'] .  $pppppt);
}else
{
return  "";
}

break;

case 'menu':
return ($CI->realt_model->data['menu'] .  $pppppt);
break;
default:

$ret=$CI->realt_model->data['realt'] .  $pppppt ;
if ($CI->realt_model->data['mlev==4']){
$ret .=$CI->realt_model->data['debug'];
}

return $ret;
}
}
else // Если нет данных в  data['realt'], выдаем ошибку.	
{return "no data for realt. Controller is not loaded  ion: realt";}
	
	

	
	
		
		
		$tag->expand();
		return $tag->parse_as_nested(file_get_contents(MODPATH.'Realt/views/realt_'.config_item('realt_type').EXT));
	}

	
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function getLastAds()
{
    $sql = "SELECT * FROM ads ORDER BY ad_id DESC";
    $query = $CI->db->query($sql);
    $ads = Array();
    // Используем метод result_array() который возвращает строку результата в виде массива
    foreach($query->result_array() as $oneadd)
        $ads[] = $oneadd;

    return $ads;
}
	
	
	
	
	
	
	
	
	
	

	// ------------------------------------------------------------------------


	/**
	 * Returns the module users URI from the config/modules.php file
	 *
	 */
	public static function uri(FTL_Binding $tag)
	{
		// Get the module URI
		include APPPATH . 'config/modules.php';

		$uri = array_search('Realt', $modules);
		
		return ( ! empty($uri)) ? $uri : '';
		
	}


	// ------------------------------------------------------------------------


	/**
	 * Returns the max upload size for JS format
	 * 
	 */
	public static function post_max_size(FTL_Binding $tag)
	{

		if (config_item('realt_max_upload') != 0)
		{
			$post_max_size = config_item('realt_max_upload').'m';
		}
		else
		{
			$post_max_size = ini_get('post_max_size');
		}
	
		
	    $val = trim($post_max_size);
	    $last = strtolower($val[strlen($val)-1]);
	    
	    switch($last) 
	    {
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }
	
	    return $val;
	}
	
	
	// ------------------------------------------------------------------------

	/**
	 * Returns url_encoded user data.
	 * Used by the fancyupload form to send encrypted info about the current connected user 
	 * to the upload method (controller/fancyupload()->upload())
	 *
	 * @usage		<ion:userdata item="<user_attribute>" [url_encode="true"] />
	 *
	 *				item 			mandatory.
	 *								Can takes values : "username", "screen_name", "email"
	 *				url_encode : 	optional.
	 *								if set to true, encodes the returned encrypted string using the
	 *								PHP rawurlencode function.
	 *
	 */
	public static function userdata(FTL_Binding $tag)
	{
		$item = (isset($tag->attr['item']) &&  $tag->attr['item'] != '') ? $tag->attr['item'] : false;
		$url_encode = (isset($tag->attr['url_encode']) &&  $tag->attr['url_encode'] == 'true') ? true : false;
		
		// If no item, return an empty string
		if ( ! $item) return '';
		
		$ci =  &get_instance();
		
		// Encryption library
		if ( empty($ci->encrypt) )
			$ci->load->library('encrypt');
			
		//$user = Access()->get_current_user();

		if ( ! empty($user->$item))
		{
			if ($url_encode === true)
			{
				return rawurlencode($ci->encrypt->encode($user->$item));
			}
			else
			{
				return $ci->encrypt->encode($user->$item);			
			}
		}
		
		return '';		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// ------------------------------------------------------------------------

	/**
	 *  
	 * to the upload method (controller/fancyupload()->upload())
	 *
	 * @usage		<ion:add_form item="<user_attribute>" [url_encode="true"] />
	 *
	 *				item 			mandatory.
	 *								Can takes values : "username", "screen_name", "email"
	 *				url_encode : 	optional.
	 *								if set to true, encodes the returned encrypted string using the
	 *								PHP rawurlencode function.
	 *
	 */
	public static function add_form(FTL_Binding $tag)
	{
	return 'ADDFORM';	
		$item = (isset($tag->attr['item']) &&  $tag->attr['item'] != '') ? $tag->attr['item'] : false;
		$url_encode = (isset($tag->attr['url_encode']) &&  $tag->attr['url_encode'] == 'true') ? true : false;
		// If no item, return an empty string
		if ( ! $item) return '';
		$ci =  &get_instance();
		// Encryption library
		if ( empty($ci->encrypt) )
			$ci->load->library('encrypt');
		//$user = Access()->get_current_user();
		if ( ! empty($user->$item))
		{
			if ($url_encode === true)
			{
				return rawurlencode($ci->encrypt->encode($user->$item));
			}
			else
			{
				return $ci->encrypt->encode($user->$item);			
			}
		}
		return '';		
	}
	
	
	
	
	
	
	
	
	

}
