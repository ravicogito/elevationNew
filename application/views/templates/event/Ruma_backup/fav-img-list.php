<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.fancybox.css"> -->
<!-- <script type="text/javascript" src="<?=base_url()?>assets/js/html2canvas.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.plugin.html2canvas.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <script src="<?=base_url()?>assets/js/jquery.fancybox.js"></script> -->
<script src="<?=base_url()?>assets/js/custom-frame.js"></script>
<!--**********sreela(05/04/18)*********-->
<script src="<?=base_url()?>assets/js/jquery.carouFredSel-6.0.4-packed.js" type="text/javascript"></script>
<!--**********end*********-->
<script type="text/javascript">
  $( function() {

	
	$( "#datepicker1" ).datepicker({ dateFormat: 'dd/mm/yy',
	   changeMonth: true,
	   changeYear: true,
	 onSelect: function (dateStr) {
	if($("#cat_id").val()=='17||River Rafting'){ 
		var optionName      = $("#cat_id").val();
		var optionArr       = optionName.split("||");
		var optionID        = optionArr[0];
		var optionCatName   = optionArr[1];
		var selectedDate    = $(this).val();
		$.ajax({
			url: _basePath+"category/populatecompany/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'cat_id': 17,
                    'date': selectedDate 					
				   },
			success: function(responce) {
						
				if(responce['process'] == 'success') {
					//$("#event_time").slideDown('slow');
					//$("#event_time").find("option:not(:first)").remove();
					$("#rafting_company").slideDown('slow');
					$("#rafting_company").find("option:not(:first)").remove();
					
					//var size = Object.keys(responce['timeslots']).length;
					//var i;
					//for(i=0; i<size+1; i++){
						//if(responce.timeslots[i]!='' && responce.timeslots[i]!=undefined){
								//$("#event_time").append("<option //value='"+responce['timeslots'][i].event_time+"'>"+responce['ti//meslots'][i].event_time+"</option>");
								
								
						//}
						
					//}
					var size = Object.keys(responce['companys']).length;
					var i;
					for(i=0; i<size+1; i++){
						if(responce.companys[i]!='' && responce.companys[i]!=undefined){
								$("#rafting_company").append("<option value='"+responce['companys'][i].raftingcompany_id+"'>"+responce['companys'][i].raftingcompany_name+"</option>");
								
								
						}
						
					}
					
          
						
				} else if(responce['process'] == 'fail') {
					$("#event_time").hide(); 
			        $("#rafting_company").hide();
					//alert("Unable to create event. Please try again.");
					return false;
				} 							
			}
		});
		}else{
			$("#event_time").hide(); 
			$("#rafting_company").hide();
		}
					
		  
		}	 
	});
	
  });
  
  	
	
  
  
  $(document).ready(function() {
	  
	  $("#rafting_company").unbind().bind("change", function() {
	  var company_id = $("#rafting_company").val();
	  var event_date = $("#datepicker1").val();

	  
	  	$.ajax({
			url: _basePath+"category/populatetime/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'company_id': company_id,
					'event_date': event_date				
				   },
			success: function(responce) {
						
				if(responce['process'] == 'success') {
				               
					$("#event_time").slideDown('slow');
					$("#event_time").find("option:not(:first)").remove();
					var size = Object.keys(responce['timeslots']).length;
					var i;
					for(i=0; i<size+1; i++){
						if(responce.timeslots[i]!='' && responce.timeslots[i]!=undefined){
								$("#event_time").append("<option value='"+responce['timeslots'][i].event_time+"'>"+responce['timeslots'][i].event_time+"</option>");
								
								
						}
						
					}

						
				} else if(responce['process'] == 'fail') {
			        $("#event_time").hide();
					return false;
				} 							
			}
		});
      
    })
    /*$("#cat_id").unbind().bind("change", function() {
      var optionName      = $("#cat_id option:selected").text();
      var optionArr       = $(this).val().split("||");
      var optionID        = optionArr[0];
      var optionName      = optionArr[1];
      //if(optionName == 'River Rafting') {
      if(optionID == '17') {
        $("#event_time").show('slow');
      }
    })*/
    //$( "#draggable" ).draggable();
    
    /*$(".imgDetails").fancybox({
                              'width':605,
                              'height':680,
                              'autoSize':false, 
                              'scrolling':'no', 
                              'autoScale':false,  
                              afterLoad: function () {      
                                //$(".fancybox-overlay").addClass("plpbox");
                              }
                            });*/

    $('form').submit(function(){
		//$(this).children('input[type=submit]').prop('disabled', true);
		$('#btncart').attr("disabled", true);
	}); 
	
	$(".remove_favourite").unbind().bind("click", function(){
		//alert('Test');
		var get_media_id = $(this).attr('id');
		var get_event_id = $("#event_id_"+get_media_id).val();
		//alert(get_event_id);
		
		var result = confirm("Are you sure to remove Favourite?");
		if (result) {
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>Category/addFavourite",
				dataType: "json",
				data:
				{
					media_id:get_media_id,
					get_event_id:get_event_id,
				},
				success:function(response)
				{
					//$("#cartSec").html(responce['HTML']);
					//alert(response.process);
					if(response.get_favourite == 'remove_favourite_true') {
						location.reload();
					}
				},
				
			});
		}
		

	});
  });
