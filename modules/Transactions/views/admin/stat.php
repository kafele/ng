<form name="realtForm" id="realtForm" action="<?= base_url() ?>admin/realt/save" method="post">

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
			<dt class="small"><label for="realt_active" title="<?= lang('module_realt_label_active') ?>"><?= lang('module_realt_label_active') ?></label></dt>
			<dd>
				<input type="checkbox" id="realt_active" name="realt_active" value="1" <?php if (config_item('realt_active') == '1'):?> checked="checked" <?php endif;?> />
			</dd>
		</dl>

	</div>

	<div id="options">
		
		<!-- Email option -->
		<h3 class="toggler"><?= lang('module_realt_title_email') ?></h3>


		<dl>
			<dt class="small"><label for="realt_send_alert"><?= lang('module_realt_label_send_alert') ?></label></dt>
			<dd><input type="checkbox" id="realt_send_alert" name="realt_send_alert" value="1" <?php if (config_item('realt_send_alert') == '1'):?> checked="checked" <?php endif;?> /></dd>
		</dl>


		<div id="mailSettings">
		
			<!--  Email to send the alert-->
			<dl>
				<dt class="small">
					<label for="realt_email"><?=lang('ionize_label_email')?></label>
				</dt>
				<dd>
					<input id="realt_email" name="realt_email" class="inputtext" type="text" value="<?= config_item('realt_email') ?>" />
				</dd>
			</dl>
					
		</div>		
<!-- Confirmation ti user : Not implemented yet
		<dl>
			<dt class="small"><label for="realt_send_confirmation"><?= lang('module_realt_label_send_confirmation') ?></label></dt>
			<dd><input type="checkbox" id="realt_send_confirmation" name="realt_send_confirmation" value="1" <?php if (config_item('realt_send_confirmation') == '1'):?> checked="checked" <?php endif;?> /></dd>
		</dl>
-->
	</div>


</div>


