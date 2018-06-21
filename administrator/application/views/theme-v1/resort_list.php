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
	Resort List 
	</h1>

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
	<div class="box-tools pull-right" style="margin-bottom:10px">
		  <a class="btn btn-block btn-default" href="<?php echo base_url().'Resort/addResort/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add New Resort</a>
	</div> 
    </section>
    <section class="content">

      <div class="row">

        <div class="col-md-12">

         

			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">

				<thead>
				<tr>
				  <th>#</th>
				  <th>Resort Name</th>
				  <th>Resort Description</th>
				  <th>Resort Contact no.</th>
				  <th>Resort Email</th>
				  <th>Resort Contact Person</th>
				  <th>Resort RFID Exist?</th>	
				  <th>Action</th>
				</tr>
				</thead>



				<tbody>
					<?php 
					if(!empty($resort_data)){
					$i=1;
					foreach($resort_data as $content) { ?>
					<tr>
					  <td><?php echo $i; ?></td>
					  <td><?php echo $content->resort_name; ?></td>
					  <td><?php $page_description = strip_tags($content->resort_desc ); 
					  
							$total_words = str_word_count($page_description);
							if($total_words > 20)
							{
								$explode_words = explode(' ',$page_description,20);
								array_pop($explode_words);
								
								echo implode(' ',$explode_words).'.........';
							}
							else{
								echo $page_description;
								
							}
							
					  ?></td>
					  <td><?php echo $content->resort_mobile; ?></td>
					  <td><?php echo $content->resort_email; ?></td>
					  <td><?php echo $content->resort_contact_person; ?></td>
					  <td><?php echo $content->is_location_resort_refid_exists; ?></td>
					  <td><a  href="<?php echo base_url().'Resort/editResort/'.$content->resort_id; ?>" class="label label-success">Edit</a>&nbsp;<a onclick="return confirm('Are you sure you want to delete this Resort?');" href="<?php echo base_url().'Resort/deleteResort/'.$content->resort_id; ?>" class="label label-danger">Delete</a></td>
					</tr>
				  
				   <?php $i++; } } else { ?>

					<tr>
						 <td colspan="7" align="center"> There is no Resort Added.</td>
					</tr>

				   <?php } ?>
				</tbody>



			</table>

					

		  

        </div>

                  

	  </div>

               

	</section>
</div>
