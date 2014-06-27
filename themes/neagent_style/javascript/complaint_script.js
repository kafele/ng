function getOffset(elem) { 
 if (elem.getBoundingClientRect) { 
 // "правильный" вариант 
 return getOffsetRect(elem) 
 } else { 
 // пусть работает хоть как-то 
 return getOffsetSum(elem) 
 } 
} 
  
function getOffsetSum(elem) { 
 var top=0, left=0 
 while(elem) { 
 top = top + parseInt(elem.offsetTop) 
 left = left + parseInt(elem.offsetLeft) 
 elem = elem.offsetParent 
 } 
  
 return {top: top, left: left} 
} 
  
function getOffsetRect(elem) { 
 // (1) 
 var box = elem.getBoundingClientRect() 
  
 // (2) 
 var body = document.body 
 var docElem = document.documentElement 
  
 // (3) 
 var scrollTop = window.pageYOffset || docElem.scrollTop || body.scrollTop 
 var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft 
  
 // (4) 
 var clientTop = docElem.clientTop || body.clientTop || 0 
 var clientLeft = docElem.clientLeft || body.clientLeft || 0 
  
 // (5) 
 var top = box.top + scrollTop - clientTop 
 var left = box.left + scrollLeft - clientLeft 
  
 return { top: Math.round(top), left: Math.round(left) } 
} 











function absPosition(obj) { // Опрелеляем top - left координаты блока obj
    var ox = 0;
    var oy = 0;
    while( obj ) {
        ox += obj.offsetLeft;
        oy += obj.offsetTop;
        //  В некоторых случаях почему-то для элемента на странице отсутствует офсет
        if ( obj.offsetParent == null ) {
		
           obj = obj.nodeName == 'BODY' ?  null : obj.parentNode;
        }

        if ( obj!=null ) obj = obj.offsetParent;
    }
  return {
  x:ox,y:oy
  };
}

function showComplaintReason(_link) {
 //alert (1);

 shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\"   onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div>\
<div class=\"ng-popup__header\">Пожаловаться</div>\
  <form name='complaintForm' action=\"" + _link.href.replace('action=abuse', 'action=abuselist') + "\" onsubmit='if (document.getElementById(\"spamtextArea\").value != \"---\") {return sendComplaint(\"" + _link.id + "\");} else {alert(\"Укажите причину жалобы!\");return false;}'>\
   <input type=\"hidden\" name=\"aid\"  value=\""+ _link.id+ "\">\
     <div class=\"ng-popup__field__label\">Причина жалобы (желательно):</div>\
	 <textarea name=\"report\" rows=3 style='width:210px; height:60px; margin: 7px 0; font-size: 12px; font-family: Arial;' id='spamtextArea'> </textarea><br>\
	<input type=\"checkbox\"  name=\"complaint\"  value=\"2\">Это объявление агента?\
   	<div class=\"ng-popup__field__label\">Отметьте галочкой, если это агент, и если сможете, спросите, из какого агентства этот врун.</div>\
   <input type=submit id=butForSpam value='Пожаловаться' style='';>\
  </form>\
    ", _link);
    document.getElementById("spamtextArea").focus();
    return false;
}

function sendComplaint(id) { 

    _link = document.getElementById(id);
    var url = "http://neagent.by/realt/complaint/";
	// alert(_link);
	  //return false;
	//cp=document.forms["complaintForm"].elements[1].value;
	
	//cp= $("input[name='complaint'][checked]").val();
	//cp=$('input:checked[name=complaint]').val() ;
	cp=$('input:checked[name=complaint]').val() ;
    //alert(cp);
	  //return false;
    var params = cutParams(_link.href) +'&complaint=' + cp +  '&report=' + document.getElementById("spamtextArea").value +  '&ajax=1';
    //alert(params);
	var method = "POST";
    var onload = reportResult;
    var contentType = "application/x-www-form-urlencoded; charset=utf-8";
    shawDivDialog("Идет обработка запроса", _link);
	//alert(url);
	 
     return setAjaxRequest(method, url, params, onload, false, contentType, false, _link);
}

