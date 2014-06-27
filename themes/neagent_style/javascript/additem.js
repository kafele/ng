//alert("additem");


$uploadscript='http://neagent.by/realt/upload/default'; // если обычная загрузка

$uploadscript='http://neagent.by/realt/upload/sutki'; // если на сутки то там меняется размер превьюшек просто

var additem = {
    init: function()
    {
        additem.form = $('#form_item');
        additem.params = $('#filters');
        additem._buildFilters();
        $('#fld_category_id').change(function(){
		//alert("change");
            additem.onChangeCategory();
            additem._buildFilters();
        });
        $('#region').change(function(){additem.onChangeLocation()});
        $('#allow_mails').click(function(){additem.onCheckMails()});
        $('input[name=private]').change(function(){if($(this).val()=='1'){$('#irename').text('Ваше имя');}else{$('#irename').text('Название компании');}});
        $('#right_price, #no_doublets').click(function(){
            window.open($(this).attr('href'),'','width=600,height=600,scrollbars=yes');
            return false;
        });
        $('#files div a').click(function(){
            $(this).parent().remove();
            
            if ($('#files div').size() < 6)
            {
                $('#fld_images_toomuch').hide();
                $('#fld_images').show();
            }
            
            if ($('#files div').size() == 1)
                $('#files').hide();
            
            return false;
        });
        
        if ($('#files div').size() == 6)
        {
           $('#fld_images').hide();
           $('#fld_images_toomuch').show();
        }
          
        $('#fld_images').change(
            function() {
                ajaxUpload(this.form,$uploadscript,'files');
                return false;
            }
        );
        additem.loadTooltips();
        additem.createTitles();
    },
    
    _buildFilters: function() {
        var selects = $('#params').find('select[id]');
        var cid = $('#fld_category_id').val();
        var par = new Array();
        var c_filters = new Array();
        $.each(selects, function(i){
            par[i] = selects.eq(i).attr('id').split('_');
            id = selects.eq(i).attr('id');
            pid = parseInt(par[i][2]);
            tid = parseInt(par[i][3]);
            stid = parseInt(par[i][4]);
            
            var pval = $('select[id=fld_param_'+pid+'] option:selected').val();
            
            n = par[i].length - 2;

            switch (n) {
                case 1:
                    if (typeof(filters[cid]['_'+pid]) != 'undefined' && !c_filters[pid]){
                        c_filters[pid] = true;
                        var pirs = filters[cid]['_'+pid];
                        $.each(pirs, function(i){
                            if( i == 0 ) return true;
                            additem.setChangeEvent(pid, pirs, i);                            
                        });
                    }
                    break;
                case 2:
                    if (typeof(filters[cid]['_'+pid][pval]) != 'undefined' && !c_filters[tid]){
                        c_filters[tid] = true;
                        var paras = filters[cid]['_'+pid][pval]['_'+tid];
                        
                        $.each(paras, function(n,v){
                            if( n == 0 ) return true;
                            additem.setChangeEvent(pid+'_'+tid, paras, n);                                                   
                        });
                    }
                    break;
            }
            
        });
        
    },
    
    setChangeEvent: function(el_id, paras, n){

        $('#fld_param_'+el_id).change(function(){
            el_val = '_'+$(this).val();
            if (el_val == '_') {
                additem.clearFilters(el_id);
            } else {
                $.each(paras[n],function(pi,pv){
                    if( pi == 0 ) {return true;}
                                        
                    var f_id = 'fld_param_'+el_id+pi;
                    
                    if (el_val == n) {
                        ps = pi.substring(1);
                                               
                        if (pv[0][1] == 't' && $.isArray(pv[0])) {
                            p_name = pv[0][0];
                        } else {
                            p_name = pv[0];
                        }                       
                                               
                        var fld = $('<div class="selectParam" />')
                            .attr('id', 'f_param_' + el_id + pi)
                            .append( $('<select />').attr({
                                'id': f_id,
                                'name': 'params[' + ps + ']',
                                'title': 'Выберите '+p_name
                            }));        
                        var src = $('#fld_param_' + el_id + pi, fld);
                        
                        $.each(pv, function(sid, sval){

                            if( sid == 0 ) {
                                src.append( $('<option />').val('').text('--- '+sval+' ---') );
                            } else {
                                sid = sid.substring(1); 
                                src.append( $('<option />').val(sid).text(sval[0]) );
                            }
                            
                        });
                        
                        additem.clearFilters(el_id);
                        $('#filters').append(fld);
                        
                        $.each(pv, function(sid){
                            if( sid != 0 ) {                                 
                                additem.setChangeEvent(el_id+pi, paras[n][pi], sid);
                            }                            
                        });
                        
                        
                    }
                });
            }
        });
    },
    
    clearFilters: function(id){
        $('div[id^=f_param_'+id+'_]', $('#filters')).remove();
    },
    
    onChangeCategory: function()
    {
        $('#params', additem.form).remove();
        var c_id = $('#fld_category_id').val();
		//alert (c_id);
		
		
		
        if ( c_id && typeof(filters[c_id]) != 'undefined') {
//            Removing params div if params length is zero
 //alert ("000");
            if (filters[c_id].length) return true;
             //alert ("001");
            $('<div id="params" />')
                .append('<label><span class="red">*</span>Выберите параметры:</label>')
                .append('<div id="filters" class="params" />')
                .insertBefore('#f_for_sale');
             //alert ("002");   
            $.each(filters[c_id], function(p_id, p_v){
                if( p_id == 0 ) return true;
                ps = p_id.substring(1);
                
                if (p_v[0][1] == 't' && $.isArray(p_v[0])) {
                    p_name = p_v[0][0];
                } else {
                    p_name = p_v[0];
                }
                
                var field = $('<div class="selectParam" />')
                    .attr('id', 'f_param' + p_id)
                    .append( $('<select />').attr({
                        'id': 'fld_param' + p_id,
                        'name': 'params[' + ps + ']',
                        'title': 'Выберите '+p_name
                    }));        
                var src = $('#fld_param' + p_id, field);
                
                $.each(p_v, function(p_d, v_l){

                    if (p_d == 0 && p_v[0][1] == 't' && $.isArray(p_v[0])) {
                        src.append( $('<option />').val('').text('--- '+p_v[0][0]+' ---') );
                    } else if( p_d == 0 ) {
                        src.append( $('<option />').val('').text('--- '+v_l+' ---') );
                    } else {
                        p_d = p_d.substring(1); 
                        src.append( $('<option />').val(p_d).text(v_l[0]) );
                    }

                });                

                $('#filters').append(field);
                
            });            

        }
    },
    
    loadTooltips: function()
    {
  //      $("#form_item input[type='text'],textarea").tooltip({
 //           position: "center right",
 //           offset: [0,10],
 //           tip: '.tooltip',
 //           delay: 0
  //      });
    },
    
    onCheckMails: function() {
        if ($('#allow_mails').attr('checked')) {
            $('#fld_phone_label').html('<span class="red">*</span>Номер телефона:');
        } else {
            $('#fld_phone_label').html('Номер телефона:');
        }
    },   
    
    onChangeLocation: function()
    {
        $('#f_metro_id').remove();
        var loc_id = $('#region').val();
        if (loc_id == '0') {
            $('#region').val('');
            $('#overlay').overlay(common.selectRegion).load().wait();
        } else {
            $.getJSON('/js/metro', {'locid': loc_id}, function(metros){
                if (metros) {
                    var field = $('<div />').attr('id', 'f_metro_id')
                        .append( $('<select />').attr({'id': 'fld_metro_id', 'name': 'metro_id'}) );

                    var slc = $('#fld_metro_id', field)
                        .append( $('<option />').val('').text('--- Выберите станцию метро ---') );
                    $.each(metros, function(i, metro){
                        slc.append('<option value="' + metro.id +'">'+ metro.name +'</option>');
                    });
                    field.prependTo('#f_location_id');
                }
            });
        }
    },
    
    showPopup: function(el)
    {
        var href = el.attr('href');
        var item = $('#item_id').html();
        $('#overlay_service').overlay({
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
             $('.overlay#overlay_service').bgiframe();
             $('.contentWrap#popup_service').html('');
            },
            onClose: function()
            {
              $('.contentWrap#popup_service').empty();
            }
        }).load();
        $.get('/js/popup', {href: href, item: item}, function(res) {
           $('.contentWrap#popup_service').append(res);
        });
    },
    
    createTitles: function()
    {        
        var placeId = $('#f_param_210').next().children('select').attr('id');
        $('#fld_category_id').change(function(){
            if ($('#fld_category_id option:selected').val() == 9) {
                $('#fld_param_210').change(function(){
                    additem.calcAuto();
                    placeId = $('#f_param_210').next().children('select').attr('id');
                    $('#'+placeId).change(function(){
                        additem.calcAuto();
                    });
                    $('#fld_param_188').change(function(){
                        additem.calcAuto();
                    });
                });                
            }
        });
        $('#fld_param_210').change(function(){
            additem.calcAuto();
            placeId = $('#f_param_210').next().children('select').attr('id');
            $('#'+placeId).change(function(){
                additem.calcAuto();
            });
        });
        $('#'+placeId).change(function(){
            additem.calcAuto();
        });
        $('#fld_param_188').change(function(){
            additem.calcAuto();
        });
    },
    
    calcAuto: function()
    {        
        var title = '';
        var brand;
        var year;
        var model;
        if ($('#fld_param_188 option:selected').val()) {
            year = ', ' + $('#fld_param_188 option:selected').text();
        } else { year = '' }
        if ($('#f_param_210 option:selected').val()) {
            brand = $('#f_param_210 option:selected').text();
        } else { brand = '' }
        var place = $('#f_param_210').next().children('select').find(':selected');
        if (place.val() != '' && place.text() != 'Другое' ) {
            model = ' ' + place.text();
        } else { model = '' } 
        title = brand + model + year;
        $('#fld_title').val(title);
    }
}

var userAgent = navigator.userAgent.toLowerCase();

jQuery.browser = {
    version: (userAgent.match( /.+(?:rv|it|ra|ie|me)[\/: ]([\d.]+)/ ) || [])[1],
    chrome: /chrome/.test( userAgent ),
    safari: /webkit/.test( userAgent ) && !/chrome/.test( userAgent ),
    opera: /opera/.test( userAgent ),
    msie: /msie/.test( userAgent ) && !/opera/.test( userAgent ),
    mozilla: /mozilla/.test( userAgent ) && !/(compatible|webkit)/.test( userAgent )
};

$(document).ready(function(){additem.init();});