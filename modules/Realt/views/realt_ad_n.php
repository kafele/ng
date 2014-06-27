<? if ($mlev=='4'){ ?><script >function to_rubric(obj, id){if  (obj.value>0){window.location.assign("http://neagent.by/realt/to_rubric/" + obj.value + "/" + id)}}; </script> <? } ?>
 
<?

 

if 	($_SERVER["REMOTE_ADDR"]=="212.98.167.242"){
	$ad_phones="www.neagent.by";
	//$ad_url=$ad_url . "/?" . $ip;
}


if ($mlev=='4'){	
$cstr = "";
for ($k = 0; $k < count($this->data['realt_cats']); $k++) {
$cid = $this->data['realt_cats'][$k]['id'];
for ($h = 0; $h < count($this->data['realt_subcats']); $h++) {
if ($this->data['realt_subcats'][$h]['parent'] == $cid) {
$cstr .= "<OPTION   value=" . $this->data['realt_subcats'][$h]['id'] . " >" . $this->data['realt_cats'][$k]['name'] . " » " . $this->data['realt_subcats'][$h]['name'] . "</OPTION>";
 }
 }
 }	
}	
	
	
echo("<!-- " );
echo($addata['ad_price']  . " " );
echo(" -->" );
	if ($ad_currency==1){$ad_currency="руб.";};
	if ($ad_currency==2){$ad_currency="$";};	
	if ($ad_currency==3){$ad_currency="€";};	
	if (!$ad_currency){$ad_currency="$";};
	if ( is_numeric($ad_price)&& $ad_price==0){$ad_price="  ";$ad_currency="";}


if ($ad_type==1){
$ad_type_class=" typevip";
} 
if ($ad_type==2){
$ad_type_class=" typevip2";
} 
	
if ($ad_isup){
$up_select_class=" up";
}  
 

if ($ad_uid=='bling.by'){
$up_select_class=" bl";
}
 
	
if ($single_ad==1){  	
	$ad_message =nl2br($ad_message);
}else{  	

if ((strlen($ad_message))>400){
 $ad_message = implode(array_slice(explode('<br>',wordwrap($ad_message,800,'<br>',false)),0,1));
 $ad_message = $ad_message  . "... <a href='". $ad_url  ."'> > > ></a> ";
}
}  	
?>
 

<div class="itm <?=$itemalt?><?=$up_select_class?><?=$ad_type_class?>" id="n<?=$ad_id;?>">
	<table class="itm_head" >
	<tr>
	<td>
		<div class="itm_pic" >
		<a href="<?  if ($mlev==4){?><?=$ad_cref;?><?}else{?><?=$ad_url;?><?}?>"   ><img src="<?=$ad_mainpic;?>" title="<?=$ad_imgtitle;?>" alt="<?=$ad_imgalt;?>" width=36 height=36></a>
		</div>
		<div class="itm_street"><?=$ad_street;?></div> 
		<div><?=$ad_postdate;?><?=$ad_isup;?></div>
	</td>
	<td width='100'>
		<div class="itm_komnat"><?=$ad_komnat;?>-комн.</div>
 		<div class="itm_price"><?=$ad_price;?>&nbsp;$</div>
	</td>
	<tr>
	</table>
	<?=$ad_message;?> 
	<table class="itm_bot" >
	<tr>
	<td>
		<a rel="nofollow" id="aid<?=$ad_id;?>"  onclick="event.preventDefault();  return  showComplaintReason(this); " href="realt/complaint/?action=abuse&aid=<?=$ad_id;?>" class="poo serv95 dots" >
			<!--Сообщить&nbsp;о&nbsp;нарушении! -->
			Сообщить о нарушении
		</a>
	</td>
	<td width='150'>
	<a href="<?  if ($mlev==4){?><?=$ad_cref;?><?}else{?><?=$ad_url;?><?}?>"   >Подробнее</a>
	</td>
	<tr>
	</table>
</div>
 
 
 
 
 



<style>
.itm { 
 padding-top:10px;
 padding-bottom:10px;
border-bottom:1px solid grey;
 
}
.typevip{
background:#f9fdda;
}
.typevip2{
background:#aaff7c;
}

.itm .itm_price { 
 
font-size:24px; 
 
}
.itm .itm_komnat { 
 
font-size:24px; 
 
}
.itm .itm_head, .itm .itm_bot{
width:100%;
}
.itm .itm_pic{float:left;margin-right:10px;}
 .itm .itm_street{font-size:18px;}
</style>





