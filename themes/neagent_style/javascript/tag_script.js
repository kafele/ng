// собснно дополнение  к  complaint



function showTagDiv(_link) {
 alert (1);

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

function reporttagResult() {
    var obj, doc, docRes, errorCode, error;
	   //alert("76");
	   //alert (this.req);
    //obj = eval("(" + this.req.responseText + ")");
	
	//alert  (this.req.responseXML);
	//ert=this.req.responseXML.getElementsByTagName('error')[0].nodeValue;
	
	  xmlResponse = this.req.responseXML;
	  
	  //alert ("text=" + this.req.responseText);
	  
	  //alert (xmlResponse);
      xmlRoot = xmlResponse.documentElement;
	  //alert (xmlRoot);
	 
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



