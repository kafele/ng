<style>
.w_alert{
width:auto;
margin:8px;

}
.w_login_alert{
width:100%;

min-height:66px;
background-color:#6bb335;
color:white;
//background-image:url(http://img1.neagent.by/s/w_green_alert.png);
//background-repeat:no-repeat;
//padding-left:68px;
text-align:center;
}

.w_register_form{
width:auto;
background-color:#dadfe1;
padding:10px;
text-align:center;
}

.w_register_form h1{
font-size:1.6em;font-weight:normal; padding-bottom:0.5em;
}

.w_register_form input{
 font-size:1.2em;
margin-top:0.4em;
margin-bottom:0.4em;
max-width:95%;
}


.w_register_form p{
font-size:0.8em;
}

.submit_btn { 
background-color: #339900;
border: medium none currentColor;
color: #FFFFFF;
height: 3em;
padding: 1em;
width: auto;
font-size: 1em;
max-width:95%;
}

p.w_alert{
font-size: 0.7em;
}

</style>


<div class="w_alert">
<div class="w_register_form">
<h1>Вход</h1>
 

<form action="loginuser" method="POST">


<label style="width:200px;">Email: </label><br><input type="text" name="email" class="inp"><br> 
<label style="width:200px;">Пароль:</label><br><input type="password" name="password" class="inp"><br>


 
<br style="clear:both;">
 

 <input type="submit" class="submit_btn" value="Войти"> <br><br style="clear:both;">
<a href="http://neagent.by/wap/sendpassword">Забыли пароль?</a>

</form>

</div>


  
<p class="w_alert">
 
 
</p>
 
 
 
</div>




 