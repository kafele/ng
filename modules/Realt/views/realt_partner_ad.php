 

<?
//if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	

	
if 	($_SERVER["REMOTE_ADDR"]=="212.98.167.242"){
	  
	$ad_phones="www.neagent.by";
	//$ad_url=$ad_url . "/?" . $ip;
	
	}


	
		//$user = $CI->connect->get_current_user();
		//if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
       /// $mlev=$this->data['mlev'] 
		// echo (  $this->data['mlev']);
		//if  ($this->data['mlev']!=4){echo("Сначала войдите"); exit;}
		
		
//	if	($ad_catid==1){
//	if (	substr($ad_phones,0,5)=="37525"||substr($ad_phones,0,4)=="8025"||substr($ad_phones,0,5)=="8 025"||substr($ad_phones,0,5)=="8-025"){
//	$ad_message = "<span style='color:red; font-size:12px;'>Скорее всего это объявление посредника (определено автоматически)! Если это так, нажимайте кнопку 'сообщить о нарушении'<br></span> ".   $ad_message ;
//	}
//	}



echo("<!-- " );
echo($addata['ad_price']  . " " );
echo(" -->" );
		
	if ($ad_currency==1){$ad_currency="руб.";};
	if ($ad_currency==2){$ad_currency="$";};	
	if ($ad_currency==3){$ad_currency="€";};	
	if (!$ad_currency){$ad_currency="$";};

	
	if ( is_numeric($ad_price)&& $ad_price==0){$ad_price="  ";$ad_currency="";}
	
	
	
	
	 
	
// $newpage='0';
 
 //if ($mlev=='4'){ $newpage='1'; }

  if ($ad_isup){
$up_select_class=" up";
}  
 
 
if ($ad_uid=='bling.by'){
$up_select_class=" bl";
}
 
 
 //////////// Временно удалено. форматирование цены. но сейчас могут ыть не только цифры
 //if (strlen($ad_price)>4) {
 //$ad_price = substr($ad_price, 0, strlen($ad_price)-3)  . " "  .  substr($ad_price, strlen($ad_price)-3 , 3);
 //}
 
 
 //if (strlen($ad_price)>7) {
 //$ad_price = substr($ad_price, 0, strlen($ad_price)-7)  . " "  .  substr($ad_price, strlen($ad_price)-7 , 7);
 //}
 
	
	
	
		
?>
 

<div class="item<?=$itemalt?><?=$up_select_class?>" id="n<?=$ad_id;?>"   >
	<div class="bord1">
		<div class="bord2">
			<div class="it_header" <? if ($single_ad!=1){ ?>onClick="document.location='<?=$ad_url;?>';" <? }?>>
				<div class="it_3">
					<div class='it_date'>
					 
					<?=$ad_postdate;?><?=$ad_isup;?>
					 
					</div>
					
					<div class='it_pl' style="width:100px;">
					<? if ($ad_pl_o) { ?>
					  <?=$ad_pl_o;?> / <?=$ad_pl_z;?> / <?=$ad_pl_k;?> м<sup>2</sup>
					  <? }?>
					</div>
					
					
					
					<div class='it_etazh' style="width:100px;">
					<? if ($ad_etazh) { ?>
					   <?=$ad_etazh;?> / <?=$ad_etazhej;?> этаж
					 <? }?>  
					</div>
					
					
					
					<div class="it_1"><a href="<?  if ($mlev==4){?><?=$ad_cref;?><?}else{?><?=$ad_url;?><?}?>"><img src="<?=$ad_mainpic;?>" title="<?=$ad_imgtitle;?>" alt="<?=$ad_imgalt;?>" width=36 height=36></a></div>
					<div class="it_2">
						<div class="it_price">
						<table class="pricetable" cellpadding=0 border=0 cellspacing=0>
						<tr><td  class="ntype<?=$ad_komnat;?>" nowrap><?=$ad_komnat_txt;?></td>
						<td class="nprice<?=$ad_komnat;?>0" nowrap><?=$ad_price;?><?=$ad_currency?></td><td class="ncl">&nbsp;</td></tr></table>
						</div>
						<div class="it_street">
						
						</div>
						<div class="it_area"> </div>
					</div>
					<div class="it_title" ><address>
					<? if ($ad_marker){ ?>
					<div style="float:left; padding-right:4px;"><img src="http://neagent.by/themes/neagent_style/assets/images/<?=$ad_marker;?>" align=left title="квартира показана на карте"  ></div>
					<? } ?>
					
					<? 
					if ( strlen($ad_street)<2){
					 $ad_street =$ad_city;
					}
					else {
					$ad_street = $ad_city . ", " . $ad_street;
					}
					?>
					
					
					<a href="<?=$ad_url;?>" title = "<?=$ad_title;?>"><?=$ad_street;?>
