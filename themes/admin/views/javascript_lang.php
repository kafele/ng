<?php 

/**
 * Ionize Content Management system
 * Javascript Lang Class
 *
 * Put in the Lang object all Ionize lang items
 * so they will be available to javascript
 *
 * @package		Ionize
 * @author		Partikule
 * @copyright	Copyright (c) 2009, Partikule
 * @category	Javascript
 * @since		Version 1.0
 * @link		http://www.partikule.net
 *
 */

?>

var Lang = new Hash({
	
	<?php foreach($this->lang->language as $key=>$text) :?>'<?= $key ?>': '<?= addslashes($text) ?>',<?php endforeach ;?>

	'current': '<?= $this->config->item('language_abbr'); ?>',
	'first': '<?= Settings::get_lang('first') ?>'

});

