  var timeAjaxWite;
 var isloading = false;
 var thisajax;
qsPath="http://wa.by/qs";
getareaPath="http://neagent.by/realt/getarea"
  
  searchQuickObjectsAjaxPath = '';
  searchQuickObjectForm = '';
  objQuickCountDebounceFn = false;
  objQuickRequestDebounced = false;
$(document).ready(function(){




if ($('#_y_5_direct1')){
//$/('.y5_ad').removeClass('y_ad');
//$('.y5_ad').removeClass('y5_ad');

//$('.y5').removeClass('yy');
//$('.y5').removeClass('y5');


 //$('.snap_noshot').addClass('it_title');
// $('.snap_noshot').removeClass('snap_noshot');
  

}

//alert ();








		if ($("a[href$='print/']")) {
        $("a[href$='print/']").attr('target', '_blank');   }
		
		if ($('.changePublish')) {
        $('.changePublish').click(function(){
            var objId = $(this).attr('rel');
            var action;
            if ($(this).find('img').hasClass('show')){
                action = 'show';
            } else {
                action = 'hide';
            }
            obj = $(this);
            $.get(                         
                    qsPath,
                    function(data){
                            if (data){
                                if (action == 'hide') {
                                    obj.find('img').attr('src', '/images/design/b_edit.gif');
                                    obj.find('img').attr('title', ' ');
                                    obj.find('img').removeClass('hide');
                                    obj.find('img').addClass('show');
                                } else {
                                    obj.find('img:first').attr('src', '/images/design/b_drop.png');
                                    obj.find('img:first').attr('title', ' ');
                                    obj.find('img').removeClass('show');
                                    obj.find('img').addClass('hide');
                                }
                            }
                    }
           );

        });
		}

		
	

	
if ($('#li_su'))	{
$('#li_su').click(function(){
 $('#big_pic').hide();
 $('.banners-shorts').hide();
 $('#big_pic_su').show();
	});
}	


if ($('#li_ar')){
$('#li_ar').click(function(){
$('#big_pic').show();
$('.banners-shorts').show();
$('#big_pic_su').hide();
	});
}

if ($('#li_kn')){
$('#li_kn').click(function(){
$('#big_pic').show();
$('.banners-shorts').show();
$('#big_pic_su').hide();
	});
}

if ($('#li_nb')){
$('#li_nb').click(function(){
$('#big_pic').show();
$('.banners-shorts').show();
$('#big_pic_su').hide();
	});
}
	
	
	
	
	

	
	
	
	
//  $('.user-vote .show-vote-rezults').click(function(){
 // if ($('.user-vote .vote-rezults')) {
 // 		$('.user-vote .vote-rezults').slideDown();  }
		
 // 		$(this).remove();
 // });
  
  
  if ($('#top_menu li')) {
  
  $('#top_menu li').click(function(){
    $('#top_menu li').each(function(){
      if($(this).attr('className').search('sel') != -1){
        
        $(this).attr('className',$(this).attr('className').replace('sel', ''));
        $('div .quick-search-' + $(this).attr('className')).hide();
      }
    })
    $('#center_menu').attr('className', ('menu ' + $(this).attr('className')));
    $('div .quick-search-' + $(this).attr('className')).show();
    idMenuLeft = $(this).attr('className');
    $(this).attr('className',($(this).attr('className') + ' sel'));
	
    cur_form=$(this).attr('className').replace('sel', '')
	//	alert  ("cur_form=" + cur_form)
		cur_count=getCurCount(cur_form);
    secondLevel = $('#'+idMenuLeft).parent().find('ul');
    if (secondLevel.css('display') == 'none') {                	
      secondLevel.slideDown();
      $('#'+idMenuLeft).parent().addClass('sel');
    }
    quickSearchFormObjects(idMenuLeft);
  });
  
  }
  
  
  
  selected = 0;
  
  
 if   ($('#top_menu li')){
  $('#top_menu li').each(function(){
    
    if($(this).attr('className').search('sel') != -1){
      selected = 1;
      $('div .quick-search-' + $(this).attr('className').replace('sel', '')).show();
      
      quickSearchFormObjects($(this).attr('className').replace('sel', ''));
    }else{
      $('div .quick-search-' + $(this).attr('className')).hide();
    }
  });
  
  
  
if ($('div .quick-search-nb')){
  if(selected == 0){
  // УМОЛЧАНИЕ
 //alert("d");
   // $('li:first').attr('className', 'nb sel');
   // $('div .quick-search-nb').show();
   // $('#center_menu').attr('className', 'menu nb');
   // quickSearchFormObjects('nb');
	//cur_form="nb";
	//cur_count=getCurCount(cur_form);
	}
	
  }
  
  
  
} ;  // if   ($('#top_menu li'))
  
  
if ($("#quich-search-kv")) {
    $("#quich-search-kv").click(function(){
      $('#apartments-form').attr('action', qsPath);
      $(this).attr('className', 'selected-quick-search-type');
      $('#quich-search-rm').attr('className', 'quick-search-type');
      quickSearchFormObjects('kv');
  });
  $("#quich-search-ap").click(function(){
      $('#apartments-form').attr('action', qsPath);
      $(this).attr('className', 'selected-quick-search-type');
      $('#quich-search-rm').attr('className', 'quick-search-type');
      quickSearchFormObjects('ar');
  });
  
    $("#quich-search-kn").click(function(){
      $('#apartments-form').attr('action', qsPath);
      $(this).attr('className', 'selected-quick-search-type');
      $('#quich-search-rm').attr('className', 'quick-search-type');
      quickSearchFormObjects('kn');
  });
  
  $("#quich-search-rm").click(function(){
      $('#apartments-form').attr('action', qsPath);
      $(this).attr('className', 'selected-quick-search-type');
      $('#quich-search-ap').attr('className', 'quick-search-type');
      quickSearchFormObjects('ar');
  });
  $("#quich-search-hs").click(function(){
      $('#zagorod-form').attr('action', qsPath);
      $(this).attr('className', 'selected-quick-search-type');
      $('#quich-search-gr').attr('className', 'quick-search-type');
      $('#hs').show();
      quickSearchFormObjects('cn');
  });
  $("#quich-search-gr").click(function(){
      $('#zagorod-form').attr('action', qsPath);
      $(this).attr('className', 'selected-quick-search-type');
      $('#quich-search-hs').attr('className', 'quick-search-type');
      $('#hs').hide();
      quickSearchFormObjects('cn');
  });
  $("#quich-search-commerce-sell").click(function(){
      $('#commerce_form').attr('action', qsPath);
      $(this).attr('className', 'selected-quick-search-type');
      $('#quich-search-commerce-rent').attr('className', 'quick-search-type');
      quickSearchFormObjects('cm');
  });
   $("#quich-search-commerce-rent").click(function(){
      $('#commerce_form').attr('action', qsPath);
      $(this).attr('className', 'selected-quick-search-type');
      $('#quich-search-commerce-sell').attr('className', 'quick-search-type');
      quickSearchFormObjects('cm');
  });
  
}
  
  formValues = new Object();
  formValues[6] = qsPath;
  formValues[19] = qsPath;  
  formValues[3] = qsPath;
  
  inputsShow = new Object();
  inputsShow[6] = 'ap';
  inputsShow[19] = 'ap';
  //inputsShow[10] = 'commerce';
  inputsShow[3] = 'house';
  //$('#' + inputsShow[6]).show();
  
  if ($("#quich-search-rent-types a")){
  $("#quich-search-rent-types a").click(function(){
      selectedType = $(this).attr('rel');
      $('#quich-search-rent-types a').each(function(){
        $(this).attr('className', 'quick-search-type');
        $('#' + inputsShow[$(this).attr('rel')]).hide();
        $('#' + inputsShow[$(this).attr('rel')] + ' input').each(function(){
          $(this).attr('checked', false);
        });
      })
      //$('#' + inputsShow[$(this).attr('rel')] + ' input').each(function(){
      //  $(this).attr('disabled', false);
      //});
      //$(this).find('input').css('border','1px solid red');
      $(this).attr('className', 'selected-quick-search-type');
      $('#quick-search-rent-form').attr('action', formValues[$(this).attr('rel')]);
      
      $('#' + inputsShow[$(this).attr('rel')]).show();
      //alert(inputsShow[$(this).attr('rel')]);
      quickSearchFormObjects('rn');
  }
  
  
  
  
  );
  
}
  
  function quickSearchFormObjects(selectedMenuId){
   // alert( "enter quickSearchFormObjects");
    quickSearchFormObjectId = $('#' + ($('.quick-search-' + selectedMenuId).find('form').attr('id')));
    searchQuickObjectForm = $('.quick-search-' + selectedMenuId).find('form').attr('id');
    searchQuickObjectsAjaxPath = quickSearchFormObjectId.attr('action');
    // alert(searchQuickObjectsAjaxPath);
     //alert(quickSearchFormObjectId);
    if (quickSearchFormObjectId.length) {
     // alert("quickSearchFormObjectId.length");
  		$(quickSearchFormObjectId).find('input, select').change(updateQuickObjectsCount);		
  		if ($.browser.msie) {
		//alert("$.browser.msie");
  			$(quickSearchFormObjectId).find('input[type=checkbox]').click(updateQuickObjectsCount);
  		}
  		$(quickSearchFormObjectId).find('input[type=text]').keyup(updateQuickObjectsCount).focus(function(){
  			if (objQuickRequestDebounced) {
  			  // alert('tyt');
  				updateObjectsCount();
  			}
  		});
  	
  		quickSearchFormObjectId.find('input[type=reset], a.reset').click(function(){
  			quickSearchFormObjectId.find('input[type=checkbox]').removeAttr('checked');
  			quickSearchFormObjectId.find('option').removeAttr('selected');
  			quickSearchFormObjectId.find('input[type=text]').val('');
  			updateObjectsCount();
  			return false;
  		});
  		
  		getQuickObjectsCount();	   
  	}
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  function updateQuickObjectsCount(){
  	objQuickRequestDebounced = true;
  	
  	if (!objQuickCountDebounceFn) {
  		objQuickCountDebounceFn = debounce(getQuickObjectsCount, upTime);
  	}
	//####################### deleted ///
  	//objQuickCountDebounceFn();
  }
  
  function getQuickObjectsCount(){	
  //alert("enter getQuickObjectsCount")
  	objQuickRequestDebounced = false;
  	someVar = searchQuickObjectsAjaxPath;
	//alert  ("someVar=" + someVar);
  	someArray = someVar.split('&');
  	configId = 0;
  	for(i in someArray){
  	  get = someArray[i].split('=');
  	  if(get[0] == 'configId'){
  	    configId = get[1];
  	  }
  	}
  //	searchQuickObjectsAjaxPath = '/bkn/index.php5?module=objects&configId=' + configId + '&class=ajax&action=GetSearchObjectsCount&useTpl=list';
  	
	searchQuickObjectsAjaxPath = qsPath;
  	//  alert ("searchQuickObjectForm=" + searchQuickObjectForm)
	//$('#' + searchQuickObjectForm).find('.preview-quick-objects-count .count').html('Объектов: 2' );
  	//$('#' + searchQuickObjectForm).find('.preview-quick-objects-count').addClass('preview-quick-objects-count-loading');
  	 
	var  hValues= $('#' + searchQuickObjectForm).serialize()
	//var  hValues= document.getElementById('search-objects-form')
	// alert("hValues" + hValues);
	
	
	
//	$.ajax({
 // url: searchQuickObjectsAjaxPath,
 // success: function(data) {
  //  $('.result').html(data);
  //  alert('Load was performed.');
 // }
//});
	
	
	
	  
		 
	
	
	
	
	
	 if(timeAjaxWite != undefined)
			clearTimeout(timeAjaxWite);
		timeAjaxWite = setTimeout(function(){
			thisajax = $.ajax({
			url: searchQuickObjectsAjaxPath,
			data: hValues,
				
				
				success: function(data) {
					isloading = false;
					//formCounter.text(data.results);
					 //alert( (data.results));
					   //alert  (data ); 
					//alert("suk")
					// alert  (hValues)
				//	if(parseInt(data) === 0) {
				//	data="-"
				//	} else {
				//	data=parseInt(data)
				//	}
					
					
					
					 $('#' + searchQuickObjectForm).find('.preview-quick-objects-count .count').html('Объектов: ' + data);
					 
                     //$('.sr').removeClass('sr')
			        //$('.sr').addClass(' ');
			  //$('.wrapper').removeClass('wrapper')
			        // $('.wrapper').addClass(' ');
			 // $('.container').removeClass('container')
			       //  $('.container').addClass('container');
			  var p = $("#header");
				var position = p.position();
				//alert  (position.left )
				// $("#header").position.left = 800;
				//  p.position();
//$("p:last").text( "left: " + position.left
					//alert("1" + data);
						//button.addClass('disable');
						//button.find('button').attr('disabled', 'disabled');
					 
				}
			});
		},500);
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
 
  	
  }
	
	
	
	
	
	
	
	
	
	
 
searchform_resize();
 
	
	
	
})//document ready end







var selectedAreas="";
var delim="";

function getSelectedAreas(){
if (selectedAreas==""){
return -1;
}
else
{
return selectedAreas;
}
}

function isReady() {
jsReady=true;
 return jsReady;
 }

function sendVarsToFlash(){
selar=getSelectedAreas();
//alert("sendFlash");
//alert(getMovie());
//window.document.testmovie.updateAreas(selar);
 getMovie().updateAreas(selar);
//getMovie().SetVariable("selectedAreas",selar);
}


function getMovie() {
	    var M$ =  navigator.appName.indexOf("Microsoft")!=-1
	    return (M$ ? window : document)["testmovie"]
	}





function area_up() {
 //alert("up")
  // alert('#area_pop_'+cur_form)
	if (!$('#area_pop_'+cur_form)) return false;
					//$('#area_pop').className = 'up';
	$('#area_pop_'+cur_form).addClass('up');
	$('#area_pop_'+cur_form).removeClass('dn')
					//$('#area_pop').className = 'up';
					//.addClass(className) 
	 if (isIE6==true){
	 $('#area_pop_nb').css( {'display': 'block'} ); //для IE 
	 $('.hidselect').css( {'visibility': 'hidden'} );  //для IE 
	 }
	 
	return false;
}




function area_dn() {
//alert ("dn");
//alert ($('#area_pop_ar'));
 if (!$('#area_pop_'+cur_form)) {

 };
	if (!$('#area_pop_'+cur_form)) return false;
	$('#area_pop_ar').addClass('dn');
	$('#area_pop_nb').addClass('dn');
	if (isIE6==true){
	$('#area_pop_nb').css( {'display': 'none'} );  //для IE 
	$('.hidselect').css( {'visibility': 'visible'} );  //для IE 
	}
	//$('#area_pop_nb').child().addClass('dn');
	return false;
}

function choose_area(obj, area_id,  area_name) {
	var id = obj.id;
	var val = parseInt(id);
	//var tid = id.replace(val+'_','');
	//gebi(tid).innerHTML = obj.innerHTML;
	
	
	var par = obj.parentNode;
	// alert(obj.name);
	//alert(obj.id);
	if (!par) return false;
	if (par.className == '') {
		par.className = 'cur';
		//var node = document.getElementById(val);
		//node['myProperty'] = 'value';
		//var metro_id = document.getElementById("mt_"+metro_id);
		//metro_id.parentNode.removeChild(idElem);
		//alert(area_name);
		
		$('#choosedArea_'+cur_form).append(", " + area_name);
		//renove comma if exists
		laststr=$('#choosedArea_'+cur_form).text();
		if ((laststr.indexOf(", ")==0) && (laststr.length>2)){
		$('#choosedArea_'+cur_form).html(laststr.substring(2,laststr.length));
		}
		
		document.getElementById("ar_"+area_id).value=area_id;
		
		selectedAreas = selectedAreas + delim + "ar_" +area_id; 
		delim=",";
		//alert(selectedAreas);
		
		
		
		
	}
	else {
		par.className = '';
		//empty("#mt_"+metro_id);
		//idElem.parentNode.removeChild(idElem);
		document.getElementById("ar_"+area_id).value="0";
		
		
		laststr=", " + ($('#choosedArea_'+cur_form).text());
		newstr=str_replace(", " + area_name, "",laststr )  //   laststr.replaceText(", " + area_name, "");
		$('#choosedArea_'+cur_form).html(newstr);
		
		
		
		
		 
		 //renove comma if exists
		laststr=$('#choosedArea_'+cur_form).text();
		if ((laststr.indexOf(", ")==0) && (laststr.length>2)){
		$('#choosedArea_'+cur_form).html(laststr.substring(2,laststr.length));
		}
		
		selectedAreas =str_replace("ar_" +area_id, "",selectedAreas ); 
		selectedAreas =str_replace(",," ,  "," , selectedAreas );
		
		
	}
	
// so far	updateObjectsCount();
	//alert(metro_id);
	return false;
}

























function choose_subarea(obj, area_id,  area_name) {
	var id = obj.id;
	var val = parseInt(id);
	//var tid = id.replace(val+'_','');
	//gebi(tid).innerHTML = obj.innerHTML;
	
	var par = obj.parentNode;
	if (!par) return false;
	if (par.className == '') {
		par.className = 'cur';
		//var node = document.getElementById(val);
		//node['myProperty'] = 'value';
		//var metro_id = document.getElementById("mt_"+metro_id);
		//metro_id.parentNode.removeChild(idElem);
		//alert(area_name);
		$('#choosedArea_'+cur_form).append(", " + area_name);
		
		
		
		
		
		//renove comma if exists
		laststr=$('#choosedArea_'+cur_form).text();
		if ((laststr.indexOf(", ")==0) && (laststr.length>2)){
		$('#choosedArea_'+cur_form).html(laststr.substring(2,laststr.length));
		}
		document.getElementById("subar_"+area_id).value=area_id;
		
		
		selectedAreas = selectedAreas + delim + "subar_" + area_id; 
		delim=",";
		//alert(selectedAreas);
		
		
		
		
	}
	
	else {
	
	//if (!par) {alert ("пролад");}
		par.className = '';
		//empty("#mt_"+metro_id);
		//idElem.parentNode.removeChild(idElem);
		document.getElementById("subar_"+area_id).value="0";
		
		
		laststr=", " + ($('#choosedArea_'+cur_form).text());
		newstr=str_replace(", " + area_name, "",laststr )  //   laststr.replaceText(", " + area_name, "");
		$('#choosedArea_'+cur_form).html(newstr);
		 
		

		
		 //renove comma if exists
		laststr=$('#choosedArea_'+cur_form).text();
		if ((laststr.indexOf(", ")==0) && (laststr.length>2)){
		$('#choosedArea_'+cur_form).html(laststr.substring(2,laststr.length));
		}
		
		selectedAreas =str_replace("subar_" +area_id, "", selectedAreas ); 
		selectedAreas =str_replace(",," ,  "," , selectedAreas );
		
		
	}
	updateObjectsCount();
	//alert(metro_id);
	return false;
}




















// str_replace("что заменяем", "чем заменяем", "исходная строка");
function str_replace(search, replace, subject) {
    return subject.split(search).join(replace);
} 


function chosen() {
//alert(cur_form);
	area_dn();
	return false;
}













function Inint_AJAX() {
	try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
	try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
	try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
	alert("XMLHttpRequest not supported");
	return null;
};
function getAreaByCityId(id, mt_url, put) {


	//alert('getMetroByCityId; id - '+id + 'url-' +mt_url +'&put='+put);
	var req = Inint_AJAX();
	req.onreadystatechange = function () {
		if (req.readyState==4) {
			if (req.status==200) {
			 
				var regText = req.responseText;
				//заполнение всех полей;
				
				$('#area_pop_nb').html(regText); //return value
				$('#area_pop_ar').html(regText); //return value
				area_dn(); // для IE
				if (regText=='') $('#chooseArea').html("нет");
				else $('#chooseArea').html('<a onclick="return area_up()" href="#">выбрать</a>');
			}
		}
	};
	
	req.open("POST", getareaPath);  //пока 

	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
	
	req.send("city_id=" + mt_url +'&put='+put);
	
	//req.send(null); //send value удалено 
	return false;
	
}




function clink(obj) {
	if (obj == undefined) return true;
	var cls = obj.className;
	var inp = $('#'+obj.id+'i');
	if (cls == '') {
		obj.className = 'clnk';
		if (inp != undefined) inp.value = '1';
	} else {
		obj.className = '';
		if (inp != undefined) inp.value = '0';
	}
	return false;
}




function gebi(id) { return document.getElementById(id); }

function imgov(obj) {
	if (obj != undefined) {
		var id = obj.id+'_ov';
		if (gebi(id)) obj.src = gebi(id).src;
	}
}

function imgou(obj) {
	if (obj != undefined) {
		var id = obj.id+'_ou';
		if (gebi(id)) obj.src = gebi(id).src;
	}
}



////////////////////////////////////////// complaint
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
   	<div class=\"ng-popup__field__label\">Отметьте галочкой, если это агент.</div>\
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

/////////////////////////////////// tag 
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






////////////////////////// ajax 






var net = new Object(); // Namespacing object
net.READY_STATE_UNINITIALIZED = 0;
net.READY_STATE_LOADING = 1;
net.READY_STATE_LOADED = 2;
net.READY_STATE_INTERACTIVE = 3;
net.READY_STATE_COMPLETE = 4;
net.ContentLoader = function(key, method, url, params, onload, onerror, contentType, headers) { // Constructor
	this.hashKey = key;
	this.unrequestBrowser = false;
	this.req = null;
	this.onload = onload;
	this.onerror = (onerror) ? onerror : this.defaultError;
	this.loadXMLDoc(method, url, params, contentType, headers);
}
net.ContentLoader.prototype = { // Methods
	loadXMLDoc : function(method, url, params, contentType, headers) {
		if (!method) method="GET";
		if (!contentType && method=="POST") contentType='application/x-www-form-urlencoded';
		if (window.XMLHttpRequest) {
			this.req=new XMLHttpRequest(); 
		} else if (window.ActiveXObject){
			this.req=new ActiveXObject("Microsoft.XMLHTTP");
		} else {
			this.unrequestBrowser = true;
			return;
		}
		if (this.req) {
			try {
				this.req.open(method,url,true);
				if (contentType){
					this.req.setRequestHeader('Content-Type', contentType);
				}
				if (headers) {
					for (var h in headers) {
						this.req.setRequestHeader(h,headers[h]);
					}
				}
				var loader=this;
				this.req.onreadystatechange=function() {
//					loader.onReadyState.call(loader);
				    /* Заглушка для	старых версий библиотеки JScript в IE */
				    req = loader.req;
                                    var ready=req.readyState;
                                    if (ready==net.READY_STATE_COMPLETE) {
                                        var httpStatus=req.status;
                                        if (httpStatus==200 || httpStatus==0) {
                                            loader.onload();
                                        } else {
                                            loader.onerror();
		                	}
				    }
				}
				this.req.send(params);
			} catch (err){
				this.onerror.call(this);
			}
		}
	},
	onReadyState : function() {
		var req=this.req;
		var ready=req.readyState;
		if (ready==net.READY_STATE_COMPLETE) {
			var httpStatus=req.status;
			if (httpStatus==200 || httpStatus==0) {
				this.onload.call(this);
			} else {
				this.onerror.call(this);
			}
		}
	},
	defaultError : function() {
		alert("error fetching data!"+"\n\nreadyState:"+this.req.readyState +"\nstatus: "+this.req.status+"\nheaders: "+this.req.getAllResponseHeaders());
	}
}
// Multy requests
var requestsHash = [];
function setAjaxRequest(method, url, params, onload, onerror, contentType, headers, _link) {
	// Check of necessary parameters
	if (!(url && params)) {
		alert("Necessary parameters are not specified");
		return;
	}
	requestsHash[requestsHash.length] = new net.ContentLoader(requestsHash.length, method, url, params, onload, onerror, contentType, headers);
	requestsHash[requestsHash.length] = (_link) ? _link : 0;
	return requestsHash[requestsHash.length - 2].unrequestBrowser;
}


/////////////////////////////// ads 

$(document).ready(function() {



	//alert ('');
	//-------------------------------------- Contact --------------------------
	//Show hiden number (phone/gg/skype)
	
	
	
	
	if ($('.link-spoiler-show')){
	

	$('.link-spoiler-show').bind('click', function(){
	

	
	
	$thiz = $(this);
		var $li = $thiz.closest('li.icon');
		var type = $li.hasClass('icon-phone') ? 'phone' : ($li.hasClass('icon-skype') ? 'skype' : 'comunicator');
		//alert  ($thiz.metadata().data);
		
		$.post($thiz.metadata().url, {data: $thiz.metadata().data, type: type, id : $li.closest('ul.contact-data').metadata().id, pdate: $thiz.metadata().pdate}, function(data){

//alert("");		
		$element = $thiz.closest('li');
		
	if (data.indexOf("доступ", 0) == -1){	
	
	
			if (data.indexOf("atal error", 0) > -1){	
			$element = $thiz.siblings('strong');
			$element.html('<span style="color:#336699;">' +'Ошибка. Попробуйте еще раз.' + '<\/span>');
			
			}
			else{
	       
			$element.children().remove();
			$element.html($element.html() + '<strong>' + data + '</strong>');
			}
			
	}		
	else
		{
		$element = $thiz.siblings('strong');
		$element.html('<span style="color:#336699;">' + data + '<\/span>');
	}
			
	
	
		


	
				
			
	$('.mention-hint-'+$li.closest('ul.contact-data').metadata().id).show();
	$('.mention-hint-'+$li.closest('ul.contact-data').metadata().id).animate({
     height: '18px'
    }, 200, function() {
    // Animation complete.
    });
		


		
			
			
		});

		return false;
	});
	
	//if ($('.layer-contact-expired').length != 0) {
	//	$('.offer-head').before('<div class="scale-indent"><div class="layer-rounded layer-notification layer-notification-offer-expired"><div class="top"><span class="right"></span><span class="left"></span></div><div class="inner"><h2></h2><p></p></div><div class="bottom"><span class="right"></span><span class="left"></span></div></div>');
	//	$('#body-container .wrapper .content div.layer-notification-offer-expired .inner h2').append(_translate_This_ad_is_expired);
	//	$('#body-container .wrapper .content div.layer-notification-offer-expired .inner p').append(_translate_Check_similar_ads);
	//	$('.offer-head').before($('.offer-related-offers').clone());
	//	$('.offer-head').before($('.related-offers').clone());
	//	$('body').addClass('offer-expired');
	//}
	
	}
	
});



///////////////////// common


























$.fn.wait = function(time, type) {
    time = time || 1000;
    type = type || "fx";
    return this.queue(type, function() {
        var self = this;
        setTimeout(function() {
            $(self).dequeue();
        }, time);
    });
};
    
var common = {
    init: function()
    {
	//alert ("-");
        $('#region').change(function(){
            if ($(this).val() == '0') {
                $('option:first', this).attr('selected', true);
                $('#overlay_region').overlay(common.selectRegion).load();
                common.getRegions();
            }
        });
    },
    selectRegion: {
        api: true,
        oneInstance: false,
        speed: 'fast',
        expose: {
            color: '#BBB',
            loadSpeed: 100,
            opacity: 0.6
        },
        onBeforeLoad: function()
        {
            // locate, clear and fix IE6 select bug
            $('.overlay#overlay_region').bgiframe();           
            $('.contentWrap#popup_region').html('<img src="'+static_prefix+'/i/theme/avito/i/ajax-loader-big.gif" alt="Загрузка продолжается..." style="margin:125px auto;display:block" />');
        },        
        onClose: function()
        {
            $('#popup_region').html('');
        }        
    },
    selectLocation: function (loc_id, loc_name)
    {
        $('#region option:first').attr('selected', true);
        if ($('#region option[value='+loc_id+']').size() == 0) {
            $('#region option:first').after($('<option />').val(loc_id).text(loc_name));
        }
        $('#region').val(loc_id).change();
        $('#overlay_region').overlay().close();
    },
    getRegions: function ()
    {
        var wrap = $('.contentWrap#popup_region');
        $.get('/js/locations', function(res) {
                wrap.html(res);
                // links top locations
                $('a', wrap).click(function(){
                    var loc = parseInt( $(this).attr('id').substr(9) );
                    common.selectLocation(loc, $(this).text());
                });

                var loc1 = $('select[name=loc_1]', wrap);
                var loc2 = $('select[name=loc_2]', wrap);

                if (!loc2.hasClass("catalog")) {
                    $('#apply_region').attr({'disabled': true});
                }
                // select other
                $(loc1).change(function(){

                    if ( $.inArray($(this).val(), ['621540', '637640', '653240']) != -1  ) {
                        loc2.html('<option value="">&nbsp;</option>')
                            .attr({'disabled': true});
                        switch (loc2.hasClass("catalog") || $.inArray($(this).val(), ['637640', '653240']) != -1) {
                            case true:
                                $('#apply_region').attr({'disabled': false});
                                break;
                            default:
                                $('#apply_region').attr({'disabled': true});
                        }

                    } else {
                        $('#apply_region').attr({'disabled': true});
                        loc2.html('<option value="">Идёт загрузка...</option>')
                            .attr({'disabled': true});
                        $('#apply_region').attr({'disabled': true});
                        $.getJSON('/js/locations', {'json':1,'id':$(this).val()}, function(locations) {
                            $.each(locations, function(i, location) {
                                loc2.append($('<option />').val(location.id)
                                                           .text(location.name));
                            });

                            $('option:first', loc2).text('Выбрать город');

                            loc2.attr({'selectedIndex': 0,
                                        'disabled': false
                                     });

                            if (loc2.hasClass("catalog")) {
                                $('#apply_region').attr({'disabled': false});
                            } else {
                                loc2.change(function (){
                                    switch (loc2.attr('selectedIndex')) {
                                        case 0:
                                            $('#apply_region').attr({'disabled': true});
                                            break;
                                        default:
                                            $('#apply_region').attr({'disabled': false});
                                        }
                                    }
                                );
                            }
                        });
                    }
                });

                // select other submit
                $('button', wrap).click(function(){
                    var loc = (loc2.val() == '') ? loc1 : loc2;
                    common.selectLocation(loc.val(), $('option:selected', loc).text());
                });

            });
    },
    getStat: function(item, step){
        $('.contentWrap#popup_statistics').html('<img src="'+static_prefix+'/i/theme/avito/i/ajax-loader-big.gif" alt="Загрузка продолжается..." style="margin:200px auto;display:block" />');
        var path = '/items/stat/'+item;
        $.post(path,{step: step}, function(res) { // get does not work in IE6/7
            $('.contentWrap#popup_statistics').html(res);
        });
       return false;
    },
    track_ga_event: function(Category, Action, Label, Value)
    {
        _gaq.push(['_trackEvent', Category, Action, Label, Value]);
    }
}

$(document).ready(function(){common.init()});