function reportResult() {
    var obj, doc, docRes, errorCode, error;
	   //alert("76");
	   //alert (this.req);
    //obj = eval("(" + this.req.responseText + ")");
	
	//alert  (this.req.responseXML);
	//ert=this.req.responseXML.getElementsByTagName('error')[0].nodeValue;
	
	  xmlResponse = this.req.responseXML;
	  //  alert ('xmlResponse = '+ xmlResponse);
      xmlRoot = xmlResponse.documentElement;
	  // alert ('xmlRoot ='+ xmlRoot.getElementsByTagName("error")[0].childNodes[0].nodeValue);
	 
	 if (xmlRoot==null){
	     
	    error = 'Ошибка сервиса. Если она будет повторяться, сообщите модератору';
	    error_code = 2;
		 //alert("errabusealreadyerrabusealready");
		shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"red\">" + error + "</span></div>");
   
		 
	   return;
	}
	
	if (xmlRoot.getElementsByTagName("error")[0]) {
      resp = xmlRoot.getElementsByTagName("error")[0].childNodes[0].nodeValue;
	}
	else
	{
	resp ="errabusenotfound2"
	}
	
	
	// alert ( "resp=" +resp);
	
	//'ert=this.req.responseXML.getElementsByTagName('error')[0].data;
	
	//obj = this.req.responseXML.getElementsByTagName('error');
	//objl = eval('(' + this.req.responseText + ')');
	//objl =  this.req.responseText ;
//alert ( this.req.responseText);
    switch (  resp ){
	case 'errabusealready':{
	    error = 'Вы уже жаловались по этому поводу';
	    error_code = 2;
		//alert("errabusealreadyerrabusealready");
	    break;
	}
	case 'errabusenotfound':{
	    error = 'Жалоба не принята. Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	case 'errabusenotfound2':{
	    error = 'Жалоба не принята - Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	case 'errabusenotselected':{
	    error = 'Вы не указали причину жалобы. Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	
	
	
	case 'okspam':{
	//spam - delete add
	    error = 'Спасибо, ваша жалоба принята. <br>Объявление будет удалено.';
	    error_code = 0;
	    break;
	}
	case 'errabuselimit':{
	    error = 'Вы временно не можете отправить жалобу. Попробуйте сделать это через минуту.';
	    error_code = 2;
	    break;
	}
	case 'erruserbanned':{
	    error = 'Вам закрыт доступ на проект';
	    error_code = 2;
	    break;
	}
	case 'okabuse':{
	    error = 'Ваша жалоба будет рассмотрена в ближайшее время';
	    error_code = 0;
	    break;
	}
	case 'errusrnotfound':{
	    error = 'Пользователь не найден';
	    error_code = 2;
	    break;
	}
	case 'errusrwasbanned':{
	    error = 'Пользователь забанен и уже находится под наблюдением Администрации';
	    error_code = 2;
	    break;
	}
	case 'errmoddenied':{
	    error = '<b>Доступ запрещен</b>. <br>У вас нет прав на выполнение этого действия';
	    error_code = 2;
	    break;
	}
	case 'errmodlimit':{
	    error = 'Вы временно не можете принимать участие в модерировании проекта';
	    error_code = 2;
	    break;
	}
	default:{
	    error = 'При обработке запроса произошла ошибка<br>Попробуйте повторить еще раз';
//      document.write( '<textarea>' + this.req.responseText + '</textarea>' );
	    error_code = 1;
	    break;
	}
    }

    if ( error_code > 0 ) {
	shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"red\">" + error + "</span></div>");
    }else {
	shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"green\">" + error + "</span></div>");
    }
    //  Если ошибки фатальные или жалоба принята, прячем ссылку
    if ( error_code==0 || error_code> 1 ) {
    	requestsHash[this.hashKey + 1].style.display = "none";
    }    
}



// ========== BEGIN: reiting ===========================





                                                                            // ========== BEGIN: reiting ===========================



