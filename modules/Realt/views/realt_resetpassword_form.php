
<div style="padding-top:70px;margin:auto;width:250px; background-color: #f4f3e5; padding:20px;">
 
<h2>Восстановление пароля</h2>
<form action="sendpassword" method="POST">

<label style="width:200px;">Логин: </label><b><?=$username;?></b><br> 

<label style="width:200px;">Новый пароль: </label><br><input   type="password" name="pass1" style="width:100%"><br> 
<label style="width:200px;">Еще раз: </label><br><input   type="password" name="pass2" style="width:100%"><br> 
<input type="hidden" name="act" value="reset">
<input type="hidden" name="temp" value="<?=$pass;?>">  
<input type="submit" value="Сохранить"> 






</form>
 
</div>