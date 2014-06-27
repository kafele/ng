<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter File Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/file_helpers.html
 */

// ------------------------------------------------------------------------

/**
 * Read File
 *
 * Opens the file specfied in the path and returns it as a string.
 *
 * @access	public
 * @param	string	path to file
 * @return	string
 */	
 
 if ( ! function_exists('get_detailTab_code'))
{
function get_detailTab_code($url , $map_view){

 //echo ("--------" . $map_view);


if (strpos($url, "?")>1){
$url1= $url . "&mapview=1";
$url0= $url . "&mapview=0";
}
else{
$url1= $url . "/?mapview=1";
$url0= $url . "/?mapview=0";
}


if ($map_view==1){
$style1="detailTab";
$linkdetail = '<a href="'.$url0.'">Список</a>';
$linkmap= '<b>Показать на карте</b>';


$style2="itemmapTabOn";
}
else{
$style1="detailTabOn";
$linkdetail  = '<b>Список</b>';
$linkmap= '<a href="'.$url1.'">Показать на карте</a>';
$style2="itemmapTab";
}


 $str='
 <style>
 
#detailTabOn { 
margin: 0px 10px 0px 0px;
}

#detailTab { 
background-color: #D4EBF7;
margin: 0px 10px 0px 0px;
}


#itemmapTabOn { 
 
}

#itemmapTab { 
background-color: #D4EBF7;
}

.viewtab{
border-bottom: 0px solid #CCCCCC;
border-left: 1px solid #CCCCCC;
border-right: 1px solid #CCCCCC;
border-top: 1px solid #CCCCCC;
float: left;padding: 5px; width: 110px; text-align: center;
}

#resultsSizing { 
font-size: 1.3em;
}

</style>
 
