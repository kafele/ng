
<div style="padding-top:70px;margin:auto;width:250px; background-color: #f4f3e5; padding:20px;">
 <?
 $returnurl =isset($returnurl)?$returnurl:"";
 
 ?>
<h2>Вход</h2>
<form action="http://neagent.by/board/loginuser" method="POST">
<input type="hidden" name="returnurl"  value="<?=$returnurl;?>"> <br>
<label style="width:200px;">Email: </label><br><input type="text" name="email" style="width:100%"><br> 
<label style="width:200px;">Пароль:</label><br><input type="password" name="password" style="width:100%"><br>
<input type="submit" value="Войти"> <br>
<a href="http://neagent.by/board/sendpassword">Забыли пароль?</a>





</form>
 
</div>