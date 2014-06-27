
<h2>Быстрый переход</h2>

<table width='100%' style="margin-bottom:12px;">
</tr>
<td width='50%'>


<ul >
<li class="fl">
<a href="http://neagent.by/board/?formtype=kv&mode=search&city=<?=$cityid?>&prtype=arenda&k1=on&k2=on&k3=on&priceMax=250">Снять квартиру в <?=$cityname?> до 200$</a> <a href="" class="morefl">(еще...)</a>
<ul style="display:none">
<li><a href="http://neagent.by/board/?formtype=kv&mode=search&city=<?=$cityid?>&prtype=arenda&k1=on&k2=on&k3=on&priceMax=300">Снять квартиру в <?=$cityname?> до 300$</a></li>
<li><a href="http://neagent.by/board/?formtype=kv&mode=search&city=<?=$cityid?>&prtype=arenda&k1=on&k2=on&k3=on&priceMax=400">Снять квартиру в <?=$cityname?> до 400$</a></li>
<li><a href="http://neagent.by/board/?formtype=kv&mode=search&city=<?=$cityid?>&prtype=arenda&k1=on&k2=on&k3=on&priceMin=400">Снять квартиру в <?=$cityname?> от 400$</a></li>
</ul>
<li>
 


 
<li class="fl">
<a href="http://neagent.by/kvartira/na-sutki">Снять квартиру на сутки</a> <a href="" class="morefl">(еще...)</a>
<ul style="display:none">
<li><a href="http://neagent.by/board/novopolotsk/kvartira/na-sutki">Снять квартиру на сутки в Новополоцке</a></li>
<li><a href="http://neagent.by/kvartira/na-sutki">Снять элитную квартиру на сутки</a></li>
</ul>
<li>


<li class="fl">
<a href="http://neagent.by/ad-form">Дать объявление о аренде/продаже квартиры</a> <a href="" class="morefl">(еще...)</a>
<ul style="display:none">
<li><a href="http://neagent.by/tolk">Дать объявление куплю/продам на "толкучку"</a></li>
 
</ul>
<li>
</ul>

</ul>





</td>
<td width='50%'>



<ul  >
<li class="fl">
<a href="http://neagent.by/board/?formtype=kv&mode=search&city=1&prtype=snimu&k1=on&k2=on&k3=on&k4=on">Сдать квартиру в Минске</a> <a href="" class="morefl">(еще...)</a>
<ul style="display:none">
<li><a href="http://neagent.by/board/?formtype=kv&mode=search&city=1&prtype=snimu&k1=on&k2=on&k3=on&k4=on">Сдать квартиру в Бресте</a></li>
<li><a href="http://neagent.by/board/?formtype=kv&mode=search&city=1&prtype=snimu&k1=on&k2=on&k3=on&k4=on">Сдать квартиру в Гомеле</a></li>
<li><a href="http://neagent.by/board/?formtype=kv&mode=search&city=1&prtype=snimu&k1=on&k2=on&k3=on&k4=on">Сдать квартиру в Витебске</a></li>
</ul>
<li>
 


 
<li class="fl">
<a href="http://neagent.by/board/kvartira/kupit">Купить квартиру в Минске </a><a href="" class="morefl">(еще...)</a>
<ul style="display:none">
<li><a href="http://neagent.by/board/brest/kvartira/kupit">Купить  квартиру в Бресте</a></li>
<li><a href="http://neagent.by/board/gomel/kvartira/kupit">Купить  квартиру в Гомеле</a></li>
<li><a href="http://neagent.by/board/vitebsk/kvartira/kupit">Купить  квартиру в Витебске</a></li>
</ul>
<li>


<li class="fl">
<a href="http://neagent.by/thanks">Благодарности </a><a href="" class="morefl">(еще...)</a>
<ul style="display:none">
<li><a href="http://neagent.by/articles">Только нужные статьи</a></li>
<li><a href="http://neagent.by/files/survey/form.php">Опрос, предложения по работе сайта</a></li>
 
</ul>
<li>
</ul>

</ul>



</td>

</tr></table>

<style>
a.morefl {
color:grey;
text-decoration:none;
border-bottom:1px dotted grey;
}

.fl{
padding-right:20px;

}
</style>



<script>



$(function(){
    $(".fl ah").click(function(){
        $(this).next().toggle();
        return false;
    })
	});
	
	$(function(){
    $(".fl a.morefl").click(function(){
        $(this).next().toggle();
        return false;
    })
	});
	</script>