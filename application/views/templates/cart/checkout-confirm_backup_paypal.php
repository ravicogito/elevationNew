<script>
$(document).on("click", "#btn_next", function(event) {
		event.preventDefault();
		var noteVal			= $('#special_note').val();
		var order_id        = $('#item_name').val();
        //alert(noteVal);
		//alert(order_id);
        $.ajax({
				type: 'POST',
				url: _basePath+'cartAdd/noteadd/',
				data: {note:noteVal,id:order_id},
				dataType: 'JSON',
				success: function(responce) {
					
					if(responce['process'] == "success") {
					 $("#paypal_payment").submit();	
					}else if(responce['process'] == 'blank') {
						alert("Process Fail No Image ID. Please try again.");
					} else {
						alert("Process Fail. Please try again.");
					}
				}
			});
	});
</script>
<div class="contwrap">
	<div class="container-fluid">
		<div class="wrap">
		<div class="row" id="cartSec">
			<div class="col-md-9">
				<div class="billing_info bdrsdo">
				  <div id="newaddrshow">
					<div class="billing_multiaddress">
						<?php if(!empty($billaddress)): ?>
						<h2>Billing Address</h2>
							<p><strong>Name:</strong> <?php echo $billaddress[0]; ?></p>
							<p><strong>Address:</strong> <?php echo $billaddress[1]; ?></p>
							<p><strong>Email:</strong> <?php echo $billaddress[2]; ?></p>
							<p><strong>Phone:</strong> <?php echo $billaddress[3]; ?></p>
							<p><strong>Country:</strong> <?php echo $billaddress[4]; ?></p>
							<p><strong>State:</strong> <?php echo $billaddress[5]; ?></p>
							<p><strong>Zip:</strong> <?php echo $billaddress[6]; ?></p>
						<?php endif; ?>
					</div>

					<div class="shipping_multiaddress">
						<?php if(!empty($shipaddress)): ?>
						<h2>Shipping Address</h2>
							<p><strong>Name:</strong> <?php echo $shipaddress[0]; ?></p>
							<p><strong>Address:</strong> <?php echo $shipaddress[1]; ?></p>
							<p><strong>Email:</strong> <?php echo $shipaddress[2]; ?></p>
							<p><strong>Phone:</strong> <?php echo $shipaddress[3]; ?></p>
							<p><strong>Country:</strong> <?php echo $shipaddress[4]; ?></p>
							<p><strong>State:</strong> <?php echo $shipaddress[5]; ?></p>
							<p><strong>Zip:</strong> <?php echo $shipaddress[6]; ?></p>
						<?php endif; ?>
					</div>
				 </div>
                 <br class="clear" />
				 <div class="note">
					<label>Special Note:</label> <textarea name="special_note" id="special_note"></textarea>
				</div>
				<br class="clear" />
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="bdrsdo">
				<?php $total_price = 0;
				if(!empty($_SESSION['Usercart'])){
				foreach($_SESSION['Usercart'] as $key => $productDetail) {
					$total_price  += ($productDetail['price']*$productDetail['quantity']);
					
				?>
				
				
                <div class="product_descriptions cart_add">
				<p><strong>Option:</strong><?php echo $productDetail['option']['name']; ?> </p>
				
				<!--//**********sreela(05/04/18)*********-->
							
				<?php if(!empty($productDetail['option_meta_frame'])){?>
				  <p><strong>Frame Name:</strong><?php echo $productDetail['option']['meta']['frame_name']; ?></p>
				<?php } ?>
				 <?php if(!empty($productDetail['option']['meta']['top']['mat_name'])){?>
				   <p><strong>Top Mat:</strong><?php echo $productDetail['option']['meta']['top']['mat_name']; ?></p>
				<?php } ?>
				<?php if(!empty($productDetail['middlemat_name'])){?>
				   <p><strong>Middle Mat:</strong><?php echo $productDetail['option']['meta']['middle']['mat_name']; ?></p>
				 <?php } ?>
				<?php if(!empty($productDetail['option']['meta']['bottom']['mat_name'])){?>
				   <p><strong>Bottom Mat:</strong><?php echo $productDetail['option']['meta']['bottom']['mat_name']; ?></p>
				<?php } ?>
				
				<!--//**********End*********-->
				
				
				<p><strong>Size:</strong><?php echo $productDetail['size']; ?></p>
				<p><strong>Quantity:</strong> <?=(array_key_exists('quantity',$_SESSION['Usercart'][$key]))?$_SESSION['Usercart'][$key]['quantity']:"1";?></p>
				<p><strong>Price:</strong> $<?=number_format($productDetail['price']*$_SESSION['Usercart'][$key]['quantity'],2);?></p>
				</div>
				
				<?php }} else {?>
				 <div>Cart is empty.. </div>
			    <?php } ?>
				</div>
				<div class="sumary bdrsdo">
				<h3>Order Summary</h3>
				<!--<div class="sbtotl"><?//=count($photoArr[$userID])?> Photos<br/>-->
				<p>Order sub-total <strong>$<?=$total_price;?> </strong></p>
					
				<p class="total_price">Total <strong>$<?php echo number_format($total_price,2);?></strong></p>
				  <p class="payoption"><img src="<?php echo base_url(); ?>assets/images/paypal.png" width="253" height="28"> </p>
				   
				  <!---- Payment ----------------------------->
				<?php
					//$paypal_url 		= 'https://www.paypal.com/cgi-bin/webscr';
					$paypal_url 		= 'https://www.sandbox.paypal.com/cgi-bin/webscr';
					$merchant_email 	= 'cogito.sunav@gmail.com';
					//$merchant_email 	= '';
					$cancel_return 		= base_url().'CartAdd/cancel';
					$success_return 	= base_url().'CartAdd/successPayment';
					$notifyURL 			= base_url().'CartAdd/ipn'; //ipn url	
					?>
					
					<form method="post" name="customerData" id="paypal_payment" action="<?=$paypal_url;?>">   
						<input type="hidden" name="business" value="<?php echo $merchant_email;?>" />
						<input type="hidden" name="notify_url" value="<?php echo $notifyURL;?>" />
						<input type="hidden" name="cancel_return" value="<?php echo $cancel_return;?>" />
						<input type="hidden" name="return" value="<?php echo $success_return;?>" />
						<input type="hidden" name="rm" value="2" />
						<input type="hidden" name="lc" value="" />
						<input type="hidden" name="no_shipping" value="1" />
						<input type="hidden" name="no_note" value="1" />
						<input type="hidden" name="currency_code" value="USD" />
						<input type="hidden" name="page_style" value="paypal" />
						<input type="hidden" name="charset" value="utf-8" />
						<input type="hidden" id="item_name" name="item_name" value="<?php echo $order_id; ?>" />		
						<input type="hidden" name="custom" value="<?php echo $customer_id; ?>" />		
						<input type="hidden" name="cbt" value="Back to FormGet" />
						<input type="hidden" value="_xclick" name="cmd"/>
						<input type="hidden" id="amount" name="amount" value="<?=$total_price?>" />
						<input class="checkout_button" name="btn_next" type="submit" id="btn_next" value="Place Order"/>
						
				   <!-- <a href="" class="prochk">Buy Now</a>-->
					</form>
				<!--Discount  <span>$10.00</span>--></div>

				
				<!-- END ----------------------------------------->
			</div>
			
		</div>
		
		</div>
	</div>
</div>