<? if (is_numeric($ad_dom)){ ?>, <?=$ad_dom;?>
<?}?> 
<? if (is_numeric($ad_korpus) ){ ?>, корп. <?=$ad_korpus;?>
<?}?>  </a></address><div class="labels" id="labels<?=$ad_id;?>"><?=$labelmark;?></div>
					</div>
				</div>
			</div>
			<div class="it_message" <? if ($single_ad!=1){ ?>onClick="document.location='<?=$ad_url;?>';" <? }?>>
			  
			<span class="it_name">
			<span class="ad_name"><noindex><?=$ad_contactname;?></noindex></span>
 
	
					


 <?  if ($mlev==4){?>  <?=$ad_email;?><br>
 
 <small style="font-size:10px;"><a href="http://neagent.by/board/uid/<?=$ad_uid;?>">UID=<?=$ad_uid;?></a>
 <a href="http://neagent.by/board/evc/<?=$ad_evc;?>">EVC=<?=$ad_evc;?></a>
<a href="http://neagent.by/board/ip/<?=$ad_ip;?>">IP=<?=$ad_ip;?></a>
 UIC=<?=$ad_uic;?></small>
 
 <?  }?>
</span>

</div>

<div class="it_options" <? if ($single_ad!=1){ ?>style="_display:none; <?} ?>">
<!-- жалуемся на суку-агента -->

<div class="pabuse">
<noindex>

<? if ($single_ad==1){ ?>
<? if ($ad_comments_count>0){ ?>
<a href="<?=$ad_url;?>" class="com " style="color:green;" title="Комментариев: <?=$ad_comments_count;?> ">(<?=$ad_comments_count;?>)</a>
<?}else{ 
?>
<a href="<?=$ad_url;?>" class="com0 " style="color:#cecece;" title="нет комментариев">(0)</a>
<?}?>
<span class="sdiv">|</span> 


<? if ($ad_hits>0){ ?>
Просмотров: <?=$ad_hits;?> <? if ($ad_unic_views>0){ ?>(уникальных <?=$ad_unic_views?>)<? } ?> <span class="sdiv">|</span> 
 
<?}?>
<?} ?>

<a rel="nofollow" id="aid<?=$ad_id;?>"  onclick="event.preventDefault();  return  showComplaintReason(this); " href="realt/complaint/?action=abuse&aid=<?=$ad_id;?>" class="poo serv95 dots" >Сообщить&nbsp;о&nbsp;нарушении!</a>






<? if ($single_ad!=1){ ?>
&nbsp;&nbsp;<a rel="nofollow" href="<?=$ad_url;?>" class="poo serv95" >
<?  if ($mlev==4){?>
ред.
<? } else{?>
Поднять/удалить
<? } ?>


</a>
<? } ?>

<? if ($single_ad==1){ ?>
 <a href="http://neagent.by/board/all/<?=$ad_id;?>" style="color:grey;"> Все объявления автора </a> 
<? } ?>
 
 
</noindex>
</div>

<!-- прекратили жаловаться  -->



<? if ($labels_flag==1) {?>

<div class="pdelete"> 
<a rel="nofollow" id="atag<?=$ad_id;?>"  onclick="return showTagDiv(this);" href="realt/tag/?action=add&aid=<?=$ad_id;?>" class="poo serv95" >
Добавить метку</a></div>

<? }?>





<?  if ($mlev==4){?>

 <div class="pdelete"> <a rel=”nofollow” href="http://neagent.by/realt/ad_delete/<?=$ad_id;?>">удалить</a></div>
 
		<?  if ($ad_pending==1){?>
		<div class="pdelete"> <a href="http://neagent.by/realt/ad_approve/<?=$ad_id;?>">допустить</a></div>
 		<?  }?>
 
 
 
 
 
 
 
<div class="pdelete"> <a href="ad_delete.asp?id=<?=$ad_id;?>">kill</a></div>
 
 
 <?
 $clearEmail = str_replace("[?]", "", $ad_email);
 ?>
 
 
<div class="ptoBL"> <a href="http://neagent.by/realt/addToBlacklist/<?=$ad_phones;?>/<?=$clearEmail;?>">blackl.</a></div>
<div class="ptoBL"> <a href="<?=$ad_cref;?>">cref</a></div>


 
 
 
 
 <? }?>

<?  if ($ad_show==0&&$mlev==4){ ?>
  <?  if ($ad_pending==0){ ?>
 УДАЛЕНО
  <? }else{?>
 НА МОДЕРАЦИИ
 <? }?> 



<?  }?>



</div>


<? if ($cat_name) {?>
<div class="it_options" style="display:none">
<div class="parent_link">Перейти в категорию ><a href="<?= $cat_URI;?>"> <?= $cat_name;?> </a></div>
</div>
<?  }?>






</div></div>

</div>










<?
//echo (count($ad_pictures));

 if ($single_ad==1&& count($ad_pictures)>0) { 
?>
<?
foreach ($ad_pictures as $ad_picture)
{
?>
<!-- фотографии   -->
<img src="<?=$pic_folder;?><?=$ad_picture;?>" style="margin-bottom:0px;margin-left:0px;">
<?

} 
}
?>



<style>
.it_1 { 
 
margin-top: -10px;
 
}

.it_2 { 
width: 160px;
}
.it_date{
width: 130px;
}
.it_pl , .it_etazh{
float:right;

}
.item { 
background-image: none;
border: none;
border-bottom: 1px solid #DADADA;
border-radius: 0px;
box-shadow: none !important;
margin-bottom: 0px !important;
}

.up .bord2 { 
border: none;
border-radius: 0px;
padding-bottom: 2px;
padding-top: 12px;
}

 .up .bord1 { 
border: none;
}
.it_message { 
 
font-size: 13px;
 
}
</style>





