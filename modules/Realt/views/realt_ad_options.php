<!-- view: realt/views/realt_ad_options -->

<?
//if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	

		
		//$user = $CI->connect->get_current_user();
		//if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
       /// $mlev=$this->data['mlev'] 
		// echo (  $this->data['mlev']);
		//if  ($this->data['mlev']!=4){echo("Сначала войдите"); exit;}
?>
<script src="http://neagent.by/themes/neagent_style/javascript/fancybox/jquery-1.4.3.min.js----"><\/script>

<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="http://neagent.by/themes/neagent_style/javascript/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<script type="text/javascript">
		$(document).ready(function() {
			/*
			*   Examples - images
			*/
$('#nonjs_options').hide();
$('#js_options').show();

$('#nonjs_options2').hide();
$('#js_options2').show();


			$("#ad_opt").fancybox({
				'width'				: 300,
				'height'			: 200,
				'autoScale'			: false,
				'overlayColor'		: '#000',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			
			
		});
	</script>

	<style>
	a.options_link{font-size:15px;   padding-top:5px; margin-left:70px; text-decoration:none; border-bottom:1px dotted #62a5d5;}
	
	</style>
	
	 
	 <div id="nonjs_options"  >
	 Для удаления объявления и других операций у вас должен быть включен javascript
	 </div>
	
	 <div id="js_options" style="display:none;">
	 <a id="ad_opt" href="http://neagent.by/realt/ad_options/<?=$ad_id;?>" class="options_link">Удалить объявление</a> 
	 </div>
	
	
	
	
	
	
	<style>
 input.text, .text {
	border: 1px solid #cecece;
	width: 450px;
	margin-bottom: 5px;
	margin-top: 5px;
}
.hide, a.hide {display:none;}
.show, a.show {display:block;}

</style>

<script>

function showhidediv(id, link) {

	if ($('#h' + id).attr('class') == 'hide')
{
	$('#h' + id).removeClass('hide');	
}
else {
	$('#h' + id).addClass('hide');
	}
}
</script>


 <div id="nonjs_options2"  >
	 Для поднятия объявления   у вас должен быть включен javascript
	 </div>
	
	 <div id="js_options2" style="display:none;">
	 <a href="javascript:void(0);" onClick="return showhidediv('supdiv', this)"  class="options_link">Поднять объявление</a>  
	 </div>




 


<div id="hsupdiv" class="hide" style="clear:both; margin-left:0px; background-color:#FAEBAE;  padding:15px; padding-bottom:15px; ">
<h2 style="font-size:18px;">Поднятие объявления</h2> 
Номер этого объявления 100<?=$ad_id;?><p> 
Чтобы поднять ЭТО объявление наверх рубрики на 5 дней, <br>отправьте СМС с текстом <b>neagent 100<?=$ad_id;?></b> на номер вашего оператора, из списка: 
 
<p>	
<b>Для абонентов мобильных операторов в РБ:</b> <table class="client_table" style="background:white;">

<tr><td>Оператор</td><td>Номер телефона</td> <td>Стоимость без НДС</td><td>Стоимость с НДС</td></tr>
<tr><td>Velcom</td><td>2325</td> <td>12900 BYR</td><td> 15480 BYR</td></tr>
<tr><td>МТС</td><td>2325</td> <td>12900 BYR</td><td>15480 BYR</td></tr>
<tr><td>life:)</td><td>2325</td> <td>12900 BYR</td><td>15480 BYR</td></tr>
<tr><td>Diallog (БелСел)</td><td>2325</td> <td>12900 BYR</td><td>15480 BYR</td></tr> 

<!--
<tr><td>Оператор</td><td>Номер телефона</td> <td>Стоимость без НДС</td><td>Стоимость с НДС</td></tr>
<tr><td>Velcom</td><td>1320</td> <td><s>5900</s> 2900 BYR</td> <td><s>7080</s> 3480 BYR</td></tr>
<tr><td>МТС</td><td>1320</td> <td><s>5000</s> 2500 BYR</td>    <td><s>6000</s> 3000 BYR</td></tr>
<tr><td>life:)</td><td>1320</td> <td><s>5000</s> 2500 BYR</td> <td><s>6000</s> 3000 BYR</td></tr>
<tr><td>Diallog (БелСел)</td><td>1320</td> <td><s>5000</s> 2500 BYR</td><td><s>6000</s> 3000 BYR</td></tr> -->

</table>
 
 
 
	
<p>
Ваше объявление станет первым в рубрике, пока кто-то другой не поднимет своё объявление с помощью SMS.<p> 
(Помните, что ваше объявление и так поднимается каждые 15 минут, если вы заходите на сайт со своего компьютера, с которого вы дали объявление. Но те объявления, которые
подняли с помощью SMS 5 дней держатся в самом верху рубрики.) 
<p>Если после вас кто-то ещё поднимет своё объявление с помощью смс, то оно появится перед вашим, а ваше станет вторым, и т.д. 	

		
<p>
<b> Составляя SMS-сообщение, 
делайте это строго по инструкции, оплата за него будет взята вашим телефонным оператором независимо от результата запроса. </b>
 <p>
Высылайте SMS-сообщение строго латинскими буквами, между словом neagent и цифрами - пробел, без переносов строки и пробелов после цифр. Убедитесь, что у вас не стоит подпись к SMS-сообщению. 
<p>
Пример SMS-сообщения  для вашего объявления под номером 100<?=$ad_id;?>:  <span style="background-color:white; font-size:18px;"><b>neagent 100<?=$ad_id;?></b></span> - вот так надо написать в сообщении, со словом neagent, пробелом, и номером. 
<p>
Отправив такой текст, пользователь поднимет 
объявление на первую позицию рубрики, в которой было размещено это объявление. 
<p>
После отправки вам придет СМС сообщение с подтверждением 
о получении. Если получите сообщение об ошибке, <b>но ввели всё правильно</b> - свяжитесь с администратором по почте info@neagent.by.   

<p>
 
 <H2 style="color:red"><b>ВАЖНО! Услуга только для частных лиц. Если вы агент, или  по телефону отвечаете, 
 что вы посредник, или вы диспетчер агентства (собираете телефоны хозяев и передаете их агентствам, 
 неважно, за деньги или бесплатно), 
 то поднятие объявления не означает, что его не удалят. Будьте внимательны. 
 Услуга предоставляется оператором сотовой связи, деньги вернуть вам уже не смогут. </b>
</h2>
 
 
 <br><br>
 <!--
 <a href="https://besmart.serveftp.net:4443/pls/ipay/!iSOU.Login?srv_no=781&pers_acc=<?=$user_id;?>100<?=$ad_id;?>& amount=15000&amount_editable=N
 ">Поднятие с помощью iPay</a> (ВНИМАНИЕ! УСЛУГА НЕ ПРЕДОСТАВЛЯЕТСЯ. СЕРВИС ТЕСТИРУЕТСЯ.)
 -->
 <br>
  <a href="/board/up?adid=100<?=$ad_id;?>&pers_acc=<?=$user_id;?>">
  Поднятие с помощью iPay</a>  
 
 
</div>
	