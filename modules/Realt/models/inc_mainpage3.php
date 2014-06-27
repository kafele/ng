<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	


$str_add .= "



<div class='mainblock'>

<img src='http://neagent.by/themes/neagent_style/assets/images/ng.jpg' align=left>
<h2>Рейтинг Народной газеты: Neagent.by - первый.</h2>



</div> <!-- end mainblock  -->









<script>
var curr_article;
curr_article=1;
var max_articles=3;
var arthover=0;

var art_arr1 = ['Осторожно: предоплата', 'Риэлтерам легче не стало.', 'Как выгодно сдать квартиру?'];
var art_arr2 = ['оплата услуг «по факту» и предоплата — это два совершенно разных подхода риэлтеров к работе. Как их отличить?', '...получая от агентства информацию о той или иной сдающейся квартире...', 'У вас есть квартира, которая простаивает? Сдать в аренду - хороший способ заработать.  '];
var art_arr3 = ['http://neagent.by/articles/ostorozhno-predoplata', 'http://neagent.by/articles/rielteram-legche-ne-stalo', 'http://neagent.by/articles/kak-vygodno-sdat-kvartiru'];


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
    opacity: 0,
   
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