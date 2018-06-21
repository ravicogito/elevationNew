<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<?php if(!empty($orderDetails)){?>
<div class="row">

<div class="col-md-9 col-sm-9">
<?php foreach($orderDetails as $order) {?>
<div class="wishl bdrsdo odrr">

<span class="col-md-6 col-sm-5 photodtl"><span>
Order ID: <strong style="margin-right:10px;"><?php echo $order['order_no']; ?></strong>  Order Date: <strong> <?php $order_date=explode(' ',$order['order_datetime']); echo  date("d-m-Y", strtotime($order_date[0])); ?></strong></span>
</span>

<span class="col-md-4 col-sm-5 photodtl" style="text-align:right">
<span>Photo Resolution: &nbsp;<strong>300dpi</strong> <br/><i>(This is high resolution photo for print)</i></span>
</span>

<span class="col-md-2 col-sm-2 dtlpric">TOTAL:
<span>$<?php echo number_format( $order['total'],2 );?></span>
<a href="<?php echo base_url(); ?>cart/orderdetails/<?php echo $order['order_id']; ?>">View Details</a>
</span>
<br clear="all">
<div class="dag"></div>
<div class="imgrow stli">


<?php if(!empty($orderImgDetails[$order['order_id']])) {  foreach($orderImgDetails[$order['order_id']] as $ImgDetails){
?>
<figure class="col-md-2 col-sm-2 col-xs-6">  
<img src="<?php echo $ImgDetails['canvas_img'];?>" width="100px"height="100px">

<figcaption> 
Price $<?php echo number_format($ImgDetails['price']*$ImgDetails['quantity'],2);?>
</figcaption>
</figure>
<?php
 }
 }
 ?>
  
  </div>


<br class="clear" />
</div>

<?php } ?>
<div class="paginatation ">
<?php echo $links; ?>


<div class="clearfix"></div>
</div>
</div>

<div class="col-md-3 col-sm-3">

<div class="sumary bdrsdo  odrsum">
<h3 style="margin-bottom: 0;">Order Summary</h3>
<?php $grand_total = 0;
foreach($orderDetails as $order) {
$grand_total+= $order['total'];	
?>
<div class="sbtotl">
Order ID: <?php echo $order['order_no']; ?> <span style="display:block;">$<?php echo number_format( $order['total'],2 );?></span></div>
<?php }?>
<div class="total">Total <span>$<?php echo number_format($grand_total,2);?></span></div>




</div>

<div class="sumary bdrsdo" >
<h3>payment method</h3>
<div class="sbtotl" style="text-align:left;">Please choose your payment
option here</div>

<div class="total" style="text-align:left;">We accepet <br/><br/>
  <img src="<?php echo base_url();?>assets/images/payment-method.png" alt="pay" width="206" height="21"></div>




</div>





</div>
</div>
<?php } else {?>
<div class="row">
<div class="col-md-9 col-sm-9">
<div class="wishl bdrsdo odrr">
Order is empty.
<?php } ?>
</div></div>
<!--<div class="row">--></div>
</div>

</div>











