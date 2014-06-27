


</div><!-- #wrapper -->



<div class="backtotop">
        <div class="a-holder">
            <div class="anchor">
                <img src="http://img1.neagent.by/s/backtotop.png">
            </div>
        </div>
</div>

<script>

$(function(){
    $(".vse-navigation .nav-more").click(function(){
        $(this).next().toggle();
        return false;
    })
    
    $(".vse-footer .site-more .nav-mholder").css({
        'margin-top':'-'+($(".vse-footer .site-more .nav-mholder").innerHeight()*1+$(".vse-footer .navigation").innerHeight()*1-13)+'px'
    });
    
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("more"))
            $(".nav-mholder").hide();
    });
    var bttresize = function(){
        var winWidth = (window.innerWidth?window.innerWidth:document.documentElement.clientWidth);
        var bttw = (winWidth - $("#wrapper").width())/4;
        var bttw = bttw>0?bttw:0;
		bttw=40;
        $(".backtotop").css({
            'width':bttw
        })
        if (bttw<100){
            $(".backtotop .a-holder").css({
                'width':bttw
            })
        } else {
            $(".backtotop .a-holder").css({
                'width':100
            })
        }
    }
    bttresize();
    $(window).resize(bttresize).scroll(function(){
        if ($(this).scrollTop()>700){
            $(".backtotop").show();
            $(".backtotop .anchor:not('.down')").stop(true,true).addClass('down').animate({
                'top':'0px'
            },function(){
                $(this).removeClass('down');
            })
        } else {
            if ($(".backtotop").is(":visible")){
                $(".backtotop .anchor:not('.up')").stop(true,true).addClass('up').animate({
                    'top':'-100px'
                },function(){
                    $(".backtotop").hide();
                    $(this).removeClass('up');
                })
            }
        }
    })
    $(".backtotop").click(function(){
        $("body,html").animate({
            scrollTop:0
        },500,function(){
            //vse_log('end')
        });
        $(".backtotop").hide();
    })
})


;
</script>



<div id="footer" style="">
	
	 <a href="privacy-policy.asp">Конфиденциальность</a> | <a href="http://neagent.by/rules">Пользовательское соглашение</a> | <a href="reklamabanner.asp">Размещение рекламы</a>
		
		<a href="http://neagent.by/kvartira/na-sutki">квартиры на сутки</a> | <a href="http://neagent.by/kvartira/snyat">аренда квартир без посредников</a>
<a href="http://neagent.by/kvartira/sdat">сдать квартиру</a> | <a href="http://neagent.by/kvartira/snyat">снять квартиру</a> | <a href="http://neagent.by/komnata/snyat">снять комнату</a> 
	Снять квартиру в Витебске |  Снять квартиру в Гомеле | Снять квартиру в Бресте  |  Снять квартиру в Гродно | Снять квартиру в Могилеве 
		
		E-mail неагента: info@neagent.by
	
	
	
<div style="display:none;">
	
	

	<div id="centban_block">
	</div>

<div id="rightban4_block">
</div>	
<div id="rightban3_block">
<div style="width:263px;  padding-top:0px; margin:0; padding-bottom:0px;text-align:center;  ">
<script type="text/javascript"><!--<![CDATA[
/* (c)AdOcean 2003-2011 */
/* PLACEMENT: smartcode.neagent.by.240_400 */
if(location.protocol.substr(0,4)=='http')document.write(unescape('%3C')+'script id="smartcode.neagent.by.240_400" src="'+location.protocol+'//by.adocean.pl/_'+(new Date()).getTime()+'/ad.js?id=hNIM7u0t7SJtV88TXoG.XPWjngddn3t_vJAL3rGApBX.47/x='+screen.width+'/y='+screen.height+'" type="text/javascript"'+unescape('%3E%3C')+'/script'+unescape('%3E'));
//]]>--></script>
</div>
</div>

</div>

<script type="text/javascript">
//if (document.getElementById('top_ban')){
//document.getElementById('top_ban').appendChild(document.getElementById('topban_block'));
//}

if (document.getElementById('center_ban')){
document.getElementById('center_ban').appendChild(document.getElementById('centban_block'));
}
if (document.getElementById('right_ban1')){
document.getElementById('right_ban1').appendChild(document.getElementById('rightban1_block'));
}
if (document.getElementById('right_ban4')){
document.getElementById('right_ban4').appendChild(document.getElementById('rightban4_block'));
}
//document.getElementById('right_ban2').appendChild(document.getElementById('rightban2_block'));
document.getElementById('right_ban3').appendChild(document.getElementById('rightban3_block'));
</script>

	<!-- -->




























	<br>
	
	<!-- (C) 2004 stat24.ru -->
 

<!-- (C) stat24 / podstranitsa -->
<script type="text/javascript">
<!--
document.writeln('<'+'scr'+'ipt type="text/javascript" src="http://by4.hit.stat24.com/_'+(new Date()).getTime()+'/script.js?id=d1M1j0MBFQRhEA3ryurcb8V3.q5BbAb7d2v0GHdnI03.m7/l=11"></'+'scr'+'ipt>');
//-->
</script>
	
		
	 
		
		
		
	<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t26.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показане число відвідувачів за"+
" сьогодні' "+
"border='0' width='88' height='15'><\/a>")
//--></script><!--/LiveInternet-->	
	
	
<!-- BEGIN RATING ALL.BY CODE - ALTERNATING THIS CODE WILL CAUSE TERMINATION ACCOUNT--><A HREF="http://www.all.by"><IMG SRC="http://www.all.by/cgi-bin/rating.cgi?id=10074508&amp;ni=2" BORDER="0" WIDTH="88" HEIGHT="31" ALT="RATING ALL.BY"></A><!-- END RATING ALL.BY CODE-->	
	
	
	
<!--Akavita counter start-->	
<!--Akavita counter start-->
<script type="text/javascript">var AC_ID=47171;var AC_TR=false;
(function(){var l='http://adlik.akavita.com/acode.js'; var t='text/javascript';
try {var h=document.getElementsByTagName('head')[0];
var s=document.createElement('script'); s.src=l;s.type=t;h.appendChild(s);}catch(e){
document.write(unescape('%3Cscript src="'+l+'" type="'+t+'"%3E%3C/script%3E'));}})();
</script><span id="AC_Image"></span>
<noscript><a target='_top' href='http://www.akavita.by/'>
<img src='http://adlik.akavita.com/bin/lik?id=47171&it=1'
border='0' height='1' width='1' alt='Akavita'/>
</a></noscript>
<!--Akavita counter end-->
	
	
	
	
	
	</div><!-- #footer -->









</body>
</html>