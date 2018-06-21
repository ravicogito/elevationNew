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
			  url:"<?php echo base_url(); ?>Register/populateAjaxbyStateCity",
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
			  url:"<?php echo base_url(); ?>Register/populateAjaxbyStateCity",
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
		
		 $("#customer_email").blur(function(){
			var customer_email = $("#customer_email").val();
			//alert(customer_email);
			$.ajax({
			  type:"POST",
			  url:"<?php echo base_url(); ?>Register/checkUser",
			  dataType:"json",
			  data:
			  {
				  customer_email:customer_email,
			  },
			  success:function(response)
			  {
				  //alert(response.customer_firstname);
				  //return false;
				 if(response.customer_data == 'true'){
					  alert("This Email id Already Exist in database");
					  return false;
				  }
				
			  },
		  });
		 });
	});

	
	
	function Checkingform(customer)
	{
			
			var customer_firstname 	= jQuery(customer).find('#customer_firstname').val();
			var customer_lastname 	= jQuery(customer).find('#customer_lastname').val();			
			var email 				= jQuery(customer).find('#customer_email').val();
			
			var customer_mobile		= jQuery(customer).find('#customer_mobile').val();		
			var customer_address	= jQuery(customer).find('#customer_address').val();
			var country_id			= jQuery(customer).find('#country_id').val();
			var state_id			= jQuery(customer).find('#state_id').val();
			var city_id				= jQuery(customer).find('#city_id').val();
			var customer_zipcode	= jQuery(customer).find('#customer_zipcode').val();
			var customer_newpass	= jQuery(customer).find('#customer_newpass').val();
			var customer_renewpass	= jQuery(customer).find('#customer_renewpass').val();
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			
			//var postcontent = $("#editorContainer iframe").contents().find("body").text();
            
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
			
			if (reg.test(email) == false) 
			{
				alert('Invalid Email Address');
				return false;
			}
			
			
			if(customer_mobile == '' || !(customer_mobile.match('[0-9]{10}')))  
			{       alert("Please put 10 digit mobile number");            				
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
			
			if(customer_newpass.length < 4)
			{
				alert("Please enter password atleast 4 digit");
            
				return false;
			}
			
			if(customer_newpass != customer_renewpass)
			{
				alert("Both You password are not match");
            
				return false;
			}
			
			if(customer_zipcode == '')  {
                alert("Please put zipcode");
            
				return false;
			}
			
	}

	</script>
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body">
                    <h3>Registration</h3>

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

                    <form role="form" method="post" action="<?php echo base_url().'Register/';?>" onsubmit ="return Checkingform(this);">
						<!-- text input -->
						
						<div  id='div_id'>
						
						<div class="form-group">

						  <label>User Email</label>

						  <input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Enter Your email" value="<?=$this->session->flashdata('customer_email') ? $this->session->flashdata('customer_email') : '' ?>">
						  
						  <input type="hidden" class="form-control" id="customer_hidds" name="customer_hidds">

						</div>

						<div class="form-group">

						  <label id="cname">User Firstname</label>

						  <input type="text" class="form-control" id="customer_firstname" name="customer_firstname" placeholder="Enter Your firstname" value="<?=$this->session->flashdata('customer_firstname') ? $this->session->flashdata('customer_firstname') : '' ?>">

						</div>
						
						<div class="form-group" id="customer_lastname_div">

						  <label>User Lastname</label>

						  <input type="text" class="form-control" id="customer_lastname" name="customer_lastname" placeholder="Enter Your lastname" value="<?=$this->session->flashdata('customer_lastname') ? $this->session->flashdata('customer_lastname') : '' ?>">

						</div>
						
						
						<div class="form-group">

						  <label>User Mobile</label>

						  <input type="text" class="form-control" id="customer_mobile" name="customer_mobile" placeholder="Enter Your mobile" value="<?=$this->session->flashdata('customer_mobile') ? $this->session->flashdata('customer_mobile') : '' ?>">

						</div>						
						
						<div class="form-group" id="customer_zipcode_div">

						  <label>New Password</label>

						  <input type="password" class="form-control" id="customer_newpass" name="customer_newpass" placeholder="Enter Your New Password">

						</div>
						
						<div class="form-group" id="customer_zipcode_div">

						  <label>ReEnter New Password</label>

						  <input type="password" class="form-control" id="customer_renewpass" name="customer_renewpass" placeholder="ReEnter Your New Password">

						</div>
						
						<div class="box-footer">

							<input type="submit" class="btn btn-success btn-block" value="Register" style="width: 60%; margin: 0 auto;">

						</div>
					</div>	

					</form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>