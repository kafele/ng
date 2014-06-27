













var $j = jQuery.noConflict(); 


function bt_up() {
	alert($('bt_pop'))
	if (!$('bt_pop')) return false;
	$('bt_pop').className = 'up';
	return false;
}

function bt_dn() {
	if (!gebi('bt_pop')) return false;
	gebi('bt_pop').className = 'dn';
	return false;
}

function choose_bt(obj, bt_id) {
	var id = obj.id;
	var val = parseInt(id);
	//var tid = id.replace(val+'_','');
	//gebi(tid).innerHTML = obj.innerHTML;
	var par = obj.parentNode;
	if (!par) return false;
	if (par.className == '') {
		par.className = 'cur';
		//var node = document.getElementById(val);
		//node['myProperty'] = 'value';
		//var metro_id = document.getElementById("mt_"+metro_id);
		//metro_id.parentNode.removeChild(idElem);
		document.getElementById("mt_"+bt_id).value=bt_id;
	}
	else {
		par.className = '';
		//empty("#mt_"+metro_id);
		//idElem.parentNode.removeChild(idElem);
		document.getElementById("mt_"+bt_id).value="0";
	}
	//alert(metro_id);
	return false;
}

function chosen() {
	metro_dn();
	return false;
}

var lastid 


$j(document).ready(function(){
//alert("ready")


//alert($("#li_rayon_comment"))
 //alert($j("li"))


 
 
 

	//$("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled - Adds empty span tag after ul.subnav
	
	if  ($j("#bt_type")) {
	$j("#bt_type").mouseover(function() { //When trigger is clicked...
		//Following events are applied to the subnav itself (moving subnav up and down)
		$j(this).parent().find("ul.subnavbt").slideDown('fast').show(); //Drop down the subnav on click
		$j(this).parent().hover(function() {
		}, function(){	
		
		
		
		
		
			$j(this).parent().find("ul.subnavbt").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up
		});
		//Following events are applied to the trigger (Hover events for the trigger)
		}).hover(function() { 
			//$(this).addClass("subhover"); //On hover over, add class "subhover"
		}, function(){	//On Hover Out
			//$(this).removeClass("subhover"); //On hover out, remove class "subhover"
	});
	
	}

	
	
	
	if ($j("#be_type")){
	
	$j("#be_type").mouseover(function() { //When trigger is clicked...
		//Following events are applied to the subnav itself (moving subnav up and down)
		$j(this).parent().find("ul.subnavbe").slideDown('fast').show(); //Drop down the subnav on click
		$j(this).parent().hover(function() {
		}, function(){	
			$(this).parent().find("ul.subnavbe").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up
		});
		//Following events are applied to the trigger (Hover events for the trigger)
		}).hover(function() { 
			//$(this).addClass("subhover"); //On hover over, add class "subhover"
		}, function(){	//On Hover Out
			//$(this).removeClass("subhover"); //On hover out, remove class "subhover"
	});
}
	
	
	
	
	 //alert($("li"))
	
	if  ($j("span")) {
	
	$j("span").mouseover(function() { 	
					
				//alert();
					if (event.target){
						  k_id= event.target.id;
						  k_cl=event.target.className;
					}
					else{
						k_id= event.srcElement.id;
						k_cl=event.srcElement.className;
					}
	
					//alert (k_cl)	
					if  (k_id){ 
						  
						  if (($j("#" + k_id + "_comment"))  &&   ((k_cl == "mainli")    ||(k_cl == "mainli diff") )    ){
							 // alert (lastid)
								if ($j(lastid))  {
									
									if ( lastid !=("#" + k_id + "_comment"))        {
									
									
									
									
									
									
									$j(lastid).slideUp('slow')
									}
									}
									  
								//alert($("#" + k_id + "_comment"))  
								
								
								
								
								
								
								
								
								
								$j("#" + k_id + "_comment").slideDown('fast').show();
								
								lastid="#" + k_id + "_comment"
						  
					
  
						  }
					}  

	});
	
	
	
	}
		 
	
	
	
	
	
	
});




 
function textCounter(field, count) {
  count.value = field.value.length;
	if (count.value >= 401) {
		document.getElementById('charCountError').innerHTML = "<br/><font color='red'>Вы достигли предела в 400 символов</font>";
	}
	else {
		document.getElementById('charCountError').innerHTML = "";
	}
}
// End -->
function komdiv(){
select=document.getElementById('cat');
cat=select.options[select.selectedIndex].value;
if ((cat==1)||(cat==3)) {
//$('#komdiv').removeClass('hide');
document.getElementById('komdiv').style.display = "block";
}
else{
//$('#komdiv').addClass('hide');
 document.getElementById('komdiv').style.display = "none";
}
//
//document.getElementById('komdiv').style.display = "none";
}
function komdiv2(){
select=document.getElementById('cat');
cat=select.options[select.selectedIndex].value;
if (cat==1) {
document.getElementById('komdiv').slideDown('fast').show();
}
else{
document.getElementById('komdiv').slideUp('slow');
}
}
 

