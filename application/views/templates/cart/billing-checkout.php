<script>
$(document).ready(function() {
	 $("#ischecked").on("click", function() {
      var billaddr 		 = $('#newbilladdr').val();
      var billing_name   = $('#billing_name').val();
      var billing_email  = $('#billing_email').val();
      var billing_mobile = $('#billing_mobile').val();
      var billing_country = $('#billing_country').val();
	  var selected_billing_country = $("#billing_country option:selected").text();
	  //alert(selected_billing_country);
      var billing_state = $('#billing_state').val();
	  var selected_billing_state = $("#billing_state option:selected").text();
      var billing_pin = $('#billing_pin').val();
	  
      if($(this).is(':checked')) {
        $('#newshipaddr').val(billaddr).attr('readonly', true);
        $('#shipping_name').val(billing_name).attr('readonly', true);
        $('#shipping_email').val(billing_email).attr('readonly', true);
        $('#shipping_mobile').val(billing_mobile).attr('readonly', true);
        $('#shipping_pin').val(billing_pin).attr('readonly', true);
		
		if(billing_country)
		{
			$('#shipping_country')

				.find('option')

				.remove()

				.end()
			;
			
			$('#shipping_country')
			 .append($("<option selected ></option>")
						.attr("value",billing_country)
						.text(selected_billing_country));
		}
		
		if(billing_state)
		{
			$('#shipping_state')

				.find('option')

				.remove()

				.end()
			;
			
			$('#shipping_state')
			 .append($("<option selected ></option>")
						.attr("value",billing_state)
						.text(selected_billing_state));
		}
		//$("<option selected ></option>", {value: billing_country, text: billing_country}).appendTo('#shipping_country');
		//$("<option selected ></option>", {value: billing_state, text: billing_state}).appendTo('#shipping_state');
		//$("#shipping_country option:selected").val(billing_country);
      } else {
        $('#newshipaddr').val('').attr('readonly', false).focus();
        $('#shipping_name').val('').attr('readonly', false).focus();
        $('#shipping_email').val('').attr('readonly', false).focus();
        $('#shipping_mobile').val('').attr('readonly', false).focus();
        $('#shipping_pin').val('').attr('readonly', false).focus();
		
		if(billing_country)
		{
			var optionids 	 = [];
			var optionValues = [];

			$('#billing_country option').each(function() {
				optionids.push($(this).val());
				optionValues.push($(this).text());
			});

			//alert(optionValues);
			//$('#result').html(optionValues);
			
			$('#shipping_country')

				.find('option')

				.remove()

				.end()
			;
			
			$.each(optionValues, function(key, value) {
				 $('#shipping_country')
					 .append($("<option></option>")
								.attr("value",key)
								.text(value)); 
			});
		}
		
		if(billing_state)
		{
			
			$('#shipping_state')

				.find('option')

				.remove()

				.end()
			;
			$('#shipping_state')
				 .append($("<option>Select</option>"));
		}
      }
    });
	$("#chkoutSubmit").on("click", function() {
		var billing_name = $("#billing_name").val();
		var billing_email = $("#billing_email").val();
		var billing_address = $("#newbilladdr").val();
		var billing_mobile = $("#billing_mobile").val();
		var billing_country = $('#billing_country').val();
		var billing_state = $('#billing_state').val();
		var billing_pin = $('#billing_pin').val();
		
		var shipping_name = $("#shipping_name").val();
		var shipping_email = $("#shipping_email").val();
		var shipping_addr = $("#newshipaddr").val();
		var shipping_mobile = $("#shipping_mobile").val();
		var shipping_country = $('#shipping_country').val();
		var shipping_state = $('#shipping_state').val();
		var shipping_pin = $('#shipping_pin').val();
		
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		
		if(billing_name == '')
		{
			alert("Billing Name Could Not me blank");
			return false;
		}
		if(billing_email == '')
		{
			alert("Billing Email Could Not me blank");
			return false;
		}
		if (reg.test(billing_email) == false) 
		{
			alert('Invalid Billing Email Address');
			return false;
		}
		if(billing_address == '')
		{
			alert("Billing Address Could Not me blank");
			return false;
		}
		if(billing_mobile == '')
		{
			alert("Billing Mobile Could Not me blank");
			return false;
		}
		if(billing_country == '')
		{
			alert("Billing Country Could Not me blank");
			return false;
		}
		if(billing_state == '')
		{
			alert("Billing State Could Not me blank");
			return false;
		}
		if(billing_pin == '')
		{
			alert("Billing Zip Could Not me blank");
			return false;
		}
		
		if(shipping_name == '')
		{
			alert("Shipping Name Could Not me blank");
			return false;
		}
		if(shipping_email == '')
		{
			alert("Shipping Email Could Not me blank");
			return false;
		}
		if (reg.test(billing_email) == false) 
		{
			alert('Invalid Shiping Email Address');
			return false;
		}
		if(shipping_addr == '')
		{
			alert("Shipping Address Could Not me blank");
			return false;
		}
		if(shipping_mobile == '')
		{
			alert("Shipping Mobile Could Not me blank");
			return false;
		}
		if(shipping_country == '')
		{
			alert("Shipping Country Could Not me blank");
			return false;
		}
		if(shipping_state == '')
		{
			alert("Shipping State Could Not me blank");
			return false;
		}
		if(shipping_pin == '')
		{
			alert("Shippinging Zip Could Not me blank");
			return false;
		}
		
		else{
			$("#frmchkout").submit();
		}
	});
	
	$(document).on("change","#billing_country",function(){
		var country_id_val = $(this).val();
		
		$('#billing_state')

			.find('option')

			.remove()

			.end()
		;
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>cartAdd/getCountrylist",
			dataType: 'json',
			data:
			{
				country_id:country_id_val,
			},
			success:function(response)
			{
				$("<option></option>", {value: '', text: 'Select'}).appendTo('#billing_state');
				$.each( response, function( key, value ) {

				  var title = response[key].state_name;

				  var state_id = response[key].state_id;
					
					$("<option></option>", {value: state_id, text: title}).appendTo('#billing_state');

				});
			},
		});
		
	});
	
	$(document).on("change","#shipping_country",function(){
		var country_id_val = $(this).val();
		
		$('#shipping_state')

			.find('option')

			.remove()

			.end()
		;
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>cartAdd/getCountrylist",
			dataType: 'json',
			data:
			{
				country_id:country_id_val,
			},
			success:function(response)
			{
				$("<option></option>", {value: '', text: 'Select'}).appendTo('#shipping_state');
				$.each( response, function( key, value ) {

				  var title = response[key].state_name;

				  var state_id = response[key].state_id;
					
					$("<option></option>", {value: state_id, text: title}).appendTo('#shipping_state');

				});
			},
		});
		
	});
	
});
</script>
<?php //pr($_SESSION,0);?>
<div class="contwrap">
	<div class="container-fluid">
		<div class="wrap">

		<div class="row" id="cartSec">
			<div class="col-md-9">
			<form name="frmchkout" id="frmchkout" method="post" action="<?php echo base_url().'cartAdd/entryOrder';?>">
				<div class="billing_info bdrsdo">
				  <h2 class="addnewadd">Billing info</h2>
				  <div id="newaddrshow">
					<div class="billing_multiaddress">
					<h3>Billing Address</h3>
						<p><label>Name:</label> <input type="text" name="billing_name" id="billing_name" value="<?=(!empty($billAddressArr['customer_firstname'])) ? $billAddressArr['customer_firstname'].$billAddressArr['customer_lastname']: ''?>"></p>
						<p><label>Email:</label> <input type="text" name="billing_email" id="billing_email" value="<?=(!empty($billAddressArr['customer_email'])) ? $billAddressArr['customer_email'] : ''?>"></p>
						<p><label>Address:</label> <textarea name="newbilladdr" id="newbilladdr" cols="" rows=""><?=(!empty($billAddressArr['customer_address'])) ? $billAddressArr['customer_address'] : ''?></textarea></p>
						<p><label>Mobile:</label> <input type="text" name="billing_mobile" id="billing_mobile" value="<?=(!empty($billAddressArr['customer_mobile'])) ? $billAddressArr['customer_mobile']: ''?>"></p>
						<p><label>Country:</label>
							<select name="billing_country" class="billing_country" id="billing_country">
								<option value="">Select</option>
								<?php foreach($countrylists as $countrylist) { ?>
									<option value="<?php echo $countrylist['country_id']; ?>"><?php echo $countrylist['country_name']; ?></option>
								<?php } ?>
							</select>
						</p>
						<p><label>State:</label>
							<select name="billing_state" class="billing_state" id="billing_state">
								<option value="">Select</option>
							</select>
						</p>
						<p><label>Zip:</label> <input type="text" name="billing_pin" id="billing_pin"></p>
					</div>

				  
				  <div class="shipping_multiaddress">
					<h3>Shipping Address</h3>
					<p><label>Name:</label> <input type="text" name="shipping_name" id="shipping_name"></p>
					<p><label>Email:</label> <input type="text" name="shipping_email" id="shipping_email"></p>
					<p><label>Address:</label> <textarea name="newshipaddr" id="newshipaddr" cols="" rows=""></textarea></p>
					<p><label>Mobile:</label> <input type="text" name="shipping_mobile" id="shipping_mobile"></p>
					<p><label>Country:</label>
						<select name="shipping_country" class="shipping_country" id="shipping_country">
							<option value="">Select</option>
							<?php foreach($countrylists as $countrylist) { ?>
								<option value="<?php echo $countrylist['country_id']; ?>"><?php echo $countrylist['country_name']; ?></option>
							<?php } ?>
						</select>
					</p>
					<p><label>State:</label>
						<select name="shipping_state" class="shipping_state" id="shipping_state">
							<option value="">Select</option>
						</select>
					</p>
					<p><label>Zip:</label> <input type="text" name="shipping_pin" id="shipping_pin"></p>
				  </div>
                  <br class="clear" />

                  <div class="billing_shppsame">
				 <input name="ischecked" id="ischecked" type="checkbox" value="1" />
					Shipping Address same as Billing Address
				  </div>
				 </div>
				</div>
			</form>
			</div>
			<div class="col-md-3">
			
				
				<div class="sumary bdrsdo">
				<h3>Order Summary</h3>
				<!--<div class="sbtotl"><?//=count($photoArr[$userID])?> Photos<br/>-->
                <div class="order_details">
                <?php $total_price = 0; 
				//pr($_SESSION['Usercart']);
				if(!empty($_SESSION['cartVal'])){
				$digital_price = 0;
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
						   
					<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$frame['qnty'];?></p>
					<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
					<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_frmset" class="remove remove_order">&nbsp;</a>
					<?php } ?>
				</div>
			
					
			   <?php $i++; } } 
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
							   
						<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$collage['qnty'];?></p>
						<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
							<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_collage" class="remove remove_order">&nbsp;</a>
						<?php } ?>
					</div>
				  
				 <?php 
				 
				 $i++;}
			  
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
			}else {?>
				 <div>Cart is empty.. </div>
			    <?php } ?>
                </div>
				 <?php $finalprice =  $digital_price+$total_price; ?>
				<p>Order sub-total <strong>$<?=$finalprice;?></strong></p> 
					<p class="total_price">Total <strong>$<?=number_format($finalprice, 2, ".","")?></strong></p>
						  <?php if(!empty($_SESSION['cartVal'])){?> 
						   <input name="" id="chkoutSubmit" value="Proceed To Checkout" class="checkout_button"  type="submit">
						  <?php }?>
				<a href="<?php echo base_url(); ?>Favourite" class="place_order" style="width:190; margin-top:10px; margin-bottom:10px;">continue shopping</a>
				<!--Discount  <span>$10.00</span>--></div>

				
				<!-- END ----------------------------------------->
			</div>
		</div>
		
		</div>
	</div>
</div>