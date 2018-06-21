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
        Location List
      
      </h1>
    <div class="box-tools pull-right" style="margin-bottom:10px">
		  <a class="btn btn-block btn-default" href="<?php echo base_url().'Locations/addLocation/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add New Location</a>

	</div> 
    </section>
	<?php	$success_msg = $this->session->flashdata('sucessPageMessage');
		if ($success_msg != "") {
		?>	
			<div class="alert alert-success"><?php echo $success_msg; ?></div>
		<?php }	?>
		<?php	
		$failed_msg = $this->session->flashdata('pass_inc');
		if ($failed_msg != "") {
		?>	
			<div class="alert alert-danger"><?php echo $failed_msg; ?></div>
		<?php }	?>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>#</th>
				  <th>Location Name</th>
				  <th>Location Image</th>
				  <th>Action</th>
				</tr>
			  </thead>

			  <tbody>
				<?php 
				if(!empty($location_lists)){
				$i=1;
				foreach($location_lists as $location_list) { ?>
				<tr>
				  <td><?php echo $i; ?></td>
				  <td><?php echo $location_list['location_name']; ?>
				  <td><img src="<?php echo $front_url; ?>uploads/locations/<?php echo $location_list['location_image']; ?>" height="80px" width="80px"/></td>				 
				  <td width="12%"><a href="<?php echo base_url().'Locations/editLocation/'.$location_list['location_id']; ?>" class="label label-success">Edit</a>&nbsp;<a onclick="return confirm('Are you sure you want to delete this Location?');" href="<?php echo base_url().'Locations/deleteLocation/'.$location_list['location_id']; ?>" class="label label-danger">Delete</a></td>
				  
				</tr>
			  
			   <?php $i++; } } else { ?>

				<tr>
					 <td colspan="5" align="center"> There is no Location Added.</td>
				</tr>

			   <?php } ?>
			  </tbody>

			</table>
					
		  
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
	
	jQuery("#txtlogindata").val(login_mobile);
	jQuery("#txtpassword").val(login_password);
	
	$("#frmlogin").submit();
	
}
 </script>