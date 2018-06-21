<div class="compphoto clearfix odrttl">
	<div class="bdrsdo">
	  <h3>Order details</h3>
	  <div class="topinfortab clearfix">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_dtltable">
		  <tr>
			<th align="left" valign="top">Transaction Id</th>
			<th align="left" valign="top">Option Name</th>
			<th align="left" valign="top">Option Name</th>
			<th align="left" valign="top">Option Size</th>
			<th align="left" valign="top">Option Quantity</th>
			<th align="left" valign="top">Option Price</th>
		  </tr>
		  <?php foreach($order_details as $key => $order_list){
//$total += $order_list['price'];
?>
		  <tr>
			<td align="left" valign="top">
			<strong>Transaction No. : <?php echo $order_details[0]['transaction_id']; ?></strong>
			<strong>Transaction No. : <?php echo $order_details[0]['order_no']; ?></strong>
			</td>
			<td align="left" valign="top"><strong><?php echo $order_list['option_name'];?></strong></td>
			<td align="left" valign="top"><strong><?php echo $order_list['option_size'];?></strong></td>
			<td align="left" valign="top"><strong><?php echo $order_list['quantity'];?></strong></td>
			<td align="left" valign="top"><strong><?php echo number_format($order_list['price'],2);?></strong></td>
		  </tr>
		  <?php } ?>
		</table>
	  </div>
	</div>
  </div>