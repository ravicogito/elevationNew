<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datetimepicker.js">
</script>
<script>(function($){
	$(document).ready( function(){	
	$('#example').DataTable();	
	}); 
	})(jQuery)
</script>
<!-- Content Wrapper. Contains page content -->  
<div class="content-wrapper">    <!-- Content Header (Page header) -->	
<section class="content-header">	
<h1>	Rafting List 	</h1>
		<?php		$success_msg = $this->session->flashdata('sucessPageMessage');		
					if ($success_msg != "") {			
		?>			
		<div class="alert alert-success"><?php echo $success_msg; ?></div>			
		<?php		}		?>		
		<?php		$failed_msg = $this->session->flashdata('pass_inc');		
					if ($failed_msg != "") 
					{			
		?>			
<div class="alert alert-danger"><?php echo $failed_msg; ?></div>			
		<?php		}		?>	
<div class="box-tools pull-right" style="margin-bottom:10px">	
<a class="btn btn-block btn-default" href="<?php echo base_url().'Guide/generate/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Generate Rafting</a>	  
<!--<a class="btn btn-block btn-default" href="<?php echo base_url().'Guide/addGuide/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add New Rafting</a>-->	</div>     
</section>    
<section class="content">      
<div class="row">        
<div class="col-md-12">         			
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">		
	<thead>				
	<tr>				  
	<th>#</th>				  
	<th>Guide Name</th>				  
	<!--<th>Guide Description</th>-->				  
	<th>River Rafting Company</th>	
	<!--<th>Category</th>-->	
	<th>Date</th>
	<th>Time</th>
	<th>Action</th>
	</tr>				
	</thead>				
	<tbody>					
		<?php 					
		if(!empty($guide_data))
		{					
			$i=1;					
			foreach($guide_data as $list) 
			{ 
			
		?>					
		<tr>					  
		<td><?php echo $i; ?></td>
		<td><?php echo $list->event_name; ?></td>					  
		<!--<td><?php //$page_description = strip_tags($list->event_description );
		//$total_words = str_word_count($page_description);							
		//if($total_words > 20){
			//$explode_words = explode(' ',$page_description,20);								
			//array_pop($explode_words);																
			//echo implode(' ',$explode_words).'.........';
			//}							
		//else{								
			//echo $page_description;														
			//}												 
		?>
		</td>-->					  
		<td><?php echo $list->raftingcompany_name; ?></td>
		<!--<td><?php echo $list->cat_name; ?></td>-->
		<td><?php echo date('d-m-Y',strtotime($list->event_date)); ?></td>
		<td><?php echo $list->event_time; ?></td>
		<td>
		   <!-- <a href="<?php echo base_url().'Guide/edit/'.$list->event_id; ?>" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;-->
			<a href="<?php echo base_url().'Guide/view/'.$list->event_id; ?>" title="View"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;<a href="<?=base_url().'Guide/assign/'.$list->event_id;?>" title="Assign"><span class="glyphicon glyphicon-user"></span></a>&nbsp;<a onclick="return confirm('Are you sure you want to delete this Guide?');" href="<?php echo base_url().'Guide/delGuide/'.$list->event_id; ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
		</td>
		</tr>				  				  
		<?php $i++; } } else { ?>					
		<tr>						 
		<td colspan="7" align="center"> There is no Guide Added.</td>					
		</tr>				   
		<?php } ?>				
	</tbody>			
</table>							          
</div>                  	  
</div>               	
</section>
</div>

<script type="text/javascript">
	function eventDelete(id) {
	    if (confirm("Are you sure you want to delete this Event?")) {
	    	alert('Ok');
	        $.ajax({        
	            url: '<?php echo base_url().'Event/delEvent/'.$list->event_id; ?>',
	            type: 'post',             
	            data: {'id' : id},
	            success: function(response) {
	            //$('#edit_user_result').html(response);          
	                $('#sent_password_result'+id).html(response);
	                setTimeout(function() {
	                    $('input[type=submit]').attr('disabled', false); 
	                    window.location.href = "users.php"; 
	                }, 5000 );  
	            }           
	        });
	    }
	}
</script>