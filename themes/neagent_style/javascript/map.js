var base_url="http://neagent.by/";






function OnLinksFetched(response)
{
		//alert("response.responseXML");
		//alert(response.responseXML);
		
		
		response_text =  response.responseText;

     //alert(response_text);
			var PointsList = response.responseXML || "no response XML";
			
			
		 
			
	






var PointsCollection = new YMaps.GeoObjectCollection();
			var curBalloon;
			var curOffer;
			var placemarkToOpen;
			if (map.getBalloon())
			{
				curBalloon = map.getBalloon();
			}
			else
				{curBalloon = null;
				//alert ("балун не добавлен");
				}










xmlDoc = $.parseXML( response_text );
   // $xml = $( xmlDoc );

len1=$(xmlDoc).find('point').length;
//alert(len1);
l1=0  ;

var a=0;
$(xmlDoc).find('point').each( 
 	                   function() 
 	                   { 
					   a=a+1;
   
   
   
   
    pLongitude = $(this).attr('longitude');
	pLatitude = $(this).attr('latitude');
	var point = new YMaps.GeoPoint(pLongitude,pLatitude);
   
  

/////////////////////  if (12 < 16)	{
				
				var desc="";
				
   				//	var placemark = new YMaps.Placemark(point,{style:'#sOfferShort'});
			if (a<10){	
			var placemark = new YMaps.Placemark(point,{style:'#sOfferNew'});
			}
			else
			{
			var placemark = new YMaps.Placemark(point,{style:'#sOfferShort'});
			}
			
            placemark.name = "Москва";
					YMaps.Events.observe(placemark,placemark.Events.Click,function(mEvent){
					update=false;
					//window.open('http://www.shildim.narod.ru/','newwin')
					//update=false;map.setCenter(mEvent.getGeoPoint());update=true;map.setZoom(map.getZoom()+1);
					});
					
					placemark.offers = $(this).attr('offers');
					placemark.name = $(this).attr('street') + ", "  + $(this).attr('number');  // Заголовок балуна
placemark.description = "Описание метки"; // Текст балуна
					// placemark.name = "Москва";
   
   
 	                   // alert($(this).attr('longitude')); 
						//of = jQuery(this).find('offer');
						
						len2=$(this).find('offer').length;
						//alert("l2=" . len2);
						l2=0  ;
					 	$(this).find('offer').each( 
					 	function() 
					 	{ 
					 	 //alert(a);
						
						desc  += 'Комнат: '+$(this).attr('rooms')+'<br>Цена:'+$(this).attr('price')+' $.<br><a href="http://neagent.by/'+$(this).attr('url')+'" target="_blank">Подробнее (в новом окне)</a><br>';
						
						
						
						
						l2 = l2 +1;
						if (l2>len2){
						alert('выход2');
						return false; 
						}
						
						//alert(jQuery(this).attr('url')); 
					 	});

						
 	                    //    title = jQuery(this).find('title').text(), 
 	                    //    url = jQuery(this).find('url').text(), 
 	                    //    desc = jQuery(this).find('desc').text(); 
 	                    //jQuery('<div class="items"></div>').html('<h2><a href="'+url+'">'+title+'</a></h2><p>'+desc+'</p>').appendTo('#xml-data'); 
 	                 
					 l1 = l1 +1;
					 if (l1+30>len1){
					// alert('выход');
					// return false; 
					 }
					

placemark.description = desc;
PointsCollection.add(placemark);					
					 
 	                });  
   


					
					
 	
			map.removeAllOverlays();
			map.addOverlay(PointsCollection);
			if (placemarkToOpen)
				placemarkToOpen.openBalloon();
}





