<!-- view: realt/views/realt_admin_addarea -->
Добавление районов 
  <div><form action="addareas" method="post">
  
  
  
<? if ($action!='defined'){?>  
<br>Город <br>
<select name="sity_id">
  
  
<option> </option>
<? for ($k = 0; $k < count($cityes_id); $k++)  { ?>  
<option value="<?=$cityes_id[$k];?>"><?=$cityes_name[$k]?></option>
<?} ?>
</select>
  
  <br>Тип данных <br>
  <select name="type_id">
  <option > </option>
  <option value="adm" >Адм. Район</option>
  <option value="mikro" >Микрорайоны</option>
  </select>
  

  <input type="hidden" name="action" value="defined">
  
   <input type="submit" value="Далее">
<?} ?>

  <? if ($action=='defined'){?>
  
  <input type="hidden" name="action" value="add">
  
  <input type="hidden" name="sity" value="<?=$sity;?>">
  Город <b><?=$sityname;?></b>
  <input type="hidden" name="type" value="<?=$type;?>">
  Тип <b><?=$typename;?></b>
  
  
  <br>Впишите районы, каждый с новой строки <br>
  <textarea style="width:400;height:300;" name="text"></textarea>
  <input type="submit" value="Добавить">
  <?} ?>
  
 
  
  </form></div>