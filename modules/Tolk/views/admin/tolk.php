<form name="fancyForm" id="fancyForm" action="<?= base_url() ?>admin/tolk/save" method="post">

<div id="sidecolumn">

	<!- Informations -->
	<div class="info">

		<dl class="compact">
			<dt class="small"><label><?=lang('ionize_label_file_uploads')?></label></dt>
			<dd><img src="<?= base_url() ?>themes/admin/images/icon_16_<?php if(ini_get('file_uploads') == true) :?>ok<?php else :?>nok<?php endif ;?>.png" /></dd>
		</dl>
		<dl class="compact">
			<dt class="small"><label><?=lang('ionize_label_max_upload_size')?></label></dt>
			<dd><?= ini_get('upload_max_filesize') ?></dd>
		</dl>

		<!-- Upload active ? -->
		<dl class="compact">
			<dt class="small"><label for="tolk_active" title="<?= lang('module_tolk_label_active') ?>"><?= lang('module_tolk_label_active') ?></label></dt>
			<dd>
				<input type="checkbox" id="tolk_active" name="tolk_active" value="1" <?php if (config_item('tolk_active') == '1'):?> checked="checked" <?php endif;?> />
			</dd>
		</dl>

	</div>

	<div id="options">
		
		<!-- Email option -->
		<h3 class="toggler"><?= lang('module_tolk_title_email') ?></h3>


		<dl>
			<dt class="small"><label for="tolk_send_alert"><?= lang('module_tolk_label_send_alert') ?></label></dt>
			<dd><input type="checkbox" id="tolk_send_alert" name="tolk_send_alert" value="1" <?php if (config_item('tolk_send_alert') == '1'):?> checked="checked" <?php endif;?> /></dd>
		</dl>


		<div id="mailSettings">
		
			<!--  Email to send the alert-->
			<dl>
				<dt class="small">
					<label for="tolk_email"><?=lang('ionize_label_email')?></label>
				</dt>
				<dd>
					<input id="tolk_email" name="tolk_email" class="inputtext" type="text" value="<?= config_item('tolk_email') ?>" />
				</dd>
			</dl>
					
		</div>		
<!-- Confirmation ti user : Not implemented yet
		<dl>
			<dt class="small"><label for="tolk_send_confirmation"><?= lang('module_tolk_label_send_confirmation') ?></label></dt>
			<dd><input type="checkbox" id="tolk_send_confirmation" name="tolk_send_confirmation" value="1" <?php if (config_item('tolk_send_confirmation') == '1'):?> checked="checked" <?php endif;?> /></dd>
		</dl>
-->
	</div>


</div>


