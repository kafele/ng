/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 254 2010-07-23 05:14:44Z emartin24 $
 */

jQuery(function ($) {
	// Load dialog on page load
	 //$('#basic-modal-content').modal();

	// Load dialog on click
	$('#basic-modal .basic').click(function (e) {
		 $('#basic-modal-content').modal();
		 //var map = new YMaps.Map($("#extend-3")[0]);
		 
		 //alert("map");
		 
		   
     //map.setCenter(new YMaps.GeoPoint(37.64, 55.76), 10);
		  
		   
		 //map.redraw();
		 
		//alert (YMaps);
//YMaps.redraw();
		return false;
	});
});


	
	
	


jQuery(function($) {
   
    //map.setCenter(new YMaps.GeoPoint(37.64, 55.76), 10);
    jQuery("a[rel]").overlay({
        onLoad : function () {
		alert ("load");
		
        }
    });
});