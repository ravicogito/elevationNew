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
        Assign Event To Customer
      
      </h1>
    <div class="box-tools pull-right" style="margin-bottom:10px">
		  <a class="btn btn-block btn-default" href="<?php echo base_url().'Event/EventToCustomer/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Assign Customer</a>

	</div><br> 
    </section><br>
	<div>
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
	<?php		}	?>
	</div>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>#</th>
				  <th>Customer Name</th>
				  <th>Event Name</th>
				  <th>Photographer Name</th>
				  <th>Resort Name</th>
				  <th>Location Name</th>
				 
				  <th>Action</th>
				</tr>
			  </thead>

			  <tbody>
				<?php 
				if(!empty($customer_location_event_relations)){
				$i=1;
				foreach($customer_location_event_relations as $customer_location_event_relation) { ?>
				<tr>
				  <td><?php echo $i; ?></td>
				  <td><?php echo $customer_location_event_relation['customer_firstname']; ?>
				  <?php echo $customer_location_event_relation['customer_middlename']; ?> <?php echo $customer_location_event_relation['customer_lastname']; ?></td>
				  <td><?php echo $customer_location_event_relation['event_name']; ?></td>
				  <td><?php echo $customer_location_event_relation['photographer_name']; ?></td>				 
				  <td><?php echo $customer_location_event_relation['resort_name']; ?></td>
				  <td><?php echo $customer_location_event_relation['location_name']; ?></td>
				  
				  <td width="12%"><a href="<?php echo base_url().'Event/deleteAssigneventCustomer/'.$customer_location_event_relation['customer_location_event_id']?>" class="label label-danger">Delete</a></td>
				  
				</tr>
			  
			   <?php $i++; } } else { ?>

				<tr>
					 <td colspan="5" align="center"> There is no customer.</td>
				</tr>

			   <?php } ?>
			  </tbody>

			</table>
					
		  
        </div>
                  
	  </div>
               
	</section>
              
  </div>