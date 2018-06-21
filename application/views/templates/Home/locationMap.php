<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 50%;
      }
      /* Optional: Makes the sample page fill the window. */
      /*html, body {
        height: 50%;
        margin: 0;
        padding: 0;
      }*/
    </style>
<?php if(!empty($latitude) && !empty($longitude)) { ?> 
<div class="authorshot bdrsdo " style="background-color: #fff;">


<div class="col-md-12">

<div id="map"></div>
    <script>

      // This example displays a marker at the center of Australia.
      // When the user clicks the marker, an info window opens.

      function initMap() {
        var uluru = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: uluru
        });

        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading"><?php echo $location; ?></h1>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

        var marker = new google.maps.Marker({
          position: uluru,
          map: map,
          title: 'Uluru (Ayers Rock)'
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJMZhj1LOlXpPsapzj3recS4C1x4aKK6U&callback=initMap">
    </script>

<h5><?php echo htmlentities($location); ?><i></h5>

<div align="right" > <a href="<?php echo base_url(); ?>" class="pinkbtn">GO HOME </a> </div>


</div>

</div>
<?php }  ?>

</div>



</div>

</div>