function cutParams(allUrl) {
  var params = allUrl.substring(allUrl.indexOf("?") + 1, allUrl.length);
  params = params.replace('action=abuse', 'action=authabuse');
  return params;
}


function shawDivDialog(html, _basis, _x, _y) {
 //alert("div");
  var div = document.getElementById("spam_dial");
    //alert(div);
  div.innerHTML = html;
  
   if (typeof _basis != 'undefined'){
  if (_basis) {
  
  
//var elm = document.getElementById('testid'); 
var coords = getOffset(_basis); 
//alert('left='+coords.left+', top='+coords.top); 
var _top = coords.top + (_y ? _y : 0);
var _left = coords.left + (_x ? _x : 0);
  
  
  
    //var _top = absPosition(_basis).y + (_y ? _y : 0);
   // var _left = absPosition(_basis).x + (_x ? _x : 0);
   
	//alert ((_basis).y);
	//alert (absPosition(_basis).y);
	
	
  }
  }
  else{
  //div.style.top = 100 + "px";
  //div.style.left = 100 + "px";

  }
  
  
  
  if (typeof _top != 'undefined') div.style.top = _top + "px";
  if (typeof _left != 'undefined') div.style.left = _left + "px";
 
 //alert(div.style.top);
  //alert(div.style.left);
div.style.display = "";
 div.style.display = "block";
 // div.style.zIndex = "300";
 
 return false;
}

function hideDivDialog() {
if (document.getElementById("spam_dial")){
  document.getElementById("spam_dial").style.display = "none";
 } 
}


function showThanksDialog(_link, aid, nick) {
    shawDivDialog("<div class=\"right mt5\"><a onclick=\"hideDivDialog(); return false;\" href=\"#\"><img src=\"/img/close_help.gif\" width=\"7\" height=\"7\" alt=\"Закрыть\" /></a></div>\
    Если Вы хотите поблагодарить пользователя <b>" + nick + "</b> за полезный ответ, отправьте SMS с кодом 22+" + aid + 
    " на короткий номер 7099.\
    Пользователь получит Ваше &laquo;спасибо&raquo; и 50 баллов на счет.\
    <br>Стоимость услуги:<br>\
    для России &mdash; $0.99 без НДС;<br>\
    для Украины &mdash; 6 грн. с НДС.\
    <br><br>\
    <a href='/thanks/" + aid + "/'>Узнать больше</a>\
    ", _link);
    return false;
}

function showIntrVote(_link, qid) {
    var url = "realt/complaint";
    var params = 'action=xml_getintrvote&qid=' + qid;
    var method = "POST";
    var onload = reportIntrVoteResult;
    var onerror = errorReit;
    shawDivDialog('Идет обработка запроса', _link);
    _link.style.display = "none";
    return setAjaxRequest(method, url, params, onload, onerror, false, false, _link);
}


function reportIntrVoteResult() {
    var html = "";
    var email = "";
    var xml  = this.req.responseXML ? this.req.responseXML : 0;
    if ( xml ){
        var length = xml.getElementsByTagName('usr').length;
        if ( length ){
            for ( i=0; i<length; i++){
                email   =  xml.getElementsByTagName('email').item(i).firstChild.nodeValue; 
                html    += "<div class=\"mb5\"><img src=\"/img/"
                        + ( xml.getElementsByTagName('vote').item(i).firstChild.nodeValue==1 ? 'ico_pos' : 'ico_neg' )
                        + ".gif\" class=\"mr3\"  /> <a href='http://www.mail.ru/agent?message&to="
                        + email + "'><img width=13 height=13 src='http://status.mail.ru/?"
                        + email + "'></a> <a href='/"+ xml.getElementsByTagName('domain').item(i).firstChild.nodeValue   
                        + "/" +  xml.getElementsByTagName('name').item(i).firstChild.nodeValue  + "/'>"
                        + xml.getElementsByTagName('nick').item(i).firstChild.nodeValue + "</a></div>";
            }
            document.getElementById('interes_who').innerHTML = html;
            document.getElementById('interes_div').style.display = 'block';
        }
    }
    hideDivDialog();
}

