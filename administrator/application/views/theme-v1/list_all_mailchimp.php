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
        Mailchimp List
      
      </h1>
    <div class="box-tools pull-right" style="margin-bottom:10px">
		  <a class="btn btn-block btn-default" href="<?php echo base_url().'Mailchimp/addmailchimp/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add New Mailchimp</a>

	</div><br> 
    </section>
	<?php		
		$success_msg = $this->session->flashdata('sucessPageMessage');
		if ($success_msg != "") {
	?>
		<div class="alert alert-success"><?php echo $success_msg; ?></div>
	<?php
		}
	?>
	
	<?php
		$failed_msg = $this->session->flashdata('failedPageMessage');
		if ($failed_msg != "") {
	?>
	<div class="alert alert-danger">
		<?php echo $failed_msg; ?>
	</div>
	<?php
		}
	?>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>#</th>
				  <th>Mailchimp Title</th>
				  <th>Mailchimp Content</th>
				  <th>Mailchimp Creation Date</th>
				  <th>Action</th>
				</tr>
			  </thead>

			  <tbody>
				<?php 
				if(!empty($mailchimp_lists)){
				$i=1;
				foreach($mailchimp_lists as $mailchimp_list) { ?>
				<tr>
				  <td><?php echo $i; ?></td>
				  <td><?php echo $mailchimp_list['title']; ?></td>
				  <td><?php echo $mailchimp_list['content']; ?></td>
				  <td><?php echo $mailchimp_list['creation_date']; ?></td>
				  <td width="12%">
					<a href="<?php echo base_url()."Mailchimp/addmailchimp/".$mailchimp_list['id']; ?>" class="label label-success">Edit</a>&nbsp;
					<a href="<?php echo base_url()."Mailchimp/deletemailchimp/".$mailchimp_list['id']; ?>" class="label label-danger">Delete</a>
					<?php if($mailchimp_list['status'] == 1): ?>
						<a  href="<?php echo base_url()."Mailchimp/unpublishmailchimp/".$mailchimp_list['id']; ?>"class="label label-danger">UnPublish</a>
					<?php else: ?>
						<a href="<?php echo base_url()."Mailchimp/publishmailchimp/".$mailchimp_list['id']; ?>" class="label label-success">Publish</a>
					<?php endif; ?>
				  </td>
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