function MapView_Ini( )
{
//alert("response.responseXML");
//alert(response.responseXML);
//response_text =  response.responseText;
//alert(response_text);
//var PointsList = response.responseXML || "no response XML";

var PointsCollection = new YMaps.GeoObjectCollection();
			var curBalloon;
			var curOffer;
			var placemarkToOpen;
			if (map.getBalloon())
			{
				curBalloon = map.getBalloon();
			}
			else
				{curBalloon = null;
				//alert ("балун не добавлен");
			}
//xmlDoc = $.parseXML( response_text );
//$xml = $( xmlDoc );
len1=50; // ?? 
//alert(len1);
l1=0  ;
var a=0;
 
for(i = 0; i < map_points.length; i++){
//alert( "lenth" + map_points.length );
//alert( "i" + i );
	a=a+1;
    pLongitude = map_points[i]['longitude'];
	pLatitude = map_points[i]['latitude'];
	var point = new YMaps.GeoPoint(pLongitude,pLatitude);

/////////////////////  if (12 < 16)	{
				
			var desc="";
   				//	var placemark = new YMaps.Placemark(point,{style:'#sOfferShort'});
				
		//	if (a<10){	
		//	var placemark = new YMaps.Placemark(point,{style:'#sOfferNew'});
		//	}
		//	else
		//	{
		//	var placemark = new YMaps.Placemark(point,{style:'#sOfferShort'});
		//	}
			//ind=a+1;
			ind=a;
			var placemark = new YMaps.Placemark(point,{style:'#sOffer'+ind});
			
			
			// alert("l3=" . len2);
            placemark.name = "Москва";
					YMaps.Events.observe(placemark,placemark.Events.Click,function(mEvent){
					update=false;
					//window.open('http://www.shildim.narod.ru/','newwin')
					//update=false;map.setCenter(mEvent.getGeoPoint());update=true;map.setZoom(map.getZoom()+1);
					});
					// alert("l4=" . len2);
					placemark.offers = map_points[i]['offers'] ;
					placemark.name =   map_points[i]['street'] +  ", "  + map_points[i]['number'];  // Заголовок балуна
placemark.description = "Описание метки"; // Текст балуна
					// placemark.name = "Москва";
   
   
 	                 // alert($(this).attr('longitude')); 
					 //of = jQuery(this).find('offer');
						
					 //len2=$(this).find('offer').length;
						len2=1;
					 // alert("l2=" . len2);
						l2=0  ;
						
						
		//	//	$(this).find('offer').each{ 
						
					 	 //alert(a);
						desc  += 'Комнат: '+map_points[i]['rooms']+'<br>Цена:'+map_points[i]['price']+' $.<br><a href="'+map_points[i]['url']+'" target="_blank">Подробнее (в новом окне)</a><br>';
						l2 = l2 +1;
						if (l2>len2){
						//alert('выход2');
						return false; 
						}
						
						//alert(jQuery(this).attr('url'));
						
		//	//	}

						
 	                    //    title = jQuery(this).find('title').text(), 
 	                    //    url = jQuery(this).find('url').text(), 
 	                    //    desc = jQuery(this).find('desc').text(); 
 	                    //jQuery('<div class="items"></div>').html('<h2><a href="'+url+'">'+title+'</a></h2><p>'+desc+'</p>').appendTo('#xml-data'); 
 	                 
					 l1 = l1 +1;
					 if (l1+30>len1){
					// alert('выход');
					// return false; 
					 }
					

placemark.description = desc;
PointsCollection.add(placemark);					
					 
 	                } 
   


					
					
 	
			map.removeAllOverlays();
			map.addOverlay(PointsCollection);
			if (placemarkToOpen)
				placemarkToOpen.openBalloon();
}





function singlepoint_ini( )
{
var PointsCollection = new YMaps.GeoObjectCollection();
			var curBalloon;			var curOffer;			var placemarkToOpen;
			if (map.getBalloon())
			{
				curBalloon = map.getBalloon();
			}
			else
				{curBalloon = null;
			}
var a=0;
	a=a+1;
    pLongitude = map_longitude;
	pLatitude = map_latitude;
	var point = new YMaps.GeoPoint(pLongitude,pLatitude);
			var desc="";
			ind=a;
			var placemark = new YMaps.Placemark(point,{style:'#sOfferNew'});
			placemark.name =   map_address;  // Заголовок балуна
placemark.description = "Описание метки"; // Текст балуна
placemark.description = desc;
PointsCollection.add(placemark);					
			map.removeAllOverlays();
			map.addOverlay(PointsCollection);
			if (placemarkToOpen)
			placemarkToOpen.openBalloon();
}






function makeQS(arr)
{
    var s = "";
    for ( var e in arr )
    {
       s += "&" + e + "=" + escape( arr[e] );
    }
    return s.substring(1);
}






