
	<?=form_open(current_url(), array('id' => 'register', 'class' => 'register'))?>

    <?php if(validation_errors()):?>
    	<ul class="messages error">
    		<li><h3>Please, check the following errors:</h3></li>
    		<?=validation_errors()?>
    	</ul>
    <?php endif ?>

        <!--::::::::::::: Username :::::::::::::-->
		<div>
			<label for="username">Username</label>
			<?=form_input(array('name' 		=> 'username',
								'id' 		=> 'username',
								'value' 	=> set_value('username'),
								'maxlength' => '15',
								'size' 		=> '45'))?>
		</div>

        <!--::::::::::::: Password :::::::::::::-->
		<div>
			<label for="password">Password</label>
			<?=form_password(array(	'name' 		=> 'password',
									'id' 		=> 'password',
									'value' 	=> set_value('password'),
									'maxlength' => '40',
									'size' 		=> '45'))?>
		</div>

        <!--::::::::::::: Confirm Password :::::::::::::-->
		<div>
			<label for="password2">Confirm Password</label>
			<?=form_password(array(	'name' 		=> 'password2',
									'id' 		=> 'password2',
									'value' 	=> set_value('password2'),
									'maxlength' => '40',
									'size' 		=> '45'))?>
		</div>

        <!--::::::::::::: E-Mail :::::::::::::-->
		<div>
			<label for="email">E-mail</label>
			<?=form_input(array('name' 		=> 'email',
								'id' 		=> 'email',
								'value' 	=> set_value('email'),
								'maxlength' => '120',
								'size' 		=> '45'))?>
		</div>

		<div class="action">
			<p><button type="submit" name="submit">Register</button></p>
		</div>

<?=form_close()?>

	<h2>Already a member?</h2>
	<p>You can <?=anchor('admin/user/login', 'login here', array('title' => 'Click here to login'))?>.</p>