function getplural(num, one, two, five){
    num = Math.abs(num);
    num %= 100;
    if ( num>19 ) { num %= 10; }
    if ( num==0 || num>4 ) { return five; }
    else if ( num==1 ) { return one; }
    else { return two; }
}

function sendQstAnsMark(_link){
    var href, params, url, method, onload, onerror;
    href = _link.href;
    params = href.substring(href.indexOf("?") + 1, href.length) + '&ajax=1';
    url = 'realt/complaint';
    method = 'POST';
    onload = reportMark;
    onerror = errorMark;
    _link = _link.parentNode.parentNode;
    _link.style.display = 'none';
    do _link = _link.nextSibling;
    while ( _link.nodeName != 'DIV' );

    _link.innerHTML = '<span class="orange bold">Запрос обрабатывается...</span>';
    return setAjaxRequest(method, url, params, onload, onerror, false, false, _link);
}

function setClassName(elem, classes){
    if ( elem.getAttribute("className") ){
        elem.setAttribute("className", classes);
    }
    else{
        elem.setAttribute("class", classes);
    }
}

































// собснно дополнение  к  complaint


//var tagsarr = [ "one", "two", "three", "four", "five" ];





var labels = "<div class='neagent-dropdown__item label-3'>\
<a class='b-mail-dropdown__item__content neagent-action' action='label' onclick='sendLabel(\"12\", \"linkId\");return false;'  href='#label/3'>\
Моя метка\
</a>\
</div>" ;





function cl(col){

col="#"+col;
selectedTagColor=col;
//$(".b-label_sample").animate({height:'200px'}, 500); 
//$(".b-label_sample").animate({backgroundColor:col}, 500); 
//$(".b-label_sample").style.backgroundColor = col;
$(".b-label_sample").css({backgroundColor: col});
//$(".b-label_sample").css('backgroundColor') =col;
//alert (ob);
//ob.style.backgroundColor= col;

}

function sampleLabel (ss){
if (ss=="" ){ss=" ";}
if (!ss){ss=" ";}
//alert($(".ng-popup__field__input").value);
//ss=$(".ng-popup__field__input").value + "6";
$(".b-label_sample").html(ss);



}




var selectedTagColor;


