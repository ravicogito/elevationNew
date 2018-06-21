<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
(function($){
	$(document).ready( function(){
		$( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
		$( "#end_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
	});
 })(jQuery)
</script>

<script>
function Checkingform(event)
{
	var customer_location 			= jQuery(event).find('#location_id').val();
	
	var customer_resort 			= jQuery(event).find('#resort_id').val();
	
	var customer_event_id 			= jQuery(event).find('#event_id').val();
	
	var dflt_photographer_name 		= jQuery(event).find('#dflt_photographer_name').val();
	
	var customer_name 				= jQuery(event).find('#customer_name').val();
	
	var start_date 					= jQuery(event).find('#datepicker').val();
	
	var end_date 					= jQuery(event).find('#end_date').val();
				
	if(customer_location == '')			
	{	alert('Please Select any Location');				
		return false;			
	}	
	
	if(customer_resort == '')			
	{	alert('Please Select any Resort');				
		return false;			
	}	
	
	if(customer_event_id == '')			
	{	alert('Please Select any Event');				
		return false;			
	}	
	
	if(dflt_photographer_name == '')			
	{	alert('Please Select any photographer name');				
		return false;			
	}		
	
	if(customer_name == '')			
	{	alert('Please Select any customer name');				
		return false;			
	}	
	
	if(start_date == '')			
	{	alert('Please Select start Date');				
		return false;			
	}	
	
	if(end_date == '')			
	{	alert('Please Select End Date');				
		return false;			
	}	
	
	else{
		return true;
	}
	
}

$('document').ready(function(){
	$("#location_id").unbind().bind("change", function() {
		
		var location_id = $(this).val();
		
		$('#resort_id')

			.find('option')

			.remove()

			.end();
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>Event/populateAjaxbyUserEvent/",
			data:
			{
				locationId:location_id
			},
			success:function(response)
			{
				var $options = [];

				$("<option></option>", {value: '', text: 'Select'}).appendTo('#resort_id');
				$.each( response, function( key, value ) {

				  var title = response[key].resort_name;

				  var id = response[key].resort_id;
					
					$("<option></option>", {value: id, text: title}).appendTo('#resort_id');

				});
			},
		});
	});
	
	$("#resort_id").unbind().bind("change", function() {
		
		var resort_id 			 = $(this).val();
		var location_id_byResort = $("#location_id").val();
		
		$('#event_id')

			.find('option')

			.remove()

			.end();
			
		$('#customer_name')

			.find('option')

			.remove()

			.end();
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>Event/populateAjaxbyUserEvent/",
			data:
			{
				resortId:resort_id,
				location_IdbyResort:location_id_byResort
			},
			success:function(response)
			{
				var $options = [];

				$("<option></option>", {value: '', text: 'Select'}).appendTo('#event_id');
				$("<option></option>", {value: '', text: 'Select'}).appendTo('#customer_name');
				$.each( response, function( key, value ) {
				  
				  var event_id			 = response[key].event_id;
				  
				  var event_name		 = response[key].event_name;
				  
				  var customer_id		 = response[key].customer_id;
				  
				  var customer_firstname = response[key].customer_firstname;
				  
				  if(response[key].event_id && response[key].event_name)
				  {
					
					$("<option></option>", {value: event_id, text: event_name}).appendTo('#event_id');
				  }
				  if(customer_id && customer_firstname)
				  {
					
					$("<option></option>", {value: customer_id, text: customer_firstname}).appendTo('#customer_name');
				  }

				});
			},
		});
	});
	
	$("#event_id").unbind().bind("change", function() {
		
		var event_id = $(this).val();
			
			$('#dflt_photographer_name')

			.find('option')

			.remove()

			.end();
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>Event/populateAjaxbyUserEvent/",
			data:
			{
				eventId:event_id
			},
			success:function(response)
			{
				var $options = [];

				//$("<option></option>", {value: '', text: 'Select'}).appendTo('#dflt_photographer_name');
				$.each( response, function( key, value ) {
				  
				  var photographer_id = response[key].photographer_id;

				  var photographer_name = response[key].photographer_name;
					
					$("<option></option>", {value: photographer_id, text: photographer_name}).appendTo('#dflt_photographer_name');

				});
			},
		});
	});
});
</script>
<style>
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
.event_ind_sec li {
    background: #f7f3f3 none repeat scroll 0 0;
    display: inline-block;
    min-height: inherit;
    margin: 0 20px 18px;
    width: 211px;
}