</script>  
<!--<script>
$(document).ready(function(){
    $(".full_frm").css("background-image","url('http://192.168.2.160/elevation_new/assets/images/frame1.png')");
});
</script>-->
<style type="text/css">
  .imgDisplay {
    /*width: 19.4%;*/
	width: 238px !important;
    height: 200px !important;
    float: left;
    margin: 3px;
    border: 1px solid #D1DCE1;
    padding: 3px;
  }
  .option{
    cursor: pointer;
  }
  /*#draggable { width: 150px; height: 150px; padding: 0.5em; z-index: 2; border: 5px solid red; position: absolute; left: 0; top: 5;}*/
</style>
<!-- <div id="draggable" class=""></div> -->

<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<div class="row">

<div class="col-md-12 full imgtop bdrsdo clearfix" style="height: auto;">

<div class="event_searchsec">
<h3>Search Event Here..</h3>
<form action="<?=$frmaction?>" method="post">
<select name="cat_id" id="cat_id">
  <option value="">Select Category</option>
  <?php foreach ($all_category as $category) {?>
    <option value="<?=$category['id'].'||'.$category['cat_name'];?>" <?=($category['id'] == $cat_id)?"selected":""?>><?=$category['cat_name']; ?></option>
  <?php }?>
</select>
<input name="event_date" type="text" placeholder="Select Date" id="datepicker1" value="<?=$event_date?>" />
<select name="rafting_company" id="rafting_company" style="display: <?php if($event_time!="0" && $categoryID=='17'){?>block<?php } else{?>none<?php }?>;">
  <option value="">Select Company</option>
  <?php if(!empty($companys)){ ?>
  <?php foreach($companys as $company){?>
  <option value="<?=$company['raftingcompany_id'];?>" <?=($company['raftingcompany_id'] == $company_id)?"selected":""?>><?=$company['raftingcompany_name']; ?></option>
  <?php }}?>
</select>
<select name="event_time" id="event_time" style="display: <?php if($event_time!="0" && $categoryID=='17'){?>block<?php } else{?>none<?php }?>;">
  <option value="">Select Time</option>
  <?php if(!empty($times)){ ?>
  <?php foreach($times as $time){?>
  <option value="<?=$time['event_time'];?>" <?=($time['event_time'] == $event_time)?"selected":""?>><?=$time['event_time']; ?></option>
  <?php }}?>
</select>

