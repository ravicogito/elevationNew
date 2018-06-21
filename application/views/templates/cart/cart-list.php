<?php //pr($photoArr,0);?>
<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		//$("#abc")[0].lastChild.nodeValue = "155.00";
		//$(".usersec").find('a:nth-child(2)').find('span:nth-child(2)').html('abb');
		
	})
	$(document).on("keyup", ".capt", function() {
		var charLeft		= 0;
		var textLength		= $(this).val().length;
		charLeft			= parseInt(25-textLength);
		$(this).next('span').next('span.rm').children().html(charLeft);
	})
	
	$(document).on("click", ".remove", function(event) {
		event.preventDefault();
		var idArr			= $(this).attr('id').split("_");
		var imgType			= idArr[1];
		var eventId			= idArr[2];	
		
		if(imgType == 'event') {
			var imgID			= '1';
		} else {
			var imgID			= idArr[3];
		}
		//alert("hi - "+imgID);
		if(confirm('Are you sure you want to remove this image?')) {
			$.ajax({
				type: 'POST',
				url: _basePath+'cart/remove/',
				data: {img_type:imgType, event_id:eventId, image_id:imgID},
				dataType: 'JSON',
				success: function(responce) {
					if(responce['process'] == "success") {
						$("#cartSec").html('');
						$("#cartSec").html(responce['HTML']);
						$(".usersec").find('a:nth-child(2)').find('span:nth-child(2)').html(responce['itemCnt']+" item(s)");
					}else if(responce['process'] == 'blank') {
						alert("Process Fail No Image ID. Please try again.");
					} else {
						alert("Process Fail. Please try again.");
					}
				}
			});
		}
	});
	
	$(document).on("blur", ".capt", function() {
		var txtCaption		= $(this).val();
		var idArr			= $(this).attr("id").split("_");
		var imgType			= idArr[1];
		var eventId			= idArr[2];	
		var imgID			= idArr[3];
		var imgCap			= imgType+"_"+eventId+"_"+imgID;
		//alert(imgID);
		save_cart(txtCaption, imgCap, "blur");
	});
	
	$(document).on("click", ".sav", function(event) {
		event.preventDefault();
		var idArr			= $(this).attr('id').split("_");
		var imgType			= idArr[1];
		var eventId			= idArr[2];	
		var imgID			= idArr[3];
		var imgCap			= imgType+"_"+eventId+"_"+imgID;
		var txtCaption		= $("#captation_"+imgType+"_"+eventId+"_"+imgID).val();		
		save_cart(txtCaption, imgCap, "click");
	});
	
	function save_cart(caption, id, eventType) {
		$.ajax({
			type: 'POST',
			url: _basePath+'cart/saveCart/',
			data: { txtcaption: caption, image_id: id, event_type: eventType },
			dataType: 'JSON',
			async: false,
			success: function(responce) {
				if(responce['process'] == "success") {
					if(eventType == "click") {
						alert("Data saved successfully.");
					}
				}else if(responce['process'] == 'blank') {
					alert("Process Fail No Image ID. Please try again.");
				} else {
					alert("Process Fail. Please try again.");
				}
			}
		});
	}
</script>
<div class="contwrap">
<div class="container-fluid">
<div class="wrap">