<div id="maincolumn">


	<p><img src="<?= base_url() ?>modules/tolk/assets/images/tolk.png" /></p>

	<p>
		Swiff meets Ajax for powerful and elegant uploads. 
		FancyUpload is a file-input replacement which features an unobtrusive, multiple-file selection menu and queued upload with an animated progress bar. 
		It is easy to setup, is server independent, completely styleable via CSS and XHTML and uses MooTools to work in all modern browsers. 
	</p>
	
	<p>Know more : <a href="http://digitarald.de/project/tolk/">http://digitarald.de/project/tolk/</a></p>

	<h3><?=lang('module_tolk_title_folder')?></h3>

	<!-- For the moment, the type is only "photoqueue", as we didn't got time to implement
		 the other kind of tolk
	-->
	<input type="hidden" name="tolk_type" value="photoqueue" />

	<!-- Type of tolk : Photoqueue or Complete 
	<dl>
		<dt>
			<label for="tolk_type"><?=lang('module_tolk_label_type')?></label>
		</dt>
		<dd>
			<select name="tolk_type" id="tolk_type">
				<option <?php if (config_item('tolk_type') == 'attach-a-file'):?>selected="selected"<?php endif;?> value="attach-a-file">Attach a file</option>
				<option <?php if (config_item('tolk_type') == 'photoqueue'):?>selected="selected"<?php endif;?> value="photoqueue">Photoqueue</option>
				<option <?php if (config_item('tolk_type') == 'single-file-button'):?>selected="selected"<?php endif;?> value="single-file-button">Single file button</option>
			</select>
		</dd>
	</dl>
	-->

	<!-- Folder -->
	<dl>
		<dt><label for="tolk_folder" title="<?= lang('module_tolk_label_folder_help') ?>"><?= lang('module_tolk_label_folder') ?></label></dt>
		<dd>
			<?= $tolk_folder ?>
		</dd>
	</dl>

	<!-- Max Upload size in MB -->
	<dl>
		<dt><label for="tolk_max_upload" title="<?= lang('module_tolk_label_max_upload_help') ?>"><?= lang('module_tolk_label_max_upload') ?></label></dt>
		<dd>
			<input id="tolk_max_upload" name="tolk_max_upload" type="text" class="text w40" value="<?= config_item('tolk_max_upload') ?>" /> 
		</dd>
	</dl>

	
		<!-- Max per page -->
	<dl>
		<dt><label for="tolk_ads_per_page" title="<?= lang('module_tolk_ads_per_page_upload_help') ?>"><?= lang('module_tolk_ads_per_page_upload') ?></label></dt>
		<dd>
			<input id="tolk_ads_per_page" name="tolk_ads_per_page" type="text" class="text w40" value="<?= config_item('tolk_ads_per_page') ?>" /> 
		</dd>
	</dl>
	
	
	
	
				<!-- SpamWords -->
	<dl>
		<dt><label for="tolk_spamwords" title="<?= lang('tolk_spamwords') ?>"><?= lang('tolk_spamwords') ?></label></dt>
		<dd>
		<textarea id="tolk_spamwords" name="tolk_spamwords" class="text" style="width:400px; height:90px;" ><?= config_item('tolk_spamwords') ?></textarea>
			 
		</dd>
	</dl>
	
	
	
	
	<!-- Prefix to uploaded file ? -->
	<dl>
		<dt><label for="tolk_file_prefix" title="<?= lang('module_tolk_label_file_prefix_help') ?>"><?= lang('module_tolk_label_file_prefix') ?></label></dt>
		<dd>
			<input id="tolk_file_prefix" name="tolk_file_prefix" type="checkbox" class="checkbox" value="1" <?php if (config_item('tolk_file_prefix') == '1'):?> checked="checked" <?php endif;?>/> 
		</dd>
	</dl>

	<!-- Group -->
	<dl>
		<dt>
			<label for="tolk_group"  title="<?= lang('module_tolk_label_group_help') ?>"><?=lang('module_tolk_label_group')?></label>
		</dt>
		<dd>
			<select name="tolk_group">
				<?php foreach($groups as $group) :?>
					
					<?php if($group['level'] > 0) :?>
					
						<option value="<?= $group['id_group'] ?>" <?php if(config_item('tolk_group') == $group['id_group']) :?> selected="selected" <?php endif ;?> ><?= $group['group_name'] ?></option>
						
					<?php endif ;?>
				
				<?php endforeach ;?>
			</select>
		</dd>
	</dl>
	

</div> <!-- /maincolumn -->
</form>

<script type="text/javascript">
	

	/**
	 * Module Panel toolbox
	 * Mandatory, even it's empty !
	 * Initialize the toolbar buttons and remove the "save" button if no parameters is given
	 *
	 */
	MUI.initModuleToolbox('tolk','tolk_toolbox');


	/**
	 * Init help tips on label
	 *
	 */
	MUI.initLabelHelpLinks('#reailForm');	


	/**
	 * SMTP form action
	 * see mocha/init-forms.js for more information about this method
	 */
	// MochaUI.setFormSubmit('fancyForm', 'settingsFormSubmit', 'admin/module/tolk/tolk/save');


	/**
	 * Show / hides Email depending the alert email is activated
	 *
	 */
	$('tolk_send_alert').addEvent('change', function(){
		alertEmailStatus();
	});
	
	alertEmailStatus = function()
	{
		if ($('tolk_send_alert').getProperty('checked') == true)
		{
			$('mailSettings').setStyle('display', 'block');
		}
		else
		{
			$('mailSettings').setStyle('display', 'none');
		}
	}
	alertEmailStatus();
	
</script>

