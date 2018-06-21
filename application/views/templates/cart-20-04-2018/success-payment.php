<div class="contwrap">
	<div class="container-fluid">
		<div class="wrap">

			<div class="row addban"><img src="<?=base_url()?>assets/images/adban.png" width="1226" height="177"></div>
			<div class="row">  
			  	<div class="col-md-9">
			  		<h2>Payment successful.</h2>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="myaccount">
<div class="contwrap">
<div class="container-fluid">

<div class="wrap">
<div class="thanku">


<div class="contwrap">
<div class="container-fluid">

<div class="wrap">

<div class="authorshot bdrsdo ">
<div class="col-md-6 acnam"><span class="icon"></span><h5>Thank You<br/><i>You have successfully purchased the images.</i></h5>
</div>
<div class="col-md-3 cunt mydtl">
<div> &nbsp;</div>
<span style="padding: 8px 13px;text-align: right;/*! vertical-align: bottom; */">
Total price: <span style="font-size:23px; vertical-align:baseline;padding-left: 4px;float: none;">$<?php echo $total; ?></span></span>
<span style="text-transform: none;">Date: <?php echo date("d/m/Y"); ?> <span class="rgt" style="color:#575653;float: right !important;font-weight: ;font-weight: 100;">Time: <?php 

$currentDateTime = date("h:i:s");
$newDateTime = date('h:i A', strtotime($currentDateTime));
echo $newDateTime;?></span></span>
</div>
</div>



<div class="compphoto clearfix odrttl"><div class="bdrsdo">
<h3>Order details</h3>

<div class="topinfortab clearfix">
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
<div class="compimg"><a href="<?=$imagePath;?>?>" rel="prettyPhoto"><img src="<?=$imagePath;?>"></a></div>
	<?php }}}} }  ?>

</div>
</div>
</div>

</div>
</div>
</div>

</div>