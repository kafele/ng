<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	


$stat_nowOnline = (int)$GLOBALS['stat_nowOnline'];
if ($stat_nowOnline ==0) { $stat_nowOnline ="...";}

$stat_adsInDay = (int)$GLOBALS['stat_adsInDay'];
if ($stat_nowOnline ==0) { $stat_nowOnline ="...";}



$n=(int)$stat_nowOnline;



$form1="объявление";
$form2="объявления";
$form5="объявлений";
//function PluralForm($n, $form1, $form2, $form5)
//{
    $n = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) {$form= $form5;}
    if ($n1 > 1 && $n1 < 5) {$form= $form2;}
    if ($n1 == 1) {$form= $form1;}
    
//}


$form="объявлений";









$str_add .= "



<div class='mainblock notopmargin' style='margin-bottom:18px;'>


<div class='site_stat'> 
<div class='stat_header'> 
<div class='stat_count' ><i>$stat_adsInDay</i> $form</div> 
<div class='stat_for'>за последние 24 часа</div> 
</div>          
<div class='stat_line'></div>

<p>
Сейчас на сайте: <b>$stat_nowOnline человек</b><br>
Посетителей за сутки: <b>5645</b><br>
<!--Телефонов агентов в базе:<b>1380</b> <br> -->
По запросу «<noindex><a href='http://search.tut.by/?status=1&encoding=1&page=0&how=rlv&query=%D1%81%D0%BD%D1%8F%D1%82%D1%8C+%D0%BA%D0%B2%D0%B0%D1%80%D1%82%D0%B8%D1%80%D1%83'>снять квартиру</a></noindex>» <b>№1</b>
<br><br>
<small><noindex>Статистика: <a rel='nofollow' href='http://all.by/cgi-bin/st_r.cgi?id=10074508'>all.by</a></noindex></small>
</p>
</div>


<div class='mainblock-cont'>
<h2>Neagent.by — сайт без агентств</h2>


<div class='mb'>




<div class='mb_item'>
<img src='http://neagent.by/themes/neagent_style/assets/images/mb1.png' alt='цены на квартиры, сдать снять квартиру'>
<p><b>Реальные цены</b><br>
 и реальные квартиры</p>
</div>
 
<div class='mb_item'>
<img src='http://neagent.by/themes/neagent_style/assets/images/mb2.png' alt='Сдать квартиру, снять квартиру без регистрации'>
<p><b>Без регистрации</b><br>
и ограничений </p>
</div>


<div class='mb_item'>
<img src='http://neagent.by/themes/neagent_style/assets/images/mb3.png' alt='Объявления о сдаче квартир, аренда квартир в Минске'> 
<p><b>Всё работает быстро</b><br>
сервер находится в Минске</p>
</div>


<div class='mb_item'>
<img src='http://neagent.by/themes/neagent_style/assets/images/mb4.png' alt='Легко сдать квартиру, легко снять квартиру  в Минске'>
<p><b>Удобно искать</b><br>
по множеству параметров</p>
</div>










 



</div> <!-- endclass='mb' -->

<div class='mb2'><noindex><a rel='nofollow' href='http://neagent.by/articles/press-reliz'>Еще о нас</a> <a rel='nofollow' href='http://neagent.by/thanks'>Благодарности</a> <a rel='nofollow' href='http://neagent.by/faq'>Вопросы</a> <!-- <a href=''>Сдай&nbsp;агента, как стеклотару</a> --></noindex></div>


</div> <!-- end mainblock-cont -->

</div> <!-- end mainblock  -->






";	