function showNewTagDiv(lid){


//alert("-");

co='<div class=\"right mt5\"><a class=\"dialclose\"   onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><table><td class=\"ng-popup__box__content\">\
  <div class=\"ng-popup__header\">Создать новую метку</div>\
  <div class=\"ng-popup__body\">\
    <div class=\"ng-popup__field ng-popup__field_label-new\" xmlns=\"http://www.w3.org/1999/xhtml\">\
      <label class=\"ng-popup__field__label\">\
        Имя метки, до 15 символов\
        <input class=\"ng-popup__field__input\" type=\"text\" value=\"\" maxlength=\"15\" onKeyUp=\"sampleLabel(this.value); \" onchange=\"sampleLabel(this.value);\"/>\
        <span class=\"b-notification b-notification_error\">\
          <span class=\"b-notification__i\">\
            <img class=\"b-mail-icon ng_label_icon_error\" alt=\"[!]\" title=\"\" src=\"//mailstatic.yandex.net/neo2/3.11.20/static/blocks/b-mail-icon/_type/b-mail-icon_error.gif\"/>\
            <span class=\"b-notification__text\"/>\
          </span>\
        </span>\
      </label>\
      <table class=\"ng-popup__field__colors\">\
        <tr>\
          <td class=\"ng-popup__field__colors__label ng-popup__field__colors__label_color\">Цвет:</td>\
          <td class=\"ng-popup__field__colors__value\">\
            <div class=\"ng-popup__label-color-line\">\
              <span class=\"ng-popup__label-color ng-popup__label-color_selected\">\
                <span style=\"background:#31c73b;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'31c73b\'); return false;\" >  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#7cc3c4;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'7cc3c4\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#5a8eff;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'5a8eff\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#ba99ff;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'ba99ff\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#a8bcce;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'a8bcce\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#c1be00;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'c1be00\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#f99000;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'f99000\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#ff8985;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'ff8985\'); return false;\">  </span>\
              </span>\
            </div>\
            <div class=\"ng-popup__label-color-line\">\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#28a931;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'28a931\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#67a3a4;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'67a3a4\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#5080e7;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'5080e7\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#a488e2;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'a488e2\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#8e9faf;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'8e9faf\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#a19f00;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'a19f00\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#db7f00;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'db7f00\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#ff3f30;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'ff3f30\'); return false;\">  </span>\
              </span>\
            </div>\
            <div class=\"ng-popup__label-color-line\">\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#1d8925;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'1d8925\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#508182;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'508182\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#456ec8;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'456ec8\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#8e75c4;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'8e75c4\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#73818e;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'73818e\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#807e00;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'807e00\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#bb6c00;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'bb6c00\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#f32300;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'f32300\'); return false;\">  </span>\
              </span>\
            </div>\
            <div class=\"ng-popup__label-color-line\">\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#136619;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'136619\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#395e5f;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'395e5f\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#385ca8;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'385ca8\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#7760a4;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'7760a4\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#57616c;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'57616c\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#5c5a00;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'5c5a00\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#9c5800;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'9c5800\'); return false;\">  </span>\
              </span>\
              <span class=\"ng-popup__label-color\">\
                <span style=\"background:#d51e00;\" class=\"b-label b-label_rounded\" onclick=\"cl(\'d51e00\'); return false;\">  </span>\
              </span>\
            </div>\
          </td>\
        </tr>\
        <tr>\
          <td class=\"ng-popup__field__colors__label\">Вид:</td>\
          <td class=\"ng-popup__field__colors__value\">\
            <span class=\"b-label b-label_rounded b-label_sample\" params=\"color=\" style=\"background-attachment: scroll; background-repeat: repeat; background-image: none; background-position: 0% 0%; background-size: auto; background-origin: padding-box; background-clip: border-box; background-color: rgb(49, 199, 59)\">  </span>\
          </td>\
        </tr>\
		<tr>\
          <td colspan=2 class=\"ng-popup__field__colors__label\">Метка будет видна только вам, <br>и только с вашего компьютера.</td>\
        </tr>\
      </table>\
    </div>\
  </div>\
  <div class=\"ng-popup__confirm\">\
    <span class=\"b-mail-button b-mail-button_default b-mail-button_button b-mail-button_grey-22px b-mail-button_22px\">\
     <input type=\"submit\" class=\"b-mail-button__button daria-action\" onClick=\"sendNewLabel(\'linkId\'); return false;\"  value=\"Создать метку\"/>\
    </span>\
    <span class=\"b-mail-button b-mail-button_default b-mail-button_button b-mail-button_grey-22px b-mail-button_22px\">\
     <input type=\"submit\" class=\"b-mail-button__button daria-action\" onclick=\"hideDivDialog(); return false;\" value=\"Отменить\"/>\
    </span>\
  </div>\
</td></table>';
//alert("22");


co = co.replace("linkId", lid);
selectedTagColor='#31c73b';

shawDivDialog(co);
return false;


}



function replaceAll(str, what, to) { 
   return str.split(what).join(to); 
} 

function getAllLabels() {
alllabels="";
if  (ul_id){

for ( i=0; i<ul_id.length; i++){

alllabels = alllabels +  "<div class='neagent-dropdown__item label-3 ng-div-label'>\
<a class='b-mail-dropdown__item__content neagent-action ng-a-label' action='label' style='color:white;background-color:"+ul_color[i]+"' onclick='sendLabel(\""+ ul_id[i] +"\", \"linkId\");return false;'  href='#label/3'>\
 "  + ul_name[i] + "</a>\
</div>";


}


}


return alllabels;
}