<div class="row addban"><img src="<?=base_url()?>assets/images/adban.png" width="1226" height="177"></div>
<div class="row" id="cartSec">
  
  <div class="col-md-9">
  
  <?php //pr($photoArr['event'],0);
		$totalPhoto			= 0;
        if(!empty($photoArr)){
			
			if(array_key_exists('event', $photoArr) ) {
				foreach($photoArr['event'] as $key => $eventArr) {?>
				<div class='eventClass'><a href="#" id="rmv_event_<?=$key?>" class="remove">REMOVE</a>
				<?php
				foreach($eventArr as $j => $val) {
					if(is_numeric($j)) {
			$imgArr 		= explode(".",$val[0]['file_name']);
			$extension 		= end($imgArr);
			$imagePath  = base_url()."uploads/customerImg_".$customer_id."/"."thumb/".$imgArr[0]."-390X320.".$extension;
  			if(array_key_exists('caption', $val[0])) {
				$caption			= $val[0]['caption'];
				$charLeft			= (25-strlen($caption));
			} else {
				$caption			= "";
				$charLeft			= 25;
			}
  	  //pr($_SESSION['cart'],0);		
  ?>
<div class="buy bdrsdo">
<div class="row">

<span class="col-md-5"><img src='<?=$imagePath;?>' ></span> 
<span class="col-md-7 photodtl"><span><b>Photography By:</b> <strong><?=$val[0]['photographer_name'];?></strong><br/>
<b>Photo Resolution: </b><strong>300dpi</strong><br/>
<b>Photo Size:	</b>		<strong><?php  echo "gdjh"; if(!empty($val[0]['photo_size'])){ echo $val[0]['photo_size'];} else{ echo 'NA'; }?></strong><br/>
<b>digital format:</b>		<strong><?php if(!empty($val[0]['digital_format'])){ echo $val[0]['digital_format'];} else{ echo 'NA'; }?></strong><br/>
<b>Photo Number:</b>		<strong><?php if(!empty($val[0]['photo_number'])){ echo $val[0]['photo_number'];} else{ echo 'NA'; }?></strong><br/><br/>
<span style="width: auto;display: inline; margin:0;">add caption:</span>	
<span class="frm_dve capt">
      <input name="captation" id="captation_event_<?=$key."_".$j?>" value="<?=$caption;?>" size="40" class="capt" type="text" maxlength="25">
     <span> Your manage should be within 25 character</span>   <span class="rm">Remaining <span><?=$charLeft;?></span></span>
       </span>
</span>

<div class="clearfix"></div>


<!--<a href="#" id="rmv_event_<?=$key."_".$j?>" class="remove">REMOVE</a> --><a class="sav" href="#" id="sav_event_<?=$key."_".$j?>">Save for later</a>

<!--<span class="col-md-3 dtlpric">Price:
<span>$<?=number_format($val[0]['media_price'],2);?></span></span>
</span>-->

</div>
</div>
<?php $totalPhoto++;}}?>
</div>
<?php }}?>
	
<?php 
			if(array_key_exists('ind', $photoArr) ) {
				foreach($photoArr['ind'] as $keyInd => $indArr) {
				foreach($indArr as $k => $indVal) {	
				if(is_numeric($k)) {
			$imgArr 		= explode(".",$indVal[0]['file_name']);
			$extension 		= end($imgArr);
			$imagePath  = base_url()."uploads/customerImg_".$customer_id."/"."thumb/".$imgArr[0]."-390X320.".$extension;
  			if(array_key_exists('caption', $indVal[0])) {
				$caption			= $indVal[0]['caption'];
				$charLeft			= (25-strlen($caption));
			} else {
				$caption			= "";
				$charLeft			= 25;
			}
  	  //pr($_SESSION['cart'],0);		
  ?>
<div class="buy bdrsdo ">
<div class="row">
<span class="col-md-5"><img src='<?=$imagePath;?>' ></span> 
<span class="col-md-7 photodtl"><span><b>Photography By:</b> <strong><?=$indVal[0]['photographer_name'];?></strong><br/>
<b>Photo Resolution: </b><strong>300dpi</strong><br/>
<b>Photo Size:	</b>		<strong><?php if(!empty($indVal[0]['photo_size'])){ echo $indVal[0]['photo_size'];} else{ echo 'NA'; }?></strong><br/>
<b>digital format:</b>		<strong><?php if(!empty($indVal[0]['digital_format'])){ echo $indVal[0]['digital_format'];} else{ echo 'NA'; }?></strong><br/>
<b>Photo Number:</b>		<strong><?php if(!empty($indVal[0]['photo_number'])){ echo $indVal[0]['photo_number'];} else{ echo 'NA'; }?></strong><br/><br/>
<!--<b>Photo Number:</b>		<strong>el001</strong><br/><br/>-->
<span style="width: auto;display: inline; margin:0;">add caption:</span>	
<span class="frm_dve capt">
      <input name="captation" id="captation_ind_<?=$keyInd."_".$k?>" value="<?=$caption;?>" size="40" class="capt" type="text" maxlength="25">
     <span> Your manage should be within 25 character</span>   <span class="rm">Remaining <span><?=$charLeft;?></span></span>
       </span>
</span>

<div class="clearfix"></div>


<a href="#" id="rmv_ind_<?=$keyInd."_".$k?>" class="remove">REMOVE</a> <a class="sav" href="#" id="sav_ind_<?=$keyInd."_".$k?>">Save for later</a>
<span class="col-md-3 dtlpric">Price:
<span>$<?=number_format($indVal[0]['media_price'],2);?></span></span>
</span>

</div>
</div>
<?php $totalPhoto++;}}}}?>
	
<?php } else {?>
	<div>Cart is empty.. </div>
<?php } ?>


