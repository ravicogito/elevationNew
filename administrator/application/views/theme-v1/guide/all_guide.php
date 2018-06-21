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
        Guide List
      
      </h1>
   <!-- <div class="box-tools pull-right" style="margin-bottom:10px">
		  <a class="btn btn-block btn-default" href="<?php echo base_url().'Guide/guideManagementadd/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add New Guide</a>

	</div> -->
    </section>
	<?php	$success_msg = $this->session->flashdata('ins_success');
		if ($success_msg != "") {
		?>	
			<div class="alert alert-success"><?php echo $success_msg; ?></div>
		<?php }	?>
		<?php	
		$failed_msg = $this->session->flashdata('ins_failed');
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
				  <th>Guide Name</th>
				  <!--<th>Action</th>-->
				</tr>
			  </thead>

			  <tbody>
				<?php 
				if(!empty($all_guides)){
				$i=1;
				foreach($all_guides as $all_guide) { ?>
				<tr>
				  <td><?php echo $i; ?></td>
				  <td><?php echo $all_guide['guide_name']; ?></td>			 
				  <!--<td width="12%"><a href="<?php echo base_url().'Guide/guideManagementadd/'.$all_guide['guide_id']; ?>" class="label label-success">Edit</a>&nbsp;
				  
				  <a onclick="return confirm('Are you sure you want to delete this Guide?');" href="<?php echo base_url().'Guide/deleteGuide/'.$all_guide['guide_id']; ?>" class="label label-danger">Delete</a></td>-->
				  
				</tr>
			  
			   <?php $i++; } } else { ?>

				<tr>
					 <td colspan="5" align="center">There is no Guide Added.</td>
				</tr>

			   <?php } ?>
			  </tbody>

			</table>
					
		  
        </div>
                  
	  </div>
               
	</section>
              
  </div>
  
 