<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style type="text/css">
body{font-family:Arial, Helvetica, sans-serif; font-size:14px;}
*{padding:0; margin:0;}
.invoive_table{border:1px solid #CCC; width:1000px; margin:0 auto; margin-top:20px;}
</style>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<body onLoad="printDiv('printableArea')">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="printableArea">
<div class="content animate-panel">
    <div class="row">
        

    	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="invoive_table">
  <tr>
    <td style="padding-left:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" align="left" valign="middle">Order # 	<strong><?=$orderDetails[0]['order_no']?></strong></td>
    <td width="100" height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">Date 	<strong><?=$orderDetails[0]['order_datetime']?></strong></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" style="padding-left:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">From:
      <?=$orderDetails[0]['customer_firstname']." ".$orderDetails[0]['customer_lastname']?><br>
      <?=nl2br($orderDetails[0]['customer_address']);?><br>
    </td>
  </tr>
  <tr>
    <?php $shipAddArr     = explode("|", $orderDetails[0]['ship_address']);?>  
    <td align="left" valign="top">Ship to: 	<?=$shipAddArr[0]?><br>
      <?=nl2br($shipAddArr[1]);?>,<br>
      <?=$shipAddArr[2];?>,<br>
      <?=(!empty($shipAddArr[4]) ? $shipAddArr[4] : '');?><br>
     <?=(!empty($shipAddArr[5]) ? $shipAddArr[5] : '');?><br>
	 <?php if(!empty($shipAddArr[6])): ?>
      Pin:-<?=(!empty($shipAddArr[6]) ? $shipAddArr[6] : '');?>
	  <?php endif; ?>
    </td>
  </tr>
</table>
</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php $billAddArr     = explode("|", $orderDetails[0]['bill_address']);?>
    <td align="left" valign="top">Bill to: 	<?=$billAddArr[0]?><br>
<?=nl2br($billAddArr[1]);?><br>
<?=$billAddArr[2]?>,<br>
<?=(!empty($billAddArr[4]) ? $billAddArr[4] : '');?><br>
  <?=(!empty($billAddArr[5]) ? $billAddArr[5] : '');?><br>
  <?php if(!empty($billAddArr[6])): ?>
  Pin:-<?=(!empty($billAddArr[6]) ? $billAddArr[6] : '');?>
  <?php endif; ?></td>
  </tr>
  <!-- <tr>
    <td align="left" valign="top">Bill to: 	Card: American Express
Card #: XXXXXXXXXXXX-3002
Card Holder: Gregory Gierwielaniec
Exp. Date: 04/2023 </td>
  </tr> -->
</table>
</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
		<table style="border: solid 1px #ccc; border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="0" border="1">
			<tbody>
					<tr>
						<th width="15%" height="40">Photo</th>
						<th width="30%" height="40">Description</th>
						<th width="10%" height="40">Status</th>
						<th width="5%" height="40">Qty.</th>
						<th width="15%" height="40">Unit Prices</th>
						<th width="20%" height="40">Total Price</th>
				</tr>
			  <?php $totalPrice = 0;
					foreach($orderDetails as $key => $order) {
					  $totalPrice   += $order['total_price'];  
			  ?>
			  <tr>
				  <td width="15%" align="center" style="padding: 5px;">
						<a href="#"><img src="<?=$order['canvas_img']?>" width="100" height="100"></a><br>
				  </td>
				  <td width="40%" align="center">Picture: <?=$order['order_img']?> Event: <?=$order['event_name']?> Size: <?=$order['option_size']?> <?php if($order['option_name'] == 'Framing'){ echo "Frame : ".$order['option_meta_frame'];} else { echo $order['option_name']; }?></td>
				  <td align="center">
						<?php if($order['order_status'] == 0): ?>
							Cancel
						<?php elseif($order['order_status'] == 1): ?>
							New
						<?php elseif($order['order_status'] == 2): ?>
							Processing
						<?php elseif($order['order_status'] == 3): ?>
							Shipped
						<?php elseif($order['order_status'] == 4): ?>
							Backorderd
						<?php endif; ?>
				  </td>
				  <td width="5%" align="center"><?=$order['quantity']?></td>
				  <td width="15%" align="center">$<?=$order['price']?></td>
				  <td width="15%" align="center">$<?=$order['total_price']?></td>
			    </tr>
			  <?php }?>
			</tbody>
			
		</table>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table style="border: solid 1px #ccc;" width="100%" cellspacing="0" cellpadding="0" border="1">
  <tbody>
    <tr>
      <td width="70%" height="40" align="left" style="padding-left:10px;"> Sub Total:</td>
      <td style="padding-right:10px;" align="right" width="30%"> $<?=$totalPrice?></td>
    </tr>
    <tr>
      <td width="70%" height="40" align="left" style="padding-left:10px;"> Coupon/Gift Cert:</td>
      <td style="padding-right:10px;" align="right" width="30%"> (0.00)</td>
    </tr>
    <tr>
      <td width="70%" height="40" align="left" style="padding-left:10px;"> Point Discount:</td>
      <td style="padding-right:10px;" align="right" width="30%"> (0.00)</td>
    </tr>
    <tr>
      <td width="70%" height="40" align="left" style="padding-left:10px;"> Tax:</td>
      <td style="padding-right:10px;" align="right" width="30%"> 0.00</td>
    </tr>
    <tr>
      <td width="70%" height="40" align="left" style="padding-left:10px;"> Shipping: Standard Delivery</td>
      <td style="padding-right:10px;" align="right" width="30%">$<?=$shipping_price?></td>
    </tr>
   
    <tr>
      <td width="70%" height="40" align="left" style="padding-left:10px;"><b>Order Total:</b></td>
      <td style="padding-right:10px;" align="right" width="30%"> $<b><?=number_format(($totalPrice+$shipping_price), 2, '.', '');?></b></td>
    </tr>
  </tbody>
	
</table>
</td>
  </tr>
</table>
<div style="width:1000px; margin:0 auto; margin-top:15px; margin-bottom:15px;">
    
    <p><?php if(!empty($customer_admin_note['customer_note'])): ?>
      <strong>Customer Note:<?php echo $customer_admin_note['customer_note']; ?></strong>
      <?php endif; ?></p>
    
    <p><?php if(!empty($customer_admin_note['admin_note'])): ?>
      <strong>Admin Note:<?php echo $customer_admin_note['admin_note']; ?></strong>
      <?php endif; ?></p>
    
</div>
    </div>
</div>
</div>
</body>
  <!-- /.content-wrapper -->