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
 
 if ( ! function_exists('get_map_code'))
{
function get_map_code(){
 $CI =& get_instance(); 
switch ($CI->data['mapType']){
case "google":
$str='<div id="GMapsID" style="width:100%;height:400px;"></div><div style="height:18px;width:100%;"></div>';
break;
 
default:
$str='<script>var address = "Минск ";</script><div id="YMapsID" style="width:100%;height:400px"></div><div style="height:18px;width:100%;"></div>';
}
return $str;
}
} 
 
 
 
 if ( ! function_exists('get_mapScript_code'))
{
function get_mapScript_code($cityid){
if (!$CI){$CI =& get_instance();}
 
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
	window.onload = function () { initializeGM(0,0,'.$cityid.');  }
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
 }}
 
 
 
 
 
 
if ( ! function_exists('get_map_params'))
{
function get_map_params($params){

 

$str='
<script>
m_params = {
description : "показаны  квартиры",
sity : "1",
rooms :  "01234",
prType :  "arenda",
formType :  "kv",';
//echo ('cat() =' . $cat);

$params_cat= isset($params['cat'] )?$params['cat']:0;
$params_postdate= isset($params['postdate'] )?$params['postdate']:0;

if ($params_cat==0){$str .='cat :  "0",';}
else{$str .='cat :  "'.$params['cat'].'",';}

$str .= 'priceMin :  "0",
priceMax :  "1000000000",
withcontent :  ""';

if ((int)$params_postdate==0){
}else{
$str .= ', postdate :  "'.(int)$params['postdate'].'"';
}


 
$str .= '}</script>';
 
return $str;
 }
}

 
 if ( ! function_exists('get_map_params2'))
{
function get_map_params2($params){
//$strings = array('blabla', 'bebebe', 'hahaha');
$p= json_encode( $params );
$str='<script>
m_params = '.$p.' </script>';
return $str;
 }
}
 
 
 
 