<div class="regform">
 
<a href="http://neagent.by/board/loginuser" class="loginlink" onclick='showlogin();return false;'>Войти<span>→</span></a>
<a href="http://neagent.by/ad-form" class="registerlink"  '>Зарегистрироваться <span>→</span></a>


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



 