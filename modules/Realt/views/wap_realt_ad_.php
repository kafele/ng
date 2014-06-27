<?
if 	($_SERVER["REMOTE_ADDR"]=="212.98.167.242"){
	$ad_phones="www.neagent.by";
	}


		//$user = $CI->connect->get_current_user();
		//if (($user['group']['group_name'])=='Super Admins'){$this->data['mlev']=4;};
       /// $mlev=$this->data['mlev'] 
		// echo (  $this->data['mlev']);
		//if  ($this->data['mlev']!=4){echo("Сначала войдите"); exit;}
		
	if	($ad_catid==1){
	if (	substr($ad_phones,0,4)=="8025"||substr($ad_phones,0,5)=="8 025"||substr($ad_phones,0,5)=="8-025"){
	$ad_message = "<span style='color:red; font-size:12px;'>Скорее всего это объявление посредника (определено автоматически)! Если это так, нажимайте кнопку 'сообщить о нарушении'<br></span> ".   $ad_message ;
	}
	 
	}	
		
	if ($ad_currency==1){$ad_currency="руб.";};
	if ($ad_currency==2){$ad_currency="$";};	
	if ($ad_currency==3){$ad_currency="€";};	
	if (!$ad_currency){$ad_currency="$";};	
	if ($ad_price==0){$ad_price="  ";$ad_currency="";}
	
	if ($ad_id=='364746'){$ad_komnat_txt="2-3 комн.";}
	
// $newpage='0';
 
 //if ($mlev=='4'){ $newpage='1'; }

  if ($ad_isup){
$up_select_class=" up";
}  
 
 
 
 if (strlen($ad_price)>4) {
 $ad_price = substr($ad_price, 0, strlen($ad_price)-3)  . " "  .  substr($ad_price, strlen($ad_price)-3 , 3);
 }
 
 
 if (strlen($ad_price)>7) {
 $ad_price = substr($ad_price, 0, strlen($ad_price)-7)  . " "  .  substr($ad_price, strlen($ad_price)-7 , 7);
 }
	
?>
 

 
 

 <style>.wapbl{padding:0px;padding-top:7px;padding-bottom:7px;
  border-bottom: 1px solid #E7E7E7;}
 
 
 </style>
 
 
 <div class="wapbl">
  <a href="/pda/base/3222527.html">
    <img src="<?=$ad_mainpic;?>" title="<?=$ad_imgtitle;?>" alt="<?=$ad_imgalt;?>" width=36 height=36>
	</a>
  <br>
  <?=$ad_postdate;?><br>
  <?=$ad_komnat_txt;?><br>
  <b>Адрес:</b>
  <?=$ad_street;?> <? if (is_numeric($ad_dom)){ ?>, <?=$ad_dom;?>
<?}?> 
<? if (is_numeric($ad_korpus) ){ ?>, корп. <?=$ad_korpus;?>
<?}?>        
  <br>
  <b>Цена:</b>
  <?=$ad_price;?><?=$ad_currency?> 
  <br>
  
   <? if ($single_ad==1 ) {  ?>
   <?=$ad_message;?>  
   <?=$ad_contactname;?>

<? if (($show_phones=='1'&&($newpage!='1')) || ($single_ad==1)){?>
<span><?=$ad_phones?></span>

<a rel="nofollow" id="aid<?=$ad_id;?>"  onclick="return showComplaintReason(this);" href="realt/complaint/?action=abuse&aid=<?=$ad_id;?>" class="poo serv95 dots" >Сообщить&nbsp;о&nbsp;нарушении!</a>

 <? }else{?>
 
<span>XXXXXXXX</span>

<a href="<?=$ad_url;?>" title="<?=$ad_title;?>" <? if($newpage!='1'){?> class="link link-spoiler link-spoiler-show {data: '<?= base64_encode($ad_phones);?>', url: 'http://neagent.by/realt/showcontact/', pdate:'<?=$ad_firstdate;?>'}" <?}?>   <? if($newpage=='1'){?> target='_blank' <?}?>> 
&laquo; <span>показать <? if($newpage=='1'){?> (в новом окне) <?}?>  </span></a>
</li>








<?  if ($mlev==4){?>

 <div class="pdelete"> <a rel=”nofollow” href="http://neagent.by/realt/ad_delete/<?=$ad_id;?>">удалить</a></div>
 
		<?  if ($ad_pending==1){?>
		<div class="pdelete"> <a href="http://neagent.by/realt/ad_approve/<?=$ad_id;?>">допустить</a></div>
 		<?  }?>

<div class="pdelete"> <a href="ad_delete.asp?id=<?=$ad_id;?>">kill</a></div>
<div class="ptoBL"> <a href="addtoblacklist.asp?number=<?=$ad_phones;?>">in blacklist</a></div>
<div class="ptoBL"> <a href="<?=$ad_cref;?>">cref</a></div>

 
 
 <? }?>

<?  if ($ad_show==0&&$mlev==4){ ?>
  <?  if ($ad_pending==0){ ?>
 УДАЛЕНО
  <? }else{?>
 НА МОДЕРАЦИИ
 <? }?> 
<?  }?>










 <? }?>
 
 
 
 
 
  <?}else{ ?>
  
  <a href="<?=$ad_url;?>" title = "<?=$ad_title;?>">подробнее </a>
   
  
  <? }?>
  
  
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
<img src="<?=$pic_folder;?><?=$ad_picture;?>" style="margin-bottom:18px;margin-left:18px;">
<?

} 
}
?>









