<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?= lang('title_ionize_installation')?></title>

<link rel="stylesheet" href="<?= base_url() ?>themes/admin/css/installer.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>themes/admin/css/form.css" type="text/css" />

</head>

<body>

<div id="page">

	<div id="content-top"></div>

	<div id="content">
	
		<img src="<?= base_url() ?>themes/admin/images/ionize_logo_install.jpg" />
		
		<h1><?= lang('title_delete_installer') ?></h1>

		<br/>

		<p><?= lang('ionize_message_delete_installer') ?></p>
		
		<br/>

		<button type="button" class="button yes right" onclick="javascript:location.href='<?= base_url() ?>admin/';"><?= lang('button_delete_installer_done_admin') ?></button>
		<button type="button" class="button yes right" onclick="javascript:location.href='<?= base_url() ?>';"><?= lang('button_delete_installer_done_site') ?></button>
		
		<br/>
	
	</div>
	
	<div id="content-bottom"></div>	
	
</div>

</body>
</html>
