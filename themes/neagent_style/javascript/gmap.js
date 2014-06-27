var base_url="http://neagent.by/";

var map;
var opened; 
  function initializeGM(longitude,latitude, z, id_region , type) {
   type="OSM";
  if (latitude!=0 && longitude!=0)
  {
   l2=longitude;
   l1=latitude;
	}else
	{
		switch (id_region)
		{   
		    case 1:
			l2=27.56164;l1=53.902257;z=11;break;
			case 2:
			l2=23.704591;l1=52.117938;z=12;break;
			
			case 3:
			l2=30.179971;l1=55.196752;z=11;break;
			 
			case 4:
			l2=30.983837;l1=52.426192;z=11;break;
			
			case 5:
			l2=23.825684;l1=53.675855;z=12;break;
			
			case 6:
			l2=30.323126;l1=53.893641;z=12;break;
			
			case 7:
			l2=28.656168;l1=55.530429; z=13;break;
			
			default:
			l2=27.56164;l1=53.902257;z=11;break;
			
			
		}
		
	}

    var latlng = new google.maps.LatLng(l1, l2);
    var myOptions ="";
	if (type=="OSM"){
	//alert('OSM');
	myOptions = {
      zoom: z,
      center: latlng,
      mapTypeId: "OSM",
    };
	
	
	map = new google.maps.Map(document.getElementById("GMapsID"), myOptions);
	  map.setOptions({ scrollwheel: false });
	
           //Define OSM map type pointing at the OpenStreetMap tile server
            map.mapTypes.set("OSM", new google.maps.ImageMapType({
                getTileUrl: function(coord, zoom) {
                    return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
                },
                tileSize: new google.maps.Size(256, 256),
                name: "OpenStreetMap",
                maxZoom: 18
            }));
	}
	else{
    myOptions = {
      zoom: z,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
	  
	  
    };
	map = new google.maps.Map(document.getElementById("GMapsID"), myOptions);
	  map.setOptions({ scrollwheel: false });
	
	}
	  
	  
	GetPoints();	

		
  }


function OnLinksFetched(response)
{
		//alert("response.responseXML");
		//alert(response.responseXML);
		
		
		response_text =  response.responseText;

     // alert(response_text);
			var PointsList = response.responseXML || "no response XML";
			
			
		 
			
	
var markers = Array();
var markerDescription = Array();




//var PointsCollection = new YMaps.GeoObjectCollection();
			var curBalloon;
			var curOffer;
			var placemarkToOpen;
  curBalloon = new google.maps.InfoWindow({content: ''});







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
	//var point = new YMaps.GeoPoint(pLongitude,pLatitude);
    var point = new google.maps.LatLng(pLatitude, pLongitude);
  

/////////////////////  if (12 < 16)	{
				
				var desc="";
				
   			if (a<10){	
	pointicon=	'http://neagent.by/themes/neagent_style/assets/images/salehousenew.png';
	 
			
		//	var placemark = new YMaps.Placemark(point,{style:'#sOfferNew'});
			}
			else
			{
	pointicon=	'http://neagent.by/themes/neagent_style/assets/images/salehouse.png';
		//	var placemark = new YMaps.Placemark(point,{style:'#sOfferShort'});
		
		
		
		
			}
		//alert('11');	
            pointname = "Москва";
					//YMaps.Events.observe(placemark,placemark.Events.Click,function(mEvent){update=false;});
		//alert('22');			
					pointoffers = $(this).attr('offers');
					pointname = $(this).attr('street') + ", "  + $(this).attr('number');  // Заголовок балуна
pointdescription = "Описание метки"; // Текст балуна
					// placemark.name = "Москва";
   
  // alert('33');
 	                   // alert($(this).attr('longitude')); 
						//of = jQuery(this).find('offer');
						
						len2=$(this).find('offer').length;
						//alert("l2=" . len2);
						l2=0  ;
					 	$(this).find('offer').each( 
					 	function() 
					 	{ 
					 	 //alert(a);
	//alert('44');		
desc  +=  "<b>" +  pointname + "</b></br>";	
						desc  += 'Комнат: '+$(this).attr('rooms')+'<br>Цена:'+$(this).attr('price')+' $.<br><a href="http://neagent.by/'+$(this).attr('url')+'" target="_blank">Подробнее (в новом окне)</a><br>';
						
						
						
						
						l2 = l2 +1;
						if (l2>len2){
						alert('выход2');
						return false; 
						}
						
						  
					 	});

					 
 	                 
					 l1 = l1 +1;
					 if (l1+30>len1){
					// alert('выход');
					// return false; 
					 }
					

//placemark.description = desc;
pointdescription = desc;
  marker = new google.maps.Marker({
      position: point, 
      map: map, 
      title:pointname,
	  icon: pointicon
  }); 
  
 markers.push(marker);
  
   
  var html=desc;
  makeInfoWin(marker, html); 

  
					 
 	                });  
   


					
					
 	
			map.removeAllOverlays();
			map.addOverlay(PointsCollection);
			if (placemarkToOpen)
				placemarkToOpen.openBalloon();
}