#loadingGIF {
	background: #fff none repeat scroll 0 0;
	box-shadow: 0 0 50px #410035;
	text-align: center;
	border-color:#410035;
	height: 60px;
	padding: 15px;
	position: fixed;
	top: 40%;
	left:45%;
	width: 270px;
	z-index: 99999;
	display:none;
}
#myOverlay {
	background: black none repeat scroll 0 0;
	display: none;
	height: 100%;
	opacity: 0.7;
	position: fixed;
	width: 100%;
	z-index: 9999;
	top: 0;
	left: 0;
}
</style>

<div class="content-wrapper"><div class="content animate-panel">    
<div class="row">        
<div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">            
	<div class="hpanel hblue">   
		 <div id="myOverlay"></div>
			<div id="loadingGIF"><img src="<?php echo base_url()?>assets/image/ajax-loader.gif" alt=""/><p style="font-size:28"><strong>PROCESSING, PLEASE WAIT...</strong></p></div>
		<div class="panel-body">                    
		<h3>Add Assign Event To Customer</h3>                    
		<?php  
			$success_msg = $this->session->flashdata('sucessPageMessage');                    
			if ($success_msg != "") {  
		?>                       
		<div class="alert alert-success"><?php echo $success_msg; ?></div>                        
		<?php   }   ?>                    
		<?php                    
		$failed_msg = $this->session->flashdata('failMessage');                    
			if ($failed_msg != "") {   ?>                        
			<div class="alert alert-danger"><?php echo $failed_msg; ?></div>                        
			<?php    }   ?>                    
			<br/>                    
			
			<form role="form" method="post" action="" onsubmit="return Checkingform(this);">
				<div class="form-group">
					<label>Location</label>							
					<select name="location_id" id="location_id" class="form-control" <!--onchange="getval(this);"-->>								
						<option value="">Select</option>								
						<?php if(!empty($fetch_all_locations)){ foreach ($fetch_all_locations as $fetch_all_location){ ?>					
							<option value="<?php echo $fetch_all_location['location_id']; ?>"><?php echo $fetch_all_location['location_name']; ?></option>								
						<?php }								
						} ?>							
					</select>	
				<input type="hidden" id="customer_location" name="customer_location" value="" />				
				</div>	
				<div class="form-group">							
					<label for="catImage">Resort Name</label>							
						<select name="resort_name" id="resort_id" class="form-control">	
						<option value="">Select</option>
					</select>						
				</div>
				
				<div class="form-group" id="default_photographer">							
					<label>Event Name</label>							
					<select name="event_id" id="event_id" class="form-control">	
								
						<option value="">Select</option>
					</select>						
				</div>
				
				<div class="form-group" id="default_photographer">							
					<label>Photographer Name</label>							
					<select name="dflt_photographer_id" id="dflt_photographer_name" class="form-control">	
								
						<option value="">Select</option>
					</select>						
				</div>
				
				<div class="form-group" id="photographer_list">							
					<label>Customer Name</label>							
					<select name="customer_name" id="customer_name" class="form-control">				
						<option value="">Select</option>						
								
					</select>						
				</div>	
				
				<div class="form-group">							
					<label for="catImage">Start Date</label><br>
					<input type="test" class="form-control" id="datepicker" name="start_date" placeholder="Enter your start date" style="width:100%">
				</div>						
								
				<div class="form-group">							
					<label for="catImage">End Date</label><br>
					<input type="test" class="form-control" id="end_date" name="end_date" placeholder="Enter your end date" style="width:100%">
				</div>	
				
				<button type="submit" name="submit_new_pass" class="btn btn-success btn-block">Assign</button>
			</form>                
			
		</div>            
	</div>        
</div>    
</div>
</div>
</div>