<div id="maincolumn">


	<p><img src="<?= base_url() ?>modules/Realt/assets/images/realt.png" /></p>

	<p>
		Swiff meets Ajax for powerful and elegant uploads. 
		Realt is a file-input replacement which features an unobtrusive, multiple-file selection menu and queued upload with an animated progress bar. 
		It is easy to setup, is server independent, completely styleable via CSS and XHTML and uses MooTools to work in all modern browsers. 
	</p>
	
	<p>Know more : <a href="http://digitarald.de/project/realt/">http://digitarald.de/project/realt/</a></p>

	<h3><?=lang('module_realt_title_folder')?></h3>

	<!-- For the moment, the type is only "photoqueue", as we didn't got time to implement
		 the other kind of realt
	-->
	<input type="hidden" name="realt_type" value="photoqueue" />

	<!-- Type of Realt : Photoqueue or Complete 
	<dl>
		<dt>
			<label for="realt_type"><?=lang('module_realt_label_type')?></label>
		</dt>
		<dd>
			<select name="realt_type" id="realt_type">
				<option <?php if (config_item('realt_type') == 'attach-a-file'):?>selected="selected"<?php endif;?> value="attach-a-file">Attach a file</option>
				<option <?php if (config_item('realt_type') == 'photoqueue'):?>selected="selected"<?php endif;?> value="photoqueue">Photoqueue</option>
				<option <?php if (config_item('realt_type') == 'single-file-button'):?>selected="selected"<?php endif;?> value="single-file-button">Single file button</option>
			</select>
		</dd>
	</dl>
	-->

	<!-- Folder -->
	<dl>
		<dt><label for="realt_folder" title="<?= lang('module_realt_label_folder_help') ?>"><?= lang('module_realt_label_folder') ?></label></dt>
		<dd>
			<?= $realt_folder ?>
		</dd>
	</dl>

	<!-- Max Upload size in MB -->
	<dl>
		<dt><label for="realt_max_upload" title="<?= lang('module_realt_label_max_upload_help') ?>"><?= lang('module_realt_label_max_upload') ?></label></dt>
		<dd>
			<input id="realt_max_upload" name="realt_max_upload" type="text" class="text w40" value="<?= config_item('realt_max_upload') ?>" /> 
		</dd>
	</dl>

	
		<!-- Max per page -->
	<dl>
		<dt><label for="realt_ads_per_page" title="<?= lang('module_realt_ads_per_page_upload_help') ?>"><?= lang('module_realt_ads_per_page_upload') ?></label></dt>
		<dd>
			<input id="realt_ads_per_page" name="realt_ads_per_page" type="text" class="text w40" value="<?= config_item('realt_ads_per_page') ?>" /> 
		</dd>
	</dl>
	
	
		<!-- Days until ads are deleted automatically -->
	<dl>
		<dt><label for="realt_ads_per_page" title="<?= lang('Days_until_ads_are_deleted_automatically') ?>"><?= lang('Days_until_ads_are_deleted_automatically') ?></label></dt>
		<dd>
			<input id="delete_automatically" name="delete_automatically" type="text" class="text w40" value="<?= config_item('delete_automatically') ?>" /> 
		</dd>
	</dl>
	
	
	
	
	
			<!-- Days until ads are deleted automatically -->
	<dl>
		<dt><label for="realt_post_delay" title="<?= lang('Post_delay') ?>"><?= lang('Post_delay') ?></label></dt>
		<dd>
			<input id="realt_post_delay" name="realt_post_delay" type="text" class="text w40" value="<?= config_item('realt_post_delay') ?>" /> 
		</dd>
	</dl>
	
	
	
	
				<!-- SpamWords -->
	<dl>
		<dt><label for="realt_spamwords" title="<?= lang('Realt_spamwords') ?>"><?= lang('Realt_spamwords') ?></label></dt>
		<dd>
		<textarea id="realt_spamwords" name="realt_spamwords" class="text" style="width:400px; height:30px;" ><?= config_item('realt_spamwords') ?></textarea>
			 
		</dd>
	</dl>
	
	
	
	
	<!-- Prefix to uploaded file ? -->
	<dl>
		<dt><label for="realt_file_prefix" title="<?= lang('module_realt_label_file_prefix_help') ?>"><?= lang('module_realt_label_file_prefix') ?></label></dt>
		<dd>
			<input id="realt_file_prefix" name="realt_file_prefix" type="checkbox" class="checkbox" value="1" <?php if (config_item('realt_file_prefix') == '1'):?> checked="checked" <?php endif;?>/> 
		</dd>
	</dl>

	
	
	<!-- Black_action --> <!-- -->
	<dl>
		<dt>
			<label for="realt_black_action"  title="<?= lang('Realt_black_action') ?>"><?=lang('Realt_black_action')?></label>
		</dt>
		<dd>
			<select name="realt_black_action" id="realt_black_action">
				<option <?php if (config_item('realt_black_action') == 'allow'):?>selected="selected"<?php endif;?> value="allow">Разрешить</option>
				<option <?php if (config_item('realt_black_action') == 'deny'):?>selected="selected"<?php endif;?> value="deny">Запретить</option>
				<option <?php if (config_item('realt_black_action') == 'selfuid'):?>selected="selected"<?php endif;?> value="selfuid">Только для своего uid </option>
				<option <?php if (config_item('realt_black_action') == 'sessionblock'):?>selected="selected"<?php endif;?> value="sessionblock">Блокировать сессию</option>
			</se
			</select>
		</dd>
	</dl>
	
	
	
	
	
	
	
	
	<!-- Group -->
	<dl>
		<dt>
			<label for="realt_group"  title="<?= lang('module_realt_label_group_help') ?>"><?=lang('module_realt_label_group')?></label>
		</dt>
		<dd>
			<select name="realt_group">
				<?php foreach($groups as $group) :?>
					
					<?php if($group['level'] > 0) :?>
					
						<option value="<?= $group['id_group'] ?>" <?php if(config_item('realt_group') == $group['id_group']) :?> selected="selected" <?php endif ;?> ><?= $group['group_name'] ?></option>
						
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
	MUI.initModuleToolbox('realt','realt_toolbox');


	/**
	 * Init help tips on label
	 *
	 */
	MUI.initLabelHelpLinks('#reailForm');	


	/**
	 * SMTP form action
	 * see mocha/init-forms.js for more information about this method
	 */
	// MochaUI.setFormSubmit('fancyForm', 'settingsFormSubmit', 'admin/module/realt/realt/save');


	/**
	 * Show / hides Email depending the alert email is activated
	 *
	 */
	$('realt_send_alert').addEvent('change', function(){
		alertEmailStatus();
	});
	
	alertEmailStatus = function()
	{
		if ($('realt_send_alert').getProperty('checked') == true)
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

