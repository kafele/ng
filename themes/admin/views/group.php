<?php

/**
 * Modal window for Editing a group
 *
 */
?>

<form name="groupForm" id="groupForm" action="<?= base_url() ?>admin/groups/update">

	<!-- Hidden fields -->
	<input id="group_PK" name="group_PK" type="hidden" value="<?= $group['id_group'] ?>" />
	
	<!-- Group name -->
	<dl>
		<dt class="small">
			<label for="slug"><?=lang('ionize_label_group_name')?></label>
		</dt>
		<dd>
			<input id="slug" name="slug" class="inputtext" type="text" value="<?= $group['slug'] ?>" />
		</dd>
	</dl>

	<!-- Group title -->
	<dl>
		<dt class="small">
			<label for="group_name"><?=lang('ionize_label_group_title')?></label>
		</dt>
		<dd>
			<input id="group_name" name="group_name" class="inputtext" type="text" value="<?= $group['group_name'] ?>" />
		</dd>
	</dl>

	<!-- Level -->
	<dl>
		<dt class="small">
			<label for="level" ><?=lang('ionize_label_group_level')?></label>
		</dt>
		<dd>
			<input id="level" name="level" class="inputtext" type="text" value="<?= $group['level'] ?>" />
		</dd>
	</dl>

	<!-- Description -->
	<dl>
		<dt class="small">
			<label for="description"><?=lang('ionize_label_group_description')?></label>
		</dt>
		<dd>
			<textarea id="description" name="description"><?= $group['description'] ?></textarea>
		</dd>
	</dl>
	
</form>

<div class="buttons">
	<button id="bSave<?= $group['id_group'] ?>" type="button" class="button yes right"><?= lang('ionize_button_save_close') ?></button>
	<button id="bCancel<?= $group['id_group'] ?>"  type="button" class="button no "><?= lang('ionize_button_cancel') ?></button>
</div>
