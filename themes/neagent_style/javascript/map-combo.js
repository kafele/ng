var base_url="http://neagent.by/";






function OnLinksFetched(response)
{
		//alert("response.responseXML");
		//alert(response.responseXML);
		
		
		response_text =  response.responseText;

     alert(response_text);
			var PointsList = response.responseXML || "no response XML";
			
			
		 
			
			
			
			
			
			
		if 	(PointsList="no response XML"){

		// page has been loaded by now
var container = document.createElement('div');
container.innerHTML = response_text;
points = container.getElementsByTagName('point');


		}
		else{
		points = PointsList.getElementsByTagName('point');
		}
		
		
	
			
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
				
			for (var i=0;i<points.length;i++)
			{
				pLongitude = points[i].getAttribute('longitude');
				  
				pLatitude = points[i].getAttribute('latitude');
				var point = new YMaps.GeoPoint(pLongitude,pLatitude);
				 
				 
	
//var geocoder = new YMaps.Geocoder(value, {results: 1, boundedBy: map.getBounds()});
//geoResult = this.get(0);

 

  // var point = new YMaps.GeoPoint(geoResult._point.__lng, geoResult._point.__lat);
  
 //pUl = points[i].getAttribute('street');
 //alert(pUl);
 //value='Беларусь, Минск, '+pUl+', 1,';
//var geocoder = new YMaps.Geocoder(value, {results: 1, boundedBy: map.getBounds()});


           // YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {

               // if (this.length()) {
                //    geoResult = this.get(0);
                    //map.addOverlay(geoResult);
                    //map.setBounds(geoResult.getBounds());}
					//var point = geoResult;
					
//}



//geoResult = this.get(0);
//geoResult.setStyle("example#customPoint");
//var point = geoResult;




				 
				 
				 
	 
				 
				 
				if (12 < 16)
				{
				 
				//	var placemark = new YMaps.Placemark(point,{style:'#sOfferShort'});
					var placemark = new YMaps.Placemark(point,{style:'#sOfferShort'});
					//var placemark = new YMaps.Placemark(point, { hasHint: 1, style:'#sOfferShort'});
            placemark.name = "Москва";
			
			
					//alert( placemark.offers);
					//YMaps.Events.observe(placemark,placemark.Events.Click,function(mEvent){update=false;map.setCenter(mEvent.getGeoPoint());update=true;map.setZoom(map.getZoom()+1);});
					
					YMaps.Events.observe(placemark,placemark.Events.Click,function(mEvent){
					update=false;
					//window.open('http://www.shildim.narod.ru/','newwin')
					//update=false;map.setCenter(mEvent.getGeoPoint());update=true;map.setZoom(map.getZoom()+1);
					
					});
					
					placemark.offers = points[i].getAttribute('offers');
					placemark.name = points[i].getAttribute('street') + ", "  + points[i].getAttribute('number');  // Заголовок балуна
					
					
placemark.description = "Описание метки"; // Текст балуна
					// placemark.name = "Москва";
					//alert( placemark.name);
					var desc="";
					
					
 	

//x=xmlDoc.getElementsByTagName("title")[0]
 

//alert(response_text);

a=0;
if (a<4){
a=a+1;

 //html =  $(response_text); 
 //alert(html.find("point").text());
 

xmlDoc = $.parseXML( response_text );
   // $xml = $( xmlDoc );

len1=$(xmlDoc).find('point').length;
alert(len1);

 l1=0  ;
$(xmlDoc).find('point').each( 
 	                function() 
 	                { 
					a=a+1;
   
 	                   // alert($(this).attr('longitude')); 
						//of = jQuery(this).find('offer');
						
						len2=$(this).find('offer').length;
						alert("l2=" . len2);
						l2=0  ;
					 	$(this).find('offer').each( 
					 	function() 
					 	{ 
					 	 alert(a);
						
						
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
					 alert('выход');
					 return false; 
					 }
					 
					 
 	                });  
   
   
   
   
   
    //$title = $(xmlDoc).find('point')[0].attr("longitude"); 
	
	//alert($title);
	
	//alert($title.html());
	
//var points = $(container).find("point");
 //alert($(container).find("point").html());
//alert($(points[i]).html());

//$(container).find("point").each(function() {

 //alert("each" );
 
//});	

	}
	
	 
	
					
 if 	(PointsList="no response XML"){
  

 
 
//offers =points[i].getElementsByTagNameNS('*', 'offer');
//alert(offers[0]);
//alert($(points[i]).html());
		// page has been loaded by now
//container = document.createElement('div');
//container.innerHTML = response_text;
//points = container.getElementsByTagName('offer');

	
		
 //container = document.createElement('div');
 //container.innerHTML = points[i].firstChild.xml;
 //points = container.getElementsByTagName('offer');
 }					
	else
{	
					
					
		
					
}	


offers = points[i].getElementsByTagName('offer');	





					 //alert(offers);
					 //alert(offers.length);
					  //alert(points[i].childNodes[0]);
					//alert( '2');
					//offers = points[i].getElementsByTagName('point');
					
					for (var k=0;k<offers.length;k++)
			{
					//$(points[i]).find("offer").each(function()
					//offers.each(function (offer)
						 
						//offer=$(this);
						  //alert(offers[k].getAttribute('rooms'));
							desc  += 'Комнат: '+offers[k].getAttribute('rooms')+'<br>Цена:'+offers[k].getAttribute('price')+' $.<br><a href="http://neagent.by/'+offers[k].getAttribute('url')+'" target="_blank">Посмотреть объявление</a><br>';
							//if (ad_id==offer.getAttribute('id_ad'))
							//{
							//	placemarkToOpen = placemark;
							//	show = true;
							//	idx = c;
							//}
							//if (show)
							//	elemToShow = divElem;
							//divElem.className = 'hide';
							//offersElement.appendChild(divElem);
							//show = true;
							//c++;
							
						}
					
					
					placemark.description = desc;
					
					
					
					
					
					
					
					
					//placemark.setIconContent('Что-то');
				}
				
				PointsCollection.add(placemark);
			}
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
			case 38:map.setCenter(new YMaps.GeoPoint(104.275,52.313),11);break;
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






