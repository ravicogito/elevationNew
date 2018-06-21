<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script>
(function($){
	$(document).ready( function(){
		$('#example').DataTable();
	});
 })(jQuery)
</script>
  
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>
       Event Feedback
      
      </h1>
    <div class="box-tools pull-right">
                     
	  <a class="btn btn-block btn-default" style="margin-bottom: 10px;background-color:#99cc00" href="<?php echo base_url().'member/downloadFeedbackList/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Download Feedback list</a>
	</div>  
    </section>
	<?php if($this->session->flashdata('success')!=""){?>
   <p class="whtreq" style="margin-left:20px;color:green"><?php echo $this->session->flashdata('success'); ?></p>
    <?php } ?>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			  <thead>
				<tr>
					<th>#</th>
					<th>Event Name</th>
					<th>User Name</th>
					<th>Overall Event Rate</th>
					<th>Timing Rate</th>					
					<th>Entertainment Rate</th>
					<th>Food Rate</th>
					<th>Parking Rate</th>
					<th>Gestlist Rate</th>
					<th>Facility Venue Rate</th>
					<th>Pricing Rate</th>
					<th>Vendor Mng Rate</th>
					<th>Attend Future Events</th>
					<th>Food Quality Rate</th>
					<th>Overall Services Quality</th>
					<th>Cleanliness Rate</th>
					<th>Order Accuracy Rate</th>
					<th>Speed Srvc Rate</th>
					<th>Value Rate</th>
					<th>Overall Experience</th>
					<th>Overall Experience Guest</th>
					<th>Order Accuracy Rate</th>	
					<th>Improve Suggestions</th>
					<th>Feedback Date</th>					
				</tr>
			  </thead>

			  <tbody>
				<?php 
				if(!empty($allFeedback)){
				$i=1;
				foreach($allFeedback as $feedback_list) { ?>
				<tr>
				  <td><?php echo $i; ?></td>
				  <td><?php echo $feedback_list['event_name']; ?></td>
				  <td><?php echo $feedback_list['user_title'].' '. $feedback_list['user_firstname'].' '.$feedback_list['user_middlename'].' '. $feedback_list['user_lastname']; ?></td>
				  <td><?php echo $feedback_list['overall_event_rate']; ?></td>				 
				  <td><?php if(!empty($feedback_list['timing_rate']) && $feedback_list['timing_rate'] != 'NoOpinion'){ echo $feedback_list['timing_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['entertainment_rate']) && $feedback_list['entertainment_rate'] != 'NoOpinion'){ echo $feedback_list['entertainment_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['food_rate']) && $feedback_list['food_rate'] != 'NoOpinion'){ echo $feedback_list['food_rate']; } else{ echo 'No Opinion' ;}?></td>				 
				  <td><?php if(!empty($feedback_list['parking_rate']) && $feedback_list['parking_rate'] != 'NoOpinion'){ echo $feedback_list['parking_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['guestlist_rate'])&& $feedback_list['guestlist_rate'] != 'NoOpinion'){ echo $feedback_list['guestlist_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['facility_venue_rate']) && $feedback_list['facility_venue_rate'] != 'NoOpinion'){ echo $feedback_list['facility_venue_rate']; } else{ echo 'No Opinion' ;}?></td>				 
				  <td><?php if(!empty($feedback_list['pricing_rate']) && $feedback_list['pricing_rate'] != 'NoOpinion'){ echo $feedback_list['pricing_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['vendor_mng_rate']) && $feedback_list['vendor_mng_rate'] != 'NoOpinion'){ echo $feedback_list['vendor_mng_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['attend_ftur_events']) && $feedback_list['attend_ftur_events'] != 'NoOpinion'){ echo $feedback_list['attend_ftur_events']; } else{ echo 'No Opinion' ;}?></td>				 
				  <td><?php if(!empty($feedback_list['food_quality_rate']) && $feedback_list['food_quality_rate'] != 'NoOpinion'){ echo $feedback_list['food_quality_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['overall_services_quality']) && $feedback_list['overall_services_quality'] != 'NoOpinion'){ echo $feedback_list['overall_services_quality']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['cleanliness_rate']) && $feedback_list['cleanliness_rate'] != 'NoOpinion'){ echo $feedback_list['cleanliness_rate']; } else{ echo 'No Opinion' ;}?></td>
				
				  <td><?php if(!empty($feedback_list['order_accuracy_rate']) && $feedback_list['order_accuracy_rate'] != 'NoOpinion'){ echo $feedback_list['order_accuracy_rate']; } else{ echo 'No Opinion' ;}?></td>				 
				  <td><?php if(!empty($feedback_list['speed_srvc_rate']) && $feedback_list['speed_srvc_rate'] != 'NoOpinion'){ echo $feedback_list['speed_srvc_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['value_rate'])&& $feedback_list['value_rate'] != 'NoOpinion'){ echo $feedback_list['value_rate']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['overall_experience']) && $feedback_list['overall_experience'] != 'NoOpinion'){ echo $feedback_list['overall_experience']; } else{ echo 'No Opinion' ;}?></td>				 
				  <td><?php if(!empty($feedback_list['overall_experience_guest']) && $feedback_list['overall_experience_guest'] != 'NoOpinion'){ echo $feedback_list['overall_experience_guest']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['fav_part_event'])){ echo $feedback_list['fav_part_event']; } else{ echo 'No Opinion' ;}?></td>
				  <td><?php if(!empty($feedback_list['improve_suggestions'])){ echo $feedback_list['improve_suggestions']; } else{ echo 'No Suggession' ;}?></td>				 
				  <td><?php if(!empty($feedback_list['feedback_date'])){ echo date("d-m-Y", strtotime(str_replace("/", "-", $feedback_list['feedback_date']))); }?></td>
				  
				  
				  
				</tr>
			  
			   <?php $i++; } } else { ?>

				<tr>
					 <td colspan="5" align="center"> There is no member on this all Member Lists.</td>
				</tr>

			   <?php } ?>
			  </tbody>

			</table>
					
		  </div>
        </div>
                  
	  </div>
               
	</section>
              
  </div>
  
 <script>

function loginUser(mobile,password){
	
	var login_mobile = mobile;
	//alert(login_mobile);
	//return false
	var login_password = password;
	
	jQuery("#txtlogindata").feedback_list(login_mobile);
	jQuery("#txtpassword").feedback_list(login_password);
	
	$("#frmlogin").submit();
	
}
 </script>