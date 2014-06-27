// Global Class Object
var NMAP = new googleMapping();

function googleMapping(){
	
	var CLASS = this;
// Class Variables ------------------------------------------
// ----------------------------------------------------------
	CLASS.mapDIV = "myMap";
	CLASS.canvassOverlayView = null; // Used for MapCanvassProjection Access
	CLASS.mapRenderedInContainer = false;
	CLASS.directionsRendered = null;
	CLASS.apiIsLoaded = false;
	CLASS.loadParcels = false;
	CLASS.trafficLayer = null;
	CLASS.mapOptions = {}; /* default -> {center:HOUSTON, zoom:11, mapTypeId:google.maps.MapTypeId.ROADMAP, domElement:"myMap"}    Gets loaded in: CLASS._installMap() */
	CLASS.map = {}; // Official Map Object, initialized in: CLASS._installMap()
	CLASS.parcelAPI = "http://parcelstream.com/DMPAPI.aspx?key=1";
	CLASS.mapAPI = 'http://maps.google.com/maps/api/js?v=3.1&sensor=true&callback=NMAP._confirmAPILoad';
	CLASS.pinURL = 'http://www.NMAP.com/images/pointer/';
	CLASS.customControlImageURL = 'http://www.NMAP.com/images/customcontrols/';
	CLASS.pins = {
		golfPrivate: 		CLASS.pinURL+'brownGolf.gif',
		golfPublic: 		CLASS.pinURL+'greenGolf.gif',
		blueHouse: 			CLASS.pinURL+'bluePointer.png',
		purpleHouse: 		CLASS.pinURL+'purplePointer.png',
		redHouse: 			CLASS.pinURL+'redPointer.png',
		greenHouse: 		CLASS.pinURL+'greenPointer.png',
		schoolElementary: 	CLASS.pinURL+'schoolElementary.gif',
		schoolMiddle: 		CLASS.pinURL+'schoolMiddle.gif',
		schoolHigh: 		CLASS.pinURL+'schoolHigh.gif',
		harLogo: 			CLASS.pinURL+'iconSmNMAP.gif',
		blueIcon: 			CLASS.pinURL+'blueIcon.png',
		greenArrow: 		CLASS.pinURL+'greenArrow.gif',
		greenFlag: 			CLASS.pinURL+'flagforSale.gif',
		blueFlag: 			CLASS.pinURL+'flagforLease.gif',
		yellowFlag: 		CLASS.pinURL+'flagallProperty.gif',
		hospitalCross: 		CLASS.pinURL+'flagforhospital.png',
		iconHighrise: 		CLASS.pinURL+'iconHighrise.gif'
	};
	CLASS.images = {
		infoWindowArrowRight: CLASS.pinURL+'infowindow/'+'arrowRight.png',
		infoWindowArrowLeft: CLASS.pinURL+'infowindow/'+'arrowLeft.png'
	};
	CLASS.customControlImages = {
		clearDrivingDirections 	: { src:CLASS.customControlImageURL+"clearDrivingDirections.png" },
		clearMap 				: { src:CLASS.customControlImageURL+"clearMap.png" },
		currentTraffic 			: { src:CLASS.customControlImageURL+"currentTraffic.png" },
		drawArea 				: { src:CLASS.customControlImageURL+"drawArea.png" },
		showListings 			: { src:CLASS.customControlImageURL+"showListings.png" }
	};
	CLASS.defaultPolyOptions = {
		strokeColor: '#000080',
		strokeWeight: 2,
		fillColor: '#000080',
		fillOpacity: 0.2,
		clickable:false
	};
	CLASS.PropertyTypeEnum = {
		singleFamily:1,
		townhouseCondo:2,
		residentialLotsLand:3,
		multiFamily:4,
		homesAndOrAcreage:5,
		highriseCondominium:6,
		residentialLease:7
	};
	CLASS.markers = [];
	CLASS.shapes = [];
	CLASS.infoWindows = [];
		
// PUBLIC Methods Below --------------------------------------------
// -----------------------------------------------------------------
	
	// Called by the developer on: onLoad()
	CLASS.initialize = function(config){ 		
		// Do we need to load parcels?
		if( typeof config != 'undefined' && typeof config.loadParcels != 'undefined' )
			CLASS.loadParcels = config.loadParcels;
		
		// Load Script
		CLASS._loadScript();
		
		// Load map onto DOM
		CLASS._installMap(config);
	}
	
	// Singleton Object holds methods to add custom controls to the map.
	CLASS.customControl = {
		// Inserts a custom control into the map navigation
		// Param: { 
		//			content: <CLASS.customControlImages>|<string>, 
		//			position: <string> "TOP | TOP_LEFT | TOP_RIGHT | BOTTOM | BOTTOM_LEFT | BOTTOM_RIGHT | LEFT | RIGHT",
		//			handler: <function> ,
		//			title: <string>
		//		  }
		insert : function(options){
			// Create new control node
			var newControl = CLASS.customControl._createElement();
			
			// Attach title to node
			if( typeof options.title!="undefined" )
				newControl.title = options.title;
			
			// Check type of content
			if( typeof options.content == "string" /*Text-only*/ )
			{
				// Apply extra css for text-only controls
				newControl = CLASS.customControl._applyTextCSS(newControl);
				// Apply content to node
				newControl.innerHTML = options.content;
			}
			else if( typeof options.content.src != "undefined" /*Custom Image*/)
			{
				// Using Private image
				// Apply content to node
				newControl.innerHTML = '<img src="'+options.content.src+'" />';
			}
			else
				alert("Content for custom control must be string or from <OBJECT.customControlImages> collection");
				
			// Check for position integrity
			var list = "TOP | TOP_LEFT | TOP_RIGHT | BOTTOM | BOTTOM_LEFT | BOTTOM_RIGHT | LEFT | RIGHT";
			if( typeof options.position!="undefined" && list.indexOf(options.position)!=-1 )
			{	// We are good to go.				
				
				// Create a "click" listener and attach given handler
				if( typeof options.handler=="function" )
					google.maps.event.addDomListener(newControl,'click', options.handler );				
				
				// Push new custom control into our map				
				CLASS.map.controls[google.maps.ControlPosition[options.position]].push(newControl);
			}
			else
				alert("Position used for custom control must be one of:\n\n"+list);
				
			// Return the new DOM node in case developer wants to manipulate it further
			return newControl;
		},
		// Create a new node element for the control
		_createElement : function(){
			// Basic div node for the control
			var newEl = document.createElement('div');
			newEl.style.cursor = 'pointer';
			//newEl.style.height = '20px';
			newEl.style.marginTop = '5px';
			newEl.style.fontFamily = 'Arial,sans-serif';
			// Turn over the new node
			return newEl;
		},
		// Function will apply specific css attribute for text-only controls
		_applyTextCSS : function(node){
			node.style.backgroundColor = 'white';
			node.style.borderStyle = 'solid';
			node.style.borderWidth = '2px';
			node.style.padding = '1px';
			node.style.textAlign = 'left';
			node.style.fontSize = '11px';
			node.style.marginRight = '10px';
			// Given the node back
			return node;
		}
	}
	
	// Loads many pins onto the map given records and pinConfig options
	// pinConfig{latField, lngField, pinIcon, titleField, htmlField}
	CLASS.loadPins = function( records, pinConfig ){
	
		// Create loop for the records
		for( var i=0; i<records.length; i++ )
		{
			// Build marker config
			var markerConfig = {
					lat: records[i][pinConfig.latField], 
					lng: records[i][pinConfig.lngField], 
					title: records[i][pinConfig.titleField], 
					html_for_popup: records[i][pinConfig.htmlField], 
					pinIcon: pinConfig.pinIcon,
					defaultInfoWindow: ( typeof pinConfig.defaultInfoWindow != 'undefined' && pinConfig.defaultInfoWindow == true ),
					onClick : ('onClick' in pinConfig && typeof pinConfig.onClick=="function") ? pinConfig.onClick:null,
					hideInfoWindow : ( 'hideInfoWindow' in pinConfig && pinConfig.hideInfoWindow==true ) ? true:false
				};
			// Pass this record over to plotPin
			CLASS.plotPin(markerConfig);
		}
	
	}
	
	// Loads one pin onto the map.
	// Param: {lat, lng, title, html and pinIcon}
	CLASS.plotPin = function( pinConfig ){ 		
		// Short Hand fix: Now allowing "html" as possible field
		if( typeof pinConfig.html != 'undefined' ) pinConfig.html_for_popup = pinConfig.html;
		
		// Do we want popups?
		var showPopup = ( typeof pinConfig.html_for_popup != 'undefined' );
		// Are we using default popups
		// true: using default, false: using custom NMAP infowindow (default)
		var googlePopup = ( typeof pinConfig.defaultInfoWindow != 'undefined' && pinConfig.defaultInfoWindow == true );
		// Do we want to show directions for this pin?
		var showDirections = ('showDirections' in pinConfig && pinConfig.showDirections==false) ? false:true;
		// Do we have a handler for this marker?
		var onClickHandler = ('onClick' in pinConfig && typeof pinConfig.onClick=="function") ? pinConfig.onClick:null;
		// Do we want to hide the google infoWindow? Mostly for Mobile Developement
		var hideInfoWindow = ( 'hideInfoWindow' in pinConfig && pinConfig.hideInfoWindow==true ) ? true:false;
		
		// Create a new marker
		var index = CLASS.markers.length;
		// Create pin configuration
		var finalConfig = {
			position: new google.maps.LatLng( pinConfig.lat, pinConfig.lng ), 
			map: CLASS.map,
			icon: pinConfig.pinIcon
		};
		
		// Check for title
		if( (typeof pinConfig.title != 'undefined' && googlePopup) || (typeof pinConfig.title != 'undefined' && !showPopup))
			finalConfig.title = pinConfig.title;
		// Check for html
		if( showPopup && !hideInfoWindow)
			finalConfig.html_for_popup = pinConfig.html_for_popup;
		
		// Create the marker
		CLASS.markers[index] = new google.maps.Marker( finalConfig );
		
		// Whether to show a html popup and create a listener
		if(showPopup)
		{
			// Get position for infowindow
			var windex = CLASS.infoWindows.length;
			
			if( googlePopup )
			{
				// Create marker's InfoWindow
				CLASS.infoWindows[windex] = new google.maps.InfoWindow({
					content: finalConfig.html_for_popup
				});
				
				// Create listener for this marker
				google.maps.event.addListener( CLASS.markers[index], 'click', function(){
					// Close any possibly open windows
					CLASS.closeWindows();				
					
					// Open this specific window
					CLASS.infoWindows[windex].open( CLASS.map, CLASS.markers[index] );
					
					// Call provided callback for onclick
					if(onClickHandler) onClickHandler(CLASS.markers[index], pinConfig.html_for_popup );
				});
			}
			else
			{
				// CUSTOM HAR INFOWINDOW
				// (Default InfoWindow)	
				CLASS.infoWindows[windex] = {};
				CLASS.infoWindows[windex].custom = true;
				CLASS.infoWindows[windex].content = finalConfig.html_for_popup;
				CLASS.infoWindows[windex].position = finalConfig.position;
				
				// Check to see if user wants to hide the infowindow
				// usually when you only want to use marker callback
				if(!hideInfoWindow)
				{
					// Create listener for this marker
					google.maps.event.addListener( CLASS.markers[index], 'mouseover', function(){
						// Open this specific window
						CLASS.customInfoWindow.fillShow(finalConfig.html_for_popup, finalConfig.position, showDirections);
					});
					// Create listener for this marker
					google.maps.event.addListener( CLASS.markers[index], 'mouseout', function(){
						// Set a 1 second delay to close the window
						// If user pans over the infowindow we will cancel this delay
						CLASS.customInfoWindow.closeDelay = setTimeout(CLASS.customInfoWindow.close,1000);
									
					});
				}
				// Call provided callback for onclick
				if(onClickHandler)
				{
					// Create listener for this marker
					google.maps.event.addListener( CLASS.markers[index], 'click', function(){
						// Call provided callback for onclick
						onClickHandler(CLASS.markers[index], pinConfig.html_for_popup );
					});
				}
			}
		}
		
		// Check to see if developer needs the markerID back
		if( typeof pinConfig.getId != 'undefined' && pinConfig.getId==true ) return index;
		
	}	
	
	// Public Method: Returns whether or not directions are currently rendered on the map
	CLASS.hasDirectionsRendered = function(){
		// Check variables to see if directions are rendered on map
		return (CLASS.directionsRendered!=null && CLASS.directionsRendered.getMap()!=null)
	}
	
	// Returns a DOM element that will render direction to and from a marker location.
	// Params: Marker Location (lat/lng or address) <string>
	CLASS.getDirectionsWrapperElement = function(markerLocation){
		// IDs for certain Elements
		var toHereWrapperID = "NMAP_drivingDirections_toHereWrapper";
		var fromHereWrapperID = "NMAP_drivingDirections_fromHereWrapper";
		var buttonWrapperID = "NMAP_drivingDirections_buttonWrapper";
		var menuWrapperID = "NMAP_drivingDirections_menuWrapper";
		var toTxtID = "NMAP_drivingDirections_toTxt";
		var fromTxtID = "NMAP_drivingDirections_fromTxt";
		var toTxtID2 = "NMAP_drivingDirections_toTxt2";
		var fromTxtID2 = "NMAP_drivingDirections_fromTxt2";
		
		// Create DOM wrapper for elements
		var wrapper = document.createElement("div");
		// Create Menu Navigation
		var menu = document.createElement("div");
		menu.innerHTML = "<br/>Directions: <a href='#' onclick='javascript:document.getElementById(\""+fromHereWrapperID+"\").style.display=\"none\";document.getElementById(\""+toHereWrapperID+"\").style.display=\"block\";document.getElementById(\""+buttonWrapperID+"\").style.display=\"block\";return false;'>To Here</a>";
		menu.innerHTML += " <a href='#' onclick='javascript:document.getElementById(\""+toHereWrapperID+"\").style.display=\"none\";document.getElementById(\""+fromHereWrapperID+"\").style.display=\"block\";document.getElementById(\""+buttonWrapperID+"\").style.display=\"block\";return false;'>From Here</a>";
		menu.id = menuWrapperID;
		// Create hidden "To This Location"
		var toHere = document.createElement("div");
		toHere.style.display = "none";
		toHere.id = toHereWrapperID;
		// Create hidden "To This Location"
		var fromHere = document.createElement("div");
		fromHere.style.display = "none";
		fromHere.id = fromHereWrapperID;
		// Create hidden "Get Directions" buttons
		var buttonTrigger 					= document.createElement("input"); 
		buttonTrigger.style.display 		= "none";
		buttonTrigger.style.borderWidth		= '2px';
		buttonTrigger.style.borderStyle		= 'solid';
		buttonTrigger.style.borderColor		= '#ccdddd';
		buttonTrigger.style.color			= '#FFFFFF';
		buttonTrigger.style.fontSize 		= '11px';
		buttonTrigger.style.fontFamily 		= 'Arial';
		buttonTrigger.style.padding 		= '3px';
		buttonTrigger.style.backgroundColor = '#006699';
		buttonTrigger.style.cursor			= 'pointer';
		buttonTrigger.value 				= "Show Directions";
		buttonTrigger.type 					= "submit";
		buttonTrigger.id 					= buttonWrapperID;
		// Create handler for button press
		google.maps.event.addDomListener( buttonTrigger, "click", function(){ 
			// Make sure that both text boxes have values
			if( document.getElementById(toTxtID).value!="" && document.getElementById(fromTxtID).value!="" )
			{
				CLASS.showDirections( document.getElementById(toTxtID).value, document.getElementById(fromTxtID).value ); 
			}
			else if( document.getElementById(toTxtID2).value!="" && document.getElementById(fromTxtID2).value!="" )
			{
				CLASS.showDirections( document.getElementById(toTxtID2).value, document.getElementById(fromTxtID2).value ); 
			}
		});
		
		
		// Add all the element nodes into the wrapper
		wrapper.appendChild( menu );
		wrapper.appendChild( toHere );
		wrapper.appendChild( fromHere );
		wrapper.appendChild( buttonTrigger );
		
		// Add content to the "To Here" container
		toHere.innerHTML = "<strong>To:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>To This Location</em><input type='hidden' value='"+markerLocation+"' id='"+toTxtID+"'/><br><strong>From:</strong> <input id='"+fromTxtID+"' value='' type='text'/>";
		// Add content to the "From Here" container
		fromHere.innerHTML = "<strong>To:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id='"+toTxtID2+"' value='' type='text'/><br><strong>From:</strong> <em>From This Location</em><input id='"+fromTxtID2+"' value='"+markerLocation+"' type='hidden'/>";		
		
		// Return all these contents
		return wrapper;
	}
	
	// callBack: ( found: <bool>, location: {lat:<float>,lng:<float>} )
	// Params: Address for which to geocode
	// Note: Only RoofTop location is returned if found
	CLASS.getRoofTop = function(searchAddress, callBack){ 
		var foundRoofTop= false;
		var foundLocation = {lat:0,lng:0};
		var geoStart 	= new google.maps.Geocoder();
		var geoRequest 	= { address: searchAddress };
		geoStart.geocode( geoRequest, function(geoResult, geoStatus){
			
			// Check the geo status to make sure our request sent through
			if( geoStatus == google.maps.GeocoderStatus.OK )
			{
				// Loop through the results
				for( var i=0; i<geoResult.length; i++ )
				{
					// We are only interested in the rooftop location
					if( geoResult[i].geometry.location_type == google.maps.GeocoderLocationType.ROOFTOP )
					{
						// We have our proper location
						foundRoofTop = true;
						foundLocation.lat = geoResult[i].geometry.location.lat();
						foundLocation.lng = geoResult[i].geometry.location.lng();
						// Break out of the loop
						break;
					}// end if
				}// end for
			}// end if OK
			
			// Return findings
			callBack( foundRoofTop, foundLocation );
		});	
	}
	
	// Renders: Directions on the map
	// callBack( Array[n].{instruction:string, distance:string, duration: string} )
	// Params: To, From (either <string> to be geocoded OR google.maps.LatLng Object)
	CLASS.showDirections = function(to,from,callback,rendertomap){
		// Check for optional param
		if( typeof rendertomap == 'undefined' )
			rendertomap = true;
		
		// Make the service request
		var dirRequest = new google.maps.DirectionsService();
		dirRequest.route({
				// Directions Request Object
				destination: to,
				origin: from,
				travelMode: google.maps.DirectionsTravelMode.DRIVING
				
		},function(dirResults, dirStatus){ 
			// Process the service response	status
			if( dirStatus!="OK" )
				alert('Directions request did not go through. One of the addresses might be invalid.');
			else
			{
				// Render Directions on map
				if( rendertomap )
				{
					// Clear Map of all shapes/markers/previous directions
					CLASS.hideMarkers();
					CLASS.hideShapes();
					CLASS.clearDrivingDirections();
					CLASS.customInfoWindow.close();
					
					// Push custom control into map.
					// Custom control lets user hide driving directions from map
					CLASS.customControl.insert({
						content: CLASS.customControlImages.clearDrivingDirections,
						position: "TOP_RIGHT",
						title: "Click here to clear driving directions from the map.",
						handler: function(){ 
							// Clear driving directions
							CLASS.clearDrivingDirections();
							// Show markers again 
							CLASS.showMarkers(); 
							// Show shapes again 
							CLASS.showShapes(); 
							// Remove custom control from map
							CLASS.map.controls[google.maps.ControlPosition["TOP_RIGHT"]].pop();
						}
					});
					// Finally render to map
					CLASS.directionsRendered = new google.maps.DirectionsRenderer({map:CLASS.map,directions:dirResults});
				}
				// CLose any open custom window
				CLASS.customInfoWindow.close();
				// Is there a callback
				if( typeof callback == 'function' )
				{
					// Build a list of instructions, incase they want to print the directions on the DOM
					var instructions = Array();
					for( var i = 0; i < dirResults.routes[0].legs.length; i++ )
					{
						for( var j = 0; j < dirResults.routes[0].legs[i].steps.length; j++ )
						{
							instructions.push({
								instruction:dirResults.routes[0].legs[i].steps[j].instructions,
								distance:dirResults.routes[0].legs[i].steps[j].distance.text,
								duration:dirResults.routes[0].legs[i].steps[j].duration.text
							});
						}
					}
					// Send allway
					callback(instructions);
				}
			}
		});
	}
	
	// Shows the infowindow of given markerID
	// Assume: All markers have InfoWindows (using parallel arrays)
	CLASS.showWindow = function(markerIndex){ 
		// Make sure that the window exists before attempting to open it.
		if( typeof CLASS.infoWindows[markerIndex]!='undefined' )
		{
			if( typeof CLASS.infoWindows[markerIndex].custom!='undefined' && CLASS.infoWindows[markerIndex].custom==true )
				CLASS.customInfoWindow.fillShow( CLASS.infoWindows[markerIndex].content, CLASS.infoWindows[markerIndex].position );
			else
				CLASS.infoWindows[markerIndex].open(CLASS.map, CLASS.markers[markerIndex]);
		}
			
	}
	// Closes the infowindow of given markerID
	// Assume: All markers have InfoWindows (using parallel arrays)
	CLASS.closeWindow = function(markerIndex){ 
		// Make sure that the window exists before attempting to open it.
		if( typeof CLASS.infoWindows[markerIndex]!='undefined' )
		{
			if( typeof CLASS.infoWindows[markerIndex].custom!='undefined' && CLASS.infoWindows[markerIndex].custom==true )
				CLASS.customInfoWindow.close();
			else
				CLASS.infoWindows[markerIndex].close();
		}
	}
	
	// Draws a polygon on the map given an array of MVC
	CLASS.drawPolyFromMVCArray = function(MVCArrayList, fitBounds){ 
		// Config options for the polygon
		var polyOptions = CLASS.defaultPolyOptions;
		polyOptions.paths = MVCArrayList;
		polyOptions.map = CLASS.map;
		// Poly on map
		CLASS.shapes[CLASS.shapes.length] = new google.maps.Polygon(polyOptions);
		
		// Center and Zoom the Map
		if( typeof fitBounds != 'undefined' && fitBounds==true )
			CLASS.map.fitBounds( CLASS.getBoundsFromMVCArray(MVCArrayList) );
	}
	
	// Returns a LatLngBounds Object given an MVCArray of LatLng
	CLASS.getBoundsFromMVCArray = function(MVCArrayList){ 
		// Vars will hold our extreme lat/lng values
		var maxLat = 0;
		var minLat = 100000; // Non-existant extremely high Latitude
		var maxLng = -100000;// Non-existant extremely low Longitude
		var minLng = 0;
		
		// Iterate through the MVC Array
		MVCArrayList.forEach(function(el,index){
			// Check each Lat and Long to possible Extremes
			if( el.lat() < minLat )
				minLat = el.lat()
			if( el.lat() > maxLat )
				maxLat = el.lat()
			if( el.lng() > maxLng )
				maxLng = el.lng()
			if( el.lng() < minLng )
				minLng = el.lng()
		});
		
		// Build our NE/SW corners
		var sw = new google.maps.LatLng( minLat, minLng );
		var ne = new google.maps.LatLng( maxLat, maxLng );
		
		// Return a LatLngBounds Obj
		return new google.maps.LatLngBounds( sw, ne );
		
	}
	
	// Fit map to current visible markers
	CLASS.fitBoundsToMarkers = function(){ 
		// Vars will hold our extreme lat/lng values
		var maxLat = 0;
		var minLat = 100000; // Non-existant extremely high Latitude
		var maxLng = -100000;// Non-existant extremely low Longitude
		var minLng = 0;
		
		if (CLASS.markers.length > 0) 
		{
			for(var i=0; i<CLASS.markers.length; i++)
			{
				var tmpPos = CLASS.markers[i].getPosition();
				var lat = tmpPos.lat();
				var lng = tmpPos.lng();
				// Check each Lat and Long to possible Extremes
				if( lat < minLat )
					minLat = lat;
				if( lat > maxLat )
					maxLat = lat;
				if( lng > maxLng )
					maxLng = lng;
				if( lng < minLng )
					minLng = lng;
			}
			// Build our NE/SW corners
			var sw = new google.maps.LatLng( minLat, minLng );
			var ne = new google.maps.LatLng( maxLat, maxLng );
			
			// Send bounds to the map
			CLASS.map.fitBounds(new google.maps.LatLngBounds( sw, ne ));
		}
	}
	
	// Util function for a unique identifier
	CLASS.getUID = function(){
		var newDate = new Date;
    	return newDate.getTime();
	}
	
	// close any possibly open windows
	CLASS.closeWindows = function(){ 
	
	  if (CLASS.infoWindows.length > 0) 
	  {
		for(var i=0; i<CLASS.infoWindows.length; i++)
		{
			if( typeof CLASS.infoWindows[i].custom!='undefined' && CLASS.infoWindows[i].custom==true )
				CLASS.customInfoWindow.close();
			else
				CLASS.infoWindows[i].close();
		}
	  }
	}
	// Hide (not delete) all shapes on the map
	CLASS.hideShapes = function(){ 
	  
	  if (CLASS.shapes.length > 0) 
	  {
		for(var i=0; i<CLASS.shapes.length; i++)
			CLASS.shapes[i].setMap(null);
	  }
	}
	
	// Show all shapes
	CLASS.showShapes = function()
	{
		// Check to see if shapes exists
		for(var i=0; i<CLASS.shapes.length; i++)
			CLASS.shapes[i].setMap(CLASS.map);
	}
	
	// Hide (not delete) all icons on the map
	CLASS.hideMarkers = function()
	{   
	  if (CLASS.markers.length > 0) 
	  {
		for(var i=0; i<CLASS.markers.length; i++)
			CLASS.markers[i].setMap(null);
	  }
	}
	
	// Show all markers
	CLASS.showMarkers = function()
	{
		// Check to see if marker exists
		for(var i=0; i<CLASS.markers.length; i++)
			CLASS.markers[i].setMap(CLASS.map);
	}
	
	// Hide only one marker, marker id passed through param
	CLASS.hideMarker = function(id)
	{
		// Check to see if marker exists
		if( typeof CLASS.markers[id]!="undefined" )
			CLASS.markers[id].setMap(null);
	}
	
	// Show only one marker, marker id passed through param
	CLASS.showMarker = function(id)
	{
		// Check to see if marker exists
		if( typeof CLASS.markers[id]!="undefined" )
			CLASS.markers[id].setMap(CLASS.map);
	}
	
	// Deletes all icons on the map
	CLASS.deleteMarkers = function(){ 
	  
	  if (CLASS.markers.length > 0) 
	  {
		CLASS.hideMarkers();  
		CLASS.markers.length = 0;
		CLASS.infoWindows.length = 0;
	  }
	}
	
	// Deletes all shapes on the map
	CLASS.deleteShapes = function(){ 
	  
	  if (CLASS.shapes.length > 0) 
	  {
		for(var i=0; i<CLASS.shapes.length; i++)
			CLASS.shapes[i].setMap(null);
		  
		CLASS.shapes.length = 0;
	  }
	}
	
	// Deletes all possible overlays from the map
	CLASS.clearMap = function(){
		// Clear all markers
		CLASS.deleteMarkers();
		// Clear all shapes
		CLASS.deleteShapes();		
	}
	// Deletes the previous driving directiosn
	CLASS.clearDrivingDirections = function(){
		// Clear possible Map directions
		if( CLASS.directionsRendered != null )
			CLASS.directionsRendered.setMap(null);
	}
	
	// Plots a pin given a zip code
	CLASS.plotPinByZip = function(zip, callback)
	{
		// Data Check
		if( typeof zip=="undefined" || isNaN(zip) )
		{
			alert("Zipcode provided is not valid.");
			return;
		}
		
		// Finds the Zip Code and re-centers the map.
		var geo = new google.maps.Geocoder();
		geo.geocode( {address:zip}, function(resultsArray, status){
						var res = resultsArray[0];
						
						// Make sure status returned without problems
						if( status = google.maps.GeocoderStatus.OK )
						{
							// Change Icon SetTitle
							var info_str = Array();
							for(var key in res.address_components) 
								info_str.push(res.address_components[key].long_name);
							// Trim the last 
							
							var loc = res.geometry.location;
							CLASS.plotPin({
									lat: loc.lat(),
									lng: loc.lng(),
									pinIcon: CLASS.pins.greenArrow,
									title: info_str.toString()
								});
							// Center/Zoom the map
							CLASS.map.setCenter( new google.maps.LatLng( loc.lat(),loc.lng() ) );
							CLASS.map.setZoom(13);
							
							// Callback developers method
							if( typeof callback == "function" )
								callback(resultsArray, status);
							
						}else
						{
							alert("Zipcode could not be found.");	
						}
				  });	
	}
	
	// Returns a Pixel Object (Google) is the x,y pixel coordinates that match a LatLng
	CLASS.latLngToPixel = function(latLng, callback)
	{
		if( CLASS.mapRenderedInContainer )
		{	
			try
			{		
				// Call the developer's callback function
				if( typeof callback == "function" )
					callback( CLASS.canvassOverlayView.getProjection().fromLatLngToContainerPixel( latLng ) );
			}catch(e){}
		}
		else
		{
			// We need to wait a little bit more
			setTimeout(function(){ CLASS.latLngToPixel(latLng, callback); },100);
		}
	}
	
	// Object used for drawing a polygon on the map
	CLASS.startDrawingPolygon = {
		index : CLASS.shapes.length,
		pathsCollection: null,
		maxPoints:0, // 0 is unlimited
		callback: null,
		centerPoly: true,
		mouseClick: null,
		mouseDoubleClick: null,
		mouseRightClick: null,
		mouseMove: null,
		// init function starts the drawing activity and event handlers
		init: function(config){
			// Create the shape index for our new polygon
			CLASS.shapes[CLASS.startDrawingPolygon.index] = null;
			
			// Initialize the pathsCollection
			CLASS.startDrawingPolygon.pathsCollection = new google.maps.MVCArray([]);
						
			// Start Event Handlers 
			CLASS.startDrawingPolygon.mouseClick 		= google.maps.event.addListener(CLASS.map,'click', CLASS.startDrawingPolygon.registerPoint );
			CLASS.startDrawingPolygon.mouseDoubleClick	= google.maps.event.addListener(CLASS.map,'dblclick', CLASS.startDrawingPolygon.finalizePolygon );
			CLASS.startDrawingPolygon.mouseRightClick 	= google.maps.event.addListener(CLASS.map,'rightclick', CLASS.startDrawingPolygon.finalizePolygon);
			CLASS.startDrawingPolygon.mouseMove 		= google.maps.event.addListener(CLASS.map,'mousemove', CLASS.startDrawingPolygon.renderNewPoly);
			
			// Assign Callback
			if( typeof config!="undefined" && typeof config.callback == 'function' )
				CLASS.startDrawingPolygon.callback = config.callback;
			// Register max number of points
			if( typeof config!="undefined" && typeof config.maxPoints != "undefined")
				CLASS.startDrawingPolygon.maxPoints = config.maxPoints;
			// Check to see if they want to center Poly
			if( typeof config!="undefined" && typeof config.centerPoly != "undefined")
				CLASS.startDrawingPolygon.centerPoly = config.centerPoly;
			// Change cursor to a crosshair
			CLASS.map.setOptions({ draggableCursor: 'crosshair' });
		},
		
		// Registers a new point into the pathsCollection Array
		registerPoint: function(location){
			// Initialize our polygon if this is our first click
			if( CLASS.shapes[CLASS.startDrawingPolygon.index]==null )
			{
				var polyOptions = CLASS.defaultPolyOptions;
				polyOptions.map = CLASS.map;
				CLASS.shapes[CLASS.startDrawingPolygon.index] = new google.maps.Polygon(polyOptions);
			}
			
			// Check to see if we are close to our max number of points
			if( CLASS.startDrawingPolygon.maxPoints!=0 && CLASS.startDrawingPolygon.pathsCollection.getLength()==CLASS.startDrawingPolygon.maxPoints-1 )
				// This will be the eigth point, so we must end the drawing
				CLASS.startDrawingPolygon.finalizePolygon(location);
			else
				// Add the location to the MVC pathsCollection
				CLASS.startDrawingPolygon.pathsCollection.push( location.latLng );
		},
		
		// Renders a new polygon with every mouse move
		renderNewPoly: function(location){
			// Wait until the user has clicked for the first time
			if( CLASS.shapes[CLASS.startDrawingPolygon.index]!=null )
			{				
				// Create a local parallel array, copy the elements of the shape and finally add only one additional latLng
				var paths = Array();
				CLASS.startDrawingPolygon.pathsCollection.forEach(function(el,i){
					paths[i] = el;
				});
				paths.push(location.latLng );
				
				// Finally put the shape on the map
				CLASS.shapes[CLASS.startDrawingPolygon.index].setPaths( paths );
			}
		},
		
		// Close up the polygon and call the developer's callback
		finalizePolygon: function(location){
			// Close all event listeners
			google.maps.event.removeListener(CLASS.startDrawingPolygon.mouseClick);
			google.maps.event.removeListener(CLASS.startDrawingPolygon.mouseDoubleClick);
			google.maps.event.removeListener(CLASS.startDrawingPolygon.mouseMove);
			google.maps.event.removeListener(CLASS.startDrawingPolygon.mouseRightClick);
			
			// Register and render the last point
			CLASS.startDrawingPolygon.renderNewPoly(location);
			
			// Change mouse cursor to original
			CLASS.map.setOptions({ draggableCursor: 'default' });
			
			// Check to see if we need to center Poly
			if( CLASS.startDrawingPolygon.centerPoly === true )
				CLASS.map.fitBounds( CLASS.getBoundsFromMVCArray( CLASS.shapes[CLASS.startDrawingPolygon.index].getPaths().getAt(0) ) );
			
			// Call back the developer's function, if provided
			if( typeof CLASS.startDrawingPolygon.callback=="function" )
				CLASS.startDrawingPolygon.callback( CLASS.shapes[CLASS.startDrawingPolygon.index].getPaths().getAt(0) );
		}
		
	}// END startDrawingPolygon object
	
	// Object used for drawing on the map
	CLASS.startDrawingRectangle = {
		NE:null,
		SW: null,
		original: null,
		index : CLASS.shapes.length,
		firstclick : true,
		doneDrawing : false,
		// Map listener objects
		mapClick1 : null,
		mapMouseMove : null,
		mapClick2 : null,
		callback : null,
		mouseMargin: 0,
		
		
		// Starts the drawing process
		startDrawing : function(loc){
			CLASS.startDrawingRectangle.original = loc;
						
			// Customize the shape setting here
			var recOptions = CLASS.defaultPolyOptions;
			recOptions.map = CLASS.map;
			recOptions.bounds = new google.maps.LatLngBounds( CLASS.startDrawingRectangle.original.latLng,CLASS.startDrawingRectangle.original.latLng );
			CLASS.shapes[CLASS.startDrawingRectangle.index] = new google.maps.Rectangle(recOptions);
			
			// Do not start again, flag also activates the rendering of the shape
			CLASS.startDrawingRectangle.firstclick = false;
			google.maps.event.removeListener(CLASS.startDrawingRectangle.mapClick1);
			CLASS.startDrawingRectangle.mapClick1=null;
		},
		
		// Redraws the rectangle everytime you move the mouse
		renderRectangle : function(loc2){
			if( !CLASS.startDrawingRectangle.firstclick )
			{			
				// Setup East and West Longitude correctly
				if( CLASS.startDrawingRectangle.original.latLng.lng()-0.0015 > loc2.latLng.lng() )
				{
					var eLng = CLASS.startDrawingRectangle.original.latLng.lng();
					var wLng = loc2.latLng.lng()+0.0015;
				}else if( CLASS.startDrawingRectangle.original.latLng.lng()+0.0015 < loc2.latLng.lng() )
				{
					var eLng = loc2.latLng.lng()-0.0015;
					var wLng = CLASS.startDrawingRectangle.original.latLng.lng();
				}else
				{
					var eLng = CLASS.startDrawingRectangle.original.latLng.lng();
					var wLng = CLASS.startDrawingRectangle.original.latLng.lng();
				}
				
				// Setup North and South Latitude correctly
				if( CLASS.startDrawingRectangle.original.latLng.lat() >= loc2.latLng.lat() )
				{
					var nLat = CLASS.startDrawingRectangle.original.latLng.lat();
					var sLat = loc2.latLng.lat();
					
				}else
				{
					var nLat = loc2.latLng.lat();
					var sLat = CLASS.startDrawingRectangle.original.latLng.lat();
				}

				// Setup new NE and SW Coordinates
				CLASS.startDrawingRectangle.SW = new google.maps.LatLng( sLat,wLng );
				CLASS.startDrawingRectangle.NE = new google.maps.LatLng( nLat,eLng );
				
				// Redraw the shape in question
				CLASS.shapes[CLASS.startDrawingRectangle.index].setBounds( new google.maps.LatLngBounds( CLASS.startDrawingRectangle.SW,CLASS.startDrawingRectangle.NE ) );
				
				// Create the listener and handler for second click
				if( CLASS.startDrawingRectangle.mapClick2==null )
					CLASS.startDrawingRectangle.mapClick2 = google.maps.event.addListenerOnce( CLASS.map, 'click', CLASS.startDrawingRectangle.finalizeDrawing );
			
			}
		},
		
		// Finalize the drawing events
		finalizeDrawing : function(locFinal){
			CLASS.startDrawingRectangle.firstclick = true;
			// Disable the event handlers
			// No more drawing
			// mapClick1: was disabled as soon as the drawing started.
			google.maps.event.removeListener(CLASS.startDrawingRectangle.mapClick2);
			google.maps.event.removeListener(CLASS.startDrawingRectangle.mapMouseMove);
			CLASS.startDrawingRectangle.mapClick2=null;
			CLASS.startDrawingRectangle.mapMouseMove=null;
			// Change mouse cursor to original
			CLASS.map.setOptions({ draggableCursor: 'default' });
			// Call provided callback, returning the bounds of the shape
			if( typeof CLASS.startDrawingRectangle.callback == 'function' )
				CLASS.startDrawingRectangle.callback(CLASS.shapes[CLASS.startDrawingRectangle.index].getBounds());
		},
		
		// Used for activating the listeners
		init : function(issuedCallback){
			CLASS.shapes[CLASS.startDrawingRectangle.index] = null;
			// Nothing happens until user clicks on the map
			CLASS.startDrawingRectangle.mapClick1 = google.maps.event.addListener(CLASS.map, 'click', CLASS.startDrawingRectangle.startDrawing );
			// New rectangle is rendered on every mouse move
			CLASS.startDrawingRectangle.mapMouseMove = google.maps.event.addListener(CLASS.map, 'mousemove', CLASS.startDrawingRectangle.renderRectangle );
			
			// Assign Callback
			if( typeof issuedCallback == 'function' )
				CLASS.startDrawingRectangle.callback = issuedCallback; 
			// Change mouse cursor to crosshair
			CLASS.map.setOptions({ draggableCursor: 'crosshair' });
		},
		
		// Manual deactivate the drawing feature
		terminate: function(){
			CLASS.startDrawingRectangle.firstclick = true;
			if( CLASS.shapes[CLASS.startDrawingRectangle.index]!=null )
			{
				// Erase any existing shape
				CLASS.shapes[CLASS.startDrawingRectangle.index].setMap(null);
				CLASS.shapes.length--;
			}
			// Change mouse cursor to original
			CLASS.map.setOptions({ draggableCursor: 'default' });
			// Disable the event handlers
			if( CLASS.startDrawingRectangle.mapClick1 != null )
				google.maps.event.removeListener(CLASS.startDrawingRectangle.mapClick1);
			if( CLASS.startDrawingRectangle.mapClick2 != null )
				google.maps.event.removeListener(CLASS.startDrawingRectangle.mapClick2);
			if( CLASS.startDrawingRectangle.mapMouseMove != null )
				google.maps.event.removeListener(CLASS.startDrawingRectangle.mapMouseMove);
		}
		
	}// END CLASS.activateDrawingRectangle()
	
	// Show traffic layer on map
	CLASS.showTraffic = function()
	{
		// Check if the layer has not been used yet
		if( CLASS.trafficLayer == null )
			CLASS.trafficLayer = new google.maps.TrafficLayer();	
			
		// Activate layer on current map
		CLASS.trafficLayer.setMap(CLASS.map);
	}
	
	// Hides the traffic on the current map
	CLASS.hideTraffic = function()
	{
		// Activate layer on current map
		CLASS.trafficLayer.setMap(null);
	}
	
	// Toggles the Traffic Layer between show/hide
	CLASS.toggleTraffic = function()
	{
		if( CLASS.trafficLayer==null || CLASS.trafficLayer.getMap()==null )
			CLASS.showTraffic();
		else
			CLASS.hideTraffic();
	}
	
	// Public Singleton object for custom infowindow
	CLASS.customInfoWindow = {		
		// setTimeout obj used for mouseout on markers
		closeDelay : null,
		
		// DOM Element
		el : document.createElement('div'),
		arrow : document.createElement('img'),
		
		// Overwrite DOM Element
		setElement : function(obj){ CLASS.customInfoWindow.el = obj; },
		
		// Private Method that create a dom Element which will 
		// be used to floated around as a infowindow for all markers
		init : function()
		{
			CLASS.customInfoWindow.el.style.fontFamily 		= 'Arial,sans-serif';
			CLASS.customInfoWindow.el.style.zIndex 			= '5000';
			CLASS.customInfoWindow.el.style.position 		= 'absolute';
			CLASS.customInfoWindow.el.style.borderWidth		= '2px';
			CLASS.customInfoWindow.el.style.borderStyle		= 'solid';
			CLASS.customInfoWindow.el.style.borderColor		= '#000000';
			CLASS.customInfoWindow.el.style.fontSize 		= '12px';
			CLASS.customInfoWindow.el.style.padding 		= '10px';
			CLASS.customInfoWindow.el.style.backgroundColor = '#FFFFFF';
			CLASS.customInfoWindow.el.style.display 		= 'none';
			CLASS.customInfoWindow.el.innerHTML 			= '';
			CLASS.customInfoWindow.el.id					= "NMAP_custom_infoWindow";
			CLASS.customInfoWindow.arrow.id					= "NMAP_custom_infoWindow_arrow";
			CLASS.customInfoWindow.arrow.style.position 	= 'absolute';
			CLASS.customInfoWindow.arrow.style.display 		= 'none';
			CLASS.customInfoWindow.arrow.style.zIndex 		= '5500';
			
			document.body.appendChild(CLASS.customInfoWindow.el);
			document.body.appendChild(CLASS.customInfoWindow.arrow);
			// Permantly setup an listener to cancel Timeouts that can potentially
			// close a infowindow when user mouses over the window
			google.maps.event.addDomListener( CLASS.customInfoWindow.el, "mouseover", function(){
				// Just incase the setTimeout is active from another marker
				if( CLASS.customInfoWindow.closeDelay != null )
				{
					clearTimeout(CLASS.customInfoWindow.closeDelay);
					CLASS.customInfoWindow.closeDelay = null;
				}
			});
			// Listen for when the user mouses out of the infowindow
			google.maps.event.addDomListener( CLASS.customInfoWindow.el, 'mouseout', function(){
				// Set a 1 second delay to close the window
				// If user pans over the infowindow we will cancel this delay
				CLASS.customInfoWindow.closeDelay = setTimeout(CLASS.customInfoWindow.close,1000);
			});
		},
		// Closes the infowindow
		close : function(){
			CLASS.customInfoWindow.closeDelay	= null;
			CLASS.customInfoWindow.el.style.display = 'none';
			CLASS.customInfoWindow.arrow.style.display = 'none';
		},
		// Open the infowindow
		open : function(){
			CLASS.customInfoWindow.el.style.display = 'block';
			CLASS.customInfoWindow.arrow.style.display = 'block';
		},
		// Hide the infowindow
		invisible : function(){
			CLASS.customInfoWindow.el.style.visibility = 'hidden';
			CLASS.customInfoWindow.arrow.style.visibility = 'hidden';
		},
		// show the infowindow
		visible : function(){
			CLASS.customInfoWindow.el.style.visibility = 'visible';
			CLASS.customInfoWindow.arrow.style.visibility = 'visible';
		},		
		// Shows the infowindow at a specific location with given content
		fillShow : function(content, latLng, showDirections)
		{
			// Check for 3rd param (optional)
			var showDir_flag = (typeof showDirections=="undefined" || showDirections);
			// Just incase the setTimeout is active from another marker
			if( CLASS.customInfoWindow.closeDelay != null )
			{
				clearTimeout(CLASS.customInfoWindow.closeDelay);
				CLASS.customInfoWindow.closeDelay = null;
			}
			
			// First see if we can get pixel coordinates for given lat and lng
			CLASS.latLngToPixel(latLng, function(markerLocation){
				// Set the content into the infowindow then show the infowindow
				CLASS.customInfoWindow.el.innerHTML = content;
				// Not all maps want to show directions on popups
				if( showDir_flag )
					CLASS.customInfoWindow.el.appendChild( CLASS.getDirectionsWrapperElement(latLng.toUrlValue()) );
				CLASS.customInfoWindow.positionWindow(markerLocation);
			});

			// NOTE: If an exception was thrown trying to get pixel coordinates for latLng
			// Then nothin will happen and infowindow will not be shown
		},
		
		// Method Check to see if the infowindow has been filled yet,
		positionWindow : function(markerLocation){
				// Open the info window (DOM calculations), but hide it from view
				CLASS.customInfoWindow.open();
				CLASS.customInfoWindow.invisible();
				
				// Calculate and set window to appropriate position
				var offSet = CLASS.customInfoWindow.calculateInfoWindowPosition(markerLocation);
				CLASS.customInfoWindow.el.style.left 	= offSet.x+"px";
				CLASS.customInfoWindow.el.style.top		= offSet.y+"px";
				// Set appropriate arrow next to marker
				if( offSet.orientation == 'left' )				
				{
					CLASS.customInfoWindow.arrow.src = CLASS.images.infoWindowArrowRight;
					CLASS.customInfoWindow.arrow.style.left 	= (offSet.markerOffsetX-22)+"px";
					CLASS.customInfoWindow.arrow.style.top		= (offSet.markerOffsetY-15)+"px";
				}else
				{
					CLASS.customInfoWindow.arrow.src = CLASS.images.infoWindowArrowLeft;
					CLASS.customInfoWindow.arrow.style.left 	= (offSet.markerOffsetX+2)+"px";
					CLASS.customInfoWindow.arrow.style.top		= (offSet.markerOffsetY-15)+"px";
				}
				
				// Now Show the infowindow
				CLASS.customInfoWindow.visible();
		},
		
		// Method decides what the location for the customInfoWindow will be.
		// Depending on what quadrant the location is in, the infowindow will
		// always render towards the center of the map.
		calculateInfoWindowPosition : function(pinLocation)
		{			
			// private collection of offsets and custom infoWindow dimensions
			var mO = CLASS.getMapOffset();
			var pO = { x:(pinLocation.x+mO.x), y:(pinLocation.y+mO.y) };
			var wD = { x:CLASS.customInfoWindow.el.offsetWidth, y:CLASS.customInfoWindow.el.offsetHeight };
			var mD = CLASS.getMapDimensions();
			var arrowWidth = 20; 
			
			// Calculate all 4 different formulas for new width and height
			// These are custom calculations designed with map container
			// divided into 4 quadrants.
			var fx1 = pO.x+arrowWidth;
			var fx2 = pO.x-(wD.x)-arrowWidth;
			var fy1 = pO.y-wD.y+30;
			var fy2 = pO.y-30;
			
			// Build return Object
			var returnObj = {
				markerOffsetX: pO.x,
				markerOffsetY: pO.y,
				mapOffsetX: mO.x,
				mapOffsetY: mO.y
			};
			
			// Decide what quadrant the pin is located in and return appropriate coordinates
			if( pinLocation.x <= (mD.x*.5) && pinLocation.y <= (mD.y*.5) )
			{
				// Quadrant 1
				returnObj.x = fx1;
				returnObj.y = fy2;
				returnObj.orientation = 'right';
				return returnObj;
			}
			else if( pinLocation.x > (mD.x*.5) && pinLocation.y <= (mD.y*.5) )
			{
				// Quadrant 2
				returnObj.x = fx2;
				returnObj.y = fy2;
				returnObj.orientation = 'left';
				return returnObj;
			}
			else if( pinLocation.x <= (mD.x*.5) && pinLocation.y > (mD.y*.5) )
			{
				// Quadrant 3
				returnObj.x = fx1;
				returnObj.y = fy1;
				returnObj.orientation = 'right';
				return returnObj;
			}
			else
			{
				// Quadrant 4
				returnObj.x = fx2;
				returnObj.y = fy1;
				returnObj.orientation = 'left';
				return returnObj;
			}
		}// END calculateInfoWindowPosition
		
	};// END customInfoWindow Singleton

	// Public method returns the pixel offset of the map container
	// realtive to the document body.
	CLASS.getMapOffset = function()
	{
		var obj = document.getElementById(CLASS.mapDIV);
		var curleft = curtop = 0;
		if (obj.offsetParent) {
			do{
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
			}while(obj = obj.offsetParent);
		}
		return {x:curleft,y:curtop};
	}
	
	// Public method returns the dimensions of the map container
	CLASS.getMapDimensions = function()
	{
		var obj = document.getElementById(CLASS.mapDIV);		
		return { x:obj.offsetWidth, y:obj.offsetHeight };
	}
	
	// Public Method to return the HTTP URL to use with static maps API
	CLASS.staticMaps = {
		// Super variables for this mini class, singleton
		initialized : false,
		url : "", // URL reset everytime the url is rendered
		plat: 0,
		plng : 0,
		
		// Function renders everything on the map
		renderMapURL : function()
		{
			// Reset the URL
			CLASS.staticMaps.url = "http://maps.google.com/maps/api/staticmap?";
			// Reset certain varaibles
			CLASS.staticMaps.plat = 0;
			CLASS.staticMaps.plng = 0;
			
			// Get current map settings
			var mapDimensions = CLASS.getMapDimensions();
			var center = CLASS.map.getCenter();
			var zoom = CLASS.map.getZoom();
			var mapType = CLASS.map.getMapTypeId();
			
			// Initialize URL
			CLASS.staticMaps.url += "sensor=false&center="+center.lat()+","+center.lng()+"&zoom="+zoom+"&size="+mapDimensions.x+"x"+mapDimensions.y+"&maptype="+mapType;
			
			// Addon the marker information
			CLASS.staticMaps.url += "&"+CLASS.staticMaps._getMarkerQuery();
			
			// Addon the Shape information
			CLASS.staticMaps.url += "&"+CLASS.staticMaps._getEncodedShapeQuery();
			
			// Cleanup on isle 1
			CLASS.staticMaps.url = CLASS.staticMaps.url.replace("&&","&"); 
				
			return CLASS.staticMaps.url;
			/*
			// Get this URL signed
			CLASS.ajax.call({
				url: "http://www.har.com/api/google_sign_url.cfm?url_path="+escape(escape(CLASS.staticMaps.url.replace('http://maps.google.com',''))),
				success: function(resp){
					window.location = "http://maps.google.com"+resp;
				}
			});
			*/
		},
		
		// STATIC MAPS - Local Methods -------------------------------------------------------------------------------------------------------------------------
		
		// Generates the marker section of the URL
		_getMarkerQuery : function()
		{
			var query = "";
			if( typeof CLASS.markers[0] != "undefined" )
			{
				var icon = CLASS.markers[0].getIcon();
				icon = ( typeof icon == "string" ) ? icon:icon.url;
				query = "markers=icon:"+icon+"|";
			}
			
			for( var i=0; i<CLASS.markers.length; i++ )
			{
				// Only allow for first 50 Markers
				if( i==50 ){/*alert("Only the first 50 listings will show on printed maps.");*/ break;};
				
				var pos = CLASS.markers[i].getPosition();
				query += ""+pos.lat()+","+pos.lng()+"|";
			}
			return query;
		},

		// Generates the shape encoded data for the URL
		_getEncodedShapeQuery : function()
		{
			var encoded_points = "";
			var firstPoint = null;
			
			// Loop through all the points in the first shape
			if( typeof CLASS.shapes[0]!="undefined" ) 
			{
				// Loop through all the points in the polygon
				CLASS.shapes[0].getPath().forEach(function(point,index){
					// Capture only first point
					if( firstPoint ==  null ) firstPoint = point;
					// Encode these Lat and Lngs
					encoded_points += CLASS.staticMaps._encodeLatLng( point.lat(), point.lng() );
				});
				
				// Add first point as last point, so we can close the image
				if( firstPoint !=  null ) encoded_points += CLASS.staticMaps._encodeLatLng( firstPoint.lat(), firstPoint.lng() );
				
				// Get the styling for the polygon
				var opts = CLASS.defaultPolyOptions;
				var path = "path=color:"+opts.strokeColor.replace("#","0x")+"|fillcolor:"+opts.fillColor.replace("#","0x")+"|weight:"+opts.strokeWeight+"|enc:";
				encoded_points = path + encoded_points;
			} 
			
			return encoded_points;
		},
		_encodeLatLng : function(lat,lng)
		{
			var late5 = Math.floor(lat * 1e5);
			var lnge5 = Math.floor(lng * 1e5);
			
			dlat = late5 - CLASS.staticMaps.plat;
			dlng = lnge5 - CLASS.staticMaps.plng;
			
			CLASS.staticMaps.plat = late5;
			CLASS.staticMaps.plng = lnge5;
			
			return CLASS.staticMaps._encodeSignedNumber(dlat) + CLASS.staticMaps._encodeSignedNumber(dlng);
		},
		_encodeSignedNumber : function(num)
		{
		  var sgn_num = num << 1;
		
		  if (num < 0) {
			sgn_num = ~(sgn_num);
		  }
		
		  return(CLASS.staticMaps._encodeNumber(sgn_num));
		},
		_encodeNumber : function(num) {
		  var encodeString = "";
		
		  while (num >= 0x20) {
			encodeString += (String.fromCharCode((0x20 | (num & 0x1f)) + 63));
			num >>= 5;
		  }
		
		  encodeString += (String.fromCharCode(num + 63));
		  return encodeString;
		}
	};// END STATIC MAPS - API
	
	// Used for ONLY IE browsers
	// High jacks the printing process and injects a static map instead of the real map.
	CLASS.printPage = {
		// Map Contianer Element
		// Fill this variable right before printing
		mapContainer : null,
		// Hold the original content of the map
		// Fill this variable right before printing
		originalContent : "",
		// Holds a unique identifier for the static map
		uniqueMapID : 	CLASS.getUID(),
		// Holds static map object
		staticMapObj : null,
		// Holds original window.print function
		_print : null,
		// Done before printing
		beforePrinting : function()
		{
			// Get map dimensions
			var mD = CLASS.getMapDimensions();
			
			if( CLASS.printPage.staticMapObj==null )
			{
				// Create an img object to hold the static map
				CLASS.printPage.staticMapObj 				= document.createElement('img');
				CLASS.printPage.staticMapObj.width 			= mD.x;
				CLASS.printPage.staticMapObj.height 		= mD.y;
				CLASS.printPage.staticMapObj.src 			= "";
				CLASS.printPage.staticMapObj.id 			= CLASS.printPage.uniqueMapID;
				CLASS.printPage.staticMapObj.style.display = "none";
				// Get the proper DOM Element for the container
				CLASS.printPage.mapContainer = document.getElementById(CLASS.mapDIV);
				// Insert static map before map container
				CLASS.printPage.mapContainer.parentNode.insertBefore(CLASS.printPage.staticMapObj,CLASS.printPage.mapContainer );
				
			}
			// Everytime you print, we need to render a new static map
			CLASS.printPage.staticMapObj.src = CLASS.staticMaps.renderMapURL().replace("size=0x0","size="+mD.x+"x"+mD.y);
			
			// Hide actual map and show static map.
			CLASS.printPage.mapContainer.style.display = "none";
			// Show static map
			CLASS.printPage.staticMapObj.style.display = "block";	
		},
		// Done After Printing
		afterPrinting : function()
		{
			// Hide static map
			CLASS.printPage.staticMapObj.style.display = "none";
			// Show actual map and show static map.
			CLASS.printPage.mapContainer.style.display = "block";
		},
		// Function used for nonIE browsers
		nonIE : function()
		{
			// Change the map to a static one
			CLASS.printPage.beforePrinting();
			// Time out to call print
			setTimeout(CLASS.printPage._print,100);
			// Wait 2 seconds then put everything back to normal.
			setTimeout(CLASS.printPage.afterPrinting,100);
		}
	};
	
	// Public AJAX Object
	CLASS.ajax = {
			// Param: { url, success(), fail(), postVars{} }
			call : function( options ){
				// Get our object
				var  xmlhttp = CLASS.ajax.getXMLHTTPObject();
				
				// Listen for state change
				xmlhttp.onreadystatechange=function()
				{
					// AJAX Call is done
					if(xmlhttp.readyState == 4) 
					{
						// only if "OK"
						//alert("State 4: "+xmlhttp.responseText);
						if (xmlhttp.status == 200)
							 if( typeof options.success=="function" ) options.success(xmlhttp.responseText);
						else
							 if( typeof options.fail=="function" ) options.fail(xmlhttp.responseText);
					}
				};
				
				// This is the actual Call
				if( typeof options.postVars=="object" )
				{
					// Prepare for post request
					var params = "";
					for( var key in options.postVars )
						params += key+"="+options.postVars[key]+"&";
					// Prepare headers
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.setRequestHeader("Content-length", params.length);
					xmlhttp.setRequestHeader("Connection", "close");
					
					// Send post request
					xmlhttp.open( "POST", options.url, true );
					xmlhttp.send(params);
				}
				else
				{
					// Send get request
					xmlhttp.open( "GET", options.url, true );
					xmlhttp.send(null);
				}
				
			},
			// Method used to get a XML HTTP obj
		 	getXMLHTTPObject : function(){
				var xmlhttp=null
				// code for W3C Standard.
				if (window.XMLHttpRequest)
				{
					return new XMLHttpRequest()
				}
				// code for IE
				else if (window.ActiveXObject)
				{
					return new ActiveXObject("Microsoft.XMLHTTP")
				}
				if (xmlhttp==null)
				{
					alert("Your browser does not support XMLHTTP.")
				}
			}// END getXMLObject()
	};// END AJAX API
		
// Private Methods Below --------------------------------------------
// ------------------------------------------------------------------
	
	// Private OverlayView() inherited class
	CLASS._MyOverlay = function(map) { this.setMap(map); }
	
	// Loads the Google API into the DOM
	CLASS._loadScript = function(){ 
		
		// Search for existing API
		// Just incase you are instanciating another object of this class
		var scripts = document.getElementsByTagName('script');
		for(var i=0; i<scripts.length; i++)
		{
			if( scripts[i].src.indexOf("maps.google.com")>0 )	
				CLASS._confirmAPILoad();
				
			// Also check for parcels maps (when parcels maps are ready).
		}
		
		// If API not loaded 
		if(!CLASS.apiIsLoaded)
		{
			var head = document.getElementsByTagName('head')[0];
			
			if( CLASS.loadParcels && false )
			{
				// Start with our Parcels API
				var apisrc2 = document.createElement('script');
				apisrc2.id	= 'parcelAPI';
				apisrc2.type= 'text/javascript';
				apisrc2.src	= CLASS.parcelAPI;
				head.appendChild(apisrc2);
			}
			// End by providing our Google Map API
			var apisrc 	= document.createElement('script');
			apisrc.id	= 'googleMapAPI';
			apisrc.type	= 'text/javascript';
			apisrc.src	= CLASS.mapAPI;
			head.appendChild(apisrc);
		}
	}
	
	// Places the actual map in the DOM
	CLASS._installMap = function(config){ 
		
		// Make sure API is finished loading asynchronously
		if( !CLASS.apiIsLoaded )
		{
			setTimeout(function(){ CLASS._installMap(config) }, 100); //<-- Recursive callback
		}
		else
		{
			// DEFAULT - Setup Map Options
			CLASS.mapOptions.center 	= new google.maps.LatLng(29.74887863492847,-95.36201477050782);
			CLASS.mapOptions.zoom 		= 11;

			CLASS.mapOptions.mapTypeId 	= google.maps.MapTypeId.ROADMAP;
			CLASS.mapOptions.domElement	= CLASS.mapDIV;
			CLASS.mapOptions.scaleControl=true;
			CLASS.mapOptions.streetViewControl	= true;
			CLASS.mapOptions.streetView	= new google.maps.StreetViewPanorama(document.getElementById(CLASS.mapDIV),{addressControl:false,visible:false,enableCloseButton:true});
			// END DEFAULT - Map Options
			
			// Overwrite with developer's options
			// We trust our developers =)
			for(var key in config)
			{
				if( key=='center' )
					CLASS.mapOptions.center = new google.maps.LatLng(parseFloat(config.center.latitude),parseFloat(config.center.longitude));
				else if( key == 'mapTypeControlStyle' )
					CLASS.mapOptions.mapTypeControlOptions = {style:google.maps.MapTypeControlStyle[config.mapTypeControlStyle]};
				else if( key == 'mapTypeId' )
					CLASS.mapOptions.mapTypeId = google.maps.MapTypeId[config.mapTypeId];
				else
					CLASS.mapOptions[key] = config[key]; 
			}
			
			// Just in case the domElement is different, lets overwrite the class variable
			if( CLASS.mapOptions.domElement!=CLASS.mapDIV ) CLASS.mapDIV=CLASS.mapOptions.domElement;
			
			try{
				// Install Map on DOM
				CLASS.map = new google.maps.Map( document.getElementById(CLASS.mapOptions.domElement), CLASS.mapOptions );
				// Installing NMAP infoWindow dom element
				CLASS.customInfoWindow.init();
				// Setup private overlay var
				CLASS._MyOverlay.prototype = new google.maps.OverlayView();
				CLASS._MyOverlay.prototype.onAdd = function() { }
				CLASS._MyOverlay.prototype.onRemove = function() { }
				CLASS._MyOverlay.prototype.draw = function() { }
				CLASS.canvassOverlayView = new CLASS._MyOverlay(CLASS.map);
				// Listen for when Map is rendered inside container (DIV)
				google.maps.event.addListener(CLASS.map, 'projection_changed', function(){ 
					// Flag this event =)
					CLASS.mapRenderedInContainer = true; 
					// Overwrite IE beforePrinting and afterPrinting methods
					if( typeof window.onbeforeprint != "undefined" )
					{
						// Add printing functionality to pages with maps
						window.onbeforeprint = CLASS.printPage.beforePrinting;
						window.onafterprint = CLASS.printPage.afterPrinting;
						// *NOTE:above functionality is IE only
					}else if( typeof window.print!="undefined" )
					{
						CLASS.printPage._print = window.print;
						window.print = CLASS.printPage.nonIE;
					}
				});
			}catch(e){alert("Installing Map: "+e.message);}
			
			// Load Parcel API - Check
			CLASS._loadParcelAPI();
			
			// Call the callback that the developer provided,
			// Usually a function that ends up ploting the pins
			if( typeof config != 'undefined' && typeof config.callback != 'undefined' ) config.callback();
		}
	}
	
	// Callback used by google API to let us know the API has been loaded
	CLASS._confirmAPILoad = function(){ 
		// Switch our apiLoaded Flag
		CLASS.apiIsLoaded = true;
	}
	
	// Loads parcels layers into our map
	CLASS._loadParcelAPI = function(){ 
		// Check to see if we are loading Parcels, so we
		// can prep and output tiles on map
		// Add a tiled parcel layer
		if( CLASS.loadParcels )
		{	
				
			// Internal Funciton: Only useful in local scope
			TileXYToQuadKey = function(tileX, tileY, levelOfDetail) {
                  var quadKey = '';
                  for (var i = levelOfDetail; i > 0; i--) {
                      var digit = '0';
                      var mask = 1 << (i - 1);
                      if ((tileX & mask) != 0) {
                          digit++;
                      }
                      if ((tileY & mask) != 0) {
                          digit++;
                          digit++;
                      }
                      quadKey += digit;
                  } //for i
                  return quadKey;

              } //TileXYToQuadKey 

			// RAW NATIVE CALLS TO PARCEL STREAM
			tilelayer = new google.maps.ImageMapType({
			  getTileUrl: function(tile, zoom) {
			  //var serverPath = "http://parcelstream.com/GetMap.aspx";
			  var serverPath = "http://t%2.parcelstream.com/VEParcelTileServer.aspx";
				  if (!true || zoom < 16 || zoom > 19)
					  return "";
			
				  var path = serverPath.replace("%2", "" + Math.floor(Math.random() * 4));
				  var tileServerPath2 = path + "?tileid=" + TileXYToQuadKey(tile.x, tile.y, zoom);
				  //  tileServerPath2 += "&layers=DMP_LICENSE/ParcelTiles";
				  tileServerPath2 += "&layers=Parcels";
				  tileServerPath2 += "&IsEncoded=true&SRS=EPSG:4326&REQUEST=MAP";
			
				  return tileServerPath2;
			
			  },
			  tileSize: new google.maps.Size(256, 256),
			  //opacity: .60,
			  isPng: true
			});
			
			CLASS.map.overlayMapTypes.push(null); // create empty overlay entry
			CLASS.map.overlayMapTypes.setAt("0", tilelayer); // set the overlay, 0 index 	
		}// END IF
	}
}// END CLASS