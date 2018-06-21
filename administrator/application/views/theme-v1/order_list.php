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
	
	$(document).ready( function(){
		$('.order_status_class').on('change', function(){
			//alert('fgf');
			var get_option_val = $(this).val();
			var order_id = $(this).attr('id');
			//alert(order_id);
			$.ajax({
				type:"POST",
				url:"<?php echo base_url()?>order/updatePaymentsuccess",
				dataType: "json",
				data:
				{
					get_option_val:get_option_val,
					order_id:order_id,
				},
				success:function(response)
				{
					if(response['get'] == "Success")
					{
						location.reload();
					}
				},
				
			});
		});
		
		$('#order_status').on('change', function(){
			var get_option_val = $(this).val();
			$.ajax({
				type:"POST",
				url:"<?php echo base_url()?>order/statuswiselisting",
				dataType: "json",
				data:
				{
					get_option_val:get_option_val,
				},
			
				success:function(response)
				{
                    
					if(response['process'] == "success")
					{
						$('#content').html(response['order_all_list']);
					}
					else{
						$('#norecords').html("<tr><td colspan='9' align='center'> There is no Order Added.</td></tr>");
					}
				},
				
			});
		});
	});
</script>
<!-- Content Wrapper. Contains page content -->  
<div class="content-wrapper" id="content">    <!-- Content Header (Page header) -->	
<section class="content-header">	
<h1>	Order List 	</h1>
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
<strong>Sort By Order Status:</strong>	  
<select name="order_status" id="order_status">
<option value="all">All</option>
<option value="0">Cancel</option>
<option value="1" selected>New</option>
<option value="2">Processing</option>
<option value="3">Shipped</option>
<option value="4">Backorderd</option>
</select>
</div>   
</section>    
<section class="content">      
<div class="row" >        
<div class="col-md-12">         			
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">		
	<thead>				
	<tr>				  
	<th>#</th>				  
	<th>Order No.</th>	
	<th>Order Date</th>	
	<th>Customer Name</th>
	<th>Invoice</th>
	<th>Total Amount</th>
	<th>Payment Status</th>
	<th>Order Status</th>
	<th>Action</th>
	</tr>				
	</thead>				
	<tbody id="norecords">					
		<?php 					
		if(!empty($order_list))
		{					
			$i=1;					
			foreach($order_list as $list) 
			{ 
		?>					
		<tr>					  
		<td><?php echo $i; ?></td>
		<td><?php echo $list->order_no; ?></td>					  
		<td><?php echo $list->order_datetime; ?></td>					  
		<td><?php echo $list->customer_firstname.'&nbsp;'.$list->customer_middlename.'&nbsp;'.$list->customer_lastname; ?></td>
		<?php if($list->order_status == '1'):?>
			<td>Invoice will generate after Payment success</td>
		<?php else: ?>
			<td><a  target="_blank" href="<?=base_url()?>Order/invoice/<?=$list->order_id?>">INVOICE</a></td>
		<?php endif; ?>
		<td>$<?php echo $list->total; ?></td>
		<td><?php echo $list->payment_status; ?></td>
		<td>
		<select name="order_status" class="order_status_class" id="<?php echo $list->order_id; ?>">
			<option value="0" <?=(($list->order_status == '0') ? 'Selected' : '')?>>Cancel</option>
			<option value="1" <?=(($list->order_status == '1') ? 'Selected' : '')?>>New</option>
			<option value="2" <?=(($list->order_status == '2') ? 'Selected' : '')?>>Processing</option>
			<option value="3" <?=(($list->order_status == '3') ? 'Selected' : '')?>>Shipped</option>
			<option value="4" <?=(($list->order_status == '4') ? 'Selected' : '')?>>Backorderd</option>
		</select>
		</td>
		<td><a href="<?php echo base_url().'Order/Orderdetails/'.$list->order_id; ?>" class="label label-success">Details</a>&nbsp;<a onclick="return confirm('Are you sure you want to delete this Order?');" href="<?php echo base_url().'Order/deleteOrder/'.$list->order_id; ?>" class="label label-danger">Delete</a></td>
		</tr>				  				  
		<?php $i++; } } else { ?>					
		<tr>						 
		<td colspan="9" align="center"> There is no Order Added.</td>					
		</tr>				   
		<?php } ?>				
	</tbody>			
</table>							          
</div>                  	  
</div>               	
</section>
</div>