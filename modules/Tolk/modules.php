<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ionize, creative CMS
 *
 * @package		Ionize
 * @author		Ionize Dev Team
 * @license		http://ionizecms.com/doc-license
 * @link		http://ionizecms.com
 * @since		Version 0.90
 */

// ------------------------------------------------------------------------

/**
 * Ionize, creative CMS Category Controller
 *
 * @package		Ionize
 * @subpackage	Controllers
 * @category	Modules management
 * @author		Ionize Dev Team
 *
 */

class Modules extends MY_admin 
{

	public $application_folder = 'application';
	
	public $modules_folder = 'modules';


	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}


	// ------------------------------------------------------------------------


	/**
	 * Default : List exiting modules
	 *
	 */
	function index()
	{
		// Get all modules config files in modules folder
		$config_files = glob($this->modules_folder . '/*/config.xml');

		// Get the modules config file
		include APPPATH . 'config/modules.php';
		
		// Module data to put to template
		$moddata = array();
		
		// Get all modules from folders
		foreach($config_files as $file)
		{
			$xml = simplexml_load_file($file);
			
			$uri = (String) $xml->uri_segment;

			// Module folder
			preg_match('/\/([^\/]*)\/config.xml$/i', $file, $matches);
			$folder = $matches[1];

			// Store data
			$moddata[$uri] = array(
					'name'				=> (String) $xml->name,
					'uri_segment'		=> (String) $xml->uri_segment,		// The install URI segment, defined by default by the XML config file
					'uri_user_segment'	=> (String) $xml->uri_segment,		// The user URI segment, can be defined by user in Ionize
					'description'		=> (String) $xml->description,
					'folder'			=> $folder,
					'file'				=> $file,
					'has_admin'			=> (String) $xml->has_admin,
					'installed'			=> false
			);
			
			// If module is installed (config data existing in /application/config/modules.php), set "installed" to true
			// Note : A module is identified by its folder name, which MUST be the same as the main module controller

			if (in_array($folder, $modules))
			{
				// Set installed to true
				$moddata[$uri]['installed'] = true;

				// Get the user segment
				foreach($modules as $segment => $f)
				{
					if ($f == $folder)
						$moddata[$uri]['uri_user_segment'] = $segment; 
				}
			}
		}
		
		$this->template['modules'] = $moddata;
		
		$this->output('modules');
	}


	// ------------------------------------------------------------------------


	/**
	 * Installs one module
	 *
	 * @param	string	Module Folder name
	 * @param	string	Module User's choosen URI (by default, the "uri_segment" value in config.xml
	 *
	 */
	function install($module_folder, $module_uri)
	{
		/*
		 * Add the module in $module config array : /application/config/modules.php
		 *
		 */
		
		// Get the modules config file : $modules, $aliases
		include APPPATH . 'config/modules.php';

		// Load the module XML config file
		if ( ! $xml = simplexml_load_file($this->modules_folder . '/' . $module_folder . '/config.xml') )
		{
			$this->error(lang('ionize_message_module_install_error_no_config'));
		}
		else
		{
			// Get the pages
			$this->load->model('page_model', '', true);
			$pages = $this->page_model->get_list();
			
			// Check if conflict with existing pages
			$conflict = array_filter($pages, create_function('$page','return $page[\'name\'] == "'. $module_uri .'";') );

			if ( ! empty($conflict))
			{
				$this->error(lang('ionize_message_module_page_conflict'));
			}
			else
			{
				// uri => Module Folder 
				$modules[$module_uri] = $module_folder;

				// Install module database tables
				if ($database = $xml->database)
				{
					if ( ! $this->install_database($database))
					{
						$this->error(lang('ionize_message_module_install_database_error'));
					}
				}
				
				// Write config file : /application/config/modules.php
				if ( ! $this->save_config($modules, $aliases))
				{
					$this->error(lang('ionize_message_module_install_error_config_write'). ' : ' .APPPATH.'/config/modules.php');
				}
				else
				{
					// Reload the panel
					$this->update[] = array(
						'element' => 'mainPanel',
						'url' => 'admin/modules'
					);
					
					// OK Answer
					$this->success(lang('ionize_message_module_saved'));
				}
			}
		}
	}
	

	// ------------------------------------------------------------------------


	/**
	 * Uninstall one module
	 *
	 * @param	string	Module Folder
	 *
	 */
	function uninstall($module_folder)
	{
		// Get the modules config file
		include APPPATH . 'config/modules.php';

		// Filter the module array
		$modules = array_filter($modules, create_function('$folder','return $folder != "'. $module_folder .'";') );

		// Write config file
		if ($this->save_config($modules, $aliases))
		{
			// Reload the panel
			$this->update[] = array(
				'element' => 'mainPanel',
				'url' => 'admin/modules'
			);
			
			// Answer
			$this->success(lang('ionize_message_module_uninstalled'));
		}
		else
		{
			$this->error(lang('ionize_message_module_install_error_config_write'));
		}
	}


	// ------------------------------------------------------------------------


	function save_config($modules, $aliases, $moddata = NULL)
	{
		$str = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); \n\n";

		$str .= '$modules = '.dump_variable($modules)."\n\n";

		$str .= '$aliases = '.dump_variable($aliases)."\n\n";