function MapView_Ini( )
{
//  загрузка  маркеров из страницы
 
			var curBalloon;
			var curOffer;
			var placemarkToOpen;
			 curBalloon = new google.maps.InfoWindow({content: ''});
			var markers = Array(); 
			 var markerDescription = new Array();
 
len1=50; // ?? 
 
l1=0  ;
var a=0;
 
for(i = 0; i < map_points.length; i++){
//alert( "lenth" + map_points.length );
//alert( "i" + i );
	a=a+1;
    pLongitude = map_points[i]['longitude'];
	pLatitude = map_points[i]['latitude'];
var point = new google.maps.LatLng(pLatitude, pLongitude);

 
				
			var desc="";
			ind=a;
			 
           pointname = "Москва";
					


//var placemark = new YMaps.Placemark(point,{style:'#sOffer'+ind});
pointicon=	'http://neagent.by/themes/neagent_style/assets/images/green_Marker'+ind+'.png';
					
					 
					pointoffers = map_points[i]['offers'] ;
					pointname =   map_points[i]['street'] +  ", "  + map_points[i]['number'];  // Заголовок балуна
pointdescription = "Описание метки"; // Текст балуна

						len2=1;
						l2=0  ;
						

						desc  +=  "<b>" +  pointname + "</b></br>";	
						desc  += 'Комнат: '+map_points[i]['rooms']+'<br>Цена:'+map_points[i]['price']+' $.<br><a href="'+map_points[i]['url']+'" target="_blank">Подробнее (в новом окне)</a><br>';
						l2 = l2 +1;
						if (l2>len2){
						 
						return false; 
						}
						
						 
						
		 
 	                 
					 l1 = l1 +1;
					 if (l1+30>len1){
					 
					 }
					
 markerDescription[a]=desc;

pointdescription = desc;
  marker = new google.maps.Marker({
      position: point, 
      map: map, 
      title:pointname,
	  icon: pointicon
  }); 
  
 markers.push(marker);
  
   
  var html=desc;
  makeInfoWin(marker, html); 
  
// google.maps.event.addListener(markers[a], 'click', function() {
// curBalloon.content=desc;
//  infoWindow.setContent(html);
//   infoWindow.open(map, this);
// })				
			




//var infoWindow = new google.maps.InfoWindow();
//var html=desc;
//google.maps.event.addListener(markers[a], 'click', function() {
//infoWindow.setContent(html);
//infoWindow.open(MYMAP.map,this);			});




			
 	                } 
   


					
					
 	
			//map.removeAllOverlays();
			//map.addOverlay(PointsCollection);
			//if (placemarkToOpen)
				//placemarkToOpen.openBalloon();
}


function singlepoint_ini( )
{
 
			var curBalloon;
			var curOffer;
			var placemarkToOpen;
			 
			curBalloon = new google.maps.InfoWindow({content: ''});
			 
 var markers = Array(); 
 var markerDescription = new Array();
  
 pLongitude = map_longitude;
 pLatitude = map_latitude;
 
var point = new google.maps.LatLng(pLatitude, pLongitude);
 
			var desc="Это где-то здесь";
			 
            pointname = "Москва";
 
pointicon=	'http://neagent.by/themes/neagent_style/assets/images/salehousenew.png';
					

pointdescription = "Описание метки"; // Текст балуна

						 
						

				//		desc  +=  "<b>" +  pointname + "</b></br>";	
				//		desc  += 'Комнат: '+map_points[i]['rooms']+'<br>Цена:'+map_points[i]['price']+' $.<br><a href="'+map_points[i]['url']+'" target="_blank">Подробнее (в новом окне)</a><br>';
						 
  

pointdescription = desc;
  marker = new google.maps.Marker({
      position: point, 
      map: map, 
      title:pointname,
	  icon: pointicon
  }); 
  
 markers.push(marker);
  
   
var html=desc;
makeInfoWin(marker, html); 

}


