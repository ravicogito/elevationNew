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
<!--**********sudhansu(23/05/18)*********-->
<script src="<?=base_url()?>assets/js/digital-package.js" type="text/javascript"></script>
<!--**********end*********-->
<script type="text/javascript">
var eventIDArr			  = new Array();
var mediaIDArr			  = new Array();
var mediaNameArr		  = new Array();
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
	
	
	$(".checkboxClass").on("click", function(event) {
    	//event.preventDefault();    	
      	var imgAttArr             = $(this).val().split('|');		
      	var imgPrice              = imgAttArr[0];
      	var eventID               = imgAttArr[1];
      	var mediaID               = imgAttArr[2];
		var mediaName             = imgAttArr[3];
		
		
		
		if($(this).prop('checked') == true) {
			
			if(eventIDArr.length === 0) {
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>Favourite/countfavImgByEvent",
				dataType: "json",
				data:
				{
					eventID:eventID,
				},
				success:function(response)
				{
				 if(response.process=='success'){
					$('#event_photo_no').html(response.event_photo_no);
					//Code by Sudhansu//	
					$('.totalevntimg').val(response.total_event_photo);
					//Code by Sudhansu//	
					$('.total_photo').val(response.event_photo_no);
				 }	
                 else{
				   alert('Event not Found.'); 	 
				 }
				},
				
			});
			
			
			
		  }
		
		
		
			if(eventIDArr.length === 0) {
				eventIDArr.push(eventID);
				mediaIDArr.push(mediaID);
				mediaNameArr.push(mediaName);
				$('#photo_no').html(mediaIDArr.length);
				
			} else {
				var arrval = $.inArray(eventID, eventIDArr);
				if(arrval !== -1) {	
					mediaIDArr.push(mediaID);
					mediaNameArr.push(mediaName);
				} else {
					alert("You can't select different boat image.");
					$(this).prop('checked', false);
				}
			 
				$('#photo_no').html(mediaIDArr.length);	
					
				
			}		
		} else {
			var indexOfArr	= $.inArray(mediaID, mediaIDArr);				

			if($.inArray(mediaID, mediaIDArr) !== -1 ) {
				mediaIDArr.splice(indexOfArr, 1);
				$('#photo_no').html(mediaIDArr.length);
				
			}
			if(mediaIDArr.length === 0) {
				eventIDArr.length 			= 0;
				$('#event_photo_no').html('');
				$('#photo_no').html('');					
			}
		}
        
		//alert("hello - "+eventIDArr);
		//alert("hi - "+mediaIDArr);	
		//alert("hi - "+mediaNameArr);
        var mediaName  = mediaNameArr.join('~');	
		var mediaId    = mediaIDArr.join('-');		
		$('.image_name').val(mediaName);
		$('.image_id').val(mediaId);	
		$('.event_id').val(eventID);
		$('.selected_photo').val(mediaIDArr.length);		
			
		
 		
	});

    $(".make_it").on("click", function(event) {	
	if($('.checkboxClass').is(":checked")) {
	var button_id = $(this).attr('id');
	var form_id = $(this).closest("form").attr('id');
	
	if((form_id === 'form_series' || form_id === 'form_package') && mediaIDArr.length < 3){
		alert('Please select 5 images only.');
	}
    else{	
	var html = $('#'+form_id).serialize();
	$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>Favourite_s/cartNew",
				dataType: "json",
				data:
				{
					formdata:html,
				},
				success:function(response)
				{
				 //alert(response.process);	
				  window.location.href = "<?php echo base_url(); ?>CartAdd_s";
				 
				},
				
			});
		}
				
	 }	
     else{
		 alert('Please select any image.');
	 }
     	 
	});	

    //################SUDHANSU-23-05-2018##########################//
	$(".make_itdg").on("click", function(event) {	
	if($('.checkboxClass').is(":checked")) {
	var button_id = $(this).attr('id');
	var form_id = $(this).closest("form").attr('id');
	
	if((form_id === 'formdigital_series' || form_id === 'formdigital_package') && mediaIDArr.length != 5){
		alert('Please select 5 images only.');
	}
    else{
	var html = $('#'+form_id).serialize();
	$.ajax({
				type:"POST",
				//url:"<?php //echo base_url(); ?>Favourite_s/cartNewDigital",
				url:"<?php echo base_url(); ?>Favourite_s/cartNewDigital",
				dataType: "json",
				data:
				{
					formdata:html,
				},
				success:function(response)
				{
				 //alert(response.process);	
				 //window.location.href = "<?php //echo base_url(); ?>CartAdd_s";
				 window.location.href = "<?php echo base_url(); ?>Favourite_s/allImagesFrame";
				 
				},
				
			});
		}
				
	 }else{
		 alert('Please select any image.');
	 }
     	 
	});

	//################SUDHANSU-23-05-2018##########################//
	
  });

