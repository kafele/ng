<?php

/**
 * Modal window for Media metadata edition
 *
 */
?>

<!-- Media summary -->
<div style="overflow:auto;background:#f2f2f2;padding:10px;margin-bottom:10px;">

	<!-- Picture file -->
	<?php if($type == 'picture') :?>
		<?php
		 	$thumb_dir = (Settings::get('system_thumb_list')) ? Settings::get('system_thumb_list') : 'thumb';
		 ?>
		<img style="float:right;" src="<?=base_url().$base_path.$thumb_dir.'/'.$file_name ?>?t=<?=time()?>"/>
	<?php endif ;?>

	<!-- Music file -->
	<?php if($type == 'music') :?>
	<div style="float:right;">
		<embed src="<?=base_url()?>themes/admin/flash/mp3Player/mp3player_simple.swf?mp3=<?= base_url().$path ?>" loop="false" menu="false" quality="high" wmode="transparent" width="224" height="20" name="track_<?= $id_media ?>" align="middle" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</div>
	<?php endif ;?>
	
	<!-- Video file -->
	<?php if($type == 'video') :?>
	
		<div style="float:right;"  id="video<?= $id_media ?>"></div>
	
		<script type="text/javascript">
			
			var s1 = new SWFObject('<?=base_url()?>themes/admin/flash/mediaplayer/player.swf','player','170','145','9');
			s1.addParam('allowfullscreen','true');
			s1.addParam('allowscriptaccess','always');
			
			s1.addParam('flashvars','file=<?=base_url().$path?>');
			
			s1.write('video<?= $id_media ?>');
			
		</script>

		<h3><?= lang('ionize_title_informations') ?></h3>
		
		<!-- 
		<embed src="<?=base_url()?>themes/admin/flash/videoPlayer/videoPlayer.swf?flv=<?=base_url().$path?>&autostart=false" loop="false" menu="false" quality="high" wmode="transparent" width="320" height="270" id="video_<?= $id_media ?>" name="video_<?= $id_media ?>" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
		-->
	<?php endif ;?>
	

	<!-- Picture file -->
	<?php if($type == 'picture') :?>

		<h3><?= lang('ionize_title_thumbs_status') ?></h3>
		
		<!-- Thumbs status -->
		<dl>
			<?php foreach($thumbs as $thumb) :?>

				<?php
				
					$size = split(',', $thumb['content']);
					$size = $size[1];
				
				?>

				<dt class="small">
					<label><?=substr($thumb['name'], strpos($thumb['name'], '_') + 1) ?> : <?= $size ?></label>
				</dt>
				<dd>
					<?php if (file_exists($this->config->item('base_path').'/'.$base_path.$thumb['name'].'/'.$file_name)) :?>
						<img src="<?= base_url() ?>/themes/admin/images/icon_16_ok.png" />
					<?php else: ?>
						<img src="<?= base_url() ?>/themes/admin/images/icon_16_delete.png" />
					<?php endif; ?>
				</dd>
	
			<?php endforeach ;?>
		</dl>

	<?php endif ;?>

	<!-- File size in ko -->
	<dl>
		<dt class="small">
			<label><?= lang('ionize_label_file_size') ?></label>
		</dt>
		<dd>
			<?php if (file_exists($path)) :?>
				<?php echo sprintf('%01.2f', filesize($path) / (1024 )) ?> ko
			<?php else :?>
				<?php echo(lang('ionize_exception_no_source_file')) ;?>
			<?php endif ;?>
		
			<?php if($type == 'picture') :?>
				 - 
				<?php if ($d = @getimagesize($path)) :?>
					<?php echo($d['0']) ?>x<?php echo($d['1']) ?>
				<?php endif ;?>
			<?php endif ;?>
		</dd>		
	
	</dl>
	
</div>


