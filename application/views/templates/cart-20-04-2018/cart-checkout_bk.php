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
		if(parseInt(textVal) < 0 || isNaN(textVal))
		{
			alert('Item Could not be Negative');
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
			<span class="col-md-7 photodtl">
               <div class="cart_title">
               <p><strong>Title:</strong>Customer Photo</p>
			   <p><strong>Option:</strong><?php echo $productDetail['option']['name']; ?></p>
			   <p><strong>Size:</strong><?php echo $productDetail['size']; ?></p>
               <p><strong>QTY:</strong><input type="text" class="qty_box" name="update_value" id="textVal_<?=$key?>" value="<?=(array_key_exists('quantity',$_SESSION['Usercart'][$key]))?$_SESSION['Usercart'][$key]['quantity']:"1";?>"><a href="javascript:void(0);" id="update_<?=$key?>" class="update_order">UPDATE</a></p>
               
               </div>
				
				
                <br class="clear" />

				
                <a href="javascript:void(0);" id="rmv_<?=$key?>" class="remove remove_order">REMOVE</a>
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

<?php if(!empty($_SESSION['Usercart'])): ?>

	<div class="col-md-3">
    <a href="<?php echo base_url(); ?>favourite" class="continue_shopbutt">Cotinue Shopping</a>
	<div class="sumary bdrsdo">

	<h3>Order Summary</h3>
	<!--<div class="sbtotl"><?//=count($photoArr[$userID])?> Photos<br/>-->
	<p>Order sub-total <strong>$<?=$total_price;?></strong></p>
	<!--Discount  <span>$10.00</span>-->
    <form name="frmchkout" id="frmchkout" method="post" action="<?php echo base_url().'cartAdd/billingCheckout/';?>" autocomplete="off">
		  <div class="infobx"><div class="cart_subtotalsec">
		<!--<p>  Enter your destination to get a
		  shipping estimate.</p>-->
		  <div class="left_carttotal">
		 
		  <p class="total_price">Total <strong>$<?=number_format($total_price, 2, ".","")?></strong></p>
		  </div>
		  <!--<span class="payoption"><img src="<?php //echo base_url(); ?>assets/images/paypal.png" width="253" height="28"> </span>-->
		  <!--<a href="" class=" orngbt">Proceed To Checkout</a>-->
		  <?php if(!empty($_SESSION['Usercart'])){?> 
		   <input name="" id="chkoutSubmit" value="Proceed To Checkout" class="checkout_button"  type="submit">
		  <?php }?>
		  </div>

		  </div>
		</form>
    </div>

	<!-- END ----------------------------------------->
	</div>
<?php endif; ?>

</div>
</div>
</div>
</div>
</div>