//		$str .= '$moddata = '.dump_variable($moddata)."\n\n";

		// add end
		$str .= "\n\n";
		$str .= '/* End of file modules.php */'."\n";
		$str .= '/* Auto generated by Themes Administration on : '.date('Y.m.d H:i:s').' */'."\n";
		$str .= '/* Location: ' .APPPATH.'/config/modules.php */'."\n";

		// write
		$ret = @file_put_contents(APPPATH . '/config/modules' . EXT, $str);

		// num bytes written > 0
		if($ret)
			return true;

		return false;
	}


	// ------------------------------------------------------------------------


	/**
	 * Installs the database tables from the config.xml file
	 * 
	 * @param	SimpleXMLElement	Database XML object
	 *
	 * @returns boolean		true if success, false if fail
	 *
	 */
	function install_database($database)
	{
		// Walk through tables
		$tables_cnt = count($database->table);
		
		// Create table script
		$script_array = array();

		  for($i = 0; $i < $tables_cnt; $i++)
         {                  
             $script = "";
             // Current table and table attributes
             $table = $database->table[$i];
             $table_attr = $table->attributes();
	
			// Array of columns items
			$script_body = array();

			if ( ! empty($table_attr))
			{
				/* 
				 * Columns script
				 *
				 */
				
				// Number of column items
				$columns_cnt = count($table->column);

				for($j = 0; $j < $columns_cnt; $j++)
				{
					// Column & column attributes
					$column = $table->column[$j];
					$column_attr = $column->attributes();

					// Column create string
					$str = $column_attr['name'].' '.$column_attr['type'];
					$str .= isset($column_attr['length']) ?		'('.$column_attr['length'].')' :			'';
					$str .= isset($column_attr['attributes']) ?	' '.$column_attr['attributes'].' ' :								'';
					$str .= isset($column_attr['zerofill']) ?	' '.$column_attr['zerofill'].' ' :			'';
					$str .= isset($column_attr['default']) ?	' DEFAULT \''.$column_attr['default'].'\' ' :	'';
					$str .= isset($column_attr['auto_increment']) ?	' AUTO_INCREMENT ' :	'';

					// Add string to script body array
					$script_body[] = $str;
				}

				// Primary key
				if ($table->primary_key)
					$script_body[] = ' PRIMARY KEY (' . $table->primary_key . ') ';

				/* 
				 * Table creation script
				 *
				 */
				
				// Table header
				$script .= 'CREATE TABLE ';
				$script .= (isset($table_attr['if_not_exists']) && $table_attr['if_not_exists'] == 'true') ? ' IF NOT EXISTS ' : '' ;
				$script .= $table_attr['name'] . '( ';

				// Table body
				$script .= implode(',', $script_body);

				$script .= ')';
				
				// Table options
				$script .= (isset($table_attr['engine'])) ?				' ENGINE=' . $table_attr['engine'] . ' ' : '';
				$script .= (isset($table_attr['default_charset'])) ?	' DEFAULT CHARSET=' . $table_attr['default_charset'] . ' ' : '';
				$script .= (isset($table_attr['collate'])) ?			' COLLATE=' . $table_attr['collate'] . ' ' : '';
				$script .= (isset($table_attr['auto_increment'])) ?		' AUTO_INCREMENT=' . $table_attr['auto_increment'] . ' ' : '';

				$script .= ';';
  
                  $script_array[] = $script;
              }
		}

		// Run the script
         if (!empty($script_array))
         {       
             // Process
             foreach ($script_array as $script)
             {   
                 if (!$this->db->simple_query($script))
                     return false;
             }   
             // Everything went fine
             return true;
         }

		return false;
	}



	// ------------------------------------------------------------------------
	
	/**
	 * @deprecated
	 *
	 */
	function save_route($module_folder, $module)
	{
		$str = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); \n\n";
	
		$str .= '$route[\'' . (String) $module->uri_segment . '\'] = \''.(String) $module->uri_segment."'; \n\n";

		// add end
		$str .= "\n\n";
		$str .= '/* End of file routes.php */'."\n";
		$str .= '/* Auto generated by Themes Administration on : '.date('Y.m.d H:i:s').' */'."\n";
		$str .= '/* Location: ' . $this->modules_folder . '/' . $module_folder .'/config/routes'. EXT." */ \n";

		// write
		$ret = @file_put_contents( $this->modules_folder . '/' . $module_folder . '/config/routes' . EXT, $str);

		// num bytes written > 0
		if($ret)
			return true;

		return false;
	}
}

/* End of file modules.php */
/* Location: ./application/controllers/admin/modules.php */