























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