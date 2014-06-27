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
 
 //$('#big_pic_su').animate({height: '500'}, 3000, function() {});




 $('#big_pic_su').show();
	});
}	


if ($('#li_ar')){

$('#li_ar').click(function(){
//alert();
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
	
})























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





