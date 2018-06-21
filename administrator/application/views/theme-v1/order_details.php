<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	

<style>
.hpanel {
    background-color: none;
    border: none;
    box-shadow: none;
    margin-bottom: 25px;
}
.hpanel.hblue .panel-body {
    border-top: 2px solid #3498db;
}
.hpanel .panel-body {
    background: #fff;
    border: 1px solid #e4e5e7;
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color: rgb(228, 229, 231);
    border-radius: 2px;
    padding: 20px;
    position: relative;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body ordr_dtl_pge">
                    <h3>Order Details</h3>
                    <hr>
					<div class="box-tools pull-right" style="margin-bottom:10px;margin-right:0px">		  
						<a class="btn btn-block btn-default" href="<?php echo base_url().'Order/listorder/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Back</a>
					</div>
					
						<b>Summary</b>
						<div class="form-group">
						  <label>Order No.:- </label>
						 <?php echo $order_details['order_no'];?>
						</div>						
						<div class="form-group">
						  <label>Transaction ID:- </label>
						 <?php echo $order_details['transaction_id'];?>
						</div>						
						<div class="form-group">
						  <label>Order Date:- </label>
						 <?php echo $order_details['order_datetime'];?>
						</div>						
						<div class="form-group">
						  <label>Customer:- </label>
						 <?php echo $order_details['customer_firstname'].'&nbsp;'.$order_details['customer_middlename'].'&nbsp;'.$order_details['customer_lastname'];?>
						</div>						
						<div class="form-group">
						  <label>Total:- </label>
						 $<?php echo $order_details['total'];?>
						</div>						
						<div class="form-group">
						  <label>Payment Status:- </label>
						 <?php echo $order_details['payment_status'];?>
						</div>	
                        <div class="form-group">
						  <label>Order Status:- </label>
						 <?php if($order_details['order_status']=='0'){ echo 'Order Cancel'; } else if($order_details['order_status']=='1'){ echo 'Ordered'; } else{echo 'Payment Success';}?>
						</div>  
						<div class="form-group">
						  <label>Customer Note:- </label>
						 <?php echo $order_details['customer_note'];?>
						</div> 
						
							<div class="product_order">
								<b>Product Order</b>
								
								<?php 
								$count = 0;
								 if(!empty($orderImgDetails)) {
								 foreach($orderImgDetails as $ImgDetails){
									if($ImgDetails[0]['digital_price'] !='0'){
								?>
								<h3>For Download Image: $<?php echo number_format($ImgDetails[0]['digital_price'],2)?></h3>
								<?php
									}
									foreach($ImgDetails as $Img){
										 $count++;
								?>
								<p><strong>Order <?php echo $count; ?>#</strong></p>
								<p><label>Package type</label><input type="text" class="form-control" value="<?php if($Img['digital_price'] != '0'){ echo 'Digital package';} else{ echo 'Printing package';} ?>" readonly /></p>
								<p><label>Quantity</label><input type="text" class="form-control" value="<?php echo $Img['quantity']; ?>" readonly /></p>
								<p><label>Unit Price</label><input type="text" class="form-control" value="<?php echo $Img['price']; ?>" readonly /></p>
								<p><label>Status</label>
								<select name="order_status" class="form-control" disabled>
									<option value="0" <?=(($order_details['order_status'] == '0') ? 'Selected' : '')?>>Cancel</option>
									<option value="1" <?=(($order_details['order_status'] == '1') ? 'Selected' : '')?>>New</option>
									<option value="2" <?=(($order_details['order_status'] == '2') ? 'Selected' : '')?>>Processing</option>
									<option value="3" <?=(($order_details['order_status'] == '3') ? 'Selected' : '')?>>Shipped</option>
									<option value="4" <?=(($order_details['order_status'] == '4') ? 'Selected' : '')?>>Backorderd</option>
								</select></p>
								<p><label>Shiped On</label><input type="text" class="form-control" value="<?php echo date($Img['order_date']); ?>" readonly /></p>								
								<p><label>Order Image Name</label><input type="text" class="form-control" value="<?php echo str_replace("~",", ",$Img['order_img']);?>" readonly /></p>
								<?php if($Img['option_frame_name']) {?>
								<p><label>Order Image Framte</label><input type="text" class="form-control" value="<?php echo ucfirst(str_replace("_"," ",$Img['option_frame_name']));?>" readonly /></p>
								<?php } ?>
								<?php if($Img['option_frame_collage']) {?>
								<p><label>Order Image Collage</label><input type="text" class="form-control" value="<?php echo ucfirst(str_replace("_"," ",$Img['option_frame_collage']));?>" readonly /></p>
								<?php } ?>
								<p><label>Order Image</label><img src="<?php echo $Img['canvas_img'] ?>" height="100px" width="100px"></p></br>
								<?php  } ?> <hr><?php } } ?>
							</div>
						
						<div class="bling_addrsa">
							<p>Ship To</p>
							
							<?php 
							$billAddrs = $order_details['bill_address'];
							$shipAddrs = $order_details['ship_address'];
							//echo $billAddrs;die;
							$bill_address_Arr = explode('|',$billAddrs);
							$ship_address_Arr = explode('|',$shipAddrs);
							?>
							<b>Billing Address</b>
							<p><label>Name</label><input type="text" class="form-control" value="<?php echo $bill_address_Arr[0]; ?>" readonly /></p>
							<p><label>Address</label><input type="text" class="form-control" value="<?php echo $bill_address_Arr[1]; ?>" readonly /></p>
							<p><label>Email</label><input type="text" class="form-control" value="<?php echo $bill_address_Arr[2]; ?>" readonly /></p>
							<p><label>Phone</label><input type="text" class="form-control" value="<?php echo $bill_address_Arr[3]; ?>" readonly /></p>
							<p><label>Country</label><input type="text" class="form-control" value="<?php echo (!empty($bill_address_Arr[4]) ? $bill_address_Arr[4] : ''); ?>" readonly /></p>
							<p><label>State</label><input type="text" class="form-control" value="<?php echo (!empty($bill_address_Arr[5]) ? $bill_address_Arr[5] : ''); ?>" readonly /></p>
							<p><label>Zip</label><input type="text" class="form-control" value="<?php echo (!empty($bill_address_Arr[5]) ? $bill_address_Arr[5] : ''); ?>" readonly /></p></br></br>
							
							<b>Shipping Address</b></br>
							<p><label>Name</label><input type="text" class="form-control" value="<?php echo $ship_address_Arr[0]; ?>" readonly /></p>
							<p><label>Address</label><input type="text" class="form-control" value="<?php echo $ship_address_Arr[1]; ?>" readonly /></p>
							<p><label>Email</label><input type="text" class="form-control" value="<?php echo $ship_address_Arr[2]; ?>" readonly /></p>
							<p><label>Phone</label><input type="text" class="form-control" value="<?php echo $ship_address_Arr[3]; ?>" readonly /></p>
							<p><label>Country</label><input type="text" class="form-control" value="<?php echo (!empty($ship_address_Arr[4]) ? $ship_address_Arr[4] : ''); ?>" readonly /></p>
							<p><label>State</label><input type="text" class="form-control" value="<?php echo (!empty($ship_address_Arr[5]) ? $ship_address_Arr[5] : ''); ?>" readonly /></p>
							<p><label>Zip</label><input type="text" class="form-control" value="<?php echo (!empty($ship_address_Arr[6]) ? $ship_address_Arr[6] : ''); ?>" readonly /></p></br></br>
						</div>
						
						
						<div class="bling_addrsa admit_not">
							<form method="post">
								<label>Admin Note:-</label> <textarea name="admin_note" class="form-control"><?php echo $order_details['admin_note']; ?></textarea>
								<input type="submit" class="btn btn-primary" value="save">
							</form>
						</div>
			
						<!--<div class="form-group">
						  <label>Invoice:- </label>
						  <a href="<?=base_url()?>Order/invoice/<?=$order_details['order_id']?>">Download</a>
                      	</div>-->
					
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->