function digitalProcsNext(){
	    var image_name        = $('.image_name').val();
	    var image_id          = $('.image_id').val();
	    var event_id          = $('.event_id').val();
	    var selected_photo    = $('.selected_photo').val();
	    var total_photo       = $('.total_photo').val();
	    var dgimg_price       = $('.dgimg_price').val();
		//alert(image_name);alert(image_id);alert(event_id);alert(selected_photo);alert(total_photo);alert(dgimg_price);
		$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>Favourite_s/cartNewDigital",
				dataType: "json",
				data:  { 
					'image_name': image_name,
					'image_id': image_id,
					'event_id': event_id,
					'selected_photo': selected_photo,
					'total_photo': total_photo,
					'dgimg_price': dgimg_price,
                    'dgtaltype': 'processnext' 					
				   },
				success:function(response)
				{
				   //alert(response);	
				  //alert(response.process);	
				  window.location.href = "<?php echo base_url(); ?>CartAdd_s";
				 
				},
				
			});
	}
</script>  
<!--<script>
$(document).ready(function(){
    $(".full_frm").css("background-image","url('http://192.168.2.160/elevation_new/assets/images/frame1.png')");
});
</script>-->

<script>
function openapackage(evt, packageName) {
	//alert(evt+'SSS'+packageName);
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace("active", "");
    }
    document.getElementById(packageName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>


<style type="text/css">
  .imgDisplay {
    /*width: 19.4%;*/
	width: 238px !important;
    height: 200px !important;
    float: left;
    margin: 3px;
    border: 1px solid #D1DCE1;
    padding: 3px;
	position:relative;
  }
  .option{
    cursor: pointer;
  }
  /*#draggable { width: 150px; height: 150px; padding: 0.5em; z-index: 2; border: 5px solid red; position: absolute; left: 0; top: 5;}*/
  
  /* Style the tab */
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>


<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<div class="row">

<div class="col-md-12 full clearfix" style="height: auto;">

<div class="event_searchsec">
<h3>Search Event Here..</h3>
<form action="<?=$frmaction?>" method="post" class="border_botm">
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
</div>
<br class="clear" />

<div class="bdrsdo fav_slider">
<h3>Favourite Photos</h3>
<!--<div class="search_detailstxt">
<h4>River Rafting </h4>
<span class="date">29th Sept 2017 </span>
<span class="location">JHW</span>
<span class="time">12.30pm</span>
</div>-->
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
        <a class="imgDetails" href="<?=base_url();?>Category/details/<?=$img['media_id']?>" rel="<?=$img['media_price']."|".$img['event_id']."|".$img['media_id']?>"><img src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative; height: 100%;"></a>
		<a style="text-align:center;" id="<?php echo $img['media_id']; ?>" class="remove_favourite" href="javascript:void(0);"><img style="height: 18px; margin-top:3px;width:18px;" src="<?php echo base_url(); ?>assets/images/delete_butt.png"></a>
        <input type="checkbox" name="checked" id="checked<?php echo $img['media_id']; ?>" class="checkboxClass" value="<?=$img['media_price']."|".$img['event_id']."|".$img['media_id']."|".$img['file_name']?>">
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
<div class="total_photosec">
<p>Total Photo of the event: <strong id="event_photo_no">0</strong></p>
<p>You have selected: <strong id="photo_no">0</strong></p>
<input type="hidden1" name="totalevntimg" class="totalevntimg" value="">
</div>
</div>
<br style="clear: both;">



<div class="tab_section">
<div class="tab">
  <button class="tablinks active" onclick="openapackage(event, 'Print')">Print and Print Packages</button>
  <button class="tablinks" onclick="openapackage(event, 'Digital')">Digital Packages</button>
</div>

<div id="Print" class="tabcontent" style="display:block;">
<form id="form_5x7" class="print_smbox">
  <h3>5x7</h3>
  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
  <div class="print_onlytext"><p>5x7 print only</p></div>
  <input type="hidden" value="30" name="size_price" />
  <input type="hidden" value="5x7" name="size" />
  <input type="hidden" value="" name="image_name" class="image_name" />
  <input type="hidden" value="" name="image_id" class="image_id" />
  <input type="hidden" value="" name="event_id" class="event_id" />
  <input type="hidden" value="If  the customer orders more than one or adds to any other print or print package the price becomes $20 each" name="msg"/>
  <input type="hidden" value="" name="selected_photo" class="selected_photo" />
  <input type="hidden" value="" name="total_photo" class="total_photo" />
  <p class="price">$30</p>
  <div class="condition_note">
  <a href="">Condition</a>
  <span>If  the customer orders more than one or adds to any other print or print package the price becomes $20 each</span>
  </div>
  <input type="button" value="Make It" name="make_it" class="make_it" id="make_it_5x7" />
  </form>
  <form id="form_8x10" class="print_smbox">
  <h3>8x10</h3>
  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
  <div class="print_onlytext"><p>8x10 print only</p></div>
   <input type="hidden" value="35" name="size_price" />
   <input type="hidden" value="8x10" name="size" />
   <input type="hidden" value="" name="image_name" class="image_name" />
   <input type="hidden" value="" name="image_id" class="image_id" />
   <input type="hidden" value="" name="event_id" class="event_id" />
   <input type="hidden" value="If  the customer orders more than one or adds to any other print or print package the price becomes $25 each" name="msg"/>
   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
   <input type="hidden" value="" name="total_photo" class="total_photo" />
   <p class="price">$35</p>
   <div class="condition_note">
   <a href="">Condition</a>
   <span>If  the customer orders more than one or adds to any other print or print package the price becomes $25 each</span>
   </div>
  <input type="button" value="Make It" name="make_it" class="make_it" id="make_it_8x10" />
  </form>
  <form id="form_11x14" class="print_smbox">
  <h3>11x14</h3>
  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
  <div class="print_onlytext"><p>1 print</p></div>
   <input type="hidden" value="45" name="size_price" />
   <input type="hidden" value="11x14" name="size" />
   <input type="hidden" value="" name="image_name" class="image_name" />
   <input type="hidden" value="" name="image_id" class="image_id" />
   <input type="hidden" value="" name="event_id" class="event_id" />
   <input type="hidden" value="" name="msg"/>
   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
   <input type="hidden" value="" name="total_photo" class="total_photo" />
   <p class="price">$45</p>
   <div></div>
  <input type="button" value="Make It" name="make_it" class="make_it" id="make_it_11x14" />
  </form>
  <form id="form_16x20" class="print_smbox">
  <h3>16x20</h3>
  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
  <div class="print_onlytext"><p>1 print</p></div>
   <input type="hidden" value="70" name="size_price" />
   <input type="hidden" value="16x20" name="size" />
   <input type="hidden" value="" name="image_name" class="image_name" />
   <input type="hidden" value="" name="image_id" class="image_id" />
   <input type="hidden" value="" name="event_id" class="event_id" />
   <input type="hidden" value="" name="msg"/>
   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
   <input type="hidden" value="" name="total_photo" class="total_photo" />
   <p class="price">$70</p>
   <div></div>
  <input type="button" value="Make It" name="make_it" class="make_it" id="make_it_16x20" />
  </form>
  
  <form id="form_20x24" class="print_smbox">
  <h3>20x24</h3>
  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
  <div class="print_onlytext"><p>1 print</p></div>
   <input type="hidden" value="90" name="size_price" />
   <input type="hidden" value="20x24" name="size" />
   <input type="hidden" value="" name="image_name" class="image_name" />
   <input type="hidden" value="" name="image_id" class="image_id" />
   <input type="hidden" value="" name="event_id" class="event_id" />
   <input type="hidden" value="" name="msg"/>
   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
   <input type="hidden" value="" name="total_photo" class="total_photo" />
   <p class="price">$90</p>
   <div></div>
  <input type="button" value="Make It" name="make_it" class="make_it" id="make_it_20x24" />
  </form>
   <form id="form_20x30" class="print_smbox">
  <h3>20x30</h3>
  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
  <div class="print_onlytext"><p>1 print</p></div>
   <input type="hidden" value="100" name="size_price" />
   <input type="hidden" value="20x30" name="size" />
   <input type="hidden" value="" name="image_name" class="image_name" />
   <input type="hidden" value="" name="image_id" class="image_id" />
   <input type="hidden" value="" name="event_id" class="event_id" />
   <input type="hidden" value="" name="msg"/>
   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
   <input type="hidden" value="" name="total_photo" class="total_photo" />
   <p class="price">$100</p>
   <div></div>
  <input type="button" value="Make It" name="make_it" class="make_it" id="make_it_20x30" />
  </form>
  <form id="form_series" class="print_smbox">
  <h3>Series</h3>
  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
  <div class="print_onlytext"><p>5 Different 4x6 Prints</p></div>
  <input type="hidden" value="30" name="size_price" />
  <input type="hidden" value="series" name="size" />
  <input type="hidden" value="" name="image_name" class="image_name" />
  <input type="hidden" value="" name="image_id" class="image_id" />
  <input type="hidden" value="" name="event_id" class="event_id" />
  <input type="hidden" value="This must be the same boat and different images! - Customer can add additional 4x6's of different images for $7/each" name="msg"/>
  <input type="hidden" value="" name="selected_photo" class="selected_photo" />
  <input type="hidden" value="" name="total_photo" class="total_photo" />
  <p class="price">$30</p>
  <div class="condition_note">
  <a href="">Condition</a>
  <span>This must be the same boat and different images! - Customer can add additional 4x6's of different images for $7/each</span>
  </div>
  <input type="button" value="Make It" name="make_it" class="make_it" id="make_it_series" />
  </form>
  
  <form id="form_package" class="print_smbox">
  <h3>Package</h3>
  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
  <div class="print_onlytext"><p>5 Different Prints, 1 8x10 and 4 4x6s</p></div>
  <input type="hidden" value="45" name="size_price" />
  <input type="hidden" value="series" name="size" />
  <input type="hidden" value="" name="image_name" class="image_name" />
  <input type="hidden" value="" name="image_id" class="image_id" />
  <input type="hidden" value="" name="event_id" class="event_id" />
  <input type="hidden" value="This must be the same boat and different images! - Customer can add additional 4x6's of different images for $7/each" name="msg"/>
  <input type="hidden" value="" name="selected_photo" class="selected_photo" />
  <input type="hidden" value="" name="total_photo" class="total_photo" />
  <p class="price">$45</p>
  <div class="condition_note">
  <a href="">Condition</a>
  <span>This must be the same boat and different images! - Customer can add additional 4x6's of different images for $7/each</span>
  </div>
  <input type="button" value="Make It" name="make_it" class="make_it" id="make_it_series" />
  </form>
  
</div>

<div id="Digital" class="tabcontent">
    <div class="digital_process" style="display: none;">
        <div class="cloise_sec">
		  <div class="cloise">
		    <h3>You have<br />Choose <span>Digital Image</span></h3>
		    <div class="alimges">
		      <h4>All Images Package <span>Download of all images for that boat</span></h4>
		       <strong>$120</strong> 
		    </div>
		  </div>
       <!--<form id="formdigital_processnext" class="print_smbox">
          <input type="hidden" name="dgimg_price" class="dgimg_price">
          <input type="hidden" value="" name="image_name" class="image_name" />
	      <input type="hidden" value="" name="image_id" class="image_id" />
	      <input type="hidden" value="" name="event_id" class="event_id" />
	      <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	      <input type="hidden" value="" name="total_photo" class="total_photo" />
		  <div class="cloise_proces">
		    <p>I don’t want to add any print package</p>
		    <a href="javascript:void(0);" onclick="digitalProcsNext();">Process to Next</a>
		  </div>
		</form>-->
		<div class="cloise_proces">
		    <p>I don’t want to add any print package</p>
		    <a href="javascript:void(0);" onclick="digitalProcsNext();">Process to Next</a>
		</div>
		<div class="clear"></div>
		</div>
		<div class="discntd">
			<h3>Discounted Print Prices
			<strong>with Digital Image Package</strong></h3>
			<div class="brdr"></div>
		</div>

 <div>
	<form id="formdigital_5x7" class="print_smbox">
	  <h3>5x7</h3>
	  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
	  <div class="print_onlytext"><p>5x7 print only</p></div>
	  <input type="hidden" value="5" name="size_price" />
	  <input type="hidden" value="5x7" name="size" />
	  <input type="hidden" value="" name="image_name" class="image_name" />
	  <input type="hidden" value="" name="image_id" class="image_id" />
	  <input type="hidden" value="" name="event_id" class="event_id" />
	  <input type="hidden" value="If  the customer orders more than one or adds to any other print or print package the price becomes $20 each" name="msg"/>
	  <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	  <input type="hidden" value="" name="total_photo" class="total_photo" />
	  <input type="hidden" name="countdg_img" class="countdg_img">
      <input type="hidden" name="dgimg_price" class="dgimg_price">
	  <p class="discnt_prc">$30</p>
	  <p class="price">$5</p>
	  
	  <input type="button" value="Make It" name="make_it" class="make_itdg" id="make_it_5x7" />
	</form>
	<form id="formdigital_8x10" class="print_smbox">
	  <h3>8x10</h3>
	  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
	  <div class="print_onlytext"><p>8x10 print only</p></div>
	   <input type="hidden" value="10" name="size_price" />
	   <input type="hidden" value="8x10" name="size" />
	   <input type="hidden" value="" name="image_name" class="image_name" />
	   <input type="hidden" value="" name="image_id" class="image_id" />
	   <input type="hidden" value="" name="event_id" class="event_id" />
	   <input type="hidden" value="If  the customer orders more than one or adds to any other print or print package the price becomes $25 each" name="msg"/>
	   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	   <input type="hidden" value="" name="total_photo" class="total_photo" />
	   <input type="hidden" name="countdg_img" class="countdg_img">
       <input type="hidden" name="dgimg_price" class="dgimg_price">
	   <p class="discnt_prc">$35</p>
	   <p class="price">$10</p>
	   
	  <input type="button" value="Make It" name="make_it" class="make_itdg" id="make_it_8x10" />
	</form>
	<form id="formdigital_11x14" class="print_smbox">
	  <h3>11x14</h3>
	  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
	  <div class="print_onlytext"><p>1 print</p></div>
	   <input type="hidden" value="14" name="size_price" />
	   <input type="hidden" value="11x14" name="size" />
	   <input type="hidden" value="" name="image_name" class="image_name" />
	   <input type="hidden" value="" name="image_id" class="image_id" />
	   <input type="hidden" value="" name="event_id" class="event_id" />
	   <input type="hidden" value="" name="msg"/>
	   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	   <input type="hidden" value="" name="total_photo" class="total_photo" />
	   <input type="hidden" name="countdg_img" class="countdg_img">
       <input type="hidden" name="dgimg_price" class="dgimg_price">
	   <p class="discnt_prc">$45</p>
	   <p class="price">$14</p>
	   <div></div>
	  <input type="button" value="Make It" name="make_it" class="make_itdg" id="make_it_11x14" />
	</form>
	<form id="formdigital_16x20" class="print_smbox">
	  <h3>16x20</h3>
	  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
	  <div class="print_onlytext"><p>1 print</p></div>
	   <input type="hidden" value="30" name="size_price" />
	   <input type="hidden" value="16x20" name="size" />
	   <input type="hidden" value="" name="image_name" class="image_name" />
	   <input type="hidden" value="" name="image_id" class="image_id" />
	   <input type="hidden" value="" name="event_id" class="event_id" />
	   <input type="hidden" value="" name="msg"/>
	   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	   <input type="hidden" value="" name="total_photo" class="total_photo" />
	   <input type="hidden" name="countdg_img" class="countdg_img">
       <input type="hidden" name="dgimg_price" class="dgimg_price">
	   <p class="discnt_prc">$70</p>
	   <p class="price">$30</p>
	   <div></div>
	  <input type="button" value="Make It" name="make_it" class="make_itdg" id="make_it_16x20" />
	</form>
	  
	<form id="formdigital_20x24" class="print_smbox">
	  <h3>20x24</h3>
	  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
	  <div class="print_onlytext"><p>1 print</p></div>
	   <input type="hidden" value="45" name="size_price" />
	   <input type="hidden" value="20x24" name="size" />
	   <input type="hidden" value="" name="image_name" class="image_name" />
	   <input type="hidden" value="" name="image_id" class="image_id" />
	   <input type="hidden" value="" name="event_id" class="event_id" />
	   <input type="hidden" value="" name="msg"/>
	   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	   <input type="hidden" value="" name="total_photo" class="total_photo" />
	   <input type="hidden" name="countdg_img" class="countdg_img">
       <input type="hidden" name="dgimg_price" class="dgimg_price">
	   <p class="discnt_prc">$90</p>
	   <p class="price">$45</p>
	   <div></div>
	  <input type="button" value="Make It" name="make_it" class="make_itdg" id="make_it_20x24" />
	</form>
	<form id="formdigital_20x30" class="print_smbox">
	  <h3>20x30</h3>
	  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
	  <div class="print_onlytext"><p>1 print</p></div>
	   <input type="hidden" value="50" name="size_price" />
	   <input type="hidden" value="20x30" name="size" />
	   <input type="hidden" value="" name="image_name" class="image_name" />
	   <input type="hidden" value="" name="image_id" class="image_id" />
	   <input type="hidden" value="" name="event_id" class="event_id" />
	   <input type="hidden" value="" name="msg"/>
	   <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	   <input type="hidden" value="" name="total_photo" class="total_photo" />
	   <input type="hidden" name="countdg_img" class="countdg_img">
       <input type="hidden" name="dgimg_price" class="dgimg_price">
	   <p class="discnt_prc">$100</p>
	   <p class="price">$50</p>
	   <div></div>
	  <input type="button" value="Make It" name="make_it" class="make_itdg" id="make_it_20x30" />
	</form>
	<form id="formdigital_series" class="print_smbox">
	  <h3>Series</h3>
	  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
	  <div class="print_onlytext"><p>5 Different 4x6 Prints</p></div>
	  <input type="hidden" value="10" name="size_price" />
	  <input type="hidden" value="series" name="size" />
	  <input type="hidden" value="" name="image_name" class="image_name" />
	  <input type="hidden" value="" name="image_id" class="image_id" />
	  <input type="hidden" value="" name="event_id" class="event_id" />
	  <input type="hidden" value="This must be the same boat and different images! - Customer can add additional 4x6's of different images for $7/each" name="msg"/>
	  <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	  <input type="hidden" value="" name="total_photo" class="total_photo" />
	  <input type="hidden" name="countdg_img" class="countdg_img">
      <input type="hidden" name="dgimg_price" class="dgimg_price">
	  <p class="discnt_prc">$35</p>
	  <p class="price">$10</p>
	  <div class="condition_note">
	  <a href="">Condition</a>
	  <span>This must be the same boat and different images! - Customer can add additional 4x6's of different images for $7/each</span>
	  </div>
	  <input type="button" value="Make It" name="make_it" class="make_itdg" id="make_it_series" />
	</form>
	<form id="formdigital_package" class="print_smbox">
	  <h3>Package</h3>
	  <img src="<?=base_url()?>assets/images/frmae_smimg.png" height="55" width="74" />
	  <div class="print_onlytext"><p>5 Different Prints, 1 8x10 and 4 4x6s</p></div>
	  <input type="hidden" value="15" name="size_price" />
	  <input type="hidden" value="package" name="size" />
	  <input type="hidden" value="" name="image_name" class="image_name" />
	  <input type="hidden" value="" name="image_id" class="image_id" />
	  <input type="hidden" value="" name="event_id" class="event_id" />
	  <input type="hidden" value="This must be the same boat and different images! - Customer can add additional 4x6's of different images for $7/each" name="msg"/>
	  <input type="hidden" value="" name="selected_photo" class="selected_photo" />
	  <input type="hidden" value="" name="total_photo" class="total_photo" />
	  <input type="hidden" name="countdg_img" class="countdg_img">
      <input type="hidden" name="dgimg_price" class="dgimg_price">
	  <p class="discnt_prc">$45</p>
	  <p class="price">$15</p>
	  <div class="condition_note">
	  <a href="">Condition</a>
	  <span>This must be the same boat and different images! - Customer can add additional 4x6's of different images for $7/each</span>
	  </div>
	  <input type="button" value="Make It" name="make_it" class="make_itdg" id="make_it_series" />
	</form>
  </div>
 </div>

	<div class="digital_allimgpackage">
		<div class="all_imagepan">
			<img src="<?=base_url()?>assets/images/choice-icon.png" align="" title="" />
			<div class="right_allimg">
			<h4>All Images</h4>
			<p>Download of all images<br />
			for that boat</p>
			<h2>$120</h2>
			</div>
			<a href="javascript:void(0);" class="get_packages" onclick="getDigitalPackage('all','120');">Get the Package</a>
			<br class="clear"/>
		</div>
		<div class="all_imagepan">
			<img src="<?=base_url()?>assets/images/choice-icon.png" align="" title="" />
			<div class="right_allimg">
			<h4>5 Images</h4>
			<p>Customer choose<br />
			5 images to download</p>
			<h2>$80</h2>
			</div>
			<a href="javascript:void(0);" class="get_packages" onclick="getDigitalPackage('5','80');">Get the Package</a>
			<br class="clear"/>
		</div>
		<div class="all_imagepan">
			<img src="<?=base_url()?>assets/images/choice-icon.png" align="" title="" />
			<div class="right_allimg">
			<h4>1 Image</h4>
			<p>Customer choose<br />
			1 image to download</p>
			<h2>$50</h2>
			</div>
			<a href="javascript:void(0);" class="get_packages" onclick="getDigitalPackage('1','50');">Get the Package</a>
			<br class="clear"/>
		</div>
	</div>
</div>

</div>

 <!-- <div class="frame">
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

 <img src="<?=thumb($firstImgPath, $f_img_path, '400', '400')?>" style="max-width:100%; position: relative;" id="disImage">

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
  </div>-->

<?php endif; ?>

</div>
</div>
</div>

</div>
<div style="clear: both;"></div>
<div id="img-out"></div>

<script>
     function fbs_click(TheImg) {alert("here");
	 //alert("hi - "+$(this).parent('div').attr('id'));
     
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

        
