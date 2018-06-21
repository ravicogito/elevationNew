<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">
  <tr>
    <td align="center" valign="top" style="border:0;"><br />
<table cellpadding="0" cellspacing="0" width="100%" style="border:0; margin:0 auto;">
<tr><td align="center" style="background:#000; text-align:center; padding:10px 0;"colspan="3" ><a href="<?php echo base_url();?>" class=""><img src="<?php echo base_url();?>assets/images/logo.png" alt="Elevation"/></a></td></tr>
        <tr>

            <th height="30" colspan="3" align="center">Order Details Request</th>

        </tr>
		<tr>
		    <th width="37%" height="30" align="right">Order Date : </th>
			<th width="5%" align="center">&nbsp;</th>
			<td height="30" align="left"><?php echo date('d-m-Y');?></td>
		</tr>

        
		
		
	</table><br />
</td>
  </tr>
  <tr>
    
    <?php if(!empty($photoArr)){
			foreach($photoArr as $key => $eventArr) {
				foreach($eventArr as $j => $val) {
					foreach($val as $i => $valimg) {
					if(is_numeric($i)) {
					
					
	$imgArr 		= explode(".",$valimg[0]['file_name']);
	$extension 		= end($imgArr);
	$imagePath  = base_url()."uploads/customerImg_".$userID."/"."thumb/".$imgArr[0]."-390X320.".$extension;
	
$imagePath				= base_url()."uploads/customerImg_".$userID."/".$valimg[0]['file_name'];
?>
 
<td align="center" valign="top" style="border:0;">

  </td>
  <a href="<?=$imagePath;?>?>" rel="prettyPhoto"><img src="<?=$imagePath;?>"></a>
  </td>


<?php }}}} }  ?>

  </tr>         	 
  <tr>
    <td align="right" valign="top">
	<p><strong>Order Total</strong> <?=$total;?></p> 
   
	<p class="order_total"><strong>Pay Via: </strong> Paypal</p>
</td>
  </tr>
  </table>