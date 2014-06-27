<div id="infoblock">
             <h3 class="head"><a href="javascript: void(0)">Для пользы дела</a></h3>
             <div>
			 <a href="http://neagent.by/articles" style="">Статьи   </a>
<a href="http://neagent.by/faq" style="">Вопрос-ответ   </a>
<a href="http://neagent.by/gbook" style="">Гостевая   </a>
<a href="http://neagent.by/articles/n" style="">Как сэкономить на звонках   </a>



<a href="http://neagent.by/files/survey/form.php" style="">30-секундный опрос    </a>








			 </div>
             <h3 class="head"><a href="javascript: void(0)">Ссылки</a></h3>
             <div style="display: none;">
			 <a href="http://realty.maxi.by/realty-agencies" target="_blank" rel="nofollow">Отзывы об агентствах</a>
			 <a href="http://otzywy.by/agentstva_nedvigimosti/" target="_blank" rel="nofollow">Отзывы (otzywy.by) </a>
			 
			 
			 
			 
			 <a href="http://realt.by/news/article/10862/" target="_blank" rel="nofollow"   > 
 Не надо сжигать риэлтеров на кострах!</a>
			 <a href="http://forum.onliner.by/viewtopic.php?t=347694&start=180" target="_blank" rel="nofollow"   > 
 Какое агентство недвижимости посоветуете?</a> 
			 <a href="http://nv-online.info/by/99/300/18952/Андрей-КАРЕЛИН-«Меня-обманули-в-агентстве-недвижимости».htm" target="_blank" rel="nofollow"   > 
 Меня обманули в агентстве недвижимости</a>
			 <a href="http://pravoby.com/consult.php?action=go&id=77141" target="_blank" rel="nofollow"   > 
Куда обратиться с жалобой на мошенников из агентства недвижимости?</a>

 <a href="http://agentby.blogspot.com/2011/11/10.html" target="_blank" rel="nofollow"   > 
Обзор сайтов недвижимости от  нашего постоянного посетителя, которого дихлофосом не вытравишь отсюда.</a>

			 
	 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 </div>
</div>
 
 
 
 <?
 $link=array();
 $link[0]=array(
 uri=> "http://oz.by/books/more10268471.html?partner=ozflashby",
 title=> "1Q84. Тысяча невестьсот восемьдесят четыре",
 picture=> "http://s5.listing.ozstatic.by/70/498/319/10/10319498_0.jpg" );
  
 $link[1]=array(
 uri=> "http://oz.by/video/more10233181.html?partner=ozflashby",
 title=> "Жутко громко и запредельно близко",
 picture=> "http://s1.listing.ozstatic.by/70/181/233/10/10233181_0.jpg" );
 
$link[2]=array(
 uri=> "http://oz.by/books/more1020251.html?partner=ozflashby",
 title=> "Мужчины с Марса, женщины с Венеры",
 picture=> "http://s1.listing.ozstatic.by/70/251/20/1/1020251_0.jpg" );

 
  
  
 $k= rand(0, 2);
 
 
 ?>
 <div style="text-align:center; width:131px;">
 <a href="<?=$link[$k]['uri'];?>"><img src="<?=$link[$k]['picture'];?>" border="1" alt="<?=$link[$k]['title'];?>" style="border:1px solid grey;"/><br><?=$link[$k]['title'];?></a>
 <br>
 </div>
 
 
 
 
 
 
 
 
 <!--
 <div style="padding-top:18px; line-height:18px;">
<noindex><a href="http://neagent.by/articles/minust" target="_blank" rel="nofollow" style="color:#4554a1;line-height:24px; margin-top:18px; ">
<img src="http://neagent.by/files/otvas.jpg"></a></noindex>
</div>
--> 
 
 <style>
 #infoblock{
 padding-left:8px;padding-bottom:12px;
 }
 #infoblock h3 a {font-family:  "Arial", "Tahoma", "Verdana", sans-serif;}
 #infoblock h3 a{
 font-style:bold; font-size:13px;color:#333;
 text-decoration:none;
 border-bottom:1px dotted;grey;
 }
 
 #infoblock div{  padding-left:8px;}
   
   
   #infoblock div a{
    display:block; padding-bottom:4px; padding-top:4px;
   }
 #infoblock div a:link{

ocolor:#333;

 }
 
 a:visited{
 щcolor:#ae57cb;
 
 }
 
 #infoblock div a:link{
 
 }
  #infoblock div a:hover{
 color:#336699;
 }
  #infoblock div  a:active{
 
 }
 </style>
 
<script>
$("#infoblock > div").hide();
 $("#infoblock > h3").click(function() {
   var tru = $(this).hasClass("head active");
   $("#infoblock h3").removeClass("active"); 
   if (tru == false) {
     $(this).addClass("active");
   }
   var nextDiv = $(this).next();
   var visibleSiblings = nextDiv.siblings("div:visible");
   if (visibleSiblings.length) {
     visibleSiblings.slideUp("fast", function() {
       nextDiv.slideToggle("fast");
     });
   } else {
     nextDiv.slideToggle("fast");
  }
 });

</script>






