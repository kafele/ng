


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



<div class="foot">
	<div class="footTop">
		<div class="page">
			<div class="footContent">
				<div class="foot1stCol">
					<p>© 2002–2013 Neagent.by<br></p>
					
					<!-- <p>Спасибо за то, что посетили наш сайт!</p> -->
					<p><a href="http://neagent.by/uslugi">Порядок оказания услуг, режим работы</a><br><a href="http://neagent.by/oplata">Порядок оплаты услуг</a> <br> Использование материалов допускается только при соблюдении правил перепечатки и при наличии гиперссылки на neagent.by</p>
					<p>Оказание услуг: ИП Минич Сергей Леонидович. УНП 101139268. Св-во 101139268 выдано Мингорисполкомом 20.07.2000г. Адрес: Минск, пр.Рокоссовского, 125-299 Т.&nbsp;(029)&nbsp;632-43-68</p>
					
					<img src="http://vab.by/themes/vabdark/assets/images/logo-raschet32.png"> <img src="http://vab.by/themes/vabdark/assets/images/logo-ipay32.png"> 
					
					
					<!--
					<a href=" .jpg" class="thickbox" title=" "><img src=" .jpg" style="height: 72px;" class="picR" alt=" "></a>
					<a href=" .jpg" class="thickbox" title=" "><img src=" .jpg" style="height: 72px;" class="picR" alt=" "></a>
					-->
					
					<p class="ico"><a href="mailto:info@neagent.by"><img src="http://img1.neagent.by/s/mail.png" class="ico">info@neagent.by</a></p>
					 
				</div>

				<div class="foot2ndCol">
					<p> Neagent.by -  самый посещаемый сайт в Беларуси по аренде квартир. </p>
					
					<div class="baners">
						
						
						
						
						
						
					
<!-- (C) stat24 / podstranitsa -->
<script type="text/javascript">
<!--
document.writeln('<'+'scr'+'ipt type="text/javascript" src="http://by4.hit.stat24.com/_'+(new Date()).getTime()+'/script.js?id=d1M1j0MBFQRhEA3ryurcb8V3.q5BbAb7d2v0GHdnI03.m7/l=11"></'+'scr'+'ipt>');
//-->
</script>
	
		
	 
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter17278198 = new Ya.Metrika({id:17278198, enableAll: true, webvisor:true});
        } catch(e) { }
    });
    
    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/17278198" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->	
		
		
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
	

					
						
						
						
						
						
					</div>
				</div>
				<div class="foot3rdCol">
					 
						<p>Минск <br> </p>
					<a href=" " title=" " id="mapLocation">Размещение рекламы</a> <br>
					 
					<a class="footPlansLink thickbox" href="http://neagent.by/kvartira/na-sutki"  >Квартиры на сутки</a><br>
					<a class="footPlansLink thickbox" href="http://neagent.by/kvartira/sdat"  >Сдать квартиру</a><br>
<a class="footPlansLink thickbox" href="http://neagent.by/kvartira/snyat" >Снять квартиру</a><br>
 
					
				</div>
				<div class="end"></div>

			</div>
		</div>
	</div>
</div>

	
	
	
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
if (document.getElementById('right_ban3')){
document.getElementById('right_ban3').appendChild(document.getElementById('rightban3_block'));
}
</script>

	<!-- -->
  
	
	<!-- (C) 2004 stat24.ru -->
 
	
	
	
	
	 <!-- #footer -->



<style>
div.foot { 
background-color: #3991d1;
padding-left:40px;
padding-right:40px;
font-family:"Segoe UI",   sans;
}
div.foot1stCol { 
border-right: 1px solid #7AA9CC;
padding-right: 20px;
width: 320px;
}

.foot1stCol   a, .foot1stCol   a:hover, .foot1stCol   a:visited{
color:#B3E7FF;
}

div.foot1stCol, div.foot2ndCol, div.foot3rdCol { 
display: table-cell;
}
div.foot2ndCol { 
padding-left: 20px;
width: 300px;
}

div.foot1stCol, div.foot2ndCol, div.foot3rdCol { 
display: table-cell;
}

div.footContent { 
background: url("http://www.ifmo.ru/images/building.gif") 100% 100% no-repeat transparent;
color: #B3E7FF;
font-size: 11px;
font-weight: normal !important;
padding: 15px 10px;
text-shadow: #15649e 0 1px 0;
}
 
div { 
display: block;
 }
 
 div.footTop { 
 
margin-top: -4px;
}

div.page { 
margin-left: auto;
margin-right: auto;
width: 980px;
}

img.picR { 
float: right;
margin: 5px 0px 10px 10px;
}
div.footContent { 
background: url("http://img1.neagent.by/s/minsk.png") 100% 100% no-repeat transparent;
color: #B3E7FF;
font-size: 11px;
padding: 15px 10px;
text-shadow: #15649e 0 1px 0;
}

div.foot p.ico { 
font-family: "Georgia", serif;
font-size: 14px;
}
 
div p.ico { 
 
margin: 0.5em 0px;
min-height: 26px;
padding: 6px 0px 0px 8px;
}
div.foot p { 
line-height: 110%;
padding: 0.5em 0px;
}
p.ico img.ico { 
margin-right: 15px;
}

img.ico { 
margin-right: 5px;
vertical-align: middle;
}

a img { 
border: medium none currentColor;
}

.foot3rdCol a,  .ico a{
color: #B3E7FF;
}

#middle { 
padding: 0px;
}

</style>





</body>
</html>