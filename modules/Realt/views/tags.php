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
	 * Define the enclosing tag.
	 * Make the <ion:fancyupload /> tag available as parent tag
	 *
	 * @usage	<ion:fancyupload type="photoqueue" />
	 *			type : 	"photoqueue" : 	Simple file queue uploader
	 *					"complete" : 		Complete Fancyupload
	 *
	 */
	 
	public $CI;
	//public $RealtApp;
	 
	public static function index(FTL_Binding $tag)
	{
		//return $tag->parse_as_nested("$tag");
	    $contenttype = (isset($tag->attr['type']) ) ? $tag->attr['type'] : false;
		if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	
		if (!$CI->RealtApp){$CI->load->model('Realt_model', 'RealtApp');}// ЗАГРУЖАЕМ МОДЕЛЬ ЕСЛИ ЕЩЕ Н ЕЗАГРУЖАЛАСЬ
//parse_str($_SERVER['QUERY_STRING'], $_GET);	
//return $ff;	
switch ($contenttype) {
case 'add_form':
// If we have feedback, lets post it.
			//берет данные с поста и  колбасит их и вставляет в базу
			
			
			
			if ( $CI->input->post('cat')){
			//ОБЪЯВЛЕНИ ПОДАНО
			$query= $CI->RealtApp->addAd();
			return file_get_contents(MODPATH.'Realt/views/realt_added'.EXT);
			}

			elseif ( $CI->input->post('mode')=="edit"){
			//ФОРМА РЕАКТИРОВАНИЯ
			
			
			
			$str_add .= $CI->parser->parse(MODPATH.'Realt/views/realt_'.$contenttype.EXT, $addata);
			return $str_add;
			
			
			
			
			//return file_get_contents(MODPATH.'Realt/views/realt_'.$contenttype.EXT);
			
			}
			
			
			
			else{
			
			
			
			
			if ($CI->uri->segment(4) =="edit") {// если редактирование объявления
                if ( is_numeric($CI->uri->segment(5))){
				$mode="edit";
				$ad_id=$CI->uri->segment(5);
				//return "edit ".$ad_id ;
				
				
				
				
				
			
				
				

				
				
				
//загружаем параметры объявления				
$CI->db->where('ad_id', $ad_id);
$CI->db->from('ads');
$query = $CI->db->get();

 if (count($query->result())==0) {
 return "Error: Ad not found.";
 };

	
foreach ($query->result() as $row)
{
$addata = array(
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_date' => $row->ad_date,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures,
			'ad_komnat' => $row->ad_komnat,
            );
$delayed=false;
}




		



	//return file_get_contents(MODPATH.'Realt/views/realt_added'.EXT);	// 'n отак, просто
	//$str_add .= $CI->parser->parse(MODPATH.'Realt/views/realt_'.$contenttype.EXT, $addata);
	$str_add .= $CI->parser->parse('realt_ad', $addata);
	 
	
	
	return;
	return $str_add;	
		
		
		
		
		
		
		
		


			
				
				
				  }
				  else{   //  неправильно введен номер объявления
				  return "Error: value not a number.";
				  };
			};

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			//ФОРМА ПОДАЧИ 
			return file_get_contents(MODPATH.'Realt/views/realt_'.$contenttype.EXT);
			}
			
			
			
			
			

break; 

case '4':

break;

default:












// Показываем список объявлений всех 

//($article_lang['title'] != '') ? $article_lang['title'] : $article['name'];
















$CI->load->library('pagination');
       $config['base_url'] = site_url('/page/'.$CI->uri->segment(4)); //  
       $config['total_rows'] = $CI->db->count_all('ads');//$CI->db->count_all('ads'); //   было $CI->$config['total_rows'] = $CI->db->count_all('records'); // 
       $config['per_page'] =    (config_item('realt_ads_per_page')>0)?config_item('realt_ads_per_page'): 20;   //  выводить на страницу
       $config['num_links'] = 6;    //  количество ссылок - косметический параметр
       $config['padding'] = 1;
	   $config['uri_segment'] = 5;
	  //$config['uri_segment'] = 2;  //  
$config['first_link'] = 'В начало';
echo ("page=".$CI->uri->segment(5)."---"); 
//$config['base_url'] = base_url().'controlpanel/';
//$config['base_url'] = site_url('controlpanel');
echo ("(" .$CI->uri->segment(4).")-это сегмент для catid--");
switch($CI->uri->segment(4)) 
	    {
	        case 'kv-sdam':				$cat_id = 1; break;
	        case 'kv-snimu':				$cat_id = 2; break;
	        case 'kom-snimu':			$cat_id = 3; break;
			case 'kom-snimu':				$cat_id = 4; break;
			case 'podselenie':				$cat_id = 9;	 break;
			case 'podselus':	 			$cat_id = 10;	 break;
			case 'doma-sdam':	 			$cat_id = 5; break;
			case 'doma-snimu':				$cat_id = 6; break;
            case 'of-sdam':	     			$cat_id = 5; break;
			case 'of-snimu':	 			$cat_id = 6; break;
			default:$cat_id = ""; $config['uri_segment'] = 4; $config['base_url'] = site_url('/page/');
	    }
$cat_id=(int)$cat_id;
if ($cat_id>0)	{
$CI->db->where('ad_catid', $cat_id);
$CI->db->from('ads');
$allresults=$CI->db->count_all_results();
$config['total_rows']= $allresults;
echo ("count:".$config['total_rows'].";");
//$config['total_rows'] = $CI->db->count_all('ads');
}
else
{
$allresults=$CI->db->count_all('ads');
$config['total_rows'] = $allresults;
}
;


$firstad=(int)($CI->uri->segment($config['uri_segment'])+1);
$lastad=$firstad+	$config['per_page']-1;
if ($lastad >$allresults){$lastad=$allresults;};
//ТУТ СДЕЛАТЬ ПРОВЕРКУ
//


		
//	продолжаем pagination
$config['full_tag_open'] ='<div class="pagination"><div class="page_numbers"><span class="page-first">'.lang('module_realt_pagination_page').'</span>';
$config['full_tag_close']='</div><p class="page_items">'.$firstad. lang('module_realt_pagination_tire').$lastad.lang('module_realt_pagination_from').$allresults.lang('module_realt_pagination_ads').'</p></div>';
$config['cur_tag_open'] = '<span class="selected">';
$config['cur_tag_close'] = '</span>';
//
	
	  $CI->pagination->initialize($config);
       $data['pager']=$CI->pagination->create_links();
       //echo ($data['pager']);
       $from=($CI->uri->segment($config['uri_segment']));
	  // echo ($from."00");
	   //echo ($limit);


	   
	
$params = array(
            'cat_id' => $cat_id
            
            );	
	 echo ("cat_id1=".$params['cat_id']);
$query= $CI->RealtApp->getAds($from, $config['per_page'], $params );
	
$str_add .= $data['pager'];

 

	
foreach ($query->result() as $row)
{
$addata = array(
            'ad_title' => $row->ad_title,
            'ad_message' => $row->ad_message,
			'ad_price' => $row->ad_price,
			'ad_phones' => $row->ad_phones,
			'ad_contactname' => $row->ad_contactname,
			'ad_date' => $row->ad_date,
			'ad_email' => $row->ad_email,
			'ad_pictures' => $row->ad_pictures,
			'ad_komnat' => $row->ad_komnat,
            );
	
$delayed=false;

//if strpublishDelay >0  and mlev=4 then
//'response.write DateToStr(strPostDate)
//delay_time=DateToStr(dateadd("n",  -(strpublishDelay) ,strForumTimeAdjust))
//if DateToStr(strPostDate) > delay_time then 
//delayed=true
//end if
//end if

//echo (strlen($addata['ad_pictures']));
 
if (strlen($addata['ad_pictures'])>2) {
 
//imagesArr=split(pictures, ",")
//firstpic="<a rel=""pics_" & strAdId & """ href=""" & "uploads/n_" & imagesArr(0) & """><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""50""   />" 
//firstpic="<a   href=""default.asp?ad_id=" &  strAdId &"""><img src=""uploads/t_" & imagesArr(0)&  """ width=""60"" height=""60""   />" 
 }
 else
{
 $addata['ad_firstpic']="<img src='". base_url()."themes/neagent_style/assets/images/nopic.gif' width='60' height='50'   />";
// firstpic="<img src=""themes/neagent/images/pic.gif"" width=""60"" height=""50""   />"
} 






 //$addata['ad_komnat']= $CI->RealtApp->getKomnatString("$addata");

 
 
 
 
//  select case komnat
// case 1
// komnat="1-комн."
// ntypestyle="1"
// case 2
// komnat="2-комн."
//  ntypestyle="2"
// case 3
// komnat="3-комн."
 // ntypestyle="3"
 //case 4
// komnat="4+ комн."
//  ntypestyle="4"
// case 0
 //komnat="комната"
 // ntypestyle="0"
 //case else
// komnat=""
// end select
 
// if CAT_ID=3 or CAT_ID=4 then 
// komnat="комната"
 // ntypestyle="0"
 // end if
  
 ///  if CAT_ID=5 or CAT_ID=5 then 
 //komnat="дом"
 // ntypestyle="0"
 // end if
  
 
 //  if CAT_ID=7 or CAT_ID=8 then 
 //komnat="офис"
 // ntypestyle="0"
 // end if
 
  		
			
			
			
			
			
			
			
			
			
$str_add .= $CI->parser->parse('realt_ad', $addata);
}
$str_add .= $data['pager'];

return $str_add;










break;
	};
	
	
	
	
	
	
	
		
		
		
		
		





		
	   

	
		// Get the module URI
		//include APPPATH . 'config/modules.php';
		//$uri = array_search('Realt', $modules);
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