function plaselabel(adid, labelname, labelcolor, labelid){

 newlab= "<div class='neagent-dropdown__item label-3 ng_label' id='"+adid+ "_" +labelid +"' style='color:white;background-color:" + labelcolor + "'>" + labelname + "<a href='' onclick=\'deleteLabel(\"" + labelid + "\", \""+adid+"\");return false;\'>×</a></div>";

document.getElementById('labels'+adid).innerHTML = document.getElementById('labels'+adid).innerHTML + newlab;


}


function remlabel(adid,  labelid){

lab=document.getElementById(adid + '_'+labelid);
lab.parentNode.removeChild(lab);


}


function showTagDiv(_link) {

//alert(labels);
labels=getAllLabels();



lid=_link.id;
clabels = labels.replace("linkId", lid);
//clabels = replaceAll(clabels, "linkId", lid);
clabelsnew = clabels.split("linkId").join(lid);
 clabels=clabelsnew;
//alert (clabelsnew);

 shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\"   onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div>\
<div class='neagent-dropdown__item label-2' style='height:18px;'><b>Метки</b>\
</div>" + clabels + " <div class='neagent-dropdown__item'>\
    <a href='' class='new_label_a' onclick=\"showNewTagDiv('"+lid +"'); return false;\">Новая метка…</a>\
    </div>\
    ", _link);
    //document.getElementById("spamtextArea").focus();
    return false;
}



function sendNewLabel(linkid) { 

col=$(".b-label_sample");
//alert(col);

tagname=$(".b-label_sample").html();

if (!tagname || tagname==""){
return false;
}

//alert('name' + tagname);
 
//tagcolor=col=$(".b-label_sample").css('backgroundColor');
 
tagcolor=selectedTagColor;
//alert(tagcolor);


//alert('color' + tagcolor);

 
 _link = document.getElementById(linkid);
//alert('_link' + _link);
 
    var url = "http://neagent.by/realt/label/";
	//lb= id;
    // alert(cp);
	//return false;
    var params =  cutParams(_link.href) +'&name=' + tagname + '&color=' + tagcolor + '&ajax=1';
   // alert('params=' + params);
	var method = "POST";
    var onload = reportLabelResult;
    var contentType = "application/x-www-form-urlencoded; charset=windows-1251";
    shawDivDialog("Идет обработка запроса", _link);
	//alert('URL='+url);
	//alert(' params='+ params);
    return setAjaxRequest(method, url, params, onload, false, contentType, false, _link);
//alert();
}




function deleteLabel(id, adid) { 
//alert('del');
 _link = document.getElementById(adid+"_"+id);
    var url = "http://neagent.by/realt/labeldelete/";
	lb= id;
     //alert( _link);
	//return false;
     var params =  'label=' + id +  '&aid=' + adid +   '&ajax=1';
   //alert('params=' + params);
	var method = "POST";
    var onload = reportLabelDeleteResult;
    var contentType = "application/x-www-form-urlencoded; charset=windows-1251";
    shawDivDialog("Идет обработка запроса" , _link);
	//alert('URL='+url);
	//alert(' -params='+ params);
    return setAjaxRequest(method, url, params, onload, false, contentType, false, _link);
//alert();
}








function sendLabel(id, linkid) { 
 //alert('sl');
 _link = document.getElementById(linkid);
    var url = "http://neagent.by/realt/label/";
	lb= id;
    // alert(cp);
	//return false;
    var params =  cutParams(_link.href) +'&label=' + lb +  '&ajax=1';
    //alert('params=' + params);
	var method = "POST";
    var onload = reportLabelResult;
    var contentType = "application/x-www-form-urlencoded; charset=windows-1251";
    shawDivDialog("Идет обработка запроса", _link);
	//alert('URL='+url);
	//alert(' params='+ params);
    return setAjaxRequest(method, url, params, onload, false, contentType, false, _link);
//alert();
}