<!--<select name="guide_name" id="guide_name" style="display: <?=(!empty($event_time))?"block":"none";?>;">
  <option value="">Select Guide</option>
   <?php if(!empty($guides)){ ?>
   <?php foreach($guides as $guide){?>
   <option value="<?=$guide['guide_id'];?>" <?=($guide['guide_id'] == $guide_id)?"selected":""?>><?=$guide['guide_name']; ?></option>
  <?php }}?>
  
</select>-->
<input name="btnsearch" id="btnsearch" type="submit" value="Search"  />
</form>
</div>
<?php if($all_img_list):?>
<br />
</div>
<br class="clear" />

<div class="bdrsdo fav_slider">
<h3>Favourite Photos</h3>
 <?php if($all_img_list)://echo"<pre>"; print_r($all_img_list);die;?>
    <div id="country_table">
    <?php $i = 0;
      foreach($all_img_list as $img) {
        
        $img_path         = $fullPath[$img['event_id']];
        $imagePath        = base_url().'uploads/'.$img_path.$img['file_name'];
		if($i < 1) {          
          $f_img_path     = $fullPath[$img['event_id']];
          $firstImgPath   = base_url().'uploads/'.$img_path.$img['file_name']; 
        }
        
    ?>
      <div id="thumbs" class="nailthumb-container imgDisplay">
        <!-- <a class="imgDetails fancybox.ajax" href="<?=base_url();?>Category/details/<?=$img['media_id']?>"><img src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative;"></a> -->
        <a class="imgDetails" href="<?=base_url();?>Category/details/<?=$img['media_id']?>" rel="<?=$img['media_price']."|".$img['event_id']."|".$img['media_id']?>"><img style="height: 89%;" src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative;"></a>
		
		<a style="text-align:center;" id="<?php echo $img['media_id']; ?>" class="remove_favourite" href="javascript:void(0);"><img style="height: 18px; margin-top:3px;width:18px;" src="<?php echo base_url(); ?>assets/images/delete_butt.png"></a>
		<!--<img id='my_image' class="fbshare" src='<?php echo base_url(); ?>assets/images/delete_butt.png' style="height: 18px; margin-top:3px;width:18px;"/>-->
		<input type="hidden" name="event_id" id="event_id_<?php echo $img['media_id']; ?>" value="<?=$img['event_id']?>">
		
      </div>
	  
    <?php } ?>	
  </div>
  <!--**********sreela(05/04/18)*********-->
	<span id="prev"><img src="<?=base_url()?>assets/images/prev_arrow.png" id=""></span>
	<span id="next"><img src="<?=base_url()?>assets/images/next_arrow.png" id=""></span>
	<!--**********end*********-->
  <?php else: ?>
    <h2> You Don't have any favourite image </h2>
  <?php endif; ?>

</div>
<br style="clear: both;">

  <div class="frame">
  <div class="choose_frame"><h2>Choose Your Options</h2>
    <ul class="frame_selection">
      <?php if($option_list) {
              foreach ($option_list as $optionKey => $option) {                
      ?>
      <li>
      <img src="<?=base_url()?>assets/images/<?=strtolower(str_replace(" ", "_", $option['option_name']))?>.png" id="">
      <span class="option" id="<?=$option['option_id']?>"><?=$option['option_name']?></span>
      </li>
      <?php }}?>
      <li>
      <img src="<?=base_url()?>assets/images/<?=strtolower(str_replace(" ", "_", $option['option_name']))?>.png" id="">
      <span class="option" id="collage">Collage</span>
      </li>
    </ul></div>

    <div class="wraper_pan">
      <div class="leftpanel fix_we" id="canvasFrame">
        <div class="full_frm_canvas" id="outerDiv">
<!-- <div class="">
<div class=""> -->
 <img src="<?=thumb($firstImgPath, $f_img_path, '400', '400')?>" style="max-width:100%; position: relative;" id="disImage">
