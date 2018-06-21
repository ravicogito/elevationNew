<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	 


<script>
function Checkingform(image)		
{				
	var customer_name 			= jQuery(image).find('#customer_name').val();
	var event					= jQuery(image).find('#event_name').val();
	var dft_photographer_name 	= jQuery(image).find('#dflt_photographer_name').val();
	var photographer_name 		= jQuery(image).find('#photographer_name').val();
	var media_type 				= jQuery(image).find('#media_type').val();
	var imgFile 				= jQuery(image).find('#customerImage').val();						
	if(customer_name == '')			
	{	alert('Select customer name');				
		return false;			
	}	
	else if(dft_photographer_name == '' && photographer_name == '')			
	{	alert('Select photographer name');				
		return false;			
	}	
	else if(media_type == '')			
	{	alert('Select media type');				
		return false;			
	}
	else if(imgFile == '')			
	{	alert('Please upload image');				
		return false;			
		
	}	
	else{
		$('#myOverlay').show();
		$('#loadingGIF').show();
		$.ajax({
			url: '<?php echo base_url();?>CustomerImageUpload/addImage',
			type: 'POST',
			contentType:false,
			processData: false,
			data: function(){
				var data = new FormData();
				jQuery.each(jQuery('#customerImage')[0].files, function(i, file) {
					data.append('customerImage_'+i, file);
				});
				data.append('customer_id' , 'customer_name');
				data.append('photographer_id' , 'photographer_name');
				data.append('media_type' , 'media_type');
				return data;
			}(),
				success: function(result) {
					//alert(result);
					if(result !=""){
						
						$('#myOverlay').hide();
						$('#loadingGIF').hide();
						
					}
					else{
						
						$('#myOverlay').hide();
						$('#loadingGIF').hide();
						alert("Please try again!");
					}
				},
			
		});

	}	
}
		
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
<script>
	function getval(sel)
	{
		//alert(sel.value);
		var customer_id = sel.value;
		$.ajax({
			url: "<?php echo base_url();?>customerImageUpload/AjaxCustomerwiseLoaction/",
			data:{customer_id:customer_id},
			type: "POST",
			dataType: 'JSON',
			success:function(responce) {
				if(responce['process'] == 'success') {
					$("#customer_location").val(responce['customer_location']);
					var locationID = responce['customer_location'];
					
					$.ajax({
						url: "<?php echo base_url();?>CustomerImageUpload/populateAjaxEvent/",
						data:{location_id:locationID},
						type: "POST",
						dataType:"HTML",
						success:function(data) {	
						//alert("success: " + data);
							
						  $("#event_name").get(0).options.length=0;			  
						  var arr = new Array();
						  if(data!="")
						  {
							arr = data.split("??");
							addOption($("#event_name").get(0), "", "No Event", "");	
							for(var i=0;i<arr.length;i++)
							{
							  var brr =  new Array();
							  brr = arr[i].split("|");
							  
							  addOption($("#event_name").get(0), brr[0], brr[1], "");
							}
						  }         
						}
					}); 
				}else{
				$("#customer_location").val('');	
			}
		  }	
		});  
	}
	
function addOption(selectbox, value, text){
		var optn = document.createElement("option");
		optn.text = text;
		optn.value = value;
		selectbox.options.add(optn);
	}