function GetPoints()
{



if (typeof singlepoint != "undefined"){
if (singlepoint==1){
//alert(11);
singlepoint_ini();
return;
}
}


if (typeof mapview != "undefined"){
if (mapview==1){
MapView_Ini();
return;
}
}

	//if (update==false)
		//return;
	//alert("update");	
	var bounds = map.getBounds();
	var zoom = map.getZoom();
	//alert(Ajax);
	//alert ("getLat()");alert (bounds.getLeftBottom().getLat());
	
	

	var m_qs=makeQS(m_params);
	
	
	
	//var ajaxU = "&noCache=" + (new Date().getTime()) + Math.random(); 
	
 
	
	
	$.ajaxSetup({cache: false});
	
//	var url = base_url+'realt/getpointsXML';
//    var params = "name=John&location=Boston&"+ m_qs;
//	var method = "POST";
//    var onload = OnLinksFetched;
//    var contentType = "text/xml; charset=\"utf-8\"";
//    return setAjaxRequest(method, url, params, onload, false, contentType, false, _link);
	
	
	
	
	
	
	$.ajax({
	url:base_url+'realt/getpointsXML',
	 //url:base_url+'files/xml.xml',
	dataType: "xml",
	contentType: "text/xml; charset=\"utf-8\"",
	type: "GET",
	complete: OnLinksFetched,
	 data: "name=John&location=Boston&"+ m_qs	
	  }); 
	  
	  
    	
	//	onFailure: function(){
		//alert("falure");
		
	//	map.setCenter(map.setCenter(82.939231,55.068406))}
	//});
}




















function prevOffer()
{
	var openedDiv = $('offers').select('div.show');
	openedDiv = openedDiv[0];
	if (openedDiv.previous('div.hide'))
	{
		openedDiv.previous('div.hide').className="show";
		openedDiv.className="hide";
		$('current').innerHTML = Number($('current').innerHTML)-1;
		if (!openedDiv.previous('div.hide'))
			$('prev').hide();
		$('next').show();
	}
	map.getBalloon().update();
}

function nextOffer()
{
	var openedDiv = $('offers').select('div.show')[0];
	if (openedDiv.next('div.hide'))
	{
		openedDiv.next('div.hide').className="show";
		openedDiv.className="hide";
		$('current').innerHTML = Number($('current').innerHTML)+1;
		if (!openedDiv.next('div.hide'))
			$('next').hide();
		$('prev').show();
	}
	map.getBalloon().update();
}

function ShowMap(longitude,latitude,id_region)
//function ShowMap()
{


	map = new YMaps.Map(document.getElementById('YMapsID'));
	//map.enableScrollZoom();
	map.addControl(new YMaps.ToolBar());
	map.addControl(new YMaps.SmallZoom());
	map.addControl(new YMaps.SearchControl());
	
	
	if (m_params['cat']==0){
	map.addControl(new RealtExpand());
	}
	map.addControl(new Informer());
	
	 
	map.disableScrollZoom();
	if (latitude!=0 && longitude!=0)
		map.setCenter(new YMaps.GeoPoint(longitude,latitude),16);
	else
	{
		switch (id_region)
		{   
		    case 1:map.setCenter(new YMaps.GeoPoint(27.56164,53.902257),11);break;
			case 10:map.setCenter(new YMaps.GeoPoint(82.928,55.003),11);break;
			case 55:map.setCenter(new YMaps.GeoPoint(73.365,54.990),11);break;
			case 38:map.setCenter(new YMaps.GeoPoint(104.275,52.117938),11);break;
			case 2:map.setCenter(new YMaps.GeoPoint(23.704591,52.313),11);break;
			case 3:map.setCenter(new YMaps.GeoPoint(30.179971,55.196752),11);break;
			case 4:map.setCenter(new YMaps.GeoPoint(30.983837,52.426192),11);break;
			case 5:map.setCenter(new YMaps.GeoPoint(23.825684,53.675855),11);break;
			case 6:map.setCenter(new YMaps.GeoPoint(30.323126,53.893641),11);break;
			case 7:map.setCenter(new YMaps.GeoPoint(28.656168,55.530429),11);break;
			default:map.setCenter(new YMaps.GeoPoint(27.56164,53.902257),11);break;
			
			
			
			
			
			
			
			
			
			
			
		}
		
	}
	var sIcon = new YMaps.Style();

	var tOffer = new YMaps.Template();
	tOffer.text = '<div style="font-size:11px;"><b>$[name]:</b></div>';
	 //alert(tOffer.text);
	YMaps.Templates.add('tOffer',tOffer);
	var tOfferHint = new YMaps.Template(); 
	tOfferHint.text = '<div style="font-size:11px;"><b>$[offers]</b> предложений</div>';
	YMaps.Templates.add('tOfferHint',tOfferHint);

	var sOffer = new YMaps.Style();
	sOffer.iconStyle = new YMaps.IconStyle();
	sOffer.iconStyle.offset = new YMaps.Point(-13,-28);
	sOffer.iconStyle.href = 'http://neagent.by/themes/neagent_style/assets/images/salehouse.png';
	sOffer.iconStyle.size = new YMaps.Point(29,28);
	sOffer.balloonContentStyle = new YMaps.BalloonContentStyle('tOffer');
	YMaps.Styles.add('#sOffer',sOffer);

	
		var sOfferNew = new YMaps.Style();
	sOfferNew.iconStyle = new YMaps.IconStyle();
	sOfferNew.iconStyle.offset = new YMaps.Point(-13,-28);
	sOfferNew.iconStyle.href = 'http://neagent.by/themes/neagent_style/assets/images/salehousenew.png';
	sOfferNew.iconStyle.size = new YMaps.Point(29,28);
	sOfferNew.hasBalloon = true;
	sOfferNew.hasHint = true;
	YMaps.Styles.add('#sOfferNew',sOfferNew);


if (typeof mapview != "undefined"){
if (mapview==1){
for(i = 0; i < map_points.length+1; i++){
createmarker(i);
}
}
}


	
	
	var sOfferShort = new YMaps.Style();
	sOfferShort.iconStyle = sOffer.iconStyle;
	//sOfferShort.hasBalloon = false;
	sOfferShort.hasBalloon = true;
	sOfferShort.hasHint = true;
	//sOfferShort.hintContentStyle = new YMaps.HintContentStyle('tOfferHint');
	YMaps.Styles.add('#sOfferShort',sOfferShort);
//alert("getp");
	YMaps.Events.observe(map,map.Events.Update,function(){GetPoints()});
	YMaps.Events.observe(map,map.Events.MoveEnd,function(){GetPoints()});
	//alert("getp2");
	GetPoints();
	//alert("get3");
}