</div>
				
<div class="col-md-3">

<div class="sumary bdrsdo">
<?php if(array_key_exists('cart', $_SESSION)) {
				if(count($_SESSION['cart']) > 0) {
?>
<h3>Order Summary</h3>
<div class="sbtotl"><?=$totalPhoto;?> Photos<br/>
Order sub-total <span>$<?php echo number_format($price,2);?></span>
<!--Discount  <span>$10.00</span>--></div>
<div class="total">Total <span>$<?=number_format($price,2);?></span></div>

<!---- Payment ----------------------------->
<?php
	//$paypal_url 		= 'https://www.paypal.com/cgi-bin/webscr';
	$paypal_url 		= 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    $merchant_email 	= 'cogito.sunav@gmail.com';
	//$merchant_email 	= '';
    $cancel_return 		= base_url().'cart/cancel';
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
		<input type="hidden" name="custom" value="<?php echo $userID; ?>" />
        <input type="hidden" name="cbt" value="Back to FormGet" />
        <input type="hidden" value="_xclick" name="cmd"/>
        <input type="hidden" id="amount" name="amount" value="<?=$price?>" />
    	<input class="grbtt" name="btn_next" type="submit" id="btn_next" value="Buy Now"/>
   <!-- <a href="" class="prochk">Buy Now</a>-->
    </form>
	

<!-- END ----------------------------------------->

<?php }} else {?>
</div>
<h3>Order Summary</h3>
<div class="sbtotl">0 Photos<br/>
Order sub-total <span>$0</span>
</div>
<div class="total">Total <span>$0.00</span></div>

<?php } ?>
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

<!--<div class="row">-->
<!--
<div class="compphoto clearfix"><div class="bdrsdo">
<div class="topinfortab clearfix">
<div class="compimg"><a href="images/compee.png" rel="prettyPhoto"><img src="<?=base_url()?>assets/images/compee.png" ></a>
<div class="com"><input id="f2" checked type="checkbox"><label class="icon" for="f2"></label> <span>$200</span></div>
</div>
<div class="compimg"><a href="images/compee.png" rel="prettyPhoto"><img src="<?=base_url()?>assets/images/compee.png" ></a>
<div class="com"><input id="f2s" checked type="checkbox"><label class="icon" for="f2s"></label> <span>$200</span></div>
</div>
<div class="compimg"><a href="images/compee.png" rel="prettyPhoto"><img src="<?=base_url()?>assets/images/compee.png" ></a>
<div class="com"><input id="f2d" checked type="checkbox"><label class="icon" for="f2d"></label> <span>$200</span></div>
</div>
<div class="col-md-3 cunt comptotal">
<div> &nbsp;</div>
<span style="padding: 14px 25px 44px;">3 Photos<br/>
Total price: <span style="font-size:23px; vertical-align:baseline; color:#000;padding-left: 4px;float: none;">$400.00</span></span>

<span>Total   <span  style="font-size:32px; vertical-align:baseline;padding-left: 4px;float: none; ">$400.00</span> 
<a href="" class="prochk" style=" margin-top:10px; width:100%;">Buy Now</a>
</span>
</div>

</div>
</div>
</div>-->

<!--</div>-->

</div>
</div>

</div>