<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	 <script>
		$('document').ready(function(){
			
		$("#location_id").unbind().bind("change", function() {
		  var locationID     = $(this).val();
		  
		  $.ajax({
			url: "<?php echo base_url();?>customer/Ajaxlocationwiserf/",
			data:{location:locationID},
			type: "POST",
			dataType:"HTML",
			success:function(data) {
			  if(data!="")
			  {
				if(data=='Y')
				{
					$("#ref_id").val(data);
					$("#c_rf_id").css({display: "block"});
					$("#div_id").css({display: "block"});
				}
				else
				{
				   $("#ref_id").val(data);	
				   $("#c_rf_id").css({display: "none"});	
				   $("#div_id").css({display: "block"});
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
			var resort_id			= jQuery(customer).find('#resort_id').val();			
			var customer_address	= jQuery(customer).find('#customer_address').val();
			var location_id			= jQuery(customer).find('#location_id').val();
			var country_id			= jQuery(customer).find('#country_id').val();
			var state_id			= jQuery(customer).find('#state_id').val();
			var city_id				= jQuery(customer).find('#city_id').val();
			var customer_zipcode	= jQuery(customer).find('#customer_zipcode').val();

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
			
			if(atpos==0 || dotpos==0 || atlastpos==email.length-1 || dotlastpos==email.length-1 || atpos+1==dotpos || atpos-1==dotpos || atpos==-1 || dotpos==-1 || email=="" || dotlastpos==-1 || atlastpos==-1 || atpos!=atlastpos)
			{
				alert('Please put a valid email');
				return false;
			}
			
			if(customer_mobile == '' || !(customer_mobile.match('[0-9]{10}')))  {
                alert("Please put 10 digit mobile number");
            
				return false;
			}
			
			if(resort_id == '')
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
		

      </script>

<style>
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
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body">
                    <h3>Edit Customer Details</h3>
                    <hr>
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

                    <form role="form" method="post" action="<?php if(!empty($customer_data['customer_id'])){ echo base_url().'Customer/updateCustomer/'.$customer_data['customer_id']; } ?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
						<input type="hidden" name="ref_id" id="ref_id" value="" />
						<div class="form-group">

						  <label>Select Location</label>

						  <select name="location_id" id="location_id" class="form-control" readonly>
								<option value="">Select</option>
									<?php if(!empty($location_list)){ foreach ($location_list as $vallist){
									?>
									<option value="<?php echo $vallist->location_id; ?>" <?php if(!empty($customer_data['location_id'])){ echo ($vallist->location_id == $customer_data['location_id'])?'selected':''; }?>><?php echo $vallist->location_name; ?></option>
									<?php
									}
									} ?>
							</select>

						</div>
						<div  id='c_rf_id' style="<?php if($customer_data['cust_rf_id']!="0"){?>display:block;<?php } else {?>display:none;<?php } ?>">
						<div class="form-group">

						  <label>RFID </label>

						  <input type="text" class="form-control" id="customer_ref_id" name="customer_ref_id" value="<?php if(!empty($customer_data['cust_rf_id'])){ echo $customer_data['cust_rf_id'];}?>" readonly>

						</div>
						</div>
						
						<div  id='div_id' style="display:block;">

						<div class="form-group">

						  <label>Customer Firstname</label>

						  <input type="text" class="form-control" id="customer_firstname" name="customer_firstname" value="<?php if(!empty($customer_data['customer_firstname'])){ echo $customer_data['customer_firstname'];}?>">

						</div>
						
						<div class="form-group">

						  <label>Customer Middlename</label>

						  <input type="text" class="form-control" id="customer_middlename" name="customer_middlename" value="<?php if(!empty($customer_data['customer_middlename'])){ echo $customer_data['customer_middlename'];}?>">

						</div>
						
						<div class="form-group">

						  <label>Customer Lastname</label>

						  <input type="text" class="form-control" id="customer_lastname" name="customer_lastname" value="<?php if(!empty($customer_data['customer_lastname'])){ echo $customer_data['customer_lastname'];}?>">

						</div>
						
						
						<div class="form-group">

						  <label>Customer Email</label>

						  <input type="text" class="form-control" id="customer_email" name="customer_email" value="<?php if(!empty($customer_data['customer_email'])){ echo $customer_data['customer_email'];}?>">

						</div>
						
						<div class="form-group">

						  <label>Customer Mobile</label>

						  <input type="text" class="form-control" id="customer_mobile" name="customer_mobile" value="<?php if(!empty($customer_data['customer_mobile'])){ echo $customer_data['customer_mobile'];}?>">

						</div>
						
						<div class="form-group">
								<label>Customer From Resort</label>
								<select name="resort_name" id="resort_id" class="form-control">
									<option value="">Select</option>
									<?php if(!empty($resort_list)){ foreach ($resort_list as $vallist){
									?>
									<option value="<?php echo $vallist['resort_id']; ?>" <?php if(!empty($customer_data['resort_id'])){ echo ($vallist['resort_id'] == $customer_data['resort_id'])?'selected':''; }?>><?php echo $vallist['resort_name']; ?></option>
									<?php
									}
									} ?>
								</select>
						</div>
						<div class="form-group">
							<label for="catImage">Customer Address</label>
							<textarea class="form-control" id="customer_address" name="customer_address" rows="3"><?php if(!empty($customer_data['customer_address'])){ echo $customer_data['customer_address'];}?></textarea>
						</div>	
						<div class="form-group">
							<label>Country</label>
							<select name="country_id" id="country_id" class="form-control">
								<option value="">Select</option>
								<?php if(!empty($country_list)){ foreach ($country_list as $countrylist){
								?>
								<option value="<?php echo $countrylist->country_id; ?>" <?php if(!empty($customer_data['customer_country_id'])){ echo ($countrylist->country_id == $customer_data['customer_country_id'])?'selected':''; }?>><?php echo $countrylist->country_name; ?></option>
								<?php
								}
								} ?>
							</select>
						</div>
						
						<div class="form-group">
							<label>State</label>
							<select name="state_id" id="state_id" class="form-control">
                  
							  <option value="">State Name...</option>
							  <?php if(!empty($state_list)){ foreach ($state_list as $statelist){
								?>
								<option value="<?php echo $statelist->state_id; ?>" <?php if(!empty($customer_data['customer_state_id'])){ echo ($statelist->state_id == $customer_data['customer_state_id'])?'selected':''; }?>><?php echo $statelist->state_name; ?></option>
								<?php
								}
								} ?>
							  
							</select>
						</div>
						
						<div class="form-group">
							<label>City</label>
							<select name="city_id" id="city_id" class="form-control">
                  
							  <option value="">City Name...</option>
							  <?php if(!empty($city_list)){ foreach ($city_list as $citylist){
								?>
								<option value="<?php echo $citylist->city_id; ?>" <?php if(!empty($customer_data['customer_city_id'])){ echo ($citylist->city_id == $customer_data['customer_city_id'])?'selected':''; }?>><?php echo $citylist->city_name; ?></option>
								<?php
								}
								} ?>
							  
							</select>
						</div>
						
						<div class="form-group">

						  <label>Customer Zipcode</label>

						  <input type="text" class="form-control" id="customer_zipcode" name="customer_zipcode" value="<?php if(!empty($customer_data['customer_zipcode'])){ echo $customer_data['customer_zipcode'];}?>">

						</div>
						

					  <!-- /.box -->
						<div class="box-footer">

							<input type="submit" class="btn btn-success btn-block" value="Update">

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