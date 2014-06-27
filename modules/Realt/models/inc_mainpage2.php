<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	


$str_add .= "







<div class='mainblock'>
<div class='mb_info'>
<p>
<b>Помогите нам стать лучше!</b> 
 <!--
Заполните наш <a href=''>опросный лист</a>. Это 
займет всего минуту.  -->
Пишите свои отзывы и пред&shy;ло&shy;же&shy;ния в <a href='http://neagent.by/gbook'>гостевую</a>.
<br><br>
Вы нам поможете, если поставите 
ссылку на нас на сво&shy;ём сайте или блоге. 
</p>
</div>


<div class='mainblock-cont'>
<h2>Важно знать</h2>


<div class='mb'>









<div class='art_short' class='border:1px solid green'>
<h3><a href='http://neagent.by/articles/kak-vygodno-sdat-kvartiru' >Как выгодно сдать квартиру?</a></h3>
У вас есть квартира, которая простаивает? Сдать в аренду - хороший способ заработать. 
<small><a href='http://neagent.by/articles/kak-vygodno-sdat-kvartiru'>Читать статью полностью <span class='arrow'>→</span></a></small>
</div >













 



</div> <!-- endclass='mb' -->

<div class='mb_art'>


<a href='' id='but_prev' class='art_prev'>Предыдущая статья</a> <a href='' id='but_next'  class='art_next'>Следующая статья</a>  


</div>


</div> <!-- end mainblock-cont -->

</div> <!-- end mainblock  -->









<script>
var curr_article;
curr_article=1;
var max_articles=3;
var arthover=0;

var art_arr1 = ['Для студентов: как снять квартиру?', 'Риэлтерам легче не стало.', 'Как выгодно сдать квартиру?'];
var art_arr2 = ['Съём квартиры можно сравнить с гонкой. Кто не успел, тот … ищет дальше.', '...получая от агентства информацию о той или иной сдающейся квартире...', 'У вас есть квартира, которая простаивает? Сдать в аренду - хороший способ заработать.  '];
var art_arr3 = ['http://neagent.by/articles/kak-studentu-snyat-kvartiru', 'http://neagent.by/articles/rielteram-legche-ne-stalo', 'http://neagent.by/articles/kak-vygodno-sdat-kvartiru'];


 //art_goto(0);


$('#but_prev').mouseover(function(){
if (arthover==0){
art_goto(-1);
arthover=1;}
return false;
  
});

$('#but_next').mouseover(function(){
if (arthover==0){art_goto(1); 
arthover=1;}
return false;
  
});

$('#but_prev').click(function(){art_goto(-1);return false;});
$('#but_next').click(function(){art_goto(1);return false;});





function art_goto(int){

curr_article=curr_article+int;

if (curr_article>max_articles) {curr_article=1;}
if (curr_article<1) {curr_article=max_articles;}




$('.art_short').animate({
    opacity: 0
   
  }, 200, function() {
  
  
  
  $('.art_short').html('<h3><a href=\"' + art_arr3[curr_article-1]+ '\" >' + art_arr1[curr_article-1] + '</a></h3>' + art_arr2[curr_article-1] +  '<small><a href=\"' + art_arr3[curr_article-1] + '\">Читать статью полностью <span class=\"arrow\">→</span></a></small>') ;

  
  $('.art_short').animate({
    opacity: 1
  }, 300, function() {
  
   
    // Animation complete.
  });
  
  
 
  
    // Animation complete.
  });






}







</script>








<h2 class='hh'>Новые объявления</h2>


















";	