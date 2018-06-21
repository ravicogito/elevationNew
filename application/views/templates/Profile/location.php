<div class="banner">
<div class="wrap">
<div class="txtprt">
<h2><span><em style="color:#e00b69; font-style:normal;">I’m</em> here </span> to make your ski </h2>
<p>make a memorable ski ...</p>
</div>
<div class="clearfix"></div>
<div class="tabwrap">  
  </div>
  <div class="clearfix"></div>
</div>
</div>
<div class="contwrap">
<div class="container-fluid">
<div class="wrap skievnt">
<div class="row">
<!------------------- Location -------------------->
<div id="default_div">
<?php if(!empty($location)) {
		foreach($location as $loc_list){
?>
<div class="boxsec col-md-12" >
	<div class="bdrsdo">	
	<div class="boxlft col-md-8 col-sm-8" style="background-image:url(<?php echo base_url();?>uploads/locations/<?php echo $loc_list['location_image'] ?>); background-repeat: no-repeat;"><img src="<?php echo base_url(); ?>assets/images/boxban.png" />
		<div class="bxtxt col-md-6 col-sm-6 col-xs-6"><?php echo $loc_list['location_name']; ?> <span><?php echo $loc_list['event_name']; ?></span><a href="<?php echo base_url();?>CustomerPhotos/customerEventPhotoList/<?php echo $loc_list['location_id']; ?>/5"><div class="bxbtn">See your <strong>Event</strong> Section</div></a></div>	
	</div>	
	<div class="boxrgt col-md-4 col-sm-4">
	<?php  //print_r($latlong); 
	if(!empty($weather_info)){ ?>
	<a href="javascript:void(0)" class="col-md-6 hovv col-sm-6"><span class="icon"><?php if($weather_info[$loc_list['location_id']] != 'NA'){ echo number_format($weather_info[$loc_list['location_id']], 1) ; ?> <sup>0</sup>C <?php } else { echo $weather_info[$loc_list['location_id']] ; }?></span><span class="atit">Today's</span> <span class="atit sml">weather report</span></a> <?php } ?>

	<a href="<?php echo base_url();?>home/photographereDetails/<?php echo $loc_list['location_id']; ?>" class="col-md-6 hovv col-sm-6 phtographer_data" id="phtographer"><span class="icon"></span><span class="atit">Contact</span> <span class="atit sml">with photographer</span></a>
	
	<!--<a href="#location_opn_map_<?php //echo $loc_list['location_id']; ?>"  rel="prettyPhoto" class="col-md-6 hovv col-sm-6 inline" id="location_map_<?php //echo $loc_list['location_id']; ?>"><span class="icon"></span><span class="atit">track</span> <span class="atit sml">your location</span></a>-->
	<a href="#location_opn_map_<?php echo $loc_list['location_id']; ?>"  rel="prettyPhoto"   class="col-md-6 hovv col-sm-6" id="location_map_<?php echo $loc_list['location_id']; ?>"><span class="icon"></span><span class="atit">track</span> <span class="atit sml">your location</span></a> 
	<a href="" class="col-md-6 hovv col-sm-6"><span class="icon"></span><span class="atit">share</span> <span class="atit sml">this event</span></a> 
	</div>
	
		<!------------------- Map -------------------->
	<div class="logform poplogfrm" id="location_opn_map_<?php echo $loc_list['location_id']; ?>">
	<?php //print_r($latlong);
	echo $latitude."<br/>";
echo $longitude;	?>

 <div id="map" style="width:500px;height:300px;"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 2,
          center: new google.maps.LatLng(2.8,-187.3),
          mapTypeId: 'terrain'
        });

        // Create a <script> tag and set the USGS URL as the source.
        var script = document.createElement('script');
        // This example uses a local copy of the GeoJSON stored at
        // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
        script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';
        document.getElementsByTagName('head')[0].appendChild(script);
      }

      // Loop through the results array and place a marker for each
      // set of coordinates.
      window.eqfeed_callback = function(results) {
        for (var i = 0; i < results.features.length; i++) {
          var coords = results.features[i].geometry.coordinates;
          var latLng = new google.maps.LatLng(coords[1],coords[0]);
          var marker = new google.maps.Marker({
            position: latLng,
            map: map
          });
        }
      }
    </script>



   
    
	
	</div>
	<!--<div class="overlay"></div>-->
	<!------------------- End Map -------------------->
	
	
	
	
	
</div>
</div>
<?php } }?>
</div>
</div>
</div>
</div>
</div>