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

