

 <script>
singlepoint=1; 
map_address='<?=$address;?>'; 
map_longitude='<?=$longitude;?>'; 
map_latitude='<?=$latitude;?>';
 
 </script>
 
 <style>
 #map_block  {
 border:1px dotted grey; margin-top:12px;
 }
  #map_block  h3{
 padding-left:12px;
 uborder-bottom:1px dotted #3c92d1;
 color: #3c92d1;
 }
 </style>
 
<div id='map_block'>
<h3 class="head">На карте</h3>
<div>
<?=$mapcode;?>
</div>
</div>

<script>
$("#map_block > div").hide();
 $("#map_block > h3").click(function() {
   var tru = $(this).hasClass("head active");
   $("#map_block h3").removeClass("active"); 
   if (tru == false) {
     $(this).addClass("active");
   }
   var nextDiv = $(this).next();
   var visibleSiblings = nextDiv.siblings("div:visible");
   if (visibleSiblings.length) {
     visibleSiblings.slideUp("fast", function() {
       nextDiv.slideToggle("fast");
     });
   } else {
     nextDiv.slideToggle("fast");
  }
  
   ShowMap(0,0,1);
 });

</script>