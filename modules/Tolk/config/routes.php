<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$route['default_controller'] = "tolk";

// guestbook/function
$route['(.*)'] = $route['default_controller'].'/$1'; 

// guestbook => guestbook/index
$route[''] = $route['default_controller'].'/index'; 


/* End of file routes.php */
/* Location: modules/guestbook/config/routes.php */ 


 