<!-- </div>
</div> -->
</div>
      </div>
      <div class="rightpanel">
        <div class="choose_size">
        <label><?=$option_size_text;?> Size:</label>
       <div class="listdiv"><?=$option_size[0]['size']?>
       <ul id="p2a_mto_ulsizeoptions" class="p2a_mto_ulsizeoptions" style="display: none;">
          <?php foreach($option_size as $sizeKey => $sizeVal){ ?>
          <li class="lisizeoptions" sizeid="<?php echo $sizeVal['size']; ?>" rel="<?=$sizeVal['price']?>"><?php echo $sizeVal['size']; ?></li>
          <?php } ?>   
        </ul>
        </div>
        </div>
        <br class="clear" />
        <div class="price">
          <input type="hidden" name="txtimgprice" id="imgPrice" value="<?=$img_price?>">
          <input type="hidden" name="txteventid" id="eventID" value="<?=$event_id?>">
          <input type="hidden" name="txtmediaid" id="mediaID" value="<?=$media_id?>">
          <input type="hidden" name="txtsizeprice" id="sizePrice" value="<?=$size_price?>">
          <input type="hidden" name="txtframeprice" id="framePrice" value="">
          <input type="hidden" name="txttopmatprice" id="topMatPrice" value="">
          <input type="hidden" name="txtmiddlematprice" id="middleMatPrice" value="">
          <input type="hidden" name="txtbottommatprice" id="bottomMatPrice" value="">
          <br class="clear" />
          <label>Your Price : </label><span class="totalPrice">$<?=$total_price;?></span>
          <p><form name="frmcanvas" id="frmcanvas" action="<?=base_url()?>Favourite/cart/" method="post">
            <input type="hidden" name="img_val" id="img_val" value="">
<input type="submit" name="btncart" id="btncart" value="Add To Cart" class="createCanvas">
          </form>
            </p>
        </div>
        <div class="about_product">
          <h2>About <?=$option_name;?></h2>
          <img src="<?=base_url()?>uploads/optionImg/<?=$option_image?>" id="">
          <p><?=nl2br($option_description);?></p>
        </div>
      </div>      
    </div>
    <br class="clear" />
<br />
  </div>

<?php endif; ?>

</div>
</div>
</div>

</div>
<div style="clear: both;"></div>
<div id="img-out"></div>

<script>
     function fbs_click(TheImg) {alert("here");
	 alert("hi - "+$(this).parent('div').attr('id'));
     
	}
	$(document).ready(function() {
		$(".fbshare").unbind().bind("click", function() {
			var TheImg 	= $(this).parent('div').children('a:eq(0)').children('img');
			
			u			= TheImg.attr('src');
			//alert("hi - "+u);
			 // t=document.title;
			t			= TheImg.attr('alt');
			window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;
		})
		
	})
</script>
<script type="text/javascript">
  function load_image(page) {
      var eventID         = $("#event_id").val();
      $(".ajax_overlay").show();
      $.ajax({
        url:"<?php echo base_url(); ?>Category/pagination/"+eventID+"/"+page,
        method:"GET",
        dataType:"json",
        success:function(data)
        {
          $(".ajax_overlay").hide();
          $('#country_table').html(data['HTML']);
          $('#pagination_link').html(data.pagination_link);
        }
      });  }

  $(document).on("click", ".pagination li a", function(event){
      event.preventDefault();
      var page = $(this).data("ci-pagination-page");
      if ($.isNumeric(page)) {
        load_image(page); 
      } else {
        return false;
      }
      
    });
	<!--**********sreela(05/04/18)*********-->
	$(function() {

	$('#country_table').carouFredSel({
					responsive: true,
					circular: true,
					infinite: false,
					auto: false,
					prev: '#prev',
					next: '#next',
					items: {
						visible: {
							min: 2,
							max: 5
						},
						width: 150,
						height: '66%'
					}
				});
});
<!--**********end*********-->
</script>

        
