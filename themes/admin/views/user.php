<?php

/**
 * Modal window for Editing an user
 *
 */
?>

<form name="userForm" id="userForm" action="<?= base_url() ?>admin/users/update">

	<!-- Hidden fields -->
	<input id="user_PK" name="user_PK" type="hidden" value="<?= $user['id_user'] ?>" />
	<input id="join_date" name="join_date" type="hidden" value="<?= $user['join_date'] ?>" />
	<input id="salt" name="salt" type="hidden" value="<?= $user['salt'] ?>" />
	
	<!-- Username -->
	<dl>
		<dt class="small">
			<label for="username"><?=lang('ionize_label_username')?></label>
		</dt>
		<dd>
			<input id="username" name="username" class="inputtext" type="text" value="<?= $user['username'] ?>" />
		</dd>
	</dl>

	<!-- Screen Name -->
	<dl>
		<dt class="small">
			<label for="screen_name"><?=lang('ionize_label_screen_name')?></label>
		</dt>
		<dd>
			<input id="screen_name" name="screen_name" class="inputtext" type="text" value="<?= $user['screen_name'] ?>" />
		</dd>
	</dl>

	<!-- Email -->
	<dl>
		<dt class="small">
			<label for="email" ><?=lang('ionize_label_email')?></label>
		</dt>
		<dd>
			<input id="email" name="email" class="inputtext" type="text" value="<?= $user['email'] ?>" />
		</dd>
	</dl>

	<!-- Group -->
	<dl>
		<dt class="small">
			<label for="email"><?=lang('ionize_label_group')?></label>
		</dt>
		<dd>
			<select name="id_group" class="select">
				<?php foreach($groups as $group) :?>
				
					<option value="<?= $group['id_group'] ?>" <?php if($user['id_group'] == $group['id_group']) :?> selected="selected" <?php endif ;?> ><?= $group['group_name'] ?></option>
				
				<?php endforeach ;?>
			</select>
		</dd>
	</dl>
	

	<!-- New password -->
	<h3><?=lang('ionize_title_change_password')?></h3>


	<!-- Password -->
	<dl>
		<dt class="small">
			<label for="password"><?=lang('ionize_label_password')?></label>
		</dt>
		<dd>
			<input id="password" name="password" class="inputtext i120" type="password" value="" />
		</dd>
	</dl>

	<!-- Password confirm -->
	<dl>
		<dt class="small">
			<label for="password2"><?=lang('ionize_label_password2')?></label>
		</dt>
		<dd>
			<input id="password2" name="password2" class="inputtext i120" type="password" value="" />
		</dd>
	</dl>

	
	<!-- Meta data -->
	<h3><?=lang('ionize_title_user_meta')?></h3>

	<?php foreach($meta_data_fields as $field) :?>

		<dl>
			<dt class="small">
				<label for="<?= $field ?>"><?= $field ?></label>
			</dt>
			<dd>
				<input id="<?= $field ?>" name="<?= $field ?>" class="inputtext i120" type="text" value="<?= $meta_data[$field] ?>" />
			</dd>
		</dl>

	<?php endforeach ;?>
	
	

	
</form>

<div class="buttons">
	<button id="bSave<?= $user['id_user'] ?>" type="button" class="button yes right"><?= lang('ionize_button_save_close') ?></button>
	<button id="bCancel<?= $user['id_user'] ?>"  type="button" class="button no "><?= lang('ionize_button_cancel') ?></button>
</div>
