<div class="compphoto clearfix odrttl">
	<div class="bdrsdo">
	  <div class="topinfortab clearfix">
	  
	  
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:960px; margin:0 auto; border:1px solid #CCC; font-family:arial;">
  <tr>
    <td align="center" valign="top"><h3>Order details</h3></td>
  </tr>
  <tr>
    <td align="center" valign="top" style="padding:15px 0;"><img src="<?php echo base_url(); ?>assets/images/logo.png" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #dfdfdf; border-left:0; border-right:0;">
	<?php 
		$tmp_data	= strtotime($order_details[0]['order_datetime']) ;
		$date		= date("d/m/Y",$tmp_data);
		$time		= date('h:i A', $tmp_data);
	?>	
  <tr style="background: #f9f9f9; font-size: 14px;">
    <td height="40" align="left" valign="middle" style="padding:10px;"><strong>Order No:</strong> <?php echo $order_details[0]['order_no']; ?></td>
    <td align="left" valign="middle" style="padding:10px;">&nbsp;</td>
    <td align="right" valign="middle" style="padding:10px;"><strong>Date:</strong> <?php echo $date; ?></td>
  </tr>
  <tr style="background: #f9f9f9; border-top:1px solid #dfdfdf; font-size: 14px;">
    <td height="40" align="left" valign="middle" style="padding:10px;"><strong>Transaction No.</strong> <?php echo $order_details[0]['transaction_id']; ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="middle" style="padding:10px;"><strong>Time:</strong> <?php echo $time;?></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="font-size: 14px; border-color: #bcbcbc; width: 98%; margin: 0 auto; margin-bottom:20px;">
  <tr>
    <th height="40" align="left" valign="middle" style="padding:10px; text-align:center;">Image</th>
    <th height="40" align="left" valign="middle" style="padding:10px; text-align:center;">Features</th>
    <th height="40" align="left" valign="middle" style="padding:10px; text-align:center;">Image Details</th>
    <th align="left" valign="middle" style="padding:10px; text-align:center;">Price</th>
	<th align="left" valign="middle" style="padding:10px; text-align:center;">Download</th>	
  </tr>
   <?php
		  $total_price =0;
		  if(!empty($order_details)){
		  foreach($order_details as $key => $order_list){
          $total_price  += $order_list['price']*$order_list['quantity'];
	?>
  <tr>
    <td align="center" valign="middle" style="padding:10px;">
		<?php 
			if($order_list['option_name']=="Only Print"){
			 $img = rtrim($order_list['canvas_img'],'~');
			 $imgArray  = explode('~',$img);
			 foreach($imgArray as $image){
			?>
			<img src="<?=$image;?>" width="100px"height="100px">
			
			<?php 
			   echo "<br/>"; 					
			 } }else{
			
			$img = rtrim($order_list['canvas_img'],'~');
			$imgArray  = explode('~',$img);
			foreach($imgArray as $image){
			?>
			<img src="<?=$image;?>" width="100px"height="100px">
		<?php } }?>
	</td>
    <td align="center" valign="middle" style="padding:10px;">
		<span>
							
			<p><strong>Size :</strong> <?php echo $order_list['option_size'];?></p><p><strong>Option Name :</strong> <?php echo $order_list['option_name'];?></p><br>
		</span>
	</td>
    <td align="center" valign="middle" style="padding:10px;">
		<?php if($order_list['option_name'] == "collage"): ?>
			<?php
			$explode_eventid = explode(',',$order_list['event_id']);
			$order_images = array_unique(explode(',',$order_list['order_img']));
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
		<?php else: ?>
							
			<?php
				$event_id = array();
				$event_id[] = $order_list['event_id'];
				$order_image = $order_list['order_img'];
			
				foreach($get_all_events as $get_all_event){
					if(in_array($get_all_event['event_id'],$event_id)){
						$event_name = $get_all_event['event_name'];
					}
				}
				
			?>
			
			<p><strong>Event Name :</strong> <?php echo $event_name;?></p>
			<!--<p><strong>Image Name :</strong> <?php echo $order_image;?></p>-->
		<?php endif; ?>
	</td>
	<td align="center" valign="middle" style="padding:10px;"><?php echo $order_list['quantity'];?></td>	
	<td align="center" valign="middle" style="padding:10px;">$<?php echo number_format($order_list['price']*		  $order_list['quantity'],2);?></strong>
		<?php if(!empty($order_list['digital_price'])){
			echo "<br/>For Download Image: $" .number_format($order_list['digital_price'],2); } 
			?>
	</td>
	<td align="center" valign="middle" style="padding:10px;">
		<?php 
			if($order_list['option_meta_frame']=="yes"){
			$order_image = explode('~',$order_list['order_img']);
			$image_id = explode('-',$order_list['media_id']);
			foreach($order_image as $orderimg){
			$download_img = $order_list['img_path'].$orderimg;						
			?>	<input type="hidden" id="download_img" value="<?php echo $download_img; ?>">
				<a class="download_link" title="<?php echo $orderimg; ?>" rel="<?php echo $download_img; ?>" href="<?php echo $download_img;?>"><?php echo $orderimg;?></a>
				<br/> 
			<?php	
			}}else{ echo "No Download.";}
		?>
	</td>
  </tr>
		  <?php } } ?>
  <tr>
    <td height="60" colspan="5" align="right" valign="middle" style="padding:10px;"><span style="padding: 8px 13px;text-align: right; display:block;"> Total price: <span style="font-size:23px; vertical-align:baseline;padding-left: 4px;float: none; color:#bd125e;"> <strong>$<?php echo number_format($order_list['total'],2); ?></strong>
	</span></span></td>
  </tr>
  	
</table>
</td>
  </tr>
   <tr>
    <td align="left" valign="top" colspan="5" style="padding:10px;"><strong>Special Note:</strong> <?php echo $order_details[0]['customer_note']; ?></td>
  </tr>
</table>
		
	  </div>
	</div>
  </div>