<?

$ad_isup = isset($ad_isup)?$ad_isup:false;
 
$single_ad = isset($single_ad)?$single_ad:false;
$ad_dom = isset($ad_dom)?$ad_dom:false;
$ad_korpus = isset($ad_korpus)?$ad_korpus:false;

 




	if ($ad_currency==1){$ad_currency="руб.";};
	if ($ad_currency==2){$ad_currency="$";};	
	if ($ad_currency==3){$ad_currency="€";};	
	if (!$ad_currency){$ad_currency="$";};	
  if ($ad_isup){
$up_select_class=" up";
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
 
 
 
 
 $ad_price=$ad_price . " " . $ad_currency;
  $ad_period2=($ad_period2)?$ad_period2:"2";
  $ad_period3=($ad_period3)?$ad_period3:"5";
 $ad_price2=($ad_price2)?$ad_price2:"...";
 $ad_price3=($ad_price3)?$ad_price3:"...";
 
if ($ad_price2!="..."){ $ad_price2   . " " . $ad_currency; }
 if ($ad_price3!="..."){ $ad_price3   . " " . $ad_currency; }
 
 
   if ($single_ad==1){  	
	$ad_message =nl2br($ad_message);
  }else{  	
	
if ((strlen($ad_message))>400){
 $ad_message = implode(array_slice(explode('<br>',wordwrap($ad_message,800,'<br>',false)),0,1));
 $ad_message = $ad_message  . "... <a href='". $ad_url  ."'> > > ></a> ";
	//$ad_message =substr($ad_message, 0, 400) . "... <a href='". $ad_url  ."'>далее</a>"; //выведет "прим"
}
	 
  } 
 
 
 
?>
 

<div class="item<?=$itemalt?> sutkiad" id="n<?=$ad_id;?>" adtype=<?=$ad_type?>>
<div class="bord1"><div class="bord2">

<div class="it_header">

<div class="it_3">


<div class="its_photo">


<div class="sutki_photo" style="background-image:url(<?=$ad_mainpic;?>)">

<div class="its_more">
<a href="<?=$ad_url;?>">ещё фото...</a>
</div>

<div class="it_price"><table class="pricetable" cellpadding=0 border=0 cellspacing=0  >
<tr><td  class="ntype<?=$ad_komnat;?>" nowrap><?=$ad_komnat_txt;?></td><td class="nprice<?=$ad_komnat;?>0" nowrap><?=$ad_price;?> </td><td class="ncl">&nbsp;</td></tr>
</table></div>
  
</div>


  
 
<div class="" style="margin:1px;margin-left:9px;margin-right:9px;padding-left:9px;padding-top:2px;height:32px;overflow:hidden;background-color:#e4e5e5">

<noindex><?=$ad_contactname;?></noindex>
<noindex> <b><?=$ad_phones;?></b></noindex>

</div></div>


<!--
<div class="it_2">
<div class="it_price"><table class="pricetable" cellpadding=0 border=0 cellspacing=0  >
		<tr><td  class="ntype<?=$ad_komnat;?>" nowrap><?=$ad_komnat_txt;?></td><td class="nprice<?=$ad_komnat;?>0" nowrap><?=$ad_price;?> $</td><td class="ncl">&nbsp;</td></tr>
		</table></div>


</div>
-->



<div class="its_message" >

<div class="its_mess_wrapper">

<a href="<?=$ad_url;?>" class="its_morelink">подробнее...</a>

 


<a href="<?=$ad_url;?>" title = "<?=$ad_title;?>"><?=$ad_title;?>  
</a><br>
 
 <b>
<?=$ad_street;?>
<? if (is_numeric($ad_dom)){ ?>, <?=$ad_dom;?>
<?}?> 
<? if (is_numeric($ad_korpus) ){ ?>, корп. <?=$ad_korpus;?>
<?}?> 
</b>
<br>
 
 
 
<?=$ad_message;?>   

</div>

<div class="its_name_wrapper">


<style>
.its_name_wrapper{
margin-top:1px;

}

div.sutki_tab_wrapper table{
7margin-top:1px;line-height:16px;height:32px;
font-size:15px; 
}
td.sp{
text-align:center;
border:1px solid white;
background-color:#e4e5e5;line-height:15px;
}
td.sp_alt{text-align:center;
border:1px solid white;
background-color:#e4eff9;line-height:15px;
}
.t11{
font-size:11px;
}
.sutkiad .it_header { 
height: 144px;}
</style>

<div class="sutki_tab_wrapper">
<table style="width:100%;">
<tr><td rowspan=2 class="sp"><span class="t11">Цена</span></td><td class="sp">1&nbsp;<span class="t11">сутки</span></td>
<? if ($ad_price2!="..."){ ?>  <td class="sp">><?=$ad_period2?>&nbsp;<span class="t11">суток</span></td>  <? }?>
<? if ($ad_price3!="..."){ ?><td class="sp">><?=$ad_period3?>&nbsp;<span class="t11">суток</span></td><? }?>
</td>
<tr><td class="sp_alt"><?=$ad_price?></td>
<? if ($ad_price2!="..."){ ?><td  class="sp_alt"><?=$ad_price2?><?=$ad_currency;?></td> <? }?>
<? if ($ad_price3!="..."){ ?><td  class="sp_alt"><?=$ad_price3?><?=$ad_currency;?></td> <? }?>
</td>
</table>
</div>

 
</div>






</div>




</div>
<div style="clear:both; width:100%;  height:9px;"></div>
</div>

















 


</div>

</div>


</div>


















