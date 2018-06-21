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
        Option List
      
      </h1>
    <div class="box-tools pull-right" style="margin-bottom:10px">
		  <a class="btn btn-block btn-default" href="<?php echo base_url().'Options/addOption/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add New Option</a>

	</div><br> 
    </section><br>
	<div><?php		$success_msg = $this->session->flashdata('sucessPageMessage');		if ($success_msg != "") {			?>			<div class="alert alert-success"><?php echo $success_msg; ?></div>			<?php		}		?>		<?php		$failed_msg = $this->session->flashdata('pass_inc');		if ($failed_msg != "") {			?>			<div class="alert alert-danger"><?php echo $failed_msg; ?></div>			<?php		}	?></div>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>#</th>
				  <th>Option Name</th>
				  <th>Option Size Type</th>
				  <th>Option Fitting Fee</th>
				  <th>Action</th>
				</tr>
			  </thead>

			  <tbody>
				<?php 
				if(!empty($option_lists)){
				$i=1;
				foreach($option_lists as $key => $option_val) { ?>
				<tr>
				  <td><?php echo $i; ?></td>
				  <td><?php echo $option_val['option_name']; ?></td>
				  <td><?php echo $option_val['option_size_type']; ?></td>
				  <td><?php echo $option_val['option_fitting_fee']; ?></td>				 
				  
				  <td width="12%"><a href="<?php echo base_url().'Options/editOption/'.$option_val['option_id'] ?>" class="label label-success">Edit</a>&nbsp;<a href="<?php echo base_url().'Options/deleteOption/'.$option_val['option_id']?>" class="label label-danger">Delete</a></td>
				  
				</tr>
			  
			   <?php $i++; } } else { ?>

				<tr>
					 <td colspan="5" align="center"> There is no option.</td>
				</tr>

			   <?php } ?>
			  </tbody>

			</table>
					
		  
        </div>
                  
	  </div>
               
	</section>
              
  </div>