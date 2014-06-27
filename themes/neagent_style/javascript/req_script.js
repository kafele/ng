



function sendData(id, mode) { 
 //alert("sendAd");
    _link = document.getElementById(id + "base");
    var url = "sendData.asp";
	Params=jQuery("#"+id).formSerialize();
	 // alert("Params=" + Params);
    var params = Params + '&ignore=' + mode +  '&ajax=1';
    var method = "POST";
    var onload = reportAdResult;
    var contentType = "application/x-www-form-urlencoded; charset=windows-1251";
    shawDivDialog("Идет обработка запроса", _link);
	//alert("34");
    return setAjaxRequest(method, url, params, onload, false, contentType, false, _link);
}











function reportAdResult() {
    var obj, doc, docRes, errorCode, error;
	//alert("76");
	//alert (this.req.responseText);
    //obj = eval("(" + this.req.responseText + ")");
	//alert  (this.req.responseXML);
	//ert=this.req.responseXML.getElementsByTagName('error')[0].nodeValue;
	  xmlResponse = this.req.responseXML;
	  //  alert (xmlResponse);
      xmlRoot = xmlResponse.documentElement;
	 // alert (xmlRoot);
      resp = xmlRoot.getElementsByTagName("error")[0].childNodes[0].nodeValue;
	 //alert (resp);
	//'ert=this.req.responseXML.getElementsByTagName('error')[0].data;
	//obj = this.req.responseXML.getElementsByTagName('error');
	//objl = eval('(' + this.req.responseText + ')');
	//objl =  this.req.responseText ;
 //alert ( resp);
    switch (  resp ){
	case 'ArrChanged':{
	    error = 'Изменено';
	    error_code = 2;
		 alert('Изменено');
	    break;
	}
	
	case 'CatChanged':{
	    error = 'Изменено';
	    error_code = 2;
		 alert('Изменено');
	    break;
	}
	
	
	
	case 'errabusenotfound':{
	    error = 'Жалоба не принята. Попробуйте еще раз';
	    error_code = 1;
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
	case 'okadded':{
	    error = 'Добавлено';
		errorstr= 'Добавлено';
	    error_code = 0;
	    break;
	}
	
	case 'okignored':{
	    error = 'Игнорировано';
		errorstr= 'Игнорировано';
	    error_code = 0;
	    break;
	}
	
	case 'errusrnotfound':{
	    error = 'Пользователь не найден';
	    error_code = 2;
	    break;
	}
	
	
	case 'errNoRights':{
	    error = 'У вас нет прав!';
	    error_code = 1;
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
	shawDivDialog("<div class=\"right mt5\"><a onclick=\"hideDivDialog(); return false;\" href=\"#\"><img src=\"/images/close_help.gif\" width=\"7\" height=\"7\" alt=\"Закрыть\" /></a></div><div class=\"text_body\"><span class=\"red\">" + error + "</span></div>");
    }else {
	shawDivDialog("<div class=\"right mt5\"><a onclick=\"hideDivDialog(); return false;\" href=\"#\"><img src=\"/images/close_help.gif\" width=\"7\" height=\"7\" alt=\"Закрыть\" /></a></div><div class=\"text_body\"><span class=\"green\">" + error + "</span></div>");
    }
    //  Если ошибки фатальные или жалоба принята, прячем ссылку
    if ( error_code==0 || error_code> 1 ) {
    	requestsHash[this.hashKey + 1].style.display = "none";
		//requestsHash[this.hashKey + 1].parentNode.parentNode.stop().animate({
		//	height: "1px"
		//}, 300);
		
		if ( error_code==0 ){
		var dv=requestsHash[this.hashKey + 1].parentNode.parentNode;
		document.getElementById("spam_dial").style.display = "none";
		var divid=dv.id;
		jQuery("#"+divid)
		.animate({height: "1px"}, 600)
		.text(errorstr)
		.animate({height: "1em"}, 400)
		.animate({ backgroundColor: "#eef2f1" }, 800);
	   }
		
		//.className=resp;
		
		
		
		//requestsHash[this.hashKey + 1].parentNode.parentNode.innerHTML = error;
    }    
}


                                                                     // ========== BEGIN: reiting ===========================


function cutParams(allUrl) {
  var params = allUrl.substring(allUrl.indexOf("?") + 1, allUrl.length);
  params = params.replace('action=abuse', 'action=authabuse');
  return params;
}

