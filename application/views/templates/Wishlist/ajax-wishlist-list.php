<div class="col-md-9">
<script type="text/javascript">	
	
		$(document).on("click", ".addcart", function(event) {
		event.preventDefault();
		var idArr			= $(this).attr('id').split("_");
		var imgID			= idArr[1];
		if(confirm('Are you sure you want to add this cart?')) {
			$.ajax({
				type: 'POST',
				url: _basePath+'wishlist/cart/',
				data: 'image_id='+imgID,
				dataType: 'JSON',
				success: function(responce) {
					if(responce['process'] == "success") {
						$("#succmsg").html(responce['msg']);
						$("#viewcart").css("display", "block");
						$(".usersec").find('a:nth-child(2)').find('span:nth-child(2)').html(responce['itemCnt']+" item(s)");
					}else if(responce['process'] == 'blank') {
						alert("Process Fail No Image ID. Please try again.");
					} else {
						alert("Process Fail. Please try again.");
					}
				}
			});
		}
		//alert('ll');
		setTimeout(function(){
		$('.crtopo').toggleClass('poplogfrmopn').append('<a href="" class="pp_close crtcls" id="pp_close"></a>');;
		$('.overlay').toggle();
		}, 500);
		
	});
	
	$(document).on("click", ".overlay, #succmsg", function(e){
	
		e.preventDefault();
		
		$('.crtopo').toggleClass('poplogfrmopn');
		$('.overlay').toggle();
		
	});
	
</script>
<?php $total = 0;
 if(!empty($wishlistDetails)){
  		foreach($wishlistDetails as $key => $val) {
  			$total					+= $val['media_price'];
  			$imagePath				= base_url()."uploads/customerImg_".$customer_id."/".$val['file_name'];
			$imgArr 		= explode(".",$val['file_name']);
			$extension 		= end($imgArr);
			$imagePath  = base_url()."uploads/customerImg_".$customer_id."/"."thumb/".$imgArr[0]."-390X320.".$extension;
  			
  			
  ?>
<div class="wishl bdrsdo">
<div class="row" id="wishistSec">
<span class="col-md-3"><img src='<?=$imagePath;?>' ></span> 
<span class="col-md-6 photodtl"><span>Photography By: <strong><?=$val['photographer_name'];?></strong><br/>
Photo Resolution: <strong>300dpi</strong></span>
<a href="javascript:void(0)" id="rmv_<?=$val['media_id']?>" class="remove">REMOVE</a>
<?php if($val['media_price']==0){?><a href="javascript:void(0)" onclick="alert('Price not set for this Image.')" class="addcart"><?php } else {?><a href="#" id="cart_<?=$val['media_id']?>" class="addcart"><?php } ?>Add to Cart</a>
</span>
<span class="col-md-3 dtlpric">Price:
<span>$<?=number_format($val['media_price'],2);?></span></span>
</div>
</div>

<?php }} else {?>
	   <div>Wishlist is empty.. </div>
	   <?php } ?>



</div>

<div class="col-md-3">
<div class="sumary bdrsdo  ">
<h3>Order Summary</h3>
<div class="sbtotl"><?=count($wishlistDetails)?> Photos<br/>
Order sub-total <span>$<?=$total;?></span></div>

<div class="total">Total <span>$<?=number_format($total, 2, ".","")?></span></div>

<!--<a href="" class="prochk">proceed to checkout</a>-->


</div>
</div>