function makeInfoWin(marker, data) {
  var infowindow = new google.maps.InfoWindow({ content: data });
  google.maps.event.addListener(marker, 'click', function() {
   if(opened){opened.close(map,marker);}
   infowindow.open(map,marker);
   opened = infowindow;
    });  
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




//alert("gg");
if (typeof mapview != "undefined"){
if (mapview==1){
//alert("ini");
MapView_Ini();
return;
}
}
//alert("2");
//alert(map); 
//alert("3");
	var bounds = map.getBounds();
	var zoom = map.getZoom();
 

	var m_qs=makeQS(m_params);
	
	
	 //alert($);
 
	
 
	
	
	$.ajaxSetup({cache: false});
	
//	var url = base_url+'realt/getpointsXML';
//    var params = "name=John&location=Boston&"+ m_qs;
//	var method = "POST";
//    var onload = OnLinksFetched;
//    var contentType = "text/xml; charset=\"utf-8\"";
//    return setAjaxRequest(method, url, params, onload, false, contentType, false, _link);
	
	
	
	//alert("f1");
	
	
	$.ajax({
	url:base_url+'realt/getpointsXML',
	 //url:base_url+'files/xml.xml',
	dataType: "xml",
	contentType: "text/xml; charset=\"utf-8\"",
	type: "GET",
	complete: OnLinksFetched,
	 data: "name=John&location=Boston&"+ m_qs	
	  }); 
	  
	  //alert("f2");
    	
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
initializeGM(longitude,latitude,id_region)
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
			
			
			
			
			
			
			
            
                // Создаём ссылку на объект
            var li = YMaps.jQuery("<li class=\"links\"><a href=\"#\"><img src='http://neagent.by/themes/neagent_style/assets/images/taxi_icon.png'>такси</a></li>");
			b1 = li.find("a");
                // Создаём обработчик щелчка по ссылке
                li.bind("click", function () {
				$('#perevozki_info').hide();
				$('#taxi_info').toggle();
				
				 
				 
return false;
                });
                // при наступлении события показываем или прячем соответствующий балун
				// и меняем стиль ссылки
               // YMaps.Events.observe(obj, obj.Events.BalloonOpen, function () {
				 	
                //});
                // Добавление ссылки на объект в общий список
			li.appendTo(_this.container);
			
			
			
			
			var li = YMaps.jQuery("<li class=\"links\" id='taxi_info' style='background-color:white; display:none; padding:3px;'><b>Заказ такси</b><br><img src='http://neagent.by/themes/neagent_style/assets/images/phone_icon.png'>158   </li>");
			li.appendTo(_this.container);
			
			
			
			
			
			
			
			
			
			  var li = YMaps.jQuery("<li class=\"links\"><a href=\"#\"><img src='http://neagent.by/themes/neagent_style/assets/images/van_icon.png'>грузоперевозки</a></li>");
			b2 = li.find("a");
                // Создаём обработчик щелчка по ссылке
                li.bind("click", function () {
				$('#taxi_info').hide();
				$('#perevozki_info').toggle();
				 
return false;
                });
                // при наступлении события показываем или прячем соответствующий балун
				// и меняем стиль ссылки
              //  YMaps.Events.observe(obj, obj.Events.BalloonOpen, function () {
				//	a.css("color", "red");
               // });
                // Добавление ссылки на объект в общий список
			li.appendTo(_this.container);
			
			var li = YMaps.jQuery("<li class=\"links\" id='perevozki_info' style='background-color:white; display:none; padding:3px;'><b>Грузоперевозки</b><br><img src='http://neagent.by/themes/neagent_style/assets/images/phone_icon.png'>+375 29 7096944 </li>");
			li.appendTo(_this.container);
 
			 
			b1.css("color", "#2e6091");b2.css("color", "#2e6091");
            b1.css("text-decoration", "none");b2.css("text-decoration", "none");
			//a1.css("border-bottom", "1px #2e6091 dotted");a2.css("border-bottom", "1px #2e6091 dotted");a3.css("border-bottom", "1px #2e6091 dotted"); 
		   
        };
// Игнорируем все клики по ссылкам, пока происходит перемещение карты
        this.isFlying = 0;
}





