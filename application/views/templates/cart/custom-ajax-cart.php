
<div class="col-md-9">
	<?php //echo"<pre>";print_r($productDetails);die; ?>
	<?php $total_price = 0; 
	if(!empty($_SESSION['Usercart'])){
	foreach($_SESSION['Usercart'] as $key => $productDetail) {

		$total_price  += $productDetail['price'];
		
	?>

	<div class="buy bdrsdo ">
		<div class="row">
			<span class="col-md-5"><img src='<?php echo base_url();?>./uploads/Action/2018-03-17/Photographer3/Ski/elev-05-400_400.png' ></span> 
			<span class="col-md-7 photodtl"><span><b>Customer Photo</b> <strong></strong><br/>
				<b><?php echo $productDetail['option']; ?> </b><br/>
				<b><?php echo $productDetail['size']; ?></b><br/>
				
				</span>

				<div class="clearfix"></div>
				
				<a href="javascript:void(0);" id="rmv_<?=$key?>" class="remove remove_order">REMOVE</a>
				<span class="col-md-3 dtlpric">Price:
					<span>$<?=number_format($productDetail['price'],2);?></span>
				</span>
			</span>

		</div>
	</div>
	
	<?php }} else {?>
	 <div>Cart is empty.. </div>
	   <?php } ?>
</div>