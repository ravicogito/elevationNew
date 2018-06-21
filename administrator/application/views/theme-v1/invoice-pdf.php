<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style type="text/css">
*{padding:0; margin:0;}
.invoive_table{border:1px solid #CCC; width:1000px; margin:0 auto; margin-top:20px; font-family:Arial, Helvetica, sans-serif;}
.invoive_table td{padding:10px;}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
    <img src="<?php echo $front_url; ?>assets/images/logo.png"/>    

    	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="invoive_table">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="36" align="left" valign="middle">Order:	<?=$orderDetails[0]['order_no']?></td>
    <td height="36" align="left" valign="middle">&nbsp;</td>
    <td height="36" align="right" valign="middle">Date 	<?=$orderDetails[0]['order_datetime']?></td>
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
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">From:
      <?=$orderDetails[0]['customer_firstname']." ".$orderDetails[0]['customer_lastname']?><br>
      <?=nl2br($orderDetails[0]['customer_address']);?><br>
    </td>
  </tr>
  <tr>
    <?php $shipAddArr     = explode("|", $orderDetails[0]['ship_address']);?>  
    <td align="left" valign="top">Ship to: 	<?=$shipAddArr[0]?><br>
      <?=nl2br($shipAddArr[1]);?><br>
      <?=$shipAddArr[2];?>
    </td>
  </tr>
</table>
</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php $billAddArr     = explode("|", $orderDetails[0]['bill_address']);?>
    <td align="right" valign="top">Bill to: 	<?=$billAddArr[0]?><br>
<?=nl2br($billAddArr[1]);?><br>
<?=$billAddArr[2]?></td>
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
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="108" align="left" valign="middle">Customer Note:	<?=$orderDetails[0]['customer_note']?></td>
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
				<tbody><tr>
			    	<th width="5%" height="36">Qty.</th>
			    	<th width="15%" height="36">SKU</th>
			    	<th width="45%" height="36">Description</th>
			    	<th width="15%" height="36">Payment Status</th>
			    	<th width="10%" height="36">Unit Prices</th>
			    	<th width="10%" height="36">Total Price</th>
				    </tr>
          <?php $totalPrice = 0;
                foreach($orderDetails as $key => $order) {
                  $totalPrice   += $order['total_price'];  
          ?>
          <tr>
					<td width="5%" align="center" valign="middle"><?=$order['quantity']?></td>
			    	<td width="15%" align="center" valign="middle" style="padding: 5px;">
					<a href="#"><img src="<?=$order['canvas_img']?>" width="100" height="100"></a><br>
			    	</td>
			    	<td width="45%" align="center" valign="middle">Picture: <?=$order['order_img']?> Event: <?=$order['event_name']?> Size: <?=$order['option_size']?> <?php if($order['option_name'] == 'Framing'){ echo "Frame : ".$order['option_meta_frame'];} else { echo $order['option_name']; }?></td>
			    	<td width="15%" align="center" valign="middle"><?=$order['payment_status']?></td>
			    	<td width="10%" align="center" valign="middle">$<?=$order['price']?></td>
			    	<td width="10%" align="center" valign="middle">$<?=$order['total_price']?></td>
				  </tr>
          <?php }?>
</tbody></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table style="border: solid 1px #ccc;" width="100%" cellspacing="0" cellpadding="0" border="1" bordercolor="#CCCCCC">
  <tbody>
    <tr>
      <td width="70%" height="30" align="left" valign="middle" style="padding-left:10px;"> <b>Total:</b></td>
      <td style="padding-right:10px;" align="right" width="30%"> $<?=$totalPrice?></td>
    </tr>
  </tbody>
</table></td>
  </tr>
</table>


        
    </div>
</div>
</div>
  <!-- /.content-wrapper -->