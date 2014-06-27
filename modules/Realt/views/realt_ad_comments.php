<!-- view: realt/views/realt_ad_comments -->

<?

?>



<script type="text/javascript">
		$(document).ready(function() {
			/*
			*   Examples - images
			*/

$('#cm_options').show();



			$("#ad_comm").fancybox({
				'width'				: 300,
				'height'			: 200,
				'autoScale'			: false,
				'overlayColor'		: '#000',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			
			
		});
	</script>
	
	
 <div id="cm_options" style="display:none;">
	 <a id="ad_comm" href="http://neagent.by/realt/ad_comment/<?=$ad_id;?>" class="options_link">Оставить комментарий </a>
	<div style="border:1px solid grey; margin:9px; padding:9px;"> 
	<h2>Вы не поверите!</h2>В связи с тем, что автор объявления оставил свой телефон, вероятно самый удобный способ снять квартиру  - это позвонить ему.<br>
 Несмотря на это, вы можете оставить свой номер телефона, его обязательно увидят  такие же соискатели как вы. Автор объявления 
принимает  звонки  от желающих, и ваши комментарии читать скорее всего НЕ БУДЕТ. Уведомления о комментарии автору не отправляются.
<br><i>neagent.by</i>
	
	</div>
	 
	 
<br>  
</div>
	 
	 
	<?
	
	$ad_comments = isset($ad_comments)?$ad_comments:array();
	
   if (count($ad_comments)>0){
   ?>
   <h2>Комментарии к объявлению </h2>
<?for ($i = 0; $i < count($ad_comments); $i++) {  ?> 
	<div class="ad_comment">
	<div class="comment_id">#<?=$ad_comments[$i]['id'];?> <a href="http://neagent.by/board/userads/<?=$ad_comments[$i]['comment_user'];?>">?</a></div>
	 <div class="comment_date"><?=$ad_comments[$i]['date'];?></div>
	 <b><?=$ad_comments[$i]['screen_name'];?></b><? if ($ad_comments[$i]['isautor']==1) { ?><span style="color:red">(автор)</span> <?}  ?><br>
	 <div class="comment_text"><?=$ad_comments[$i]['text'];?></div>
	 
	 
	 
	<? if ($mlev==4){ ?> 
	<? if ($ad_comments[$i]['show']==0){ ?>
	<br>
	СКРЫТ
	<br>
	<?  } ?>
	
<a href="http://neagent.by/realt/comment_delete/<?=$ad_comments[$i]['id'];?>"> Удалить</a>	
	 <?  } ?>
	 </div>
	 
	 
	<? } } ?>
	 
	 
	<!-- 
		<div>
	<form  action = "" >
	<h3>Написать комментарий </h3> 
 
	<input type="hidden" name="ad_id" value="<?=$ad_id;?>">
	  <textarea name="comment"> </textarea><br>
	<input type="submit" value="Отправить комментарий">
	

	</form>
	</div>
	
	-->