function createmarker(ind){
    var sOfferNew = new YMaps.Style();
	sOfferNew.iconStyle = new YMaps.IconStyle();
	sOfferNew.iconStyle.offset = new YMaps.Point(-13,-34);
	//ind=ind+1;
	sOfferNew.iconStyle.href = 'http://neagent.by/themes/neagent_style/assets/images/green_Marker'+ind+'.png';
	sOfferNew.iconStyle.size = new YMaps.Point(20,34);
	sOfferNew.hasBalloon = true;
	sOfferNew.hasHint = true;
	YMaps.Styles.add('#sOffer'+ind,sOfferNew);
}

 function RealtExpand () {
		// Добавляем элемент на карту
        this.onAddToMap = function (map, position) {
			// создаём контейнер, в котрый будем помещать содержимое
            this.container = YMaps.jQuery("<ul><li>Показать новые:<ul></ul></li></ul>")
            this.map = map;
            this.position = position || new YMaps.ControlPosition(YMaps.ControlPosition.TOP_RIGHT, new YMaps.Size(10, 10));
            // Выставление необходимых CSS-свойств для контейнера
            this.container.css({
                position: 'relative',
				float: 'right',
				width: '120px',
                zIndex: YMaps.ZIndex.CONTROL,
                background: '#fff',
                listStyle: 'none',
                padding: '5px',
                margin: 0,
				marginTop: "40px"
            });
			// Помещаем в контейнер список регионов, который создаст нам следующая функция
            this._generateList();
            // Применение позиции к управляющему элементу
            this.position.apply(this.container);
            // Добавляем контейнер на карту
            this.container.appendTo(this.map.getContainer());
        }
        // Формирование списка регионов
        this._generateList = function () {
            var _this = this;
            // Для каждого объекта вызываем функцию-обработчик
			
			
			
			
			
			
			
            
                // Создаём ссылку на объект
            var li = YMaps.jQuery("<li class=\"links\"><a href=\"#\">Квартиры в аренду</a></li>");
			a1 = li.find("a");
                // Создаём обработчик щелчка по ссылке
                li.bind("click", function () {mapview=0;
				m_params['cat']='1';GetPoints();
				a1.css("color", "grey");a2.css("color", "grey");a3.css("color", "grey");a4.css("color", "grey");
				a1.css("color", "red");
return false;
                });
                // при наступлении события показываем или прячем соответствующий балун
				// и меняем стиль ссылки
               // YMaps.Events.observe(obj, obj.Events.BalloonOpen, function () {
				 	
                //});
                // Добавление ссылки на объект в общий список
			li.appendTo(_this.container);
			
			
			
			  var li = YMaps.jQuery("<li class=\"links\"><a href=\"#\">Комнаты в аренду</a></li>");
			a2 = li.find("a");
                // Создаём обработчик щелчка по ссылке
                li.bind("click", function () {mapview=0;
				m_params['cat']='3';GetPoints();
				a1.css("color", "grey");a2.css("color", "grey");a3.css("color", "grey");a4.css("color", "grey");
				a2.css("color", "red");
return false;
                });
                // при наступлении события показываем или прячем соответствующий балун
				// и меняем стиль ссылки
              //  YMaps.Events.observe(obj, obj.Events.BalloonOpen, function () {
				//	a.css("color", "red");
               // });
                // Добавление ссылки на объект в общий список
			li.appendTo(_this.container);
			
			
			var li = YMaps.jQuery("<li class=\"links\"><a href=\"#\">Квартиры на продажу</a></li>");
			a3 = li.find("a");
                // Создаём обработчик щелчка по ссылке
                li.bind("click", function () {mapview=0;
				m_params['cat']='13';GetPoints();
				a1.css("color", "grey");a2.css("color", "grey");a3.css("color", "grey");a4.css("color", "grey");
				a3.css("color", "red");
return false;
                });
                // при наступлении события показываем или прячем соответствующий балун
				// и меняем стиль ссылки
              //  YMaps.Events.observe(obj, obj.Events.BalloonOpen, function () {
				//	a.css("color", "red");
               // });
                // Добавление ссылки на объект в общий список
			li.appendTo(_this.container);
			
			
					  var li = YMaps.jQuery("<li class=\"links\"><a href=\"#\">Квартиры на сутки</a></li>");
			a4 = li.find("a");
                // Создаём обработчик щелчка по ссылке
                li.bind("click", function () {
				m_params['cat']='11';GetPoints();
				a1.css("color", "grey");a2.css("color", "grey");a3.css("color", "grey");a4.css("color", "grey");
				a4.css("color", "red");
return false;
                });
                // при наступлении события показываем или прячем соответствующий балун
				// и меняем стиль ссылки
              //  YMaps.Events.observe(obj, obj.Events.BalloonOpen, function () {
				//	a.css("color", "red");
               // });
                // Добавление ссылки на объект в общий список
			li.appendTo(_this.container);	
			a1.css("color", "grey");a2.css("color", "grey");a3.css("color", "grey");a4.css("color", "grey");
           
		   
        };
// Игнорируем все клики по ссылкам, пока происходит перемещение карты
        this.isFlying = 0;
}


















 function Informer () {
		// Добавляем элемент на карту
        this.onAddToMap = function (map, position) {
			// создаём контейнер, в котрый будем помещать содержимое
            this.container = YMaps.jQuery("<ul><li> <ul></ul></li></ul>")
            this.map = map;
            this.position = position || new YMaps.ControlPosition(YMaps.ControlPosition.TOP_RIGHT, new YMaps.Size(10, 10));
            // Выставление необходимых CSS-свойств для контейнера
            this.container.css({
                position: 'relative',
				clear: 'both',
				float: 'right',
				width: '120px',
                zIndex: YMaps.ZIndex.CONTROL,
               // background: '#fff',
                listStyle: 'none',
                padding: '5px',
                margin: 0,
				marginTop: "0px"
            });
			// Помещаем в контейнер список регионов, который создаст нам следующая функция
            this._generateList();
            // Применение позиции к управляющему элементу
            this.position.apply(this.container);
            // Добавляем контейнер на карту
            this.container.appendTo(this.map.getContainer());
			
			
			 
			
			
			
			
			
			
			
        }
        // Формирование списка регионов
        this._generateList = function () {
            var _this = this;
            // Для каждого объекта вызываем функцию-обработчик
	 
			//a1.css("border-bottom", "1px #2e6091 dotted");a2.css("border-bottom", "1px #2e6091 dotted");a3.css("border-bottom", "1px #2e6091 dotted"); 
		   
        };
// Игнорируем все клики по ссылкам, пока происходит перемещение карты
        this.isFlying = 0;
}





