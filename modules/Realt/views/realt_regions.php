



<div class="region">
<div class="h2">Выберите город:</div>
<div style='float:left;'>
<table  cellpadding = 20 ><tr><td  >

					 <? 
					 
					 
					 
					 for ($i = 0; $i < (count($regions)); $i++) {
                     $region = $regions[$i];
 
					 
					 if ($i==3){
					 echo("</td></tr></table></div><div style='float:left;'><table  cellpadding = 20 ><tr><td  >");
					 }
					 else{
					 echo("</td><td >");
					 }
 
					 $uri[$i]= ($uri[$i]=='minsk')?"": "board/" .$uri[$i];
					 ?>
                		
						<ul style="padding:5px;">
                        <li><div class=""></div><a href="http://neagent.by/<?=$uri[$i]?>" ><b><?=$names[$i]?></b></a>&nbsp;<small style="color:grey; font-size:13px;">(<?=$count[$i]?>)</small></li>
						<li><div class=""></div> <small style="color:grey; font-size:13px;">Область: </small> </li>
						<?
						for ($k = 1; $k < (count($region)); $k++) { 
						$ind=$index[$region[$k]];
						?>
						
						
						<?  if ($k==0){ ?>
						<li><div class=""></div><a href="http://neagent.by/"><?=$names[$ind]?></a></li>
						<?}else{?>
						<li><div class=""></div><a href="http://neagent.by/board/<?=$uri[$ind]?>"><?=$names[$ind]?></a>&nbsp;<small style="color:grey; font-size:13px;">(<?=$count[$ind]?>)</small></li>
						<? }}?>
						</ul> <br><br>
					<? }?>
</td></tr></table></div><div style="clear:both;"></div>
</div>