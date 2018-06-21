<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>(function($){
	$(document).ready( function(){	
		$('#example').DataTable();
		}); 
	})
	(jQuery)
</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>Rafting Company List</h1> 
	<?php  
	$success_msg = $this->session->flashdata('sucessPageMessage');
	if ($success_msg != "") { 
	?>  
	<div class="alert alert-success"><?php echo $success_msg; ?></div>                        <?php } ?>  
	<?php 	
	$failed_msg = $this->session->flashdata('pass_inc'); 
	if ($failed_msg != "") { ?> 
	<div class="alert alert-danger"><?php echo $failed_msg; ?></div>                        <?php } ?>
	<!--<div class="box-tools pull-right" style="margin-bottom:10px">
	<a class="btn btn-block btn-default" href="<?php echo base_url().'Riverraftingcompany/addRaftingcompany/'; ?>">
	<i class="fa fa-plus-square"></i>&nbsp;Add New Rafting Company</a>	
	</div>-->     
    </section>
    <!-- Main content -->
     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         
 <!-- Default box --> <!-- ********************** GRID LAYOUT **********************-->
  <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">	<thead>
	<tr>
	  <th>#</th>
	  <th>Rafting Company Name</th>	  
	  <!--<th>Rafting Company Email</th>	  
	  <th>Rafting Company Mobile</th>	
	  <th>Action</th>-->
	</tr>	
	</thead>	
	<tbody>
	<?php 
	if(!empty($raftingcompany_list)){
	$i=1;
	foreach($raftingcompany_list as $list) { ?>
	<tr>
	  <td width="11%"><?php echo $i; ?></td>
	  <td width="16%"><?php echo $list->raftingcompany_name; ?></td>
	  <!--<td width="16%"><?php echo $list->raftingcompany_email; ?></td>
	  <td width="16%"><?php echo $list->raftingcompany_mobile; ?></td>-->
	 <!-- <td width="12%">
	  <a href="<?php echo base_url().'Riverraftingcompany/editRaftingCompany/'.$list->raftingcompany_id; ?>" class="label label-success">Edit</a>
	  &nbsp;
	  <a onclick="return confirm('Are you sure you want to delete this Rafting Company?');" href="<?php echo base_url().'Riverraftingcompany/deleteRaftingCompany/'.$list->raftingcompany_id; ?>" class="label label-danger">Delete</a></td>-->
	</tr>
  
   <?php $i++; } } else { ?>

	<tr>
		 <td colspan="5" align="center"> There is no Rafting Company Added.</td>
	</tr>

   <?php } ?>
   </tbody>

  </table>
</div>
<!-- /.box-body -->
</div><!-- ******************** END **************************--></section> </div>