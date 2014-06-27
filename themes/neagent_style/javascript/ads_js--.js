$(document).ready(function() {
	

	
	//-------------------------------------- Contact --------------------------
	//Show hiden number (phone/gg/skype)
	
	if ($('.link-spoiler-show')){
	$('.link-spoiler-show').bind('click', function(){
		$thiz = $(this);
		var $li = $thiz.closest('li.icon');
		//alert ('li');
		var type = $li.hasClass('icon-phone') ? 'phone' : ($li.hasClass('icon-skype') ? 'skype' : 'comunicator');
		//alert ($thiz.metadata().url);
	
		
		
		$.post($thiz.metadata().url, {data: $thiz.metadata().data, type: type, id : $li.closest('ul.contact-data').metadata().id}, function(data){
			//alert (data);
			$element = $thiz.closest('li');
			$element.children().remove();
			$element.html($element.html() + '<strong>' + data + '</strong>');
			$('.mention-hint-'+$li.closest('ul.contact-data').metadata().id).show();
		});
		return false;
	});
	
	if ($('.layer-contact-expired').length != 0) {
		$('.offer-head').before('<div class="scale-indent"><div class="layer-rounded layer-notification layer-notification-offer-expired"><div class="top"><span class="right"></span><span class="left"></span></div><div class="inner"><h2></h2><p></p></div><div class="bottom"><span class="right"></span><span class="left"></span></div></div>');
		$('#body-container .wrapper .content div.layer-notification-offer-expired .inner h2').append(_translate_This_ad_is_expired);
		$('#body-container .wrapper .content div.layer-notification-offer-expired .inner p').append(_translate_Check_similar_ads);
		$('.offer-head').before($('.offer-related-offers').clone());
		$('.offer-head').before($('.related-offers').clone());
		$('body').addClass('offer-expired');
	}
	
	}
	
});

function setMainImage(url, id) {
	$li = $('ul.gallery-browser li');
	$img = $li.find('img');
	$img.removeClass('active');
	$img.addClass('inactive');
	$li.eq(id - 1).find('img').removeClass('inactive').addClass('active');
	$('#gallery_main_img').attr('src', url).metadata().id = id;
}

function preloadImg(image){
	$img = $('<img>').attr({'src': image}).hide();
	$('body').append($img);
}