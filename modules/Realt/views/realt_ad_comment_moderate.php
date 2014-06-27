<!-- view: realt/views/realt_ad_comments --><?

?>

	<div class="ad_comment" style="border-bottom:1px solid grey; padding:4px;" id="comment_<?=$comment_id;?>">
<?	
	// <div class="comment_id">#<?=$comment_id;? > <a href="http://neagent.by/board/userads/<?=$comment_user;? >">?</a></div>
?>	
	 
	 
	 <div class="comment_text">
	 
	 <b><?=$ad_comments[$i]['screen_name'];?></b><? if ($ad_comments[$i]['isautor']==1) { ?><span style="color:red">(автор)</span> <?}  ?> 
	 
	 <?=$comment_text;?> &nbsp; <small style="color:grey; font-size:0.7em;"><?=$comment_date;?></small></div> 
	 
	 
	 
	<? if ($mlev==4){ ?> 
	<? if ($comment_show==0){ ?>
	<br>
	СКРЫТ
	<br>
	<?  } ?>
<a href="http://neagent.by/wap/adid/<?=$comment_ad;?>"> Перейти</a>		
<a href="http://neagent.by/realt/comment_delete/<?=$comment_id;?>"> Удалить</a>
<a href="#"   onclick="selectitem(<?=$comment_id;?>);  return false;"> На удаление</a>		
<a href="http://neagent.by/realt/comment_approve/<?=$comment_id;?>"> Допустить</a>
<a href="http://neagent.by/realt/user_tomoderate/<?=$comment_user;?>"> Юзера на модерацию</a>	
	 <?  } ?>
	 </div>