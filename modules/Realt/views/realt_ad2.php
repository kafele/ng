 

<?
//if (!$CI){$CI =& get_instance();$CI->load->library('parser');}	

		
		//$user = $CI->connect->get_current_user();
		//if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
       /// $mlev=$this->data['mlev'] 
		// echo (  $this->data['mlev']);
		//if  ($this->data['mlev']!=4){echo("Сначала войдите"); exit;}
		
		
		
	if ($ad_currency==1){$ad_currency="руб.";};
	if ($ad_currency==2){$ad_currency="$";};	
	if ($ad_currency==3){$ad_currency="€";};	
		
		
		
?>
 

<div class="item<?=$itemalt?>" id="n<?=$ad_id;?>">
<div class="it_header">

<div class="it_3">

<div class=it_date><?=$ad_postdate;?><?=$ad_isup;?>

</div>
<div class="it_1">
<img src="http://neagent.by/themes/neagent_style/assets/images/kvartira.gif" title="<?=$ad_imgtitle;?>" alt="<?=$ad_imgalt;?>" width=36 height=36>
</div>




<div class="it_2">
<div class="it_price"><table class="pricetable" cellpadding=0 border=0 cellspacing=0  >
		<tr><td  class="ntype<?=$ad_komnat;?>" nowrap><?=$ad_komnat_txt;?></td><td class="nprice<?=$ad_komnat;?>0" nowrap><?=$ad_price;?> <?=$ad_currency?></td><td class="ncl">&nbsp;</td></tr>
		</table></div>
<div class="it_street"><?=$ad_street;?></div>
<div class="it_area"> </div>
</div>




<div class="it_title" ><h2>
<a href="<?=$ad_url;?>" title = "<?=$ad_title;?>"><?=$ad_title;?> </a></h2>
</div>




</div>

</div>
<div class="it_message">
<?=$ad_message;?>   

<span class="it_name">
<noindex><?=$ad_contactname;?></noindex>







<ul class="contact-data {id:'100<?=$ad_id;?>'}">
<li class="icon <? if   (strpos($ad_phones, "втор скрыл")>-1){?> icon-locked<?} else {?>icon-phone<?} ?>">
Телефон: <strong>


 <? if ($show_phones==1){?>
<span><?=$ad_phones?></span>
</strong> 
</li>
<li id="mention-hint"  class="mh mention-hint-100<?=$ad_id;?>"  style="overflow:hidden;height:18px;border: 1px solid #efe99e;"><div class="contact-data-info clr">
При звонке сообщите, что Вы прочитали это объявление на <b class="service-name">Neagent.by</b></div></li>

 <? }else{?>
 
<span>XXXXXXXX</span>
</strong> 
<a href="<?=$ad_url;?>" title="<?=$ad_title;?>" class="link link-spoiler link-spoiler-show {data: '<?= base64_encode($ad_phones);?>', url: 'http://neagent.by/realt/decodecontact/', pdate:'<?=$ad_firstdate;?>'}">
&laquo; <span>показать</span></a>
</li>
<li id="mention-hint"  class="mh mention-hint-100<?=$ad_id;?>" style="display: none" ><div class="contact-data-info clr">
 При звонке сообщите, что Вы прочитали это объявление на <b class="service-name">Neagent.by</b></div></li>

 
 
 <? }?>
 
 </ul>





<style>
ul.contact-data{font-size:14px;color:#2b2b2b;line-height:24px;margin:0 12px 0 0px; font-style:normal;}
ul.contact-data li.icon-phone{background-image:url("http://neagent.by/themes/neagent_style/assets/images/icon-phone-mini.png");}
ul.contact-data li.icon-locked{background-image:url("http://neagent.by/themes/neagent_style/assets/images/icon-lock-mini.png");}
ul.contact-data li a{font-size:11px;}
a.link-spoiler:link{border:none;text-decoration:none;font-size:11px;}
a.link-spoiler span:hover{border-bottom:1px dotted #125e77;}
 

div.contact-data-info b{color:#125e77;}
 ul.contact-data li.icon{padding-left:20px;background-repeat:no-repeat;background-position:left 6px;}
.contact-data-info {background-image: url("http://neagent.by/themes/neagent_style/assets/images/icon-mini-info.png");
background-origin: padding-box;
background-position: 6px 50%;
background-repeat: no-repeat;

background-color:#FFFFCC;
font-size: 11px;
height: 18px;
line-height: 18px;
padding-left:27px;



}

.mh{overflow:hidden;height:1px;border: 1px solid #efe99e;}





</style>
					
					


 <?  if ($mlev==4){?>  <?=$ad_email;?><br><small><a href="http://neagent.by/board/uid/<?=$ad_uid;?>">UID=<?=$ad_uid;?></a></small><?  }?>
</span>

</div>

<div class="it_options">
<!-- жалуемся на суку-агента -->

<div class="pabuse">
<noindex>
<a rel="nofollow" id="aid<?=$ad_id;?>"  onclick="return showComplaintReason(this);" href="realt/complaint/?action=abuse&aid=<?=$ad_id;?>" class="poo serv95" >сообщить&nbsp;о&nbsp;нарушении!</a>

&nbsp;&nbsp;<a rel="nofollow" href="<?=$ad_url;?>" class="poo serv95" >поднять/редактировать/удалить</a>

</noindex>
</div>

<!-- прекратили жаловаться  -->

<?  if ($mlev==4){?>



 <div class="pdelete"> <a rel=”nofollow” href="http://neagent.by/realt/ad_delete/<?=$ad_id;?>">удалить</a></div>
 
		<?  if ($ad_pending==1){?>
		<div class="pdelete"> <a href="http://neagent.by/realt/ad_approve/<?=$ad_id;?>">допустить</a></div>
 		<?  }?>
 
 
 
 
 
 
 
<div class="pdelete"> <a href="ad_delete.asp?id=<?=$ad_id;?>">kill</a></div>
<div class="ptoBL"> <a href="addtoblacklist.asp?number=<?=$ad_phones;?>">in blacklist</a></div>
<div class="ptoBL"> <a href="<?=$ad_cref;?>">cref</a></div>


 <?  if ($ad_show==0){ ?>
 
 
 
  <?  if ($ad_pending==0){ ?>
 УДАЛЕНО
  <? }else{?>
 
 НА МОДЕРАЦИИ
 <? }?> 
 
 
 
 <? }?>





<?  }?>



</div>


<? if ($cat_name) {?>
<div class="it_options">
<div class="parent_link">Перейти в категорию ><a href="<?= $cat_URI;?>"> <?= $cat_name;?> </a></div>
</div>
<?  }?>







</div>



















