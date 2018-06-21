<script>
function validateNumber(number) {

    var filter = /^[0-9]+$/;

    if (filter.test(number)) {

      return true;

    }	else {

      return false;

    }

  }
  
$(document).on("click", "#btn_next", function(event) {
		event.preventDefault();
		var errorCounter	=	0;
		if($.trim($('#showcardno').val())==""){

			errorCounter++;

			$('.ajax-loader').css('visibility','hidden');

			$('#showcardno').next('span').addClass('errornew').html('Please select Card No.');

		} 

			else{

			$('#showcardno').next('span').removeClass('errornew').html('');

		}
		
		if($.trim($('#txtcvv').val())==""){

					errorCounter++;

					$('.ajax-loader').css('visibility','hidden');

					$('#txtcvv').next('span').addClass('errornew').html('Please enter CVV No.');

				}

				else{

				  if(!validateNumber($.trim($('#txtcvv').val()))){

					errorCounter++;

					$('.ajax-loader').css('visibility','hidden');

					$('#txtcvv').next('span').addClass('errornew').html('Please enter valid cvv number.');

				  }	

				  else{

					$('#txtcvv').next('span').removeClass('errornew').html('');

				  }	

				}

				

				if($("#expyear").val() == <?=date('Y')?>) {

					errorCounter++;

					if($("#expmnth").val() < <?=date('m')?>) {

					$('.ajax-loader').css('visibility','hidden');

					$('#expyear').next('span').addClass('errornew').html('Your card is already expired.');

					}

				  }

				else{

				$('#expyear').next('span').removeClass('errornew').html('');

				}  

				if($.trim($('#txtcarhdname').val())==""){

					errorCounter++;

					$('.ajax-loader').css('visibility','hidden');

					$('#txtcarhdname').next('span').addClass('errornew').html('Please enter Card Holder Name.');

				}

				else{

				$('#txtcarhdname').next('span').removeClass('errornew').html('');

				}
				
			if(errorCounter == 0)

			  {
				  
				  var noteVal		  = $('#special_note').val();
				  var order_id        = $('#order_id').val();
        
					$.ajax({
							type: 'POST',
							url: _basePath+'cartAdd/noteadd/',
							data: {note:noteVal,id:order_id},
							dataType: 'JSON',
							success: function(responce) {
								
								if(responce['process'] == "success") {
								 $("#frm").submit();	
								}else if(responce['process'] == 'blank') {
									alert("Process Fail No Image ID. Please try again.");
								} else {
									alert("Process Fail. Please try again.");
								}
							}
						});


              }			  
				
		
		
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
				<div class="sumary bdrsdo">
				<?php $total_price = 0;
				//pr($_SESSION['cartVal'],0);
				if(!empty($_SESSION['cartVal'])){
				  $digital_price=0;	
				 foreach($_SESSION['cartVal'] as $cartkey => $cartValue){
				$all_images_id = array();
				//$price    	       				    = $_SESSION['cartVal'][$cartkey]['size_price'];
				if(!empty($_SESSION['cartVal'][$cartkey]['dgimg_price'])){
				$digital_price+= $_SESSION['cartVal'][$cartkey]['dgimg_price'];	
				}
				$size     	      					= $_SESSION['cartVal'][$cartkey]['size'];
				if(!empty($_SESSION['cartVal'][$cartkey]['images'])){
				$images					   		    = $_SESSION['cartVal'][$cartkey]['images'];
				$images_id 							= $_SESSION['cartVal'][$cartkey]['imagesID'];
				$all_images 						= explode('~',$images);
				$all_images_id 						= explode('-',$images_id);
				}
				
				$quantity  							= $_SESSION['cartVal'][$cartkey]['quantity'];
				$event_id  							= $_SESSION['cartVal'][$cartkey]['eventID'];
				if(!empty($_SESSION['cartVal'][$cartkey]['packagetype'])&& ($_SESSION['cartVal'][$cartkey]['packagetype']=='digital-pkg')){?>
				<p class="for_cartdownloadimg">For Download Image: <?php echo '$';?><?php echo number_format($_SESSION['cartVal'][$cartkey]['dgimg_price'],2); ?></p>
			   <?php }
				if(array_key_exists('frmset',$_SESSION['cartVal'][$cartkey])){
					$i       = 0;					
					foreach($_SESSION['cartVal'][$cartkey]['frmset'] as $key => $frame){ 					
					$qnty		  	= $frame['qnty'];
					$finalp        	= $frame['print_price']+$frame['frameprice'];
					$total_price  	+=  $finalp*$qnty;
				?>
			
				
				<div class="product_descriptions">

					<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $size; ?></p>
						   
					<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($finalp*$qnty),2);?></p>
						   
					<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$_SESSION['cartVal'][$cartkey]['frmset'][$key]['qnty'];?></p>
					<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
					<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_frmset" class="remove remove_order">&nbsp;</a>
					<?php } ?>
				</div>
			
					
			   <?php $i++;
						
					}
				
				} 
				if(array_key_exists('collage',$_SESSION['cartVal'][$cartkey])){
					$i       = 0;
					foreach($_SESSION['cartVal'][$cartkey]['collage'] as $key => $collage){ 
			 
					$original_price = $collage['frameprice'];
					$qnty		  	= $collage['qnty'];
					$finalp        	= $collage['frameprice']+$collage['print_price'];
					$total_price  	+=  $finalp*$qnty;
				?>				
						<div class="product_descriptions">

							<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $size; ?></p>
								   
							<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($finalp*$qnty),2);?></p>
								   
							<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$_SESSION['cartVal'][$cartkey]['collage'][$i]['qnty'];?></p>
							<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
								<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_collage" class="remove remove_order">&nbsp;</a>
							<?php } ?>
						</div>
					  
					 <?php 
					 
					 $i++;
					}
				}
				if(array_key_exists('print',$_SESSION['cartVal'][$cartkey])){
			 
					if($_SESSION['cartVal'][$cartkey]['print']!='onlyprint'){
					$i      = 0;	
					foreach($_SESSION['cartVal'][$cartkey]['print'] as $key => $print){
						$qnty		  	= $print['qnty'];
						$finalp        	= $print['print_price'];
						$total_price  += $finalp*$qnty;
		
				?>
					
						<div class="product_descriptions">

							<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $size; ?></p>
								   
							<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($finalp*$qnty),2);?></p>
								   
							<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$_SESSION['cartVal'][$cartkey]['print'][$i]['qnty'];?></p>
								   
							<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
								<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" class="remove remove_order">&nbsp;</a>
							<?php } ?>
						</div>

					<?php $i++; 
						} 
					}	
					else {	
					$j      = 0;
					
						foreach($_SESSION['cartVal'][$cartkey]['single_price'] as $key=> $single_price)
						{
						 $price      = $single_price;  
						}
						if(!empty($all_images)){				
						foreach($all_images as $key =>  $image){
								//pr($_SESSION['cartVal'],0);
							$total_price  += $_SESSION['cartVal'][$cartkey]['single_price'][$key]*$quantity;
							$img_path         = $_SESSION['cartVal'][$cartkey]['fullPath'];
							$imagePath        = $_SESSION['cartVal'][$cartkey]['imagePath'].'/'.$image;	 
							?> 				
						
							<div class="product_descriptions">

								<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $size; ?></p>
								<?php if(!empty($_SESSION['cartVal'][$cartkey]['download']) && $_SESSION['cartVal'][$cartkey]['download']=='yes'){echo 'No print price'; } else{?>	   
								<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($_SESSION['cartVal'][$cartkey]['single_price'][$key]*$quantity),2);?></p>
								<?php } ?>
									   
								<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$_SESSION['cartVal'][$cartkey]['qty'][$key];?></p>
								<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
								<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" class="remove remove_order">&nbsp;</a>
								<?php } ?>
							</div>
							   
						<?php $j++;   
						} 
						}
					}	
					} 
				}
				} 
				else {?>
				 <div>Cart is empty.. </div>
			    <?php } ?>
				</div>
				<div class="sumary bdrsdo">
				<h3>Order Summary</h3>
				<!--<div class="sbtotl"><?//=count($photoArr[$userID])?> Photos<br/>-->
				 <?php $finalprice =  $digital_price+$total_price; ?>
				<p>Order sub-total <strong>$<?=$finalprice;?> </strong></p>
					
				<p class="total_price">Total <strong>$<?php echo number_format($finalprice,2);?></strong></p>
				  <p style="text-align: center;" class="payoption"><img src="<?php echo base_url(); ?>assets/images/authorized_logo.png"> </p>
				  <!----------------Authorize.net------------------------->
				  <div class="right_carddetails"><form action="<?php echo base_url()?>cartAdd/authorize_payment" method="post" id="frm" enctype="multipart/form-data" autocomplete="off">
				  <input type="hidden" id="order_id" name="order_id" value="<?php echo $order_id; ?>" />
				  <input type="hidden" id="amount" name="amount" value="<?=$finalprice?>" />
				   <div class="card_mumber" style="margin-top:10px">         
					 <label>Card Number :</label>
					 <span class="errornewwrap">
					  <input name="showcardno" type="text" class="" id="showcardno" maxlength="15" />
					 <span class=""></span>
					</span>
				   </div>

					 <div class="cvv_code" style="margin-top:10px">         
					 <label>CVV Code :</label>
					 <span class="errornewwrap">
					  <input name="txtcvv" type="text" class="tb220" id="txtcvv" />
					 <span class=""></span>
					</span>
					 </div>
					 <div class="exp_date">
					 <label>Expiration Date :</label>               

					 <!--<input name="exp_date" type="text" class="tb220" id="exp_date"/></br></br>-->
					  <span class="errornewwrap">
					 <select id="expmnth" name="expmnth" style="width:47%">
					 <option value="">MM</option>
					 <?php for ($j = 1; $j<= 12; $j++) {?>

						<option value="<?=($j<=9)?"0".$j:$j;?>"><?=($j<=9)?"0".$j:$j;?></option>

					<?php }?>
					 </select> / <select id="expyear" name="expyear" style="width:47%">
					  <?php for ($i = date('Y'); $i<= date('Y')+10; $i++) {?>

					  <option value="<?=$i?>"><?=$i?></option>

					  <?php }?>
					 </select>
					<span class=""></span>
					</span>
					 
					 </div>
					<div class="cvv_code" style="margin-top:10px">         
					 <label>Name on Card :</label>
					  <span class="errornewwrap">
					  <input name="txtcarhdname" type="text" class="tb220" id="txtcarhdname" />
					  <span class=""></span>
					</span>
					  <input class="checkout_button" name="btn_next" type="submit" id="btn_next" value="Place Order">
					 </div>					 
					 
					 
									  
				  
				  
				  </form></div>
				   
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
					
					<!--<form method="post" name="customerData" id="paypal_payment" action="<?=$paypal_url;?>">   
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
						
				  
					</form>-->
				<!--Discount  <span>$10.00</span>--></div>

				
				<!-- END ----------------------------------------->
			</div>
			
		</div>
		
		</div>
	</div>
</div>