<!-- Media form -->
<form name="mediaForm<?= $id_media ?>" id="mediaForm<?= $id_media ?>" action="<?= base_url() ?>admin/media/save">

	<input type="hidden" name="id_media" value="<?= $id_media ?>" />
	<input type="hidden" name="type" value="<?= $type ?>" />
	
	<!-- Copyright -->
	<dl>
		<dt class="small">
			<label for="copyright"><?=lang('ionize_label_copyright')?></label>
		</dt>
		<dd>
			<input id="copyright_<?= $type.$id_media ?>" name="copyright" class="inputtext" type="text" value="<?= $copyright ?>" />
		</dd>
	</dl>

	<!-- Link (URL) -->
	<dl>
		<dt class="small">
			<label for="link"><?=lang('ionize_label_link')?></label>
		</dt>
		<dd>
			<input id="link_<?= $type.$id_media ?>" name="link" type="text" class="inputtext w200" value="<?= $link ?>" />
			<img class="inputicon" src="<?=base_url()?>themes/admin/images/icon_16_clear_field.png" onclick="javascript:clearField('link_<?= $type.$id_media ?>');"/>
		</dd>
	</dl>

	<!-- Date -->
	<dl>
		<dt class="small">
			<label for="date_<?= $type.$id_media ?>"><?=lang('ionize_label_date')?></label>
		</dt>
		<dd>
			<input id="date_<?= $type.$id_media ?>" name="date" type="text" class="inputtext w120 date" value="<?= getFrenchDatetime($date) ?>" />
		</dd>
	</dl>

	<!-- extend fields goes here... -->
	<?php if (Settings::get('use_extend_fields') == '1') :?>
		<?php foreach($extend_fields as $extend_field) :?>
		
			<?php if ($extend_field['translated'] != '1') :?>
			
				<dl>
					<dt class="small">
						<label for="cf_<?= $extend_field['id_extend_field'] ?>" title="<?= $extend_field['description'] ?>"><?= $extend_field['label'] ?></label>
					</dt>
					<dd>
						<?php
							$extend_field['content'] = ($extend_field['content'] != '') ? $extend_field['content'] : $extend_field['default_value'];
						?>
					
						<?php if ($extend_field['type'] == '1') :?>
							<input id="cf_<?= $extend_field['id_extend_field'] ?>" class="inputtext w200" type="text" name="cf_<?= $extend_field['id_extend_field'] ?>" value="<?= $extend_field['content']  ?>" />
						<?php endif ;?>
						
						<?php if ($extend_field['type'] == '2' OR $extend_field['type'] == '3') :?>
							<textarea id="cf_<?= $extend_field['id_extend_field'] ?>" class="<?php if($extend_field['type'] == '3'):?> tinyTextarea <?php endif ;?> inputtext w340 h80" name="cf_<?= $extend_field['id_extend_field'] ?>"><?= $extend_field['content'] ?></textarea>
						<?php endif ;?>
						
						<!-- Checkbox -->
						<?php if ($extend_field['type'] == '4') :?>
							
							<?php
								$pos = 		explode("\n", $extend_field['value']);
								$saved = 	explode(',', $extend_field['content']);
							?>
							<?php
								$i = 0; 
								foreach($pos as $values)
								{
									$vl = explode(':', $values);
									$key = $vl[0];
									$value = (!empty($vl[1])) ? $vl[1] : $vl[0];

									?>
									<input type="checkbox" id= "cf_<?= $extend_field['id_extend_field'].$i ?>" name="cf_<?= $extend_field['id_extend_field'] ?>[]" value="<?= $key ?>" <?php if (in_array($key, $saved)) :?>checked="checked" <?php endif ;?>><label for="cf_<?= $extend_field['id_extend_field'] . $i ?>"><?= $value ?></label></input><br/>
									<?php
									$i++;
								}
							?>
						<?php endif ;?>
						
						<!-- Radio -->
						<?php if ($extend_field['type'] == '5') :?>
							
							<?php
								$pos = explode("\n", $extend_field['value']);
							?>
							<?php
								$i = 0; 
								foreach($pos as $values)
								{
									$vl = explode(':', $values);
									$key = $vl[0];
									$value = (!empty($vl[1])) ? $vl[1] : $vl[0];

									?>
									<input type="radio" id= "cf_<?= $extend_field['id_extend_field'].$i ?>" name="cf_<?= $extend_field['id_extend_field'] ?>" value="<?= $key ?>" <?php if ($extend_field['content'] == $key) :?> checked="checked" <?php endif ;?>><label for="cf_<?= $extend_field['id_extend_field'] . $i ?>"><?= $value ?></label></input><br/>
									<?php
									$i++;
								}
							?>
						<?php endif ;?>
						
						<!-- Selectbox -->
						<?php if ($extend_field['type'] == '6' && !empty($extend_field['value'])) :?>
							
							<?php									
								$pos = explode("\n", $extend_field['value']);
								$saved = 	explode(',', $extend_field['content']);
							?>
							<select name="cf_<?= $extend_field['id_extend_field']?>">
							<?php
								$i = 0; 
								foreach($pos as $values)
								{
									$vl = explode(':', $values);
									$key = $vl[0];
									$value = (!empty($vl[1])) ? $vl[1] : $vl[0];
									?>
									<option value="<?= $key ?>" <?php if (in_array($key, $saved)) :?> selected="selected" <?php endif ;?>><?= $value ?></option>
									<?php
									$i++;
								}
							?>
							</select>
						<?php endif ;?>
						
						
						<!-- Date & Time -->
						<?php if ($extend_field['type'] == '7') :?>
						
							<input id="cf_<?= $extend_field['id_extend_field'] ?>" class="inputtext w120 date" type="text" name="cf_<?= $extend_field['id_extend_field'] ?>" value="<?= $extend_field['content']  ?>" />
							
						<?php endif ;?>
						
					</dd>
				</dl>	
					
			<?php endif ;?>
		<?php endforeach ;?>
	<?php endif ;?>



	<!-- Lang data -->
	<fieldset id="picture-lang">
		
		<!-- Tabs -->
		<div class="tab">
			<ul class="tab-content">
				
				<?php foreach(Settings::get_languages() as $language) :?>
					<li id="tab-media<?= $id_media ?><?= $language['lang'] ?>"><a><span>Text : <?= ucfirst($language['name']) ?></span></a></li>
				<?php endforeach ;?>
			</ul>
		</div>
		
		<!-- Text block -->
		<?php foreach(Settings::get_languages() as $language) :?>

			<?php $lang = $language['lang']; ?>
			
			<div id="block-media<?= $id_media ?><?= $lang ?>" class="block media<?= $id_media ?>lang">

				<!-- title -->
				<dl>
					<dt class="small">
						<label for="title_<?= $lang ?><?= $type.$id_media ?>"><?= lang('ionize_label_title') ?></label>
					</dt>
					<dd>
						<input id="title_<?= $lang ?><?= $type.$id_media ?>" name="title_<?= $lang ?>" class="inputtext w200" type="text" value="<?= ${$lang}['title'] ?>"/>
						<img class="inputicon" src="<?= base_url() ?>themes/admin/images/icon_16_clear_field.png"  onclick="javascript:clearField('title_<?= $lang ?><?= $type.$id_media ?>');"/>
					</dd>
				</dl>
		
				<!-- alternative text -->
				<dl>
					<dt class="small">
						<label for="alt_<?= $lang ?><?= $type.$id_media ?>"><?= lang('ionize_label_alt') ?></label>
					</dt>
					<dd>
						<input id="alt_<?= $lang ?><?= $type.$id_media ?>" name="alt_<?= $lang ?>" class="inputtext w200" type="text" value="<?= ${$lang}['alt'] ?>"/>
						<img class="inputicon" src="<?= base_url() ?>themes/admin/images/icon_16_clear_field.png"  onclick="javascript:clearField('alt_<?= $lang ?><?= $type.$id_media ?>');"/>
					</dd>
				</dl>
		
				<!-- description -->
				<dl>
					<dt class="small">
						<label for="description_<?= $lang ?><?= $type.$id_media ?>"><?= lang('ionize_label_description') ?></label>
					</dt>
					<dd>
						<input id="description_<?= $lang ?><?= $type.$id_media ?>" name="description_<?= $lang ?>" class="inputtext w200" type="text" value="<?= ${$lang}['description'] ?>"/>
						<img class="inputicon" src="<?= base_url() ?>themes/admin/images/icon_16_clear_field.png"  onclick="javascript:clearField('description_<?= $lang ?><?= $type.$id_media ?>');"/>
					</dd>
				</dl>
			</div>

			<!-- extend fields goes here... -->
			<?php if (Settings::get('use_extend_fields') == '1') :?>
				<?php foreach($extend_fields as $extend_field) :?>
					<?php if ($extend_field['translated'] == '1') :?>
					
						<dl>
							<dt class="small">
								<label for="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang ?>" title="<?= $extend_field['description'] ?>"><?= $extend_field['label'] ?></label>
							</dt>
							<dd>
								<?php if ($extend_field['type'] == '1') :?>
									<input id="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang ?>" class="inputtext w340" type="text" name="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang ?>" value="<?= $extend_field[$lang]['content'] ?>" />
								<?php endif ;?>
								<?php if ($extend_field['type'] == '2' || $extend_field['type'] == '3') :?>
									<textarea id="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang ?>" class="inputtext w340 h80" name="cf_<?= $extend_field['id_extend_field'] ?>_<?= $lang ?>"><?= $extend_field[$lang]['content'] ?></textarea>
								<?php endif ;?>
							</dd>
						</dl>	
							
					<?php endif ;?>
				<?php endforeach ;?>
			<?php endif ;?>
			
		<?php endforeach ;?>
		
	</fieldset>


</form>

<div class="buttons">
	<button id="bSave<?= $type.$id_media ?>" type="button" class="button yes right"><?= lang('ionize_button_save_close') ?></button>
	<button id="bCancel<?= $type.$id_media ?>"  type="button" class="button no "><?= lang('ionize_button_cancel') ?></button>
</div>


<script type="text/javascript">

	/** 
	 * Calendars
	 *
	 */
	datePicker.attach();

	/** 
	 * Show current tabs
	 */
 	displayBlock('.media<?= $id_media ?>lang', 'media<?= $id_media.Settings::get_lang('first') ?>');

	/** 
	 * Add events to tabs
	 * - Lang Tab Events 
	 */
	<?php foreach(Settings::get_languages() as $lang) :?>
		$('tab-media<?= $id_media ?><?= $lang["lang"] ?>').addEvent('click', function(){ displayBlock('.media<?= $id_media ?>lang', 'media<?= $id_media ?><?= $lang["lang"] ?>'); });
	<?php endforeach ;?>

</script>
