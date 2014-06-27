<? if ($mlev=='4'){ ?>
<script >

function to_rubric(obj, id){

// alert(obj.value);
if  (obj.value>0){
 window.location.assign("http://neagent.by/realt/to_rubric/" + obj.value + "/" + id)
}

};
 </script>
  <? 

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
  
  
  
  
  
  
  
  
  ?>








<style>
.w_ad{
background-image:url('http://img1.neagent.by/s/w_grad_delim.gif');
background-repeat:repeat-x;
background-position:0 100%  ;
//border-bottom:1px dotted #ccc;
padding:0.5em;
line-height:1.5em;
}
.w_kom{
color:white;
background-color:#b1e788;
}
.w_str{
font-weight:bold; 
}
.w_str a{

 color:#333333;
 text-decoration:none;
}
div.w_date{
line-height:1.2em;
font-size:0.6em;
color:#999;
}
div.w_pic{
float:right;
 padding-right:1em;
}
 </style>





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
		if ($ad_street==""){$ad_street="Улица не указана";};
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
 

 
 
 <div class="w_ad">

<div class="w_pic">
<a href="<?=$ad_url;?>">
 <img src="<?=$ad_mainpic;?>" title="<?=$ad_imgtitle;?>" alt="<?=$ad_imgalt;?>" width=36 height=36>
 </a>
</div>

<div class="w_date">
<span class="w_rubr">Сдаю квартиру</span> | <span class="w_date">  <?=$ad_postdate;?></span>
</div>


<span class="w_str"><a href="<?=$ad_url;?>">

<?=$ad_street;?> <? if (is_numeric($ad_dom)){ ?>, <?=$ad_dom;?>
<?}?> 
<? if (is_numeric($ad_korpus) ){ ?>, корп. <?=$ad_korpus;?>
<?}?> 

</a></span> <br>
<span class="w_kom"><?=$ad_komnat_txt;?></span> | <span class="w_price"><?=$ad_price;?><?=$ad_currency?></span>   
<p>isagent=<?=$ad_isagent;?></p> 
<p><?=$ad_message;?></p>  
<p><?=$ad_phones?></p> 
<p><?=$ad_email?></p> 
<?  if ($mlev==4){?>
<br>
 <div class="pdelete"> <a rel=”nofollow” href="http://neagent.by/realt/ad_delete/<?=$ad_id;?>">удалить</a></div>
  <div class="pdelete"> <a rel=”nofollow” href="http://neagent.by/realt/ad_mark_as_agent/<?=$ad_id;?>">{agent}</a></div>
		<?  if ($ad_pending==1){?>
		<div class="pdelete"> <a href="http://neagent.by/realt/ad_approve/<?=$ad_id;?>">допустить</a></div>
 		<?  }?>

<div class="pdelete"> <a href="ad_delete.asp?id=<?=$ad_id;?>">kill</a></div>
<?
 $clearEmail = str_replace("[?]", "", $ad_email);
 ?>
 
  
<div class="ptoBL"> <a href="http://neagent.by/realt/addToBlacklist/<?=$ad_phones;?>/<?=$clearEmail;?>/?id=<?=$ad_id;?>">0blackl.</a></div>

<div class="ptoBL"> <a href="<?=$ad_cref;?>">cref1</a></div>

<div class="ptoBL"> <a href="">в ...</a></div>
<div style="display:block; position:relative;  width:35px;">
<SELECT id="cat"  name="cat"  style="width:35px;" onchange="to_rubric(this, <?=$ad_id;?>);"  >
<OPTION value="0" >-выберите рубрику-</OPTION>
<?=$cstr ?>
</SELECT>
</div>
 
 
 <? }?>












</div>



 
 


