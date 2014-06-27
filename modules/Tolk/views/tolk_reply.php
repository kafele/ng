

<div style="<?if ($firstReply==1){?>border-top:1px dotted #015b9a;<?}?>  padding-top: 5px; padding-left:68px; height: 1px; "> 

<!--
<small><a href="guestbook_delete.asp?id=1029">del</a>|<a href="guestbook_delete.asp?id=1029&hide=1">hide</a>
[<?=$tolk_r_poster_ip;?>] [<?=$tolk_poster_uid;?>]  </small> -->

 

</div>	

<div style="margin-bottom:5px; color:#333; padding-left:20px; padding-bottom:12px; border-bottom:1px <?if ($lastReply==1){?>solid<?}else{?>dotted<?}?>  #015b9a;">
<b> <?=$tolk_r_contactname;?>: </b><?=$tolk_r_message;?>


<!--
<div style="width:100%;text-align:right;">
<form  style="width:auto; "  method="post" action="guestbook-add-form"    >
<input type="hidden" name="parent" value="<?=$tolk_r_message_id;?>">
<input type="hidden" name="cat" value="<?=$tolk_r_cat;?>">
<input type="Submit"   value="Ответить" class="button">
</form>
</div>
-->





 </div>