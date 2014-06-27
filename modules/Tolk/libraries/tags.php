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
class Tolk_Tags
{
	/**
	 * Define the enclosing tag.
	 * Make the <ion:tolk /> tag available as parent tag
	 *
	 * @usage	<ion:fancyupload type="photoqueue" />
	 *			type : 	"photoqueue" : 	Simple file queue uploader
	 *					"complete" : 		Complete Fancyupload
	 *
	 */
	 
	public $CI;
	//public $TolkApp;
	 
	public static function index(FTL_Binding $tag)
	{
	$CI =& get_instance();
 $CI->load->library('parser'); 	

$mode = (isset($tag->attr['mode']) ) ? $tag->attr['mode'] : false;

//echo ("mode=".$mode);

if ($mode=='ini'){
$CI->load->model('tolk_model');
$contenttype = (isset($tag->attr['type']) ) ? $tag->attr['type'] : false;

//echo ("contenttype=" .$contenttype);

switch ($contenttype) {
case 'add_form':
//echo "ADD";
$CI->tolk_model->getAddFormPage(); // РІС‹Р·С‹РІР°РµРј С„СѓРЅРєС†РёСЋ РїРѕРєР°Р·Р° РѕР±СЉСЏРІР»РµРЅРёР№
break;


case 'getpage':
$CI->tolk_model->getHttpPage(); // РІС‹Р·С‹РІР°РµРј С„СѓРЅРєС†РёСЋ РїРѕРєР°Р·Р° РѕР±СЉСЏРІР»РµРЅРёР№
break;


default:


$CI->tolk_model->getPage(); // Страница нормальная



}
 

 
 
 
$data=$CI->tolk_model->data;

if ($data['meta_title']){$tag->locals->page['meta_title']=$data['meta_title'];}
else{
$tag->locals->page['meta_title']="Tolk Neagent.by.";//$data['NAME'];
}
$tag->locals->page['meta_keywords']=$data['NAME'];

$tag->locals->page['meta_description']=$data['NAME'];
if ($data['meta_description']){$tag->locals->page['meta_description']=$data['meta_description'];}

return;
}


//echo ("- неиниcontenttype=" .$contenttype);



if ($CI->tolk_model->data['tolk']){
$contenttype = (isset($tag->attr['type']) ) ? $tag->attr['type'] : false;
switch ($contenttype) {
case 'add_form':
return ($CI->tolk_model->data['tolk']);
break; 
case '4':
break;
default:
return ($CI->tolk_model->data['tolk']);
}
}
else // Р•СЃР»Рё РЅРµС‚ РґР°РЅРЅС‹С… РІ  data['tolk'], РІС‹РґР°РµРј РѕС€РёР±РєСѓ.	
{return "no data for tolk. Controller is not loaded  ion: tolk";}
	
	

	
	
		
		
		
		
		





		
	   

	
		// Get the module URI
		//include APPPATH . 'config/modules.php';
		//$uri = array_search('Realt', $modules);
		$tag->expand();
		return $tag->parse_as_nested(file_get_contents(MODPATH.'Tolk/views/realt_'.config_item('realt_type').EXT));
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

		$uri = array_search('Tolk', $modules);
		
		return ( ! empty($uri)) ? $uri : '';
		
	}


	// ------------------------------------------------------------------------


	/**
	 * Returns the max upload size for JS format
	 * 
	 */
	public static function post_max_size(FTL_Binding $tag)
	{

		if (config_item('tolk_max_upload') != 0)
		{
			$post_max_size = config_item('tolk_max_upload').'m';
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
