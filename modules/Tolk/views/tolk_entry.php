<div style="padding-top: 5px; padding-left:48px; height: 45px; background: #DFDFDF url(<?=$tolk_image_url;?>) no-repeat; background-position: 0 0; "> 
<span style="font-size:18px;"><?=$tolk_contactname;?></span>

<br> <small>



(Добавлено : <?=$tolk_postdate;?> )


<span style="color:red;"></span></small>





</small>
<!--
<small><a href="guestbook_delete.asp?id=1029">del</a>|<a href="guestbook_delete.asp?id=1029&hide=1">hide</a>
[<?=$gb_poster_ip;?>] [<?=$gb_poster_uid;?>]  </small> -->

 


</div>	
<div style=" margin-bottom:0px; padding-bottom:4px; border-bottom:0px solid  #015b9a;">
 <h2> <b style="color:green;"><?=$tolk_action?></b>:  <?=$tolk_title;?> 
 <? if (strlen($tolk_price)>0 && $tolk_price!=" " && $tolk_price!="0"){ ?>
 <span style="color:#38b347">Цена: <?=$tolk_price;?></span>
  <? }?>
 </h2> <?=$tolk_message;?>
<br>
<?=$tolk_phones;?>








<?
$tolk_cat = isset($tolk_cat)?$tolk_cat:0;


?>






<div style="width:100%;text-align:right;">
<form  style="width:auto; "  method="post" action="http://neagent.by/tolk-add-form" >
<input type="hidden" name="parent" value="<?=$tolk_message_id;?>">
<input type="hidden" name="cat" value="<?=$tolk_cat;?>">
<input type="Submit"   value="Написать ответ" class="button">
</form>
</div>




<?if ($mlev==4) {?>

<div style="width:100%;text-align:right;">
 <a href="http://neagent.by/tk/delete/<?=$tolk_message_id;?>">удалить </a>
</div>

<? }?>



 </div>