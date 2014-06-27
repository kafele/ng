order by <a href="" onclick="javascript:sortAds(2,4); return false;">date</a>   <a href="">price</a>





<script>

function sortAds(type, params){	
   alert("enter sortAds")
  	objQuickRequestDebounced = false;
  	someVar = searchQuickObjectsAjaxPath;
	//alert  ("someVar=" + someVar);
  	someArray = someVar.split('&');
  	configId = 0;
  	for(i in someArray){
  	  get = someArray[i].split('=');
  	  if(get[0] == 'configId'){
  	    configId = get[1];
  	  }
  	}
  //	searchQuickObjectsAjaxPath = '/bkn/index.php5?module=objects&configId=' + configId + '&class=ajax&action=GetSearchObjectsCount&useTpl=list';
	searchQuickObjectsAjaxPath = qsPath;
  	//  alert ("searchQuickObjectForm=" + searchQuickObjectForm)
	//$('#' + searchQuickObjectForm).find('.preview-quick-objects-count .count').html('Объектов: 2' );
  	//$('#' + searchQuickObjectForm).find('.preview-quick-objects-count').addClass('preview-quick-objects-count-loading');
  	 
	var  hValues= $('#' + searchQuickObjectForm).serialize()
	//var  hValues= document.getElementById('search-objects-form')
	// alert("hValues" + hValues);

//	$.ajax({
 // url: searchQuickObjectsAjaxPath,
 // success: function(data) {
  //  $('.result').html(data);
  //  alert('Load was performed.');
 // }
//});
	 if(timeAjaxWite != undefined)
			clearTimeout(timeAjaxWite);
		timeAjaxWite = setTimeout(function(){
			thisajax = $.ajax({
			url: searchQuickObjectsAjaxPath,
			data: hValues,
	
				success: function(data) {
					isloading = false;
					//formCounter.text(data.results);
					 //alert( (data.results));
					   //alert  (data ); 
					//alert("suk")
					// alert  (hValues)
				//	if(parseInt(data) === 0) {
				//	data="-"
				//	} else {
				//	data=parseInt(data)
				//	}
					 $('#' + searchQuickObjectForm).find('.preview-quick-objects-count .count').html('Объектов: ' + data);
                     //$('.sr').removeClass('sr')
			        //$('.sr').addClass(' ');
			  //$('.wrapper').removeClass('wrapper')
			        // $('.wrapper').addClass(' ');
			 // $('.container').removeClass('container')
			       //  $('.container').addClass('container');
			  var p = $("#header");
				var position = p.position();
				//alert  (position.left )
				// $("#header").position.left = 800;
				//  p.position();
//$("p:last").text( "left: " + position.left
					//alert("1" + data);
						//button.addClass('disable');
					//button.find('button').attr('disabled', 'disabled');
				}
			});
		},500);
  }

</script>






