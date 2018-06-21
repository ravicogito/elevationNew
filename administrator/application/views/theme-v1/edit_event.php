


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	 
<script>		
function Checkingform(event)		
{			
	var event_name 			= jQuery(event).find('#event_name').val();
	var event_location 		= jQuery(event).find('#location_id').val();	
	var event_desp 			= jQuery(event).find('#event_description').val();	
	var resort_name 		= jQuery(event).find('#resort_name').val();				
	var photographer_name 	= jQuery(event).find('#photographer_name').val();		
	

	if(event_name == '')
	{
		alert('Please put event name');

		return false;
	}
	if(event_location == '')
	{
		alert('Please select event location');

		return false;
	}
	if(event_desp == '')
	{
		alert('Please put event description');

		return false;
	}
	if(resort_name == '')
	{
		alert('Please select event resort');

		return false;
	}
	if(photographer_name == '')
	{
		alert('Please select event photographer');

		return false;
	}		
}		
(function($){		 	
	$(document).ready( function(){				
	$( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });				
	$( "#event_end_date" ).datepicker({ dateFormat: 'dd-mm-yy' });		 	
	});		 
})(jQuery) 
function addOption(selectbox, value, text){
		var optn = document.createElement("option");
		optn.text = text;
		optn.value = value;
		selectbox.options.add(optn);
}
$('document').ready(function(){
	$("#location_id").unbind().bind("change", function() {
	
	  var location_id     = $(this).val();
	  //alert(location_id);
	  $.ajax({
		url: "<?php echo base_url();?>Event/populateAjaxResortByLocation/",
		data:{location:location_id},
		type: "POST",
		dataType:"HTML",
		success:function(data) {
			//alert("success: " + data);
			$("#resort_id").get(0).options.length=0;			  
			var arr = new Array();
			if(data!="")
			{
			arr = data.split("??");	
			addOption($("#resort_id").get(0), "", "Select Resort", "");		
			for(var i=0;i<arr.length;i++)
			{
			
			  var brr =  new Array();
			  brr = arr[i].split("|");
			  
			  addOption($("#resort_id").get(0), brr[0], brr[1], "");
			}
			}    
		}
	  }); 
	});

	$("#resort_id").unbind().bind("change", function() {

	  var resortID     = $(this).val();
	  //alert(resortID);
	  $.ajax({
		url: "<?php echo base_url();?>Event/populateAjaxPhotographerByLocation/",
		data:{resort:resortID},
		type: "POST",
		dataType:"HTML",
		success:function(data) {
			//alert("success: " + data);
			$("#photographer_id").get(0).options.length=0;			  
			var arr = new Array();
			if(data!="")
			{
			arr = data.split("??");	
			addOption($("#photographer_id").get(0), "", "Select Photographer", "");	
			for(var i=0;i<arr.length;i++)
			{
			  var brr =  new Array();
			  brr = arr[i].split("|");
			  
			  addOption($("#photographer_id").get(0), brr[0], brr[1], "");
			}
			}    
		}
	  }); 
	});

});

</script>     

<style>.hpanel {    background-color: none;    border: none;    box-shadow: none;    margin-bottom: 25px;}.hpanel.hblue .panel-body {    border-top: 2px solid #b00e4e;}.hpanel .panel-body {    background: #fff;    border: 1px solid #e4e5e7;        border-top-width: 1px;        border-top-style: solid;        border-top-color: rgb(228, 229, 231);    border-radius: 2px;    padding: 20px;    position: relative;}</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"><div class="content animate-panel">    
<div class="row">        
<div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;"> 
<div class="hpanel hblue">                
<div class="panel-body">                    
	<h3>Edit Event Data</h3>                    
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
	
	<form role="form" method="post" action="<?php if(!empty($event_data['event_id'])){ echo base_url().'Event/updateEvent/'.$event_data['event_id']; } ?>" onsubmit="return Checkingform(this);" enctype="multipart/form-data">
		<div class="form-group">						  
		<label>Event Name</label>						  
		<input type="text" class="form-control" id="event_name" name="event_name" value="<?php if(!empty($event_data['event_name'])){ echo $event_data['event_name'];}?>">						
		</div>						
		<div class="form-group">							
		<label for="catImage">Event Description</label>
		<textarea class="form-control" id="event_description" name="event_description" rows="3"><?php if(!empty($event_data['event_description'])){ echo $event_data['event_description'];}?></textarea>			</div>
		<div class="form-group">						 
		<label>Event Date</label>						  
		<input type="text" class="form-control" id="datepicker" name="event_date" placeholder="Enter Date" value="<?php if(!empty($event_data['event_date'])){ echo date('d-m-Y',strtotime($event_data['event_date']));}?>">						
		</div>
		<div class="form-group">

		  <label>Select Location</label>

		  <select name="location_id" id="location_id" class="form-control">
				<option value="">Select</option>
					<?php if(!empty($location_list)){ foreach ($location_list as $vallist){
					?>
					<option value="<?php echo $vallist->location_id; ?>" <?php if(!empty($event_data['location_id'])){ echo ($vallist->location_id == $event_data['location_id'])?'selected':''; }?>><?php echo $vallist->location_name; ?></option>
					<?php
					}
					} ?>
			</select>

		</div>
		<div class="form-group">
			<label>Select Resort</label>
			<select name="resort_name" id="resort_id" class="form-control">
				<option value="">Select Resort</option>
				<?php if(!empty($resort_lists)){ foreach ($resort_lists as $resort_list){
				?>
				<option value="<?php echo $resort_list['resort_id']; ?>" <?php if(!empty($event_data['resort_id'])){ echo ($resort_list['resort_id'] == $event_data['resort_id'])?'selected':''; }?>><?php echo $resort_list['resort_name']; ?></option>
				<?php
				}
				} ?>
			</select>
		</div>
		<div class="form-group">
			<label>Photographer Name</label>
			<select name="photographer_name" id="photographer_id" class="form-control">
				<option value="">Select</option>
				<?php if(!empty($all_photographers)){ foreach ($all_photographers as $all_photographer){
				?>
				<option value="<?php echo $all_photographer->photographer_id; ?>" <?php if(!empty($event_data['photographer_id'])){ echo ($all_photographer->photographer_id == $event_data['photographer_id'])?'selected':''; }?>><?php echo $all_photographer->photographer_name; ?></option>
				<?php
				}
				} ?>
				
			</select>
		</div>
		
		<div class="form-group">
		  <label>Event Price</label>
		  <input type="text" class="form-control" id="event_price" name="event_price" placeholder="Put event price" value="<?php if(!empty($event_data['event_price'])){ echo $event_data['event_price'];}?>">
		</div>
		
		<button type="submit" name="submit_new_pass" class="btn btn-success btn-block">Update</button>                               					
	</form>                
</div>            
</div>        
</div>    
</div>
</div>
</div>  <!-- /.content-wrapper -->