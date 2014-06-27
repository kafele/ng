<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$route['default_controller'] = "realt";

// Your second controller
$route['mysecondcontroller'] = 'vitebsk';

// realt/function
$route['(.*)'] = $route['default_controller'].'/$1'; 

// fancyupload => realt/index
$route[''] = $route['default_controller'].'/index'; 


/* End of file routes.php */
/* Location: modules/Realt/config/routes.php */ 




//$route['kv-snimu'] = $route['ad_form'] ;
$route['kv-sdam'] = $route['default_controller'] ;