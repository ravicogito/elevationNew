<?php 	unset($_SESSION['cartVal']); 
		unset($_SESSION['subtotal']); ?>
<div class="contwrap">
  <div class="container-fluid">
    <div class="wrap">
      <!--<div class="row addban"><img src="<?=base_url()?>assets/images/adban.png" width="1226" height="177"></div>-->
      <div class="row">
        <div class="col-md-9">
          <h2 style="padding-left: 10px;">Payment successful.</h2>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="wrap">
  <div class="thanku">
    <div class="contwrap">
      <div class="container-fluid">
        <div class="wrap">
          <div class="authorshot bdrsdo">
            <div class="col-md-6 acnam"><span class="icon"></span>
              <h5>Thank You
                <?php $total_prices = 0;
				foreach($order_details as $key => $order_list){	  
					$total_prices  += $order_list['price'];
				}
				if(!empty($customer_details)){ echo $customer_details['customer_firstname'].' '.$customer_details['customer_lastname'] ; } ?>
                <br/>
                <i>You have successfully purchased the images.</i></h5>
            </div>
            <div class="col-md-4 cunt mydtl">
              <div> &nbsp;</div>
             
              <span style="text-transform: none;">Order No.<span class="rgt" style="color:#575653;float: right !important;font-weight: ;font-weight: 100;"><strong><?php echo $order_details[0]['order_no']; ?></strong>
              </span></span>
              <span style="text-transform: none;">Transaction No. <span class="rgt" style="color:#575653;float: right !important;font-weight: ;font-weight: 100;"><strong><?php echo $order_details[0]['transaction_id']; ?></strong>
              </span></span>
              <?php 	$tmp_data	= strtotime($order_details[0]['order_datetime']) ;
		$date		= date("d/m/Y",$tmp_data);
		$time		= date('h:i A', $tmp_data);
?>
              <span style="text-transform: none;">Date: <strong><?php echo $date; ?></strong> <span class="rgt" style="color:#575653;float: right !important;font-weight: ;font-weight: 100;">Time:
              <strong><?php echo $time;?></strong>
              </span></span>
               
            </div>

          </div>
          <div class="compphoto clearfix odrttl">
            <div class="bdrsdo orddets">              
              <div class="topinfortab clearfix">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_dtltable">
                  <tr>
                  <!--<th align="left" valign="top">Order Id</th>-->
					<th align="left" valign="top" width="20%">Image</th>
                    <th align="left" valign="top" width="20%">Features</th>     
					<th align="left" valign="top" width="20%">Image Details</th>
                    <th align="left" valign="top" width="20%">Quantity</th>
                    <th align="left" valign="top" width="20%">Price</th>
					<th align="left" valign="top" width="20%">Download</th>
                  </tr>
                  <?php $total_price = 0;
					if(!empty($orderDetails)){
						foreach($orderDetails as $key => $opn_list){ 
					?>
					
					<tr >
						<td colspan="7">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_dtltable">
						<?php if($opn_list[0]['digital_price'] != '0'){ ?>
						<tr><td colspan="6">
								<?php 
										echo "<h3><br/>For Download Image: $" .number_format($opn_list[0]['digital_price'],2)."</h3>";									
								?>
						</td></tr>
						<?php } ?>	
					<?php foreach($opn_list as $key => $val) {
						?>
						
						<tr class="price_col">
							<td align="left" valign="left" width="18%" class="price_col">					
								<?php 
								if($val['option_name']=="Only Print"){
								 $img = rtrim($val['canvas_img'],'~');
								 $imgArray  = explode('~',$img);
								 foreach($imgArray as $image){
								?>
								<img src="<?=$image;?>" width="100px"height="100px">
								
								<?php 
								   echo "<br/>"; 					
								} }
								else{
								
									$img = rtrim($val['canvas_img'],'~');
									$imgArray  = explode('~',$img);
									foreach($imgArray as $image){
									?>
									<img src="<?=$image;?>" width="100px"height="100px">
									<?php } 
								}?>
							</td>
							<td align="left" valign="left" width="19%" class="price_col">	
								<span>
									
									<p><strong>Size :</strong> <?php echo $val['option_size'];?></p><p><strong>Option Name :</strong> <?php echo $val['option_name'];?></p><br>
								</span>
							</td>
							<td align="left" valign="left" width="19%" class="price_col">
								<?php 
								if($val['option_name'] == "collage"): 
								$explode_eventid = explode(',',$val['event_id']);
								$order_images = array_unique(explode(',',$val['order_img']));
								$event_ids = array_unique($explode_eventid);
								?>
							
								<?php
								$event_name = array();
								$order_image = array();
								
									foreach($get_all_events as $get_all_event){
										if(in_array($get_all_event['event_id'],$event_ids)){
										$event_name[] = $get_all_event['event_name']; 
										$order_image = $order_images; 
										}
									}
									$event_name_implode = implode(',',$event_name); 
									$get_order_image = implode(',',$order_image); 
								?>
							
								<p><strong>Event Name :</strong> <?php echo $event_name_implode;?></p>
								
								<?php else: 
									$event_id = array();
									$event_id[] = $val['event_id'];
									$order_image = $val['order_img'];
								
									foreach($get_all_events as $get_all_event){
										if(in_array($get_all_event['event_id'],$event_id)){
											$event_name = $get_all_event['event_name'];
										}
									}
									
								?>
							
								<p><strong>Event Name :</strong> <?php echo $event_name;?></p>
							
								<?php endif; ?>
							</td>
							   <!--****************End****************-->
							<td align="left" valign="left" width="18%"><?php echo $val['quantity'];?></td>
							<td align="left" valign="left" width="18%">$<?php echo number_format($val['price']*	$val['quantity'],2);?></strong>								
							</td>
							<td align="left" valign="left" width="18%" class="price_col">
							<?php 
							if($val['option_meta_frame']=="yes"){
							$order_image = explode('~',$val['order_img']);
							$image_id = explode('-',$val['media_id']);
							foreach($order_image as $orderimg){
							$download_img = $val['img_path'].$orderimg;						
							?>	<input type="hidden" id="download_img" value="<?php echo $download_img; ?>">
								<a class="download_link" title="<?php echo $orderimg; ?>" rel="<?php echo $download_img; ?>" href="javascript:void(0)"><?php echo $orderimg;?></a>
								<br/> 
							<?php	
							}}
							?>
							</td>
							<?php }?>
						</tr>						
						</table>
						</td>
						</tr>	
					<?php } ?>
					<tr>
					   <td align="right" valign="top" colspan="6" class="price_col"><span style="padding: 8px 13px;text-align: right; display:block;"> Total price: <span style="font-size:23px; vertical-align:baseline;padding-left: 4px;float: none; color:#bd125e;"> <strong>$<?php echo number_format($val['total'],2); ?></strong>
						</span></span>
						</td>
					</tr>
					<?php } ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	
	$(".download_link").click(function(){
		var downloadLink		= $(this).attr('rel');
		var imageName			= $(this).attr('title');

		$.ajax({
	          url: _basePath+"CartAdd/download/",
			  async : false,
	          data: {download_link: downloadLink, image_name:imageName},
	          type: 'POST',
				
	          success: function(response) {  
					//alert(response);
					console.log(response);
					//alert(response);
					var filename = response.split(',');
					//window.location.href=response;
					//alert(filename[0]);
					//alert(filename[1]);
					var a = $("<a>").attr("href", filename[0]).attr("download", filename[1]).appendTo("body");
					a[0].click();
					a.remove();
	          },
	        });
	});
});
</script>