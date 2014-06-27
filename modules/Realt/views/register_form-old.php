<div class="regform">
<h3>Регистрация</h3>
<div class="regdiv">
<form action="http://neagent.by/board/saveuser" method="POST">
<label>Email</label> <input name="email" class="inp" > <br style="clear:both;">
<label>Пароль</label><input  type="password"  name="pass" class="inp" > <br style="clear:both;">
<input type="submit" class="subm" value="Сохранить"><br style="clear:both;">
</form>
</div>
<a href="http://neagent.by/board/loginuser" class="loginlink" onclick='showlogin();return false;'>Войти<span>→</span></a>
</div>

<script>
function showlogin(){
$('#loginModal').modal({
	opacity:80,
	overlayCss: {backgroundColor:'#000'}
});
}
</script>

<div id='loginModal' style='display:none; background-color:white;padding:22px; width:300px;border:3px solid #3c92d1'>
 

 
 <h2>Вход</h2>
<form action="http://neagent.by/board/loginuser" method="POST">

<label style="width:200px;">Email: </label><br><input type="text" name="email" style="width:100%"><br> 
<label style="width:200px;">Пароль:</label><br><input type="password" name="password" style="width:100%"><br>
<input type="submit" value="Войти"> <br>
<a href="http://neagent.by/board/sendpassword">Забыли пароль?</a>
 
 
<p>  <a href='#' class='simplemodal-close'><< Отмена</a>.</p>
</form>

</div>



 