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
              <!--<span style="padding: 8px 13px;text-align: right;"> Total price: <span style="font-size:23px; vertical-align:baseline;padding-left: 4px;float: none;"><?php //echo $total_prices; ?>
              </span></span>-->
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
              <h3>Order details</h3>
              <div class="topinfortab clearfix">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_dtltable">
                  <tr>
                  <!--<th align="left" valign="top">Order Id</th>-->
					<th align="left" valign="top">Image</th>
                    <th align="left" valign="top">Features</th>                    
                    <th align="left" valign="top">Quantity</th>
                    <th align="left" valign="top">Price</th>
                  </tr>
                  <?php $total_price = 0;
				  foreach($order_details as $key => $order_list){
					  
						$total_price  += $order_list['price'];
					?>
                  <tr>
                 <!--  <td align="left" valign="top">or#1803932842</td>
                  <td align="left" valign="top">9Y511876UG841512L</td>-->
				  
				 <!--//**********sreela(05/04/18)*********-->
                    <td align="left" valign="middle">	<img src="<?=$order_list['canvas_img'];?>" width="100px"height="100px"></td>
					<td align="left" valign="middle">	<span>
					  <p><strong>Option Name :</strong> <?php echo $order_list['option_name'];?></p>
													<p><?php if(!empty($order_list['option_meta_frame'])){?>
													<strong>Frame :</strong> <?php echo $order_list['option_meta_frame'];
													}
													?></p>
													<?php if(!empty($order_list['option_top_mat'])){?>
														<p><strong>Top Mat :</strong> <?php echo $order_list['option_top_mat']; ?></p>
														<?php } ?>
														<?php if(!empty($order_list['option_middle_mat'])){?>
														<p><strong>Middle Mat :</strong> <?php echo $order_list['option_middle_mat']; ?></p>
														<?php } ?>
														<?php if(!empty($order_list['option_bottom_mat'])){?>
														<p><strong>Bottom Mat :</strong> <?php echo $order_list['option_bottom_mat']; }?></p>
														<p><strong>Size :</strong> <?php echo $order_list['option_size'];?></p><br>
														</span>
					</td>
                   <!--****************End****************-->
                    <td align="left" valign="middle"><?php echo $order_list['quantity'];?></td>
                    <td align="left" valign="middle">$<?php echo number_format($order_list['price'],2);?></strong></td>
                  </tr>
                 
                  <?php } ?>
                   <tr><td align="right" valign="top" colspan="4" class="price_col"><span style="padding: 8px 13px;text-align: right; display:block;"> Total price: <span style="font-size:23px; vertical-align:baseline;padding-left: 4px;float: none; color:#bd125e;"> <strong>$<?php echo $total_price; ?></strong>
              </span></span></td></tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
