<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
<script>
$(document).ready( function(){
	$(".remove_order").unbind().bind("click", function(){
		//alert('Test');
		var remove_id = $(this).attr('id').split("_");
		var product_key			= remove_id[1];
		//alert(product_key);
		var result = confirm("Are you sure to delete?");
		if (result) {
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>CartAdd/removeProduct",
				dataType: "json",
				data:
				{
					product_key:product_key,
				},
				success:function(response)
				{
					//$("#cartSec").html(responce['HTML']);
					//alert(response.process);
					if(response['process'] == 'success') {
						location.reload();
					}
				},
				
			});
		}
	});
	
	$(".update_order").unbind().bind("click", function(){
		var remove_id = $(this).attr('id').split("_");
		var product_key			= remove_id[1];
		//alert(product_key);
		
		var hiddenprice = $("#hiddenprice_"+product_key).val();
		var textVal	    = $("#textVal_"+product_key).val();
		/* alert(textVal);
			return false; */
		if(textVal == 0)
		{
			alert('Item Could not be Zero');
			return false;
		}
		//var price_val   = textVal * hiddenprice;
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>CartAdd/updateQuantity",
			dataType: "json",
			data:
			{
				textVal:textVal,
				key:product_key,
				hiddenprice:hiddenprice,
			},
			success:function(response)
			{
				if(response['process'] == 'success') {
						location.reload();
					}
			},
			
		});
		//alert(price_val);
		//var price_val = $("price_"+product_key).html("Price:<span>$</span>");
	});
});
</script>

<div class="contwrap">
<div class="container-fluid">
<div class="wrap">

<div class="row" id="cartSec">

<div class="col-md-9">
	<?php //echo"<pre>";print_r($productDetails);die; ?>
	<?php $total_price = 0; 
	if(!empty($_SESSION['Usercart'])){
	foreach($_SESSION['Usercart'] as $key => $productDetail) {

		$total_price  += $productDetail['price'];
		
	?>

	<div class="buy bdrsdo ">
		<div class="row">
			<span class="col-md-5"><img src="<?=$productDetail['cur_img'];?>"></span> 
			<span class="col-md-7 photodtl"><span><b>Customer Photo</b> <strong></strong><br/>
				<b><?php echo $productDetail['option']['name']; ?> </b><br/>
				<b><?php echo $productDetail['size']; ?></b><br/>
				
				</span>

				<div class="clearfix"></div>
				
				<a href="javascript:void(0);" id="rmv_<?=$key?>" class="remove remove_order">REMOVE</a></br></br>
				<input type="text" name="update_value" id="textVal_<?=$key?>" value="<?=(array_key_exists('quantity',$_SESSION['Usercart'][$key]))?$_SESSION['Usercart'][$key]['quantity']:"1";?>">
				<a href="javascript:void(0);" id="update_<?=$key?>" class="remove update_order">UPDATE</a>
				<span class="col-md-3 dtlpric" id="price_<?=$key?>">Price:
				<input type="hidden" name="hidds" id="hiddenprice_<?=$key?>" value="<?=number_format($productDetail['price'],2);?>">
					<span>$<?=number_format($productDetail['price'],2);?></span>
				</span>
			</span>

		</div>
	</div>
	
	<?php }} else {?>
	 <div>Cart is empty.. </div>
	   <?php } ?>
</div>


<div class="col-md-3">
<div class="sumary bdrsdo">
<h3>Order Summary</h3>
<!--<div class="sbtotl"><?//=count($photoArr[$userID])?> Photos<br/>-->
Order sub-total <span>$<?=$total_price;?></span>
<!--Discount  <span>$10.00</span>--></div>
<div class="total">Total <span>$<?=number_format($total_price, 2, ".","")?></span></div>

<!---- Payment ----------------------------->
<?php
	//$paypal_url 		= 'https://www.paypal.com/cgi-bin/webscr';
	$paypal_url 		= 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    $merchant_email 	= 'cogito.sunav@gmail.com';
	//$merchant_email 	= '';
    $cancel_return 		= base_url().'cartAdd/cancel';
    $success_return 	= base_url().'cart/success';
    $notifyURL 			= base_url().'cart/ipn'; //ipn url	
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
        <input type="hidden" name="item_name" value="Photography Cart" />
		<input type="hidden" name="custom" value="<?php //echo $userID; ?>" />
        <input type="hidden" name="cbt" value="Back to FormGet" />
        <input type="hidden" value="_xclick" name="cmd"/>
        <input type="hidden" id="amount" name="amount" value="<?php //echo $total; ?>" />
    	<input class="grbtt" name="btn_next" type="submit" id="btn_next" value="Buy Now"/>
   <!-- <a href="" class="prochk">Buy Now</a>-->
    </form>
	

<!-- END ----------------------------------------->
</div>

<div class="sumary bdrsdo" >
<h3>payment method</h3>
<div class="sbtotl" style="text-align:left;">Please choose your payment
option here</div>

<div class="total" style="text-align:left;">We accepet <br/><br/>
	<img src="<?=base_url()?>assets/images/payment-method.png" alt="pay" width="206" height="21">  	
</div>
</div>

</div>
</div>
</div>
</div>
</div>