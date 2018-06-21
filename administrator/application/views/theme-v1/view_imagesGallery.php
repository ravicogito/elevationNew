<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/jquery.prettyPhoto.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/dist/css/prettyPhoto.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	 
<script>				
$("document").ready(function(){			
	$("#media_type").change(function(){				
		var media_type = $("#media_type").val();								
		if(media_type == 'Image'){					
			$("#Image_div").show();					
			$("#video_div").hide();	
		}				
		else if(media_type == 'Video'){					
			$("#Image_div").hide();					
			$("#video_div").show();
		}			
	});					
});		 		
function Checkingform(image){			
	var pattern = /^((http|https|ftp):\/\/)/; 			
	var image_type = jQuery(image).find('#image_type').val();
	var imgFile = jQuery(image).find('#imageimg').val();						
	if(image_type == '')			
	{	alert('Select image Type');				
		return false;			
	}									
	if(imgFile == '')			
	{				
		alert('Please upload image');				
		return false;			
	}			
}	

$("area[rel^='prettyPhoto']").prettyPhoto({overlay_gallery: false});
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, iframe_markup: "<iframe src='{path}' width='{width}' height='{height}' frameborder='no' allowfullscreen='true'></iframe>", autoplay_slideshow: false, overlay_gallery: false });
				
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true, overlay_gallery: false});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});	 	      
</script>
<style>
.event_ind_sec li {
    background: #f7f3f3 none repeat scroll 0 0;
    display: inline-block;
    min-height: inherit;
    margin: 0 20px 18px;
    width: 211px;
}
.hpanel {
	background-color: none;    
	border: none;    
	box-shadow: none;    
	margin-bottom: 25px;
}
.hpanel.hblue .panel-body {   
	border-top: 2px solid #3498db;
}
.hpanel .panel-body {    
	background: #fff;    
	border: 1px solid #e4e5e7; 
	border-top-width: 1px;
	border-top-style: solid;
	border-top-color: rgb(228, 229, 231);
	border-radius: 2px;
	padding: 20px;
	position: relative;
}
.event_ind_sec li {
	min-height:inherit;
   
}
#edit_btn {
    float: left;
	margin-top:3px;
	margin-left: 125px;
}
#delete_btn {
    float: right;
	margin-top:3px;
}
.event_ind_sec li li{
	min-height: inherit;
}

.event_ind_sec_in a{padding: 5px 0 !important;}
.gallery {
    padding-left: 0;
    margin-left: -20px;
}
.event_ind_sec{padding-left:40px;}

.ntpublis {
background-color: #d8110b; 
width: 48px; display:inline-block;
}
#publish_btn {
	float: left; margin-top: 2px;
}
#unpublish_btn {
	float: left; margin-top: 2px;
}
a.publis {
background-color: #8db600;
    width: 48px; display:inline-block;
}
.gallery #edit_btn {
	margin-left: 76px;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel ">    
<div class="row"> 
	<!--<div id="myOverlay"></div>
			<div id="loadingGIF"><img src="<?php echo base_url()?>assets/images/ajax-loader_ifsc.gif" alt=""/><p style="font-size:28"><strong>PROCESSING, PLEASE WAIT...</strong></p></div>-->
	<div class="box-tools pull-right" style="margin-bottom:10px;margin-right:20px">		  
		<a class="btn btn-block btn-default" href="<?php echo base_url().'CustomerImageUpload'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Back</a>	</div> 
	<?php if(!empty($Image_list)){ ?>
	<div class="event_ind_sec">	
		 
		<div id="galltittl"><h3>Image Gallery Of Customer - <span style="color:#b00e4e;font-size:25px;font-weight:20px"><?php if(!empty($Image_list[0]['customer_firstname']) || !empty($Image_list[0]['customer_middlename']) || !empty($Image_list[0]['customer_lastname'])){ echo $Image_list[0]['customer_firstname'] ." ". $Image_list[0]['customer_middlename'] ." ". $Image_list[0]['customer_lastname'] ; }?></span></h3></div>
	
		<ul class="gallery clearfix" id="galImg">
		<?php
		foreach($Image_list as $images){
			
			if(!empty($images['media_type']) && $images['media_type'] == 'Image'){
		?>
			<li>
				<div class="event_ind_sec_in">
				<?php
					$url_tmp  = base_url();
					$home_url = str_replace("/administrator", "", $url_tmp);
				?>	 
					<a href="<?php echo $home_url; ?>uploads/customerImg_<?php if(!empty($customer_id)){ echo $customer_id .'/'.$images['file_name'] ; } ?>" rel="prettyPhoto[gallery1]"><img src="<?php echo $home_url; ?>uploads/customerImg_<?php if(!empty($customer_id)){ echo $customer_id .'/'.$images['file_name']; } ?>" alt="" height="212px" width="212px"></a>
							 
				</div>
				<?php if($images['publish_status'] =='0'){ ?>
				<div id="publish_btn">
					<a href="<?php echo base_url();?>CustomerImageUpload/publishImage/<?php if(!empty($images['media_id']) && !empty($customer_id)){ echo $images['media_id'].'/'.$customer_id; } ?>"  id='publish' title="publish" class="publis" style="padding: 0 !important;"><img src="<?php echo base_url();?>assets/image/publis.png" width="38" height="29" alt="" style="width: 38px; height: 30px; margin-left:5px; float:left;"/></a>
				</div>
				<?php }
				else{
				?>
				<div id="unpublish_btn">
					<a href="<?php echo base_url();?>CustomerImageUpload/unPublishImage/<?php if(!empty($images['media_id']) && !empty($customer_id)){ echo $images['media_id'].'/'.$customer_id; } ?>"  id = 'unpublish'  title="unpublish" class="ntpublis" style="padding: 0 !important;"><img src="<?php echo base_url()?>assets/image/ntpublis.png" width="38" height="29" alt="" style="width: 38px; height: 30px; margin-left:5px; float:left;"/></a>
				</div>	
				
				<?php 
				}
				?>
			
				<div id="edit_btn">
				<a href="<?php echo base_url();?>CustomerImageUpload/editImage/<?php if(!empty($images['media_id']) && !empty($customer_id)){ echo $images['media_id'].'/'.$customer_id; } ?>"  id = 'edit' title="edit" class="editbuttn" style="padding: 0 !important;"><img src="<?php echo base_url()?>assets/image/edit.png" width="38" height="29" alt="" style="width: 38px; height: 30px; margin-left:5px; float:left;"/></a>
				</div>
				<div id="delete_btn">
				<a href="<?php echo base_url();?>CustomerImageUpload/deleteImage/<?php if(!empty($images['media_id'])){ echo $images['media_id'].'/'.$customer_id;; } ?>" onclick="return confirm('Are you sure to delete the image?')" id = '' title="delete" class="deletebuttn" style="padding: 0 !important;"><img src="<?php echo base_url()?>assets/image/delete.png" width="38" height="29" alt="" style="width: 38px; height: 30px; margin-left:5px; float:left;"/></a>
				</div>
			</li>
		<?php } } ?>
		</ul>
	</div>
	<?php } ?>
</div>
</div> 
</div> <!-- /.content-wrapper -->