






upTime = 1000;
objRequestDebounced = false;
objCountDebounceFn = false;

qsPath="http://wa.by/qs";

$(document).ready(function(){	

 perc=1;







































if ($('#textsel')) {
        $('#textsel').change(function(){
                $('#textselvalue').attr('name', ('text' + $(this).attr('value')));
        })
	}

	
		

	searchFormObject = $('#search-objects-form');
		
	searchFormObject = 'form'; 

//alert("searchFormObject.length=" + searchFormObject.length);
	
	if (searchFormObject.length) {
	
	
	  //$(".searchButton").before("<div style='border:2px solid red;height:40px;'>").after("ll</div>");;
	    
	//$(searchFormObject).find('input[type=submit]').before("Hello");
	 
	
	
	
	
		$(searchFormObject).find('input, select').change(updateObjectsCount);
		$(searchFormObject).find('input, select').keypress(updateObjectsCount);
$(searchFormObject).find('input, select').change(updateObjectsCount);
		$(searchFormObject).find('input[type=checkbox]').click(updateObjectsCount);
		if ($.browser.msie) {
			$(searchFormObject).find('input[type=checkbox]').click(updateObjectsCount);
		}
		
		//alert("keyup(updateObjectsCount)");
		$(searchFormObject).find('input[type=text]').keyup(updateObjectsCount).focus(function(){
			if (objRequestDebounced) {
				updateObjectsCount();
			}
		});
	
		$(searchFormObject).find('input[type=reset], a.reset').click(function(){
			$(searchFormObject).find('input[type=checkbox]').removeAttr('checked');
			$(searchFormObject).find('option').removeAttr('selected');
			$(searchFormObject).find('input[type=text]').val('');
			updateObjectsCount();
			return false;
		});
		 
		$('#change-search-parameters').click(function(){
			
			if ($('#search-parameters-form').css('display') == 'none') {
				$('#search-parameters-form').show();
			} else {
				$('#search-parameters-form').hide();
			}
		});
		
		getObjectsCount();	

       cur_count= getCurCount(cur_form);
		
	}
});





function updateObjectsCount() {	
//alert("updateObjectsCount");
//alert(searchObjectsAjaxPath);
	objRequestDebounced = true;
	
	if (!objCountDebounceFn) {
	 //alert("!objCountDebounceFn!");
		objCountDebounceFn = debounce(getObjectsCount, 1000);
	}
	// ################## deleted
	//objCountDebounceFn();
}

function getObjectsCount(){	
	objRequestDebounced = false;
	 // alert("enter getObjectsCount");
	//alert(searchObjectsAjaxPath);
	$('#search-objects-form').find('.preview-objects-count').addClass('preview-objects-count-loading');
	
	
	
	
	searchQuickObjectsAjaxPath = qsPath;
	var  hValues= $('#' + searchQuickObjectForm).serialize()
	 if(timeAjaxWite != undefined)
			clearTimeout(timeAjaxWite);
		timeAjaxWite = setTimeout(function(){
			thisajax = $.ajax({
			url: searchQuickObjectsAjaxPath,
			data: hValues,
				success: function(data) {
					isloading = false;
					

cur_count=getCurCount(cur_form);
//alert ("data=" + data); 
 //alert ("cur form" + cur_form);  
 //alert ("cur count=" + cur_count); 
 //alert ("serchobjcount=" & searchQuickObjectForm);
		 
					if(parseInt(data) === 0) {
					data="-"
					} else {
					data=parseInt(data)
					}
 updatebutton(data);

					 $('#' + searchQuickObjectForm).find('#preview-quick-objects-count .count').html('Объектов: ' + data);
                     $('#count_'+cur_form).html('Объектов: ' + data);
				}
			});
		},500);
	
	
	
	
	
	
	
	
	
	 
	
}



function updatebutton(dat){

if (dat=="-")  {
dat=0;
 
}


if(parseInt(dat) === 0) {
					dat=0;
					} else {
					dat=parseInt(dat);
					}


if (!( cur_count >0 )){
cur_count=600;
}					
					

perc = 150*  dat/cur_count ;
 //alert (perc); 
//$('#buttonful').width( perc);




perc = parseInt(perc)


if  (!perc>1 ) {perc=1;

} 
 
//alert (perc); 
if  ($('#buttonful_' + cur_form)) {
$('#buttonful_' + cur_form).animate({
    width:  perc
    
  }, 1000, function() {
    // Animation complete.
  });

}





}








function changeDistrictsState(containerId){
	
	if ($('#' + containerId).find('input[type=checkbox][checked]').length == 0) {
		$('#' + containerId).find('input[type=checkbox]').attr('checked', true);
	} else {		
		$('#' + containerId).find('input[type=checkbox]').removeAttr('checked');
	}
	
	updateObjectsCount();
}


function changeSubwayState(containerId){	
	if ($('#' + containerId).find('option[selected]').length == 0) {
		$('#' + containerId).find('option').attr('selected', true);
	} else {		
		$('#' + containerId).find('option').removeAttr('selected');	}
	
	updateObjectsCount();
}

function test(){
	$.postForm(searchObjectsAjaxPath, $('#search-objects-form'), function(){
		alert('asd');
	});
}

(function($) {
	$.extend({
		postForm: function(url, form, callback, type){
		data = new Object();
		
		this.isArrayElement = function (name) {
			return name.substring(name.length 	 - 2);
		}
		 
		jQuery(form).find('input[name!=""],select[name!=""],textarea[name!=""]').each(function(id, element){
			jElement = jQuery(element);
			tagName = jElement.attr('tagName');
			elementName = jElement.attr('name');
			isArray = elementName.substring(elementName.length - 2) == '[]';
			elementValue = false;
			
			switch (tagName.toLowerCase()) {
				case 'input':
					elementType = jElement.attr('type');
					
				

				
				
				
				

				switch (elementType) {
						case 'checkbox':									
							if (jElement.attr('checked') == true) {							
								elementValue = jElement.val();
							}
						break;
						default:
							elementValue = jElement.val();
						break;
					}
				break;
				case 'select':
					if (isArray) {			
						data[elementName] = new Array();
						optionsCount = 0;
						jElement.find('option').each(function(optionId, option){
							jOption = jQuery(option);
							if (jOption.attr('selected')) {
								data[jElement.attr('name')][optionsCount++] = jOption.val();
							}
						});
					} else {
				




				elementValue = jElement.val()
					}				
				break;
				case 'textarea':
					elementValue = jElement.val();
				break;
			}
			
			
			
			
			
			
			if (isArray) {
				if (!data[elementName])  {
					data[elementName] = new Array();
				}
				
				newElementId = data[elementName].length;
				if (elementValue) {
					data[elementName][newElementId] = elementValue;
				}
			} else if(elementValue) {				
				data[elementName] = elementValue;
			}
		});
		
		if (typeof type != 'undefined' && type == 'json') {
			postFn = jQuery.getJSON;
		} else {
			postFn = jQuery.post;
		}
		
		delete(elementValue);
		
		postFn(url, data, callback);
	}
	})

        
})(jQuery);












var timeout;
function debounce   (callback, delay) {

 
 
clearTimeout(timeout);
timeout = setTimeout(callback, delay);
 
} 

function getCurCount(c_form){
 //alert  ("###" + c_form )
if ((c_form == "nb")|| (c_form == "nb   ")) {
return 600;
//alert ("nbbbb")
}
if ((c_form == "ar") || ("c_form == ar   ")) {
//alert ("arrrrrrr")
return 450;
}
return  -1;
}