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
