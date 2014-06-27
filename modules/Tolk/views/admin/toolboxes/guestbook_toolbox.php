<div class="toolbox divider nobr">
	<input id="settingsFormSubmit" type="submit" class="submit" value="<?= lang('ionize_button_save_module_settings') ?>" />
</div>


<div class="toolbox divider">
	<input type="button" class="toolbar-button" id="sidecolumnSwitcher" value="<?= lang('ionize_label_hide_options') ?>" />
</div>

<script type="text/javascript">

	/**
	 * Options show / hide button
	 *
	 */
	MUI.initSideColumn();


	/**
	 * Form action
	 * see mocha/init-forms.js for more information about this method
	 */
	MochaUI.setFormSubmit('guestbookForm', 'settingsFormSubmit', 'admin/module/guestbook/guestbook/save');


</script>