$('document').ready(function(){
	/* $("#event_name").unbind().bind("change", function() {
	$("#default_photographer").hide();
	$("#photographer_list").show();
	  var eventID     = $(this).val();
	  
	  $.ajax({
		url: "<?php echo base_url();?>CustomerImageUpload/populateAjaxPhotographer/",
		data:{event:eventID},
		type: "POST",
		dataType:"HTML",
		success:function(data) {
			//alert("success: " + data);
			$("#photographer_name").get(0).options.length=0;			  
			var arr = new Array();
			if(data!="")
			{
			arr = data.split("??");			
			for(var i=0;i<arr.length;i++)
			{
			  var brr =  new Array();
			  brr = arr[i].split("|");
			  
			  addOption($("#photographer_name").get(0), brr[0], brr[1], "");
			}
			}    
		}
	  }); 
	}); */
	
	$("#customer_name").unbind().bind("change", function() {
		
		var customer_id = $(this).val();
		
		$('#event_name')

			.find('option')

			.remove()

			.end()
		;
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>CustomerImageUpload/populateAjaxbyUserEvent/",
			data:
			{
				customerId:customer_id
			},
			success:function(response)
			{
				var $options = [];

				$("<option></option>", {value: '', text: 'Select'}).appendTo('#event_name');
				$.each( response, function( key, value ) {

				  var title = response[key].event_name;

				  var event_id = response[key].event_id;
					
					$("<option></option>", {value: event_id, text: title}).appendTo('#event_name');

				});
			},
		});
	});
	
	$("#event_name").unbind().bind("change",function() {
		var event_id = $(this).val();
		var customer_name = $("#customer_name").val();
		
		$('#dflt_photographer_name')

			.find('option')

			.remove()

			.end()
		;
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>CustomerImageUpload/populateAjaxbyUserEvent/",
			data:
			{
				eventId:event_id,
				customerName:customer_name,
			},
			success:function(response)
			{
				var $options = [];

				$.each( response, function( key, value ) {

				  var photographer_name = response[key].photographer_name;

				  var photographer_id = response[key].photographer_id;
					
					$("<option></option>", {value: photographer_id, text: photographer_name}).appendTo('#dflt_photographer_name');

				});
			},
			
		});
	});
});
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"><div class="content animate-panel">    
<div class="row">        
<div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">            
	<div class="hpanel hblue">   
		 <div id="myOverlay"></div>
			<div id="loadingGIF"><img src="<?php echo base_url()?>assets/image/ajax-loader.gif" alt=""/><p style="font-size:28"><strong>PROCESSING, PLEASE WAIT...</strong></p></div>
		<div class="panel-body">                    
		<h3>Add Customer Images</h3>                    
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
			
			<form role="form" method="post" action="" onsubmit="return Checkingform(this);" enctype="multipart/form-data">
			<div class="form-group">
				<label>Customer Name</label>							
				<select name="customer_id" id="customer_name" class="form-control" <!--onchange="getval(this);"-->>								
					<option value="">Select</option>								
					<?php if(!empty($customerlist)){ foreach ($customerlist as $val){ ?>					
						<option value="<?php echo $val->customer_id; ?>"><?php echo $val->customer_firstname; ?></option>								
					<?php }								
					} ?>							
				</select>	
			<input type="hidden" id="customer_location" name="customer_location" value="" />				
			</div>	
			<div class="form-group">							
				<label for="catImage">Event Name</label>							
					<select name="event_name" id="event_name" class="form-control">	
					<option value="">Select</option>					
					
					
					<!--<option value="Video">Video</option>-->
				</select>						
			</div>
			<div class="form-group" id="photographer_list" style="display:none">							
				<label>Photographer Name</label>							
				<select name="photographer_name" id="photographer_name" class="form-control">				
					<option value="">Select</option>								
											
				</select>						
			</div>	
			<div class="form-group" id="default_photographer">							
				<label>Photographer Name</label>							
				<select name="dflt_photographer_id" id="dflt_photographer_name" class="form-control">	
							
					<option value="">Select</option>
				</select>						
			</div>
			<div class="form-group">							
				<label for="catImage">Album Title</label><br>
				<input type="test" id="media_title" name="media_title" placeholder="Enter  album title here" style="width:100%">
			</div>						
			<div class="form-group">							
				<label for="catImage">Album Description</label>							
				<textarea class="form-control" id="media_description" name="media_description" rows="3" placeholder="Put album description here"></textarea>
			</div>						
			<div class="form-group">							
				<label for="catImage">Media Type</label>							
					<select name="media_type" id="media_type" class="form-control">
					<option value="">Select</option>
					<option value="Image" selected>Image</option>
					<!--<option value="Video">Video</option>-->
				</select>						
			</div>												
			<div class="form-group" id="Image_div">							
			<label for="catImage">Upload Images</label>							
			<input type="file" id="customerImage" name="customerImage[]" multiple>						</div>						
			<button type="submit" name="submit_new_pass" class="btn btn-success btn-block">Upload</button>                               					
			</form>                
			
		</div>            
	</div>        
</div>    
</div>
</div>
</div>  <!-- /.content-wrapper -->