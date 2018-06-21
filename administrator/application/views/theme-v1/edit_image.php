<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	 
<script>
function Checkingform(image)		
{
	var media_price 			= jQuery(image).find('#media_price').val();
	if(media_price == ""){
		
		alert('Please put image price');				
		return false;
	}
}
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
	border-top: 2px solid #b00e4e;
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
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"><div class="content animate-panel">    
<div class="row">        
<div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;"> 
<div class="hpanel hblue">                
<div class="panel-body"> 
	<div class="box-tools pull-right" style="margin-bottom:10px;margin-right:20px">		  
		<a class="btn btn-block btn-default" href="<?php echo base_url().'CustomerImageUpload/viewImage/'.$customer_id ?>"><i class="fa fa-plus-square"></i>&nbsp;Back</a>	</div> 				
	<h3>Edit Customer Image</h3>                    
	<?php	$success_msg = $this->session->flashdata('sucessPageMessage');                    
			if ($success_msg != "") 
			{                        
	?>                        
			<div class="alert alert-success"><?php echo $success_msg; ?></div>
	<?php   }   ?>                    
	<?php $failed_msg = $this->session->flashdata('pass_inc');  
	if ($failed_msg != "") {   
	?> <div class="alert alert-danger"><?php echo $failed_msg; ?></div>
	<?php }  ?>                    
	<br/>                    
	
	<form role="form" method="post" action="<?php if(!empty($media_id)){ echo base_url().'CustomerImageUpload/updateEditImage/'.$media_id.'/'.$customer_id; } ?>" onsubmit="return Checkingform(this);" enctype="multipart/form-data">
		<?php
			$url_tmp  = base_url();
			$home_url = str_replace("/administrator", "", $url_tmp);
		?>
		<div><img src="<?php echo $home_url;?>uploads/customerImg_<?php if(!empty($customer_id) && !empty($media_id)){ echo $customer_id .'/'.$Image_data['file_name']; } ?>" width="150px;" height="150px" alt="" style="width: 150px; height: 150px; margin-left:5px; float:left;"/></div>
		<div class="form-group" id="Image_div" style="width:50%;float:left;margin-left:50px;">							
			<label for="catImage"><h4>Upload Images</h4></label>	
			<input type="hidden" id="old_img" name="old_img" value="<?php if(!empty($Image_data['file_name'])){ echo $Image_data['file_name']; } ?>">
			<input type="file" id="editcustmImage" name="editcustmImage">					
		</div>
		<div class="form-group col-md-5" style="margin-left:35px;" >							
				<label for="catImage"><h4>Image Price(in $)</h4></label><br>
				<input type="text" id="media_price" name="media_price" value="<?php if(!empty($Image_data['media_price'])){ echo $Image_data['media_price']; } else { }?>"  style="width:100%">
		</div>
		<div class="form-group col-md-5">							
				<label for="catImage"><h4>Photo Resolution</h4></label><br>
				<input type="text" id="photo_resolution" name="photo_resolution" value="<?php if(!empty($Image_data['photo_resolution'])){ echo $Image_data['photo_resolution']; } else { }?>"  style="width:100%">
		</div>
		<div class="form-group col-md-5">							
				<label for="catImage"><h4>Photo Size</h4></label><br>
				<input type="text" id="photo_size" name="photo_size" value="<?php if(!empty($Image_data['photo_size'])){ echo $Image_data['photo_size']; } else { }?>"  style="width:100%">
		</div>
		<div class="form-group col-md-5">							
				<label for="catImage"><h4>Digital Format</h4></label><br>
				<input type="text" id="digital_format" name="digital_format" value="<?php if(!empty($Image_data['digital_format'])){ echo $Image_data['digital_format']; } else { }?>"  style="width:100%">
		</div>
		<div style="overflow: hidden;width: 100%; padding-top: 16px;clear: both;">
			<button type="submit" name="submit_new_pass" class="btn btn-success btn-block" style="width: 200px;margin: 0 auto;">Save</button>
		</div>                               					
	</form>                
</div>            
</div>        
</div>    
</div>
</div>
</div>  <!-- /.content-wrapper -->