<div id="'. $style1.'" class="viewtab">
'
. $linkdetail . 
'
</div>
<div id="'. $style2.'" class="viewtab">
'
. $linkmap . 
'
</div>
<div style="clear:both;border-style:solid;border-width:1px 0px 0px 0px;border-color:#cccccc;font-size:0.1em;height:1px;padding:0px;margin:0px;margin-bottom:9px;"></div>';
 return $str;
 }
 } 
 
 
 
 
 
 
 
 
 
 
 
 
 if ( ! function_exists('getJS'))
{
	function getJS( &  $data)  // byref
	{
	if (!isset($CI)){$CI =& get_instance();$CI->load->library('parser');}
	$showmap = $data['showmap']; 
	$wap_view = $data['wap_view']; 
	$mlev = $data['mlev']; 
	
$JSdata['css']='		
	<link rel="stylesheet" href="http://neagent.by/themes/neagent_style/assets/css/style.css" type="text/css" media="screen, projection" />
	<!--[if lte IE 6]><link rel="stylesheet" href="style_ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/all.js"></script>
	<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/jquery.simplemodal.1.4.2.min.js"></script>
	
	';
	
	if ($showmap){
	
	}
	
	
	
	
	if ($data['mlev']==49999){
	$JSdata['css'] .= ' <style>	#content{	width:auto !important;	padding-right: 40px !important;}		#sideRight{display:none   !important;}
    </style>	';
	}
	
	
	
	
	
		
$JSdata['css_wap']='		
	<link rel="stylesheet" href="http://neagent.by/themes/neagent_style/assets/css/wap_style.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="http://neagent.by/themes/neagent_style/assets/css/wap_rightmenu.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="http://neagent.by/themes/neagent_style/assets/css/wap_form.css" type="text/css" media="screen, projection" />
    <script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/req_script.js"></script>
	<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/ads_js.js"></script>
	<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/jquery.simplemodal.1.4.2.min.js"></script>
		';		

		
		
		
$JSdata['topstart']='<div id="spam_dial" >spam_dial</div>
<div id="header"  >
		<table  width="100%" border=0 cellpadding=0 cellspacing=0 id="headerins" ><tr>
		<td id="hl0" width="60px;">
		</td>
		<td id="hl" width=230px;>
		<a id="topnav-logo" href="http://neagent.by">Неагент - сдать квартиру, снять квартиру.</a>
		</td><td  style="vertical-align:top;">
		<div id="hr" style="">
		<div class="searchform-wrapper"> 
		 
		 
		';

$JSdata['topend']='</div>
		</div>
		</td>
		<td id="hl9" width="60px;">
		</td>
		</tr>
		</table>
</div><!-- #header-->';
 
$JSdata['topstart_wap']=' 
<div id="header"  >
<a id="topnav-logo" href="http://neagent.by/board/wap">Неагент</a>
		</td><td  style="vertical-align:top;">
		<div id="hr" style="">
		
		 
		 
';
		
		
$JSdata['topend_wap']='
		</div>
		</td></tr>
		</table>
</div><!-- #header-->';	


//$addata = array('names' => "");
$addata = array('sutki_vip' => $CI->data['sutki_vip']);
$infoblock = $CI->parser->parse('realt_infoblock', $addata);
$context_ads = $CI->parser->parse('realt_context_ads', $addata);	
$footer = $CI->parser->parse('realt_footer', $addata);	
if ($data['wap_view']==1){
$data['footer']="" ;
$data['context_ads']="" ;
$data['infoblock']="" ;
$data['css']=$JSdata['css_wap'] ;
$data['realt_topstart']=$JSdata['topstart_wap'];
$data['realt_topend']=$JSdata['topend_wap']; 
}
else{
$data['footer']=$footer ;
$data['context_ads']=$context_ads ;
$data['infoblock']=$infoblock ;
$data['css']=$JSdata['css'] ;
$data['realt_topstart']=$JSdata['topstart'] ;
$data['realt_topend']=$JSdata['topend'] ;
}






 
}

}
   
 
 
  if ( ! function_exists('getTAPE'))
{
	function getTAPE( )  // byref
	{
	
	
	
	
	$str="--------------";
	
	
	return $str;
	}
	
	}
 
 
 
 
 if ( ! function_exists('getRubricsCode'))
{
	function getRubricsCode( )  // byref
	{
 
 $str=' 
    <div  style=" padding:10px;" >
   <table border=0 style="border:0; width:100%"><tr><td style="width:25%;">
          <a href="http://neagent.by/kvartira/snyat" class="subitem1" title="Снять квартиру">Снять квартиру </a><br>
          <a href="http://neagent.by/komnata/snyat" class="subitem1" title="Снять комнату">Снять комнату</a><br>
		  <a href="http://neagent.by/kvartira/na-sutki" title="Квартиры на сутки" class="subitem5">Квартиры на сутки</a><br>
		  <a href="http://neagent.by/dom/snyat" class="subitem1">Снять дом</a><br>
		</td>  
		 <td style="width:25%;"> 
        <a href="http://neagent.by/kvartira/sdat" class="subitem2" title="Сдать квартиру">Сдать квартиру </a><br>
        <a href="http://neagent.by/komnata/sdat" class="subitem2" title="Сдать комнату">Сдать комнату</a><br>
        <a href="http://neagent.by/komnata/podselus" class="subitem4">Подселюсь</a> <br>
		<a href="http://neagent.by/komnata/podselenie" class="subitem3">Возьму на подселение</a> 
		 </td>
		 
		 <td style="width:25%;">
          <a href="http://neagent.by/kvartira/kupit" class="subitem5 new" title="Купить квартиру">Купить квартиру</a><br>
       
          <a href="http://neagent.by/kvartira/prodat" class="subitem5 new" title="Продать квартиру">Продать квартиру</a><br>
     </td>
          <td style="width:25%;"> 
          <a href="http://neagent.by/dom/sdat" class="subitem2">Сдать дом </a><br>
          <a href="http://neagent.by/dom/na-sutki" class="subitem5">Снять дом на сутки</a><br>
          <a href="http://neagent.by/office/snyat" class="subitem1">Снять помещение</a><br>
          <a href="http://neagent.by/office/sdat" class="subitem2">Сдать помещение</a>
   </td></tr></table>
   
   </div>
   </div>
   
   <div style="height:10px;"></div>
   
   <div class="contentIns" >';
 
 return $str;
 }
	
	}
 