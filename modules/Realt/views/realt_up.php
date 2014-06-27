 


 
<div class="up_form">
<h1>Вы заказали поднятие объявления  N <?=$ad_id?></h1>
 
<p>Заполните данные, необходимые для создания счета</p>
<form action="/board/up" method="POST">


<label style="width:200px;">Фамилия: </label><br><input type="text" name="surname"  value="<?=$surname?>" class="inp"><br> 
<label style="width:200px;">Имя: </label><br><input type="text" name="firstname"  value="<?=$firstname?>" class="inp"><br> 

<label style="width:200px;">Отчество: </label><br><input type="text" name="lastname"  value="<?=$lastname?>" class="inp"><br> 

<br style="clear:both;">
 
 <input type="hidden"  name="action"  value="do">  
 <input type="hidden"  name="ad_id"  value="<?=$ad_id?>">  

 <input type="submit" class="submit_btn" value="Далее"> <br><br style="clear:both;">
 

</form>

</div>


 
 
 
 




 