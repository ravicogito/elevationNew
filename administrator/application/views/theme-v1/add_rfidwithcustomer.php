<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


	<script>
	function addOption(selectbox, value, text){
		var optn = document.createElement("option");
		optn.text = text;
		optn.value = value;
		selectbox.options.add(optn);
	}
	$('document').ready(function(){
		
		$("#go").click(function() {
		
		  var rfID     = $('#resort_ref_id').val();
		  var rID     = $('#resort_id').val();
		  var lID     = $('#location_id').val();
		//alert(lID +'&&&&'+rfID);
		if(rID == '')
			{
				$("#div_id").css({display: "none"});
				$("#c_rf_id").hide();
				alert('Please select resort');
				$('#resort_ref_id').val('');
				return false;
			}	
		  if(rfID == '')
			{
				alert('Please enter RFID');

				return false;
			}
		else{	

		  $.ajax({
			url: "<?php echo base_url();?>customer/AjaxCustomerList/",
			data:{rfID:rfID,lnID:lID,rstID:rID},
			type: "POST",
			dataType: 'json',
			success:function(responce) {
				//alert(responce['resort_name']);	
				//alert("78"+responce['process']);
				//addOption($("#resort_id").get(0), responce['resort_id'], responce['resort_name']);
						
				if(responce['process'] == 'success') {					
					$("#div_id").css({display: "block"});
					$(".message").html('');
					
					var customer_name 	= responce['customer_firstname'] +' '+ responce['customer_middlename'] +' '+ responce['customer_lastname'];
					$("#customer_list").css({display: "none"});
					$("#customer_name_div").css({display: "block"});							
					$("#customer_email_div").css({display: "block"});					
					$("#customer_mobile_div").css({display: "block"});
					$("#customer_name").val(customer_name);
					$('#customer_name').attr('readonly', true);					
					$("#customer_email").val(responce['customer_email']);
					$('#customer_email').attr('readonly', true);
					$("#customer_mobile").val(responce['customer_mobile']);
					$('#customer_mobile').attr('readonly', true);					
					
					$(".box-footer").css({display: "none"});
					
				}
				else{
					//$(".box-button").css({display: "none"});
						
					alert('Customer not exist against this RFID. Please add customer manually');
					
					$("#div_id").css({display: "block"});
					$("#c_rf_id").hide();
					$("#resort_ref_id").val("");					
					$("#customer_list").css({display: "block"});
					
					$("#customer_name_div").css({display: "none"});
							
					$("#customer_email_div").css({display: "none"});
					
					$("#customer_mobile_div").css({display: "none"});
					
					$("#customer_list_id").get(0).options.length=0;			  
					var arr = new Array();
					
					
					if(responce['customer_data']!="")
					{
					
					arr = responce['customer_data'].split("??");	
					addOption($("#customer_list_id").get(0), "", "Select customer", "");		
					for(var i=0;i<arr.length;i++)
					{
					
					  var brr =  new Array();
					  brr = arr[i].split("|");
					  
					  addOption($("#customer_list_id").get(0), brr[0], brr[1], "");
					}
					}
					$(".box-footer").css({display: "block"});
					
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
			success:function(data){
				//alert(data);
			if(data!="")
			{
				//alert(data['comboVal'] +'67547'+data['resort_data']);				
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
				/*$("#s2_id").css({display: "none"});
				$("#s1_id").css({display: "block"});
				$("#c2_id").css({display: "none"});
				$("#c1_id").css({display: "block"});*/
				$("#resort_id_div").css({display: "block"});
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
		}); 	

		});
		$("#resort_id").unbind().bind("change", function() {
		 $('#resort_ref_id').val('');	
		  var resortID    = $(this).val();
		 //alert(resortID);
		  $.ajax({
			url: "<?php echo base_url();?>customer/populateAjaxRfidByResort/",
			data:{resort:resortID},
			type: "POST",
			dataType:"json",
			success:function(data) {
				//alert("success: " + data);
				
				if(data['comboVal'] == "Y"){						
					$("#ref_id").val(data['resort_data']);
					$("#c_rf_id").show();
					$("#go_div").show();
					$("#div_id").css({display: "none"});
					$(".message").html('');					
					
				}
				else{	
					alert("This resort does not have any RFID.Assign the customer with this resort without RFID.");
					$("#ref_id").val('N'); 
				    $("#c_rf_id").css({display: "none"});	
                    $("#div_id").css({display: "block"});
					$("#customer_list").css({display: "block"});					
					$("#customer_name_div").css({display: "none"});							
					$("#customer_email_div").css({display: "none"});					
					$("#customer_mobile_div").css({display: "none"});				    
					$("#customer_list_id").get(0).options.length=0;			  
					var arr = new Array();				
					
					if(data['customer_data']!="")
					{
					
					arr = data['customer_data'].split("??");	
					addOption($("#customer_list_id").get(0), "", "Select customer", "");		
					for(var i=0;i<arr.length;i++)
					{
					
					  var brr =  new Array();
					  brr = arr[i].split("|");
					  
					  addOption($("#customer_list_id").get(0), brr[0], brr[1], "");
					}
					}
					
				}
			}
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

</style>	
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body">
                    <h3>Assign RFID With Customer</h3>

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

                    <form role="form" method="post" action="<?php echo base_url().'Customer/RfidToCustomer/';?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
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

						<div class="form-group" id="resort_id_div" style="display:none">								
							<label>Resort Name</label>								
							<select name="resort_id" id="resort_id" class="form-control">
							<option value="">Select Resort</option>
							</select>							
						</div>
						
						<div  id='c_rf_id' style="display:none;">
						
						<div class="form-group">

						  <label>Resort RF ID </label>

						  <input type="text" class="form-control" id="resort_ref_id" name="resort_ref_id" placeholder="Enter your RFID">

						</div>						
						
						<div class="box-button" >

							<input type="button" id="go" class="btn btn-success btn-block" value="Go">

						</div>
						<div><span class="message"></span></div>
						
						</div><br>
							
						<div  id='div_id' style="display:none;">
						<div class="form-group" id="customer_list">
							<select name="customer_list_id" id="customer_list_id" class="form-control">
								<option value="">Select</option>
								<?php if(!empty($customer_list)){ foreach ($customer_list as $customerlist){
								?>
								<option value="<?php echo $customerlist['customer_id']; ?>"><?php echo $customerlist['customer_firstname'].' '.$customerlist['customer_middlename'].' '.$customerlist['customer_lastname']; ?></option>
								<?php
								}
								} ?>
							</select>
						  

						</div>
						
						<div class="form-group" id="customer_name_div">

						  <label id="cname">Customer Name</label>

						  <input type="text" class="form-control" id="customer_name" name="customer_firstname" placeholder="Enter customer firstname" value="">

						</div>
						
						<div class="form-group" id="customer_email_div">

						  <label>Customer Email</label>

						  <input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Enter customer email">

						</div>
						
						<div class="form-group" id="customer_mobile_div">

						  <label>Customer Mobile</label>

						  <input type="text" class="form-control" id="customer_mobile" name="customer_mobile" placeholder="Enter customer mobile">

						</div>
						<div class="box-footer" id="assign_btn">

							<input type="submit" class="btn btn-success btn-block" value="Assign">

						</div>
						
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>