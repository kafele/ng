function ajaxUpload(form,url_action,id_element){
    form = typeof(form)== "string"?$('#'+form):form;
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id","ajax-temp");
    iframe.setAttribute("name","ajax-temp");
    iframe.setAttribute("width","0");
    iframe.setAttribute("height","0");
    iframe.setAttribute("border","0");
    iframe.setAttribute("style","width: 0; height: 0; border: none;");
    form.parentNode.appendChild(iframe);        
    window.frames['ajax-temp'].name="ajax-temp";        
        if (id_element != 'logo'){
            $('#progress').show();
			//alert ("показан прог");
            $('#files').show();
			//alert ("показаны файлы");
        }
        $('#ajax-temp').load(function(){
            doUpload();
        });        
    form.setAttribute("target","ajax-temp");
    form.setAttribute("action",url_action);
	//alert (url_action);
    form.setAttribute("method","post");
    form.setAttribute("enctype","multipart/form-data");
    form.setAttribute("encoding","multipart/form-data");
    form.submit();
    form.removeAttribute("target");
    form.setAttribute("action",window.location.href);
     $('#fld_images').attr('disabled',true);
}

function doUpload(){
    var frame = $('#ajax-temp').contents().find('body');
    var imageName = frame.html();
    frame.empty();    
    $('#progress').hide(); 
//alert("loaded");
	 //alert(imageName);
    if (imageName.substr(0, 5) == 'error') {
       //alert(imageName.substr(7));
        if ($('#files div').size() == 1)
            $('#files').hide();
    } else if (imageName.substr(0, 4) == 'http' && $('#files img').attr('src') != imageName ) {
	
	 //alert(imageName);
	
        $('<div></div>')
            .append('<input type="hidden" name="images[]" value="'+imageName+'" />')
            .append('<table cellpadding="0" cellspacing="0"><tr><td><img src="'+ imageName.replace('_80x60', '_100x75') +'" alt="" /></td></tr></table>')
            .append(
                $('<a class="aj delete"><span>удалить</span></a>').click(function(){
                    $(this).parent().remove();
                    
                    if ($('#files div').size() < 6)
                    {
                        $('#fld_images_toomuch').hide();
                        $('#fld_images').show();
                    }
                    
                    if ($('#files div').size() == 1)
                        $('#files').hide();
                    
                    return false;
                })
            ).insertBefore('#progress');
        
        if ($('#f_images .images a').size() == 5)
        {
            $('#fld_images').hide();
            $('#fld_images_toomuch').show();
        }
        
        if ($('#files div').size() > 5)
        {
            $('#fld_images').hide();
            $('#fld_images_toomuch').show();
        }
    }
    else if (imageName.substr(0, 4) == 'shop') {
        var host = $('#media_host').val();
        var image_id = imageName.substr(4);
        $('<div></div>')
            .append('<input type="hidden" name="images[]" value="'+image_id+'" />')
            .append('<table cellpadding="0" cellspacing="0"><tr><td><img src="http://'+ host + '/images/thumb/' + imageName +'.jpg" alt="" /></td></tr></table>')
            .append(
                $('<a class="aj delete"><span>удалить</span></a>').click(function(){
                    $(this).parent().remove();
                    var image_id = $(this).parent().find('input').val();
                    $.post('/profile/shop_photo_remove', {
                        image_id: image_id
                    }, function(data) {
                        if ($('#files div').size() == 1)
                        $('#files').hide();
                    });
                    return false;
                })
            )
            .insertBefore('#progress');
    }
    else if (imageName.substr(0, 4) == 'logo') {
        var host = $('#media_host').val();
        var logo_id = imageName.substr(4);
        //$('#files').hide();
        $('<div id="shop_logo"></div>')
            .append('<p class="shop_logo"><img src="http://'+ host + '/images/thumb/' + imageName +'.jpg" alt="" /></p>')
            .append(
                $('<p class="remove_shop_logo"><a class="aj delete" href="/profile/shop_logo_remove"><span>удалить</span></a></p>').click(function(){
                    $('#shop_logo').remove();
                    $.post('/profile/shop_logo_remove', function(data) {
                        
                    });
                    $('#logo_upload_form').show();
                    return false;
                })
            )
            .insertBefore('#logo_upload_form');
            $('#logo_upload_form').hide();
    }
    $('#fld_images').attr('disabled',false);
    $('#ajax-temp').unload(function(){            
        doUpload();
    });
}