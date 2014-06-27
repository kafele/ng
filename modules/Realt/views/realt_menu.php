
<?


  


?>


<div id = "rightmenu">
<ul><li class='mainitem'>
<a href='<?= $base_url; ?>kvartira/snyat' class='menuitem1'  onClick='shiftSubDiv(1); return false;'>Квартиры</a>
<ul id="subDiv1" style="display:none"> <li class='subitem' >
<span class='sdam'><a href='<?= $base_url; ?>kvartira/snyat' class='subitem1' title="Снять квартиру">Снять</a> </span>
<span class='sdam'><a href='<?= $base_url; ?>kvartira/sdat' class='subitem2' title="Сдать квартиру">Сдать</a> </span>
 
<span class='sdam'> <a href='<?= $base_url; ?>kvartira/na-sutki' title="Квартиры на сутки" class='subitem5'>Квартиры на сутки</a> </span>

<span class='sdam'><a href='<?= $base_url; ?>kvartira/kupit' class='subitem5 new' title="Купить квартиру">Купить</a> </span>
<span class='sdam'><a href='<?= $base_url; ?>kvartira/prodat' class='subitem5 new' title="Продать квартиру">Продать</a> </span>
</li></ul></li>

<li class='mainitem'>
<a href='<?= $base_url; ?>komnata/snyat' class='menuitem2'  onClick='shiftSubDiv(2); return false;'> Комнаты</a><ul id="subDiv2" style="display:none"> <li class='subitem' ><span class='sdam'> 
<a href='<?= $base_url; ?>komnata/snyat' class='subitem1' title="Снять комнату">Снять </a> </span><span class='sdam'> 
<a href='<?= $base_url; ?>komnata/sdat' class='subitem2' title="Сдать комнату">Сдать</a> </span>
<span class='sdam'> <a href='<?= $base_url; ?>komnata/podselenie' class='subitem3'>Возьму на подселение</a> </span>
<span class='sdam'> <a href='<?= $base_url; ?>komnata/podselus' class='subitem4'>Подселюсь</a> </span>
</li></ul></li>

<li class='mainitem'>
<a href='<?= $base_url; ?>dom/snyat' class='menuitem3'  onClick='shiftSubDiv(3); return false;'> Дома, коттеджи</a><ul id="subDiv3" style="display:none"> <li class='subitem' ><span class='sdam'> 
<a href='<?= $base_url; ?>dom/snyat' class='subitem1'>Снять</a></span>
<span class='sdam'> <a href='<?= $base_url; ?>dom/sdat' class='subitem2'>Сдать</a> </span>
<span class='sdam'> <a href='<?= $base_url; ?>dom/na-sutki' class='subitem5'>Снять на сутки</a> </span>
</li></ul></li>

<li class='mainitem'>
<a href='<?= $base_url; ?>office/snyat' class='menuitem4'  onClick='shiftSubDiv(4); return false;'> Офисы</a><ul id="subDiv4" style="display:none"> <li class='subitem' ><span class='sdam'> 
<a href='<?= $base_url; ?>office/snyat' class='subitem1'>Снять</a> </span><span class='sdam'> 
<a href='<?= $base_url; ?>office/sdat' class='subitem2'>Сдать</a> </span></li></ul></li></ul>	
</div>
<!-- end  right menu -->

<script>
var currelm=1;
function shiftSubDiv(n)
// Скрывает/раскрывает подразделы меню с ID вида subDiv1, subDiv2 и т.д.
// Номер подраздела передается в качестве аргумента.
{
var elm="";
  if (currelm != n) {
   elm = document.getElementById('subDiv'+currelm);
   elm.style.display = 'none';
  }
    elm = document.getElementById('subDiv'+n);
    elm.style.display = 'block'
	currelm=n;
};
<?=$this->data['js_menu'];?>
</script>
<?	if  ($this->data['mlev']==4){ ?>
<script type="text/javascript" src="http://neagent.by/themes/neagent_style/views/default/modulargrid.js"></script>
<?	}?>