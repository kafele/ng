 
<?

 
$ad_uid = isset($ad_uid)? $ad_uid: false;

	if ($ad_currency==1){$ad_currency="руб.";};
	if ($ad_currency==2){$ad_currency="$";};	
	if ($ad_currency==3){$ad_currency="€";};	
	if (!$ad_currency){$ad_currency="$";};	
  if (isset($ad_isup)){
$up_select_class=" up";
} 
else{
$up_select_class="";
}

 
 if (strlen($ad_price)>4) {
 $ad_price = substr($ad_price, 0, strlen($ad_price)-3)  . " "  .  substr($ad_price, strlen($ad_price)-3 , 3);
 }
 if (strlen($ad_price)>7) {
 $ad_price = substr($ad_price, 0, strlen($ad_price)-7)  . " "  .  substr($ad_price, strlen($ad_price)-7 , 7);
 }
 
 
   if ($ad_mainpic=="http://neagent.by/modules/Realt/files/"){
 $ad_mainpic="http://neagent.by/themes/neagent_style/assets/images/sutki_no_photo.jpg";
 }
 
 $ad_message =nl2br($ad_message);
?>
 

<div class="item<?=$itemalt?> sutkiad" id="n<?=$ad_id;?>">
<div class="it_header" style="height:auto;">

<div class="it_3">


<div class="its_photo">


<div class="sutki_photo" style="background-image:url(<?=$ad_mainpic;?>)">



<div class="it_price"><table class="pricetable" cellpadding=0 border=0 cellspacing=0  >
<tr><td  class="ntype<?=$ad_komnat;?>" nowrap><?=$ad_komnat_txt;?></td><td class="nprice<?=$ad_komnat;?>0" nowrap><?=$ad_price;?> <?=$ad_currency?></td><td class="ncl">&nbsp;</td></tr>
</table></div>
  
</div>


<div class="it_street"><?=$ad_street;?>
<? if (is_numeric($ad_dom)){ ?>, <?=$ad_dom;?>
<?}?> 
<? if (is_numeric($ad_korpus) ){ ?>, корп. <?=$ad_korpus;?>
<?}?> 


</div>

<? if ($ad_sp_mest) {?>  <div class="its_sp_mest">Спальных мест: <?=$ad_sp_mest;?></div><? }?> 





<div style="margin-left:9px;">
<? for ($i = 0; $i < count($ad_picturesarray); $i++) { ?>
<a rel="photos_group"  href="<?=$ad_picturesarraybig[$i];?>" ><img src="<?=$ad_picturesarray[$i];?>"></a>
<? } ?>
</div>


<?


$ad_link2=str_replace("http://", "", strtolower($ad_link));
$len1= strpos($ad_link2, '/');
if  (!$len1){
$ad_sitename=$ad_link2;
}
else{
$ad_sitename=substr($ad_link2, 0, $len1);
}

?>


<? if ($ad_link) {?> 
<div class="its_sp_mest"><noindex>Сайт: <a href="<?=$ad_link;?>" target="blank"><?=$ad_sitename;?></a></noindex></div>
<? }?> 



 <script src="http://neagent.by/themes/neagent_style/javascript/fancybox/jquery-1.4.3.min.js"><\/script>

<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="http://neagent.by/themes/neagent_style/javascript/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="http://neagent.by/themes/neagent_style/javascript/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<script type="text/javascript">
		$(document).ready(function() {
		
		
		
		 
		
	 
		
		$("a[rel=photos_group]").fancybox({
		           'overlayColor'		: '#000',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over'
				 
			});
		
			 
			
			
		});
	</script>









</div>



 



<div class="its_message" >

<div class="its_mess_wrapper" style="height:auto;">

 

<a href="#" title = "<?=$ad_title;?>"><?=$ad_title;?> </a><br>

<?=$ad_message;?>   

</div>

<div class="its_name_wrapper">
<span class="it_name">
<noindex><?=$ad_contactname;?></noindex>
<noindex> <?=$ad_phones;?></noindex> <?  if ($mlev==4){?><br><small><a href="http://neagent.by/board/uid/<?=$ad_uid;?>">UID=<?=$ad_uid;?></a></small><?  }?>
</span>
</div>


<!--
<div class="its_name_wrapper">
<span class="it_name">
<noindex> <?=$ad_email;?></noindex>  
</span>
</div>
-->






</div>




</div>
<br style="clear:both;">





</div>

















<div class="it_options">
<!-- жалуемся на вопрос -->
<!--
<div class="pabuse"><a id="aid<?=$ad_id;?>"  onclick="return showComplaintReason(this);" href="realt/complaint/?action=abuse&aid=<?=$ad_id;?>" class="poo serv95" ><noindex>сообщить&nbsp;о&nbsp;нарушении!</noindex></a></div>
-->
<!-- прекратили жаловаться на вопрос -->

<?  if ($mlev==4){?>



<div class="pdelete"> <a href="http://neagent.by/realt/sutki_ad_delete/<?=$ad_id;?>">удалить</a></div>

<?  if ($ad_show==0){?> <span style="color:red;">УДАЛЕНО</span><?  }?>



<?  }?>



</div>



</div>


<?  if ($mlev==4){?>

<?  if ($ad_show==0){?> <span style="color:red;">УДАЛЕНО</span><?  }?>

Клиент: <?=$client_name;?><br>

Дата окончания: <?=$ad_enddate;?>

<?  }?>





<div class="parent_link">Перейти в категорию ><a href="http://neagent.by/kvartira/na-sutki" title = "Квартиры на сутки" >Квартиры на сутки</a></div>











