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
        Role List
      
      </h1>
    <div class="box-tools pull-right" style="margin-bottom:10px">
		  <a class="btn btn-block btn-default" href="<?php echo base_url().'Role/addRole/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add New Role</a>

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
				  <th>Role Name</th>
				  <th>Action</th>
				</tr>
			  </thead>

			  <tbody>
				<?php 
				if(!empty($role_lists)){
				$i=1;
				foreach($role_lists as $role_list) { ?>
				<tr>
				  <td><?php echo $i; ?></td>
				  <td><?php echo $role_list['role_name']; ?>
				  <td width="12%"><a href="<?php echo base_url().'Role/editRole/'.$role_list['role_id']; ?>" class="label label-success">Edit</a></td>
				  
				</tr>
			  
			   <?php $i++; } } else { ?>

				<tr>
					 <td colspan="5" align="center"> There is no Role Added.</td>
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