function sendTag(id) { 
    _link = document.getElementById(id);
    var url = "http://neagent.by/realt/complaint/";
	// alert(_link);
	  //return false;
	//cp=document.forms["complaintForm"].elements[1].value;
	
	cp= jQuery("input[name='complaint'][checked]").val();
    // alert(cp);
	  //return false;
    var params = cutParams(_link.href) +'&complaint=' + cp +  '&report=' + document.getElementById("spamtextArea").value +  '&ajax=1';
     // alert('params=' + params);
	var method = "POST";
    var onload = reporttagResult;
     var contentType = "application/x-www-form-urlencoded; charset=windows-1251";
    shawDivDialog("Идет обработка запроса", _link);
	 // alert('URL='+url);
    return setAjaxRequest(method, url, params, onload, false, contentType, false, _link);
}




function reportLabelResult() {
    var obj, doc, docRes, errorCode, error;
	   //alert("76");
	   //alert (this.req);
    //obj = eval("(" + this.req.responseText + ")");
	
	//alert  (this.req.responseXML);
	//ert=this.req.responseXML.getElementsByTagName('error')[0].nodeValue;
	
	  xmlResponse = this.req.responseXML;
	    //alert (xmlResponse);
      xmlRoot = xmlResponse.documentElement;
	  // alert (xmlRoot);
	 
	 if (xmlRoot==null){
	    error = 'Ошибка сервиса. Если она будет повторяться, сообщите модератору';
	    error_code = 2;
		 //alert("errabusealreadyerrabusealready");
		shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"red\">" + error + "</span></div>");
	   return;
	}
	
	if (xmlRoot.getElementsByTagName("error")[0]) {
      resp = xmlRoot.getElementsByTagName("error")[0].childNodes[0].nodeValue;
	}
	else
	{
	resp ="errabusenotfound2"
	}
	
	
	  //alert ( "resp=" +resp);
	
	//'ert=this.req.responseXML.getElementsByTagName('error')[0].data;
	
	//obj = this.req.responseXML.getElementsByTagName('error');
	//objl = eval('(' + this.req.responseText + ')');
	objl =  this.req.responseText ;
 //alert ( objl);
    switch (  resp ){
	case 'errabusealready':{
	    error = 'Вы уже жаловались по этому поводу';
	    error_code = 2;
		//alert("errabusealreadyerrabusealready");
	    break;
	}
	case 'errabusenotfound':{
	    error = 'Жалоба не принята. Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	case 'errabusenotfound2':{
	    error = 'Жалоба не принята - Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	case 'errabusenotselected':{
	    error = 'Вы не указали причину жалобы. Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	
	
	
	case 'oklabel':{
	//spam - delete add
	    error = 'Метка добавлена. ';
	    error_code = 0;
		if (xmlRoot.getElementsByTagName("adid")[0]) {
		adid = xmlRoot.getElementsByTagName("adid")[0].childNodes[0].nodeValue;
		labelname = xmlRoot.getElementsByTagName("labelname")[0].childNodes[0].nodeValue;
		labelcolor = xmlRoot.getElementsByTagName("labelcolor")[0].childNodes[0].nodeValue;
		labelid = xmlRoot.getElementsByTagName("labelid")[0].childNodes[0].nodeValue;
		}
		//alert(adid);
		//alert(labelname);
		plaselabel(adid, labelname, labelcolor, labelid);
	    break;
	}
	case 'errabuselimit':{
	    error = 'Вы временно не можете отправить жалобу. Попробуйте сделать это через минуту.';
	    error_code = 2;
	    break;
	}
	case 'erruserbanned':{
	    error = 'Вам закрыт доступ на проект';
	    error_code = 2;
	    break;
	}
	case 'okabuse':{
	    error = 'Ваша жалоба будет рассмотрена в ближайшее время';
	    error_code = 0;
	    break;
	}
	case 'errusrnotfound':{
	    error = 'Пользователь не найден';
	    error_code = 2;
	    break;
	}
	case 'errusrwasbanned':{
	    error = 'Пользователь забанен и уже находится под наблюдением Администрации';
	    error_code = 2;
	    break;
	}
	case 'errmoddenied':{
	    error = '<b>Доступ запрещен</b>. <br>У вас нет прав на выполнение этого действия';
	    error_code = 2;
	    break;
	}
	case 'errmodlimit':{
	    error = 'Вы временно не можете принимать участие в модерировании проекта';
	    error_code = 2;
	    break;
	}
	default:{
	    error = 'При обработке запроса произошла ошибка<br>Попробуйте повторить еще раз';
//      document.write( '<textarea>' + this.req.responseText + '</textarea>' );
	    error_code = 1;
	    break;
	}
    }

    if ( error_code > 0 ) {
	shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"red\">" + error + "</span></div>");
    }else {
	hideDivDialog();
	//shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"green\">" + error + "</span></div>");
    }

    
}




