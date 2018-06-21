<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


	<script>
	$('document').ready(function(){
		
		$("#go").click(function() {
		
		  var rfID     = $('#customer_ref_id').val();
		  var lID     = $('#location_id').val();
		 // alert(lID);
		  if(rfID == '')
			{
				alert('Please enter RFID');

				return false;
			}
		else{	

		  $.ajax({
			url: "<?php echo base_url();?>customer/AjaxCustomerList/",
			data:{rfID:rfID,lnID:lID},
			type: "POST",
			dataType: 'JSON',
			success:function(responce) {
				alert(responce);
				if(responce['process'] == 'success') {
					alert(responce['resort_data']);
					$("#div_id").css({display: "block"});
					$("#s1_id").css({display: "none"});
					$("#s2_id").css({display: "block"});
					$("#c1_id").css({display: "none"});
					$("#c2_id").css({display: "block"});
					$(".message").html('');
					//$(".box-button").css({display: "none"});
					$("#customer_firstname").val(responce['customer_firstname']);
					$('#customer_firstname').attr('readonly', true);
					$("#customer_middlename").val(responce['customer_middlename']);
					$('#customer_middlename').attr('readonly', true);
					$("#customer_lastname").val(responce['customer_lastname']);
					$('#customer_lastname').attr('readonly', true);
					$("#customer_email").val(responce['customer_email']);
					$('#customer_email').attr('readonly', true);
					$("#customer_mobile").val(responce['customer_mobile']);
					$('#customer_mobile').attr('readonly', true);
					$("#customer_address").val(responce['customer_address']);
					$('#customer_address').attr('readonly', true);
					$("#country_id").val(responce['customer_country_id']);
					$('#country_id').attr('readonly', true);
					$("#ss_id").val(responce['customer_state_id']);
					$('#ss_id').attr('readonly', true);
					$("#cc_id").val(responce['customer_city_id']);
					$('#cc_id').attr('readonly', true);
					$("#customer_zipcode").val(responce['customer_zipcode']);
					$('#customer_zipcode').attr('readonly', true);
					$(".box-footer").css({display: "none"});
					$("#resort_id").get(0).options.length=0;			  
					var arr = new Array();
					if(responce['resort_data']!="")
					{
					alert(responce['resort_data']);
					arr = responce['resort_data'].split("??");	
					addOption($("#resort_id").get(0), "", "Select Resort", "");		
					for(var i=0;i<arr.length;i++)
					{
					
					  var brr =  new Array();
					  brr = arr[i].split("|");
					  
					  addOption($("#resort_id").get(0), brr[0], brr[1], "");
					}
					}
			    }
				else{
					//$(".box-button").css({display: "none"});
					$(".message").html('Customer not exist against this RFID. Please add new one.');
					$("#s2_id").css({display: "none"});
					$("#s1_id").css({display: "block"});
					$("#c2_id").css({display: "none"});
					$("#c1_id").css({display: "block"});
					$("#div_id").css({display: "block"});
					$("#customer_firstname").val('');
					$("#customer_middlename").val('');
					$("#customer_lastname ").val('');
					$("#customer_email").val('');
					$("#customer_mobile").val('');
					$("#customer_address").val('');
					$("#country_id").val('');
					$("#ss_id").val('');
					$("#cc_id").val('');
					$("#customer_zipcode").val('');
					$('#customer_firstname').attr('readonly', false);
					$('#customer_middlename').attr('readonly', false);
					$('#customer_lastname').attr('readonly', false);
					$('#customer_email').attr('readonly', false);
					$('#customer_mobile').attr('readonly', false);
					$('#customer_address').attr('readonly', false);
					$('#country_id').attr('readonly', false);
					$('#ss_id').attr('readonly', false);
					$('#cc_id').attr('readonly', false);
					$('#customer_zipcode').attr('readonly', false);
					$(".box-footer").css({display: "block"});
					$("#resort_id").get(0).options.length=0;			  
					var arr = new Array();
					if(responce['resort_data']!="")
					{
					alert(responce['resort_data']);
					arr = responce['resort_data'].split("??");	
					addOption($("#resort_id").get(0), "", "Select Resort", "");		
					for(var i=0;i<arr.length;i++)
					{
					
					  var brr =  new Array();
					  brr = arr[i].split("|");
					  
					  addOption($("#resort_id").get(0), brr[0], brr[1], "");
					}
					}
				}
        
			}
		  }); 
		} 
		
		});
		
		$("#location_id").unbind().bind("change", function() {
		  var locationID     = $(this).val();
		  
		  $.ajax({
			url: "<?php echo base_url();?>customer/Ajaxlocationwiserf/",
			data:{location:locationID},
			type: "POST",
			dataType:"json",
			success:function(data) {
				//alert(data);
			  if(data!="")
			  {
				//alert(data['comboVal'] +'67547'+data['resort_data']);
				if(data['comboVal']=='Y')
				{
					$("#ref_id").val(data['comboVal']);
					$("#c_rf_id").css({display: "block"});
					$("#div_id").css({display: "none"});
					$(".message").html('');
					
				}
				else
				{
					$("#ref_id").val('N'); 
				    $("#c_rf_id").css({display: "none"});	
                    $("#div_id").css({display: "block"});
				    $("#customer_firstname").val('');
					$("#customer_middlename").val('');
					$("#customer_lastname ").val('');
					$("#customer_email").val('');
					$("#customer_mobile").val('');
					$("#customer_address").val('');
					$("#country_id").val('');
					$("#state_id").val('');
					$("#city_id").val('');
					$("#customer_zipcode").val('');
					$('#customer_firstname').attr('readonly', false);
					$('#customer_middlename').attr('readonly', false);
					$('#customer_lastname').attr('readonly', false);
					$('#customer_email').attr('readonly', false);
					$('#customer_mobile').attr('readonly', false);
					$('#customer_address').attr('readonly', false);
					$('#country_id').attr('readonly', false);
					$('#state_id').attr('readonly', false);
					$('#city_id').attr('readonly', false);
					$('#customer_zipcode').attr('readonly', false);
					$(".box-footer").css({display: "block"});
					$("#s2_id").css({display: "none"});
					$("#s1_id").css({display: "block"});
					$("#c2_id").css({display: "none"});
					$("#c1_id").css({display: "block"});
					$("#resort_id").get(0).options.length=0;			  
					var arr = new Array();
					if(data['resort_data']!="")
					{
					//alert(data['resort_data']);
					arr = data['resort_data'].split("??");	
					addOption($("#resort_id").get(0), "", "Select Resort", "");		
					for(var i=0;i<arr.length;i++)
					{
					
					  var brr =  new Array();
					  brr = arr[i].split("|");
					  
					  addOption($("#resort_id").get(0), brr[0], brr[1], "");
					}
					}
				}
				
			  }         
			}
		  }); 	

		});
		
		$("#country_id").unbind().bind("change", function() {
		  var countryID     = $(this).val();
		  
		  $.ajax({
			url: "<?php echo base_url();?>customer/populateAjaxstate/",
			data:{country:countryID},
			type: "POST",
			dataType:"HTML",
			success:function(data) {
			
			  //$("#state_id").get(0).options.length=0;
			  //addOption($("#state_id").get(0), "", "-- Select state --", "");
			  var arr = new Array();
			  if(data!="")
			  {
				
				arr = data.split("??");
				for(var i=0;i<arr.length;i++)
				{
				  var brr =  new Array();
				  brr = arr[i].split("|");
				  
				  addOption($("#state_id").get(0), brr[0], brr[1], "");
				}
			  }         
			}
		  }); 
		});
		
		 $("#state_id").unbind().bind("change", function() {
		  var stateID     = $(this).val();
		  
		  $.ajax({
			url: "<?php echo base_url();?>customer/populateAjaxCity/",
			data:{state:stateID},
			type: "POST",
			dataType:"HTML",
			success:function(data) {
			
			  $("#city_id").get(0).options.length=0;
			  addOption($("#city_id").get(0), "", "-- Select City --", "");
			  var arr = new Array();
			  if(data!="")
			  {
				arr = data.split("??");
				for(var i=0;i<arr.length;i++)
				{
				  var brr =  new Array();
				  brr = arr[i].split("|");
				  addOption($("#city_id").get(0), brr[0], brr[1], "");
				}
			  }         
			}
		  }); 
		});
	});

	
	function addOption(selectbox, value, text){
		var optn = document.createElement("option");
		optn.text = text;
		optn.value = value;
		selectbox.options.add(optn);
	}
	function Checkingform(customer)
	{
			var location_id 		= jQuery(customer).find('#location_id').val();
			var ref_id              = jQuery(customer).find('#ref_id').val();  
			var customer_ref_id 	= jQuery(customer).find('#customer_ref_id').val();
			var customer_firstname 	= jQuery(customer).find('#customer_firstname').val();
			var customer_lastname 	= jQuery(customer).find('#customer_lastname').val();			
			var email 				= jQuery(customer).find('#customer_email').val();
			var atpos				= email.indexOf("@");
			var atlastpos			= email.lastIndexOf("@");
			var dotpos				= email.indexOf(".");
			var dotlastpos			= email.lastIndexOf(".");
			var customer_mobile		= jQuery(customer).find('#customer_mobile').val();
			var resort_name			= jQuery(customer).find('#resort_id').val();			
			var customer_address	= jQuery(customer).find('#customer_address').val();
			var location_id			= jQuery(customer).find('#location_id').val();
			var country_id			= jQuery(customer).find('#country_id').val();
			var state_id			= jQuery(customer).find('#state_id').val();
			var city_id				= jQuery(customer).find('#city_id').val();
			var customer_zipcode	= jQuery(customer).find('#customer_zipcode').val();
			
			//var postcontent = $("#editorContainer iframe").contents().find("body").text();
            if(location_id == '')
			{
				alert('Please select location');

				return false;
			}
			
            if(ref_id == 'Y')
			{  			
				if(customer_ref_id == '')
				{
					alert('Please put customer RF ID');

					return false;
				}
			}
			
			if(customer_firstname == '')
			{
				alert('Please put customer firstname');

				return false;
			}
			
			if(customer_lastname == '')
			{
				alert('Please put customer lastname');

				return false;
			}
			
			if(email == '')
			{
				alert('Please put email id');

				return false;
			}
			
			if(!validateEmail(email))
			{
				alert('Please put valid email id');

				return false;
			}
			
			if(atpos==0 || dotpos==0 || atlastpos==email.length-1 || dotlastpos==email.length-1 || atpos+1==dotpos || atpos-1==dotpos || atpos==-1 || dotpos==-1 || email=="" || dotlastpos==-1 || atlastpos==-1 || atpos!=atlastpos )
			{
				alert('Please put a valid email');
				return false;
			}
			
			if(customer_mobile == '' || !(customer_mobile.match('[0-9]{10}')))  
			{       alert("Please put 10 digit mobile number");            				
				return false;			
		
			}
			if(resort_name == '')
			{
				alert('Please select resort');

				return false;
			}
			
			if(customer_address == '')
			{
				alert('Please put customer address');

				return false;
			}
			
			if(country_id == '')
			{
				alert('Please select country');

				return false;
			}
			
			if(state_id == '')
			{
				alert('Please select state');

				return false;
			}
			
			if(city_id == '')
			{
				alert('Please select city');

				return false;
			}
			
			if(customer_zipcode == '')  {
                alert("Please put zipcode");
            
				return false;
			}
	}
	
	function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
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

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body">
                    <h3>Add New Customer</h3>

                    <?php
                    $success_msg = $this->session->flashdata('sucessPageMessage');
                    if ($success_msg != "") {
                        ?>
                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                        <?php
                    }
                    ?>
                    <?php
                    $failed_msg = $this->session->flashdata('pass_inc');
                    if ($failed_msg != "") {
                        ?>
                        <div class="alert alert-danger"><?php echo $failed_msg; ?></div>
                        <?php
                    }
                    ?>

                    <form role="form" method="post" action="<?php echo base_url().'Customer/addCustomer/';?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
						<input type="hidden" name="ref_id" id="ref_id" value="" />
						<div class="form-group">

						  <label>Select Location</label>

						  <select name="location_id" id="location_id" class="form-control">
								<option value="">Select</option>
								<?php if(!empty($location_list)){ foreach ($location_list as $locationlist){
								?>
								<option value="<?php echo $locationlist->location_id; ?>"><?php echo $locationlist->location_name; ?></option>
								<?php
								}
								} ?>
							</select>

						</div>

						<div  id='c_rf_id' style="display:none;">
						
						<div class="form-group">

						  <label>Customer RF ID </label>

						  <input type="text" class="form-control" id="customer_ref_id" name="customer_ref_id" placeholder="Enter your RFID">

						</div>
						<div class="box-button">

							<input type="button" id="go" class="btn btn-success btn-block" value="Go">

						</div>
						
						<div><span class="message"></span></div>
						
						</div>
						<div  id='div_id' style="display:none;">

						<div class="form-group">

						  <label>Customer Firstname</label>

						  <input type="text" class="form-control" id="customer_firstname" name="customer_firstname" placeholder="Enter customer firstname" value="">

						</div>
						
						<div class="form-group">

						  <label>Customer Middlename</label>

						  <input type="text" class="form-control" id="customer_middlename" name="customer_middlename" placeholder="Enter customer middlename" value="">

						</div>
						
						<div class="form-group">

						  <label>Customer Lastname</label>

						  <input type="text" class="form-control" id="customer_lastname" name="customer_lastname" placeholder="Enter customer lastname">

						</div>
						
						
						<div class="form-group">

						  <label>Customer Email</label>

						  <input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Enter customer email">

						</div>
						
						<div class="form-group">

						  <label>Customer Mobile</label>

						  <input type="text" class="form-control" id="customer_mobile" name="customer_mobile" placeholder="Enter customer mobile">

						</div>
						
						<!--<div class="form-group">
							<label>Customer From Resort</label>
							<select name="resort_id" id="resort_name" class="form-control">
								<option value="">Select</option>
								<?php if(!empty($resort_list)){ foreach ($resort_list as $vallist){
								?>
								<option value="<?php echo $vallist->resort_id; ?>"><?php echo $vallist->resort_name; ?></option>
								<?php
								}
								} ?>
							</select>
						</div>-->
						<div class="form-group">								
							<label>Resort Name</label>								
							<select name="resort_name" id="resort_id" class="form-control">
							<option value="">Select Resort</option>
							</select>							
						</div>
						<div class="form-group">
							<label for="catImage">Customer Address</label>
							<textarea class="form-control" id="customer_address" name="customer_address" rows="3"></textarea>
						</div>	
						<div class="form-group">
							<label>Country</label>
							<select name="country_id" id="country_id" class="form-control">
								<option value="">Select</option>
								<?php if(!empty($country_list)){ foreach ($country_list as $countrylist){
								?>
								<option value="<?php echo $countrylist->country_id; ?>"><?php echo $countrylist->country_name; ?></option>
								<?php
								}
								} ?>
							</select>
						</div>
						
						<div class="form-group" id="s1_id">
							<label>State</label>
							<select name="state_id" id="state_id" class="form-control">
							<option value="">Select</option>
							</select>
						</div>
						<div class="form-group" id="s2_id">
							<label>State</label>
							<select name="rf_state_id" id="ss_id" class="form-control">
							<option value="">Select</option>
							<?php if(!empty($state_list)){ foreach ($state_list as $statelist){
								?>
								<option value="<?php echo $statelist->state_id; ?>"><?php echo $statelist->state_name; ?></option>
								<?php
								}
								} ?>
							</select>
							
						</div>
						
						<div class="form-group" id="c1_id">
							<label>City</label>
							<select name="city_id" id="city_id" class="form-control">
							<option value="">Select</option>
							</select>
						</div>
						
						<div class="form-group" id="c2_id">
						<label>City</label>
							<select name="rf_city_id" id="cc_id" class="form-control">
							<option value="">Select</option>
							<?php if(!empty($city_list)){ foreach ($city_list as $citylist){
								?>
								<option value="<?php echo $citylist->city_id; ?>"><?php echo $citylist->city_name; ?></option>
								<?php
								}
								} ?>
							</select>
						</div>
						
						<div class="form-group">

						  <label>Customer Zipcode</label>

						  <input type="text" class="form-control" id="customer_zipcode" name="customer_zipcode" placeholder="Enter customer mobile">

						</div>
						

					  <!-- /.box -->
						<div class="box-footer">

							<input type="submit" class="btn btn-success btn-block" value="Add">

						</div>
					</div>	

					</form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->