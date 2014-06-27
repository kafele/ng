

<div style="line-height:18px;" ><h1 style="font-size:18px;color: #336699; float:left; line-height:18px;">Необходима регистрация</h1> &nbsp; &nbsp;| &nbsp;&nbsp;<span>Уже зарегистрированы? Войдите <a href="http://neagent.by/board/loginuser"   onclick='showlogin();return false;'>здесь</a>.</span> </div>


 
<div style="padding-top:36px;" >
<form action="http://neagent.by/board/register" method="POST">
<label style="font-size:14px; color:#555;  display:block;" >Введите ваш Email:</label> 
<input name="email" style="border:1px solid #98ce8e; height:28px; width:250px; font-size:22px; " class="inp" > 
<br style="clear:both;">
 
 
<br style="clear:both;">
<input type="hidden" name="action" value="regstep1">
 

<input type="submit"   class="submitinput" value="Получить письмо с паролем и войти на сайт"><br style="clear:both;">
</form>
</div>

 
<div  style="margin-top :38px; margin-bottom:300px;">
Neagent.by  работал без регистрации 3 года, но сейчас участились <a href="http://news.tut.by/society/320361.html" target="blank">случаи</a>  подачи ложных объявлений  мошенниками,  агентами и черными маклерами, работающими без лицензии.<br>
Регистрация и проверка телефонов помогает отсеять таких клиентов, и 
чувствовать себя в безопасности при прозванивании номеров телефонов на сайте.
 <br>

</div>



<script>
function showlogin(){
$('#loginModal').modal({
	opacity:0,
	overlayCss: {backgroundColor:'#fff'}
});
}
</script>
<style>


 .submitinput {
	height: 27px;
	cursor: pointer;
	padding: 2px 6px 5px 6px;
	overflow: visible;
	border: none;
	background-color: #FF9000;
    border: 1px solid #CCCCCC;
	0background: url(img/button-repeat.png) repeat-x;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;    
}
	
	
	

















.modal_form_wrapper{
//background:#d2d2d2; 
background:url(http://neagent.by/themes/neagent_style/assets/images/wrappermodal.png)  ;

 
 padding:10px;
border-radius:10px; 
 -webkit-border-radius:10px; 
 -moz-border-radius:10px; 
 -khtml-border-radius:10px;
}
.modal_form{
 
background:#4492d4;  padding:24px;
border:1px solid #3082be; 
border-radius:6px; 
 -webkit-border-radius:6px; 
 -moz-border-radius:6px; 
 -khtml-border-radius:6px;
}
.closemodal{
0float:right;
}

.modal_form a.simplemodal-close{
float:right;
display:block;background:url(http://neagent.by/themes/neagent_style/assets/images/closemodal.png)  no-repeat;
height:26px; width:26px;  text-indent:-2000px;
}

.modal_form h2{
font-size:22px; color:white; padding-bottom:12px;
}
.modal_form .input_login{
height:24px; font-size:18px; width:200px;

}

.modal_form  label , .modal_form  a{
color:white;
}


</style>
<div id='loginModal' style='display:none;'>
<div class="modal_form_wrapper">
<div class="modal_form">
<a href='#' class='simplemodal-close'><< Отмена</a>
 <h2>Вход</h2>
<form action="http://neagent.by/board/loginuser" method="POST">

<label style="width:200px;">Email: </label><br><input type="text" class="input_login" name="email"  ><br> 
<label style="width:200px;">Пароль:</label><br><input type="password" class="input_login" name="password"  ><br>
<input type="submit" value="Войти"> <br>
<a href="http://neagent.by/board/sendpassword">Забыли пароль?</a>
 
 

</form>
</div></div>
</div>



 