function reportLabelDeleteResult() {
    var obj, doc, docRes, errorCode, error;
	//  alert("76");
	   //alert (this.req);
    //obj = eval("(" + this.req.responseText + ")");
	
	//alert  (this.req.responseXML);
	//ert=this.req.responseXML.getElementsByTagName('error')[0].nodeValue;
	
	  xmlResponse = this.req.responseXML;
	  //alert (xmlResponse);
      xmlRoot = xmlResponse.documentElement;
	 // alert (xmlRoot);
	 
	 if (xmlRoot==null){
	    error = 'Ошибка сервиса. Если она будет повторяться, сообщите модератору';
	    error_code = 2;
		 //alert("errabusealreadyerrabusealready");
		shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"red\">" + error + "</span></div>");
	   return;
	}
	
	if (xmlRoot.getElementsByTagName("error")[0]) {
      resp = xmlRoot.getElementsByTagName("error")[0].childNodes[0].nodeValue;
	}
	else
	{
	resp ="errabusenotfound2"
	}
	
	
	  //alert ( "resp=" +resp);
	
	//'ert=this.req.responseXML.getElementsByTagName('error')[0].data;
	
	//obj = this.req.responseXML.getElementsByTagName('error');
	//objl = eval('(' + this.req.responseText + ')');
	objl =  this.req.responseText ;
 //alert ( objl);
    switch (  resp ){
	case 'errabusealready':{
	    error = 'Вы уже жаловались по этому поводу';
	    error_code = 2;
		//alert("errabusealreadyerrabusealready");
	    break;
	}
	case 'errabusenotfound':{
	    error = 'Жалоба не принята. Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	case 'errabusenotfound2':{
	    error = 'Жалоба не принята - Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	case 'errabusenotselected':{
	    error = 'Вы не указали причину жалобы. Попробуйте еще раз';
	    error_code = 1;
	    break;
	}
	
	
	
	case 'oklabel':{
	//spam - delete add
	//alert("deleted");
	    error = 'Метка удалена. ';
	    error_code = 0;
		if (xmlRoot.getElementsByTagName("adid")[0]) {
		adid = xmlRoot.getElementsByTagName("adid")[0].childNodes[0].nodeValue;
		labelid = xmlRoot.getElementsByTagName("labelid")[0].childNodes[0].nodeValue;
		}
		
		//alert(adid);
		//alert(labelid);
		remlabel(adid, labelid);
	    break;
	}
	
	
	default:{
	    error = 'При обработке запроса произошла ошибка<br>Попробуйте повторить еще раз';
//      document.write( '<textarea>' + this.req.responseText + '</textarea>' );
	    error_code = 1;
	    break;
	}
    }

    if ( error_code > 0 ) {
	shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"red\">" + error + "</span></div>");
    }else {
	hideDivDialog();
	//shawDivDialog("<div class=\"right mt5\"><a class=\"dialclose\" onclick=\"hideDivDialog(); return false;\" href=\"#\">Закрыть</a></div><div class=\"text_body\"><span class=\"green\">" + error + "</span></div>");
    }
    //  Если ошибки фатальные или жалоба принята, прячем ссылку
    if ( error_code==0 || error_code> 1 ) {
    	requestsHash[this.hashKey + 1].style.display = "none";
    }    
}