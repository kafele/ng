<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$route['default_controller'] = "transactions";

// realt/function
$route['(.*)'] = $route['default_controller'].'/$1'; 

// fancyupload => realt/index
$route[''] = $route['default_controller'].'/index'; 


/* End of file routes.php */
/* Location: modules/Realt/config/routes.php */ 


