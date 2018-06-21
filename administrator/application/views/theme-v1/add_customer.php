<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->


	<script>
	function addOption(selectbox, value, text){
		var optn = document.createElement("option");
		optn.text = text;
		optn.value = value;
		selectbox.options.add(optn);
	}
	$('document').ready(function(){
		
		$("#country_id").unbind().bind("change", function() {
		  var countryID     = $(this).val();
		  
		$('#state_id')

			.find('option')

			.remove()

			.end();
		
		  $.ajax({
			  type:"POST",
			  url:"<?php echo base_url(); ?>Customer/populateAjaxbyStateCity",
			  data:
			  {
				  country_id:countryID
			  },
			  success:function(response)
			  {
					var $options = [];
				    $("<option></option>", {value: '', text: 'Select'}).appendTo('#state_id');
					$.each( response, function( key, value ) {

					  var state_name = response[key].state_name;

					  var state_id = response[key].state_id;
						
						$("<option></option>", {value: state_id, text: state_name}).appendTo('#state_id');

					});
			  },
		  });
		});
		
		 $("#state_id").unbind().bind("change", function() {
		  var stateID     = $(this).val();
		  var country_id  = $("#country_id").val();
		  
		  $('#city_id')

			.find('option')

			.remove()

			.end();
		
		  $.ajax({
			  type:"POST",
			  url:"<?php echo base_url(); ?>Customer/populateAjaxbyStateCity",
			  data:
			  {
				  country_id_for_city:country_id,
				  state_id_for_city:stateID,
			  },
			  success:function(response)
			  {
					var $options = [];
				    $("<option></option>", {value: '', text: 'Select'}).appendTo('#city_id');
					$.each( response, function( key, value ) {

					  var city_name = response[key].city_name;

					  var city_id = response[key].city_id;
						
						$("<option></option>", {value: city_id, text: city_name}).appendTo('#city_id');

					});
			  },
		  });
		});
	});

	
	
	function Checkingform(customer)
	{
			var location_id 		= jQuery(customer).find('#location_id').val();
			var ref_id              = jQuery(customer).find('#ref_id').val();  
			var resort_ref_id 	= jQuery(customer).find('#resort_ref_id').val();
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
				if(resort_ref_id == '')
				{
					alert('Please put resort RF ID');

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
						
						<div  id='div_id'>

						<div class="form-group">

						  <label id="cname">Customer Firstname</label>

						  <input type="text" class="form-control" id="customer_firstname" name="customer_firstname" placeholder="Enter customer firstname" value="">

						</div>
						
						<div class="form-group" id="customer_middlename_div">

						  <label>Customer Middlename</label>

						  <input type="text" class="form-control" id="customer_middlename" name="customer_middlename" placeholder="Enter customer middlename" value="">

						</div>
						
						<div class="form-group" id="customer_lastname_div">

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
						<div class="form-group" id="customer_address_div">
							<label for="catImage">Customer Address</label>
							<textarea class="form-control" id="customer_address" name="customer_address" rows="3"></textarea>
						</div>	
						<div class="form-group" id="country_id_div">
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
						<!--<div class="form-group" id="s2_id">
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
							
						</div>-->
						
						<div class="form-group" id="c1_id">
							<label>City</label>
							<select name="city_id" id="city_id" class="form-control">
							<option value="">Select</option>
							</select>
						</div>
						
						<!--<div class="form-group" id="c2_id">
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
						</div>-->
						
						<div class="form-group" id="customer_zipcode_div">

						  <label>Customer Zipcode</label>

						  <input type="text" class="form-control" id="customer_zipcode" name="customer_zipcode" placeholder="Enter customer mobile">

						</div>

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