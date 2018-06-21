<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.fancybox.css">
<script type="text/javascript" src="<?=base_url()?>assets/js/html2canvas.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.plugin.html2canvas.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url()?>assets/js/jquery.fancybox.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
        $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
   
    $(".imgDetails").fancybox({
                              'width':605,
                              'height':680,
                              'autoSize':false, 
                              'scrolling':'no', 
                              'autoScale':false,  
                              afterLoad: function () {      
                                //$(".fancybox-overlay").addClass("plpbox");
                              }
                            });
    $(".cap").on("click", function(event) {
      event.preventDefault();
      /*var c = document.getElementById('sortable');
      var t = c.getContext();
      window.open('', c.toDataURL());*/
      $('#sortable').html2canvas({
          onrendered: function (canvas) {               
              //Set hidden field's value to image data (base-64 string)
              theCanvas = canvas;
                document.body.appendChild(canvas);

                // Convert and download as image 
                Canvas2Image.saveAsPNG(canvas); 
                $("#img-out").append(canvas);
              //alert(canvas.toDataURL("image/png"));
              $('#img_val').val(canvas.toDataURL("image/png"));
              //Submit the form manually
              
          }
      });
    })
    
  })
</script>  
<style type="text/css">
 .full_frame{width: 400px; border: 10px solid red; height: 400px; margin: 0 auto;}
 .flame_pan{width: 33.3%;
  border: 4px solid black;
  float: left;
  height: 380px;
}
#sortable div { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 30%; height: 70%; font-size: 4em; text-align: center; cursor: move; }
</style>
<!-- <div id="draggable" class=""></div> -->

<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<div class="row">

<div class="col-md-12 full imgtop bdrsdo clearfix" style="height: auto;">

<div class="event_searchsec">
<h3>Search Event Here..</h3>

</div>
    <div id="country_table">
   
  </div>
</div>

</div>
</div>
</div><input type="hidden" name="img_val" id="img_val" value="" />
<div class="full_frame" id="sortable"">
  <div class="flame_pan ui-state-default"><img src="http://192.168.2.160/elevation_new/./uploads/Kid/2018-03-11/Photographer2/Test Event/0d26078b68019f3b1f12d73a0134eb0c-400_400.jpg"></div>
  <div class="flame_pan ui-state-default"><img src="http://192.168.2.160/elevation_new/./uploads/Kid/2018-03-11/Photographer2/Test Event/2c5b75a178e58b1eae9e969133d830b8-400_400.jpg"></div>
  <div class="flame_pan ui-state-default"><img src="http://192.168.2.160/elevation_new/./uploads/Kid/2018-03-11/Photographer2/Test Event/e598cc5b5f7e74325db116397feab30e-400_400.jpg"></div>
</div>
<br style="clear: both;">
<div><a href="#" class="cap">Capture</a></div>
</div>
<div id="img-out"></div>