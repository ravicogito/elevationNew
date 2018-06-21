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
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>
	Customer Image List     
	</h1>		<div class="box-tools pull-right" style="margin-bottom:10px">		<a class="btn btn-block btn-default" href="<?php echo base_url().'customerImageUpload/addImage/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add New Images</a>	</div>	
     
    </section>

    <!-- Main content -->
     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
		
			<?php
					 $errMsg = $this->session->flashdata('errorPageMessage');
					 $successMsg =  $this->session->flashdata('sucessPageMessage');
				   if(!empty($successMsg)) { ?>

				   <div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $successMsg; ?>
						</div>

				  <?php } ?>
				  <?php if(!empty($errMsg)) { ?>

				   <div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $errMsg; ?>
						</div>

				  <?php } ?>
         
               <!-- Default box -->
<!-- ********************** GRID LAYOUT **********************-->

	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	 <thead>
		<tr>
		  <th>#</th>
		  <th>Customer Name</th>		  		   
		  <th>Photographer Name</th>
		  <th>Album Title </th>		  		  
		  <th>Album Type </th>		  		  
		  <th>Album Path </th>		  		  
		  <th>Album Upload Date</th>
		  <th>Action</th>
		</tr>
	 </thead>
	 <tbody>
		<?php 
		if(!empty($image_lists)){
		$i=1;
		foreach($image_lists as $list) { ?>
		<tr>
		  <td><?php echo $i; ?></td>
		  <td><?php echo $list->customer_firstname; ?></td>
		  <td><?php echo $list->photographer_name; ?></td>		  
		  <td><?php echo $list->media_title; ?></td>
		  <td><?php echo $list->media_type; ?></td>		  		  
		  <td><?php echo $list->media_path; ?></td>		  		  
		  <td><?php echo date('d-m-Y',strtotime($list->upload_date)); ?></td>		  
		  <td width="13%"><a  href="<?php echo base_url().'customerImageUpload/viewImage/'.$list->customer_id; ?>" class="label label-success">View</a></td>
		  </tr>
	  
	   <?php $i++; } } else { ?>

		<tr>
			 <td colspan="7" align="center"> There is no Gallery Added.</td>
		</tr>

	   <?php } ?>
	 </tbody>
	</table>
</div>
<!-- /.box-body -->
</div>
<!-- ******************** END **************************--></section> </div>