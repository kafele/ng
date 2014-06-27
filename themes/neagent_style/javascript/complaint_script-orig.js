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
  <div class=\"mtm10\">Причина:</div>\
  <form name='complaintForm' action=\"" + _link.href.replace('action=abuse', 'action=abuselist') + "\" onsubmit='if (document.getElementById(\"spamtextArea\").value != \"---\") {return sendComplaint(\"" + _link.id + "\");} else {alert(\"Укажите причину жалобы!\");return false;}'>\
   <input type=\"hidden\" name=\"aid\"  value=\""+ _link.id+ "\">\
    <input type=\"radio\"  name=\"complaint\"  value=\"2\">Это агентство!<br>\
   	<input type=\"radio\"  name=\"complaint\" value=\"3\">Другое.<br>Комментарий:<br>\<textarea name=\"report\" rows=3 style='width:210px; height:60px; margin: 7px 0; font-size: 12px; font-family: Arial;' id='spamtextArea'> </textarea><br>\
    <input type=submit id=butForSpam value='Сообщить модератору' style='font-size: 95%; font-family: tahoma;';>\
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
	
	cp= jQuery("input[name='complaint'][checked]").val();
    // alert(cp);
	  //return false;
    var params = cutParams(_link.href) +'&complaint=' + cp +  '&report=' + document.getElementById("spamtextArea").value +  '&ajax=1';
     //alert(params);
	var method = "GET";
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
	
	
	// alert ( "resp=" +resp);
	
	//'ert=this.req.responseXML.getElementsByTagName('error')[0].data;
	
	//obj = this.req.responseXML.getElementsByTagName('error');
	//objl = eval('(' + this.req.responseText + ')');
	//objl =  this.req.responseText ;
//alert ( ert);
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
function shawDivDialog(html, basis, _x, _y) {
 //alert("div");
  var div = document.getElementById("spam_dial");
    //alert(div);
  div.innerHTML = html;
  if (basis) {
    var _top = absPosition(basis).y + (_y ? _y : 0);
    var _left = absPosition(basis).x + (_x ? _x : 0);
	//var _left=20
	//alert(_top);
	//alert(_left);
  }
  if (typeof _top != 'undefined') div.style.top = _top + "px";
  if (typeof _left != 'undefined') div.style.left = _left + "px";
 
 //alert(div.style.top);
  //alert(div.style.left);
div.style.display = "";
 div.style.display = "block";
 // div.style.zIndex = "300";
}

function hideDivDialog() {
  document.getElementById("spam_dial").style.display = "none";
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

