
<?php if(!empty($locationDetails)){

	  $i=1;
	if(!empty($eventDetails)){
	foreach($eventDetails as $events){
	if(!empty($alleventsimages)){	
	if(array_key_exists($events['event_id'],$alleventsimages)) {
?>	
<div class="boxsec col-md-12" >
<div class="bdrsdo">
 
<div class="boxlft col-md-8" id="galpto<?php echo $i; ?>">
<div class="slider">
			
			
			<div class="carousel"> 
			<?php foreach($alleventsimages[$events['event_id']] as $list){ 	
				$imgArr 		= explode(".",$list['file_name']);
				$extension 		= end($imgArr);
				$imagePath  = base_url()."uploads/customerImg_".$list['customer_id']."/"."thumb/".$imgArr[0]."-826X511.".$extension;	
				$file_name=$imgArr[0]."-826X511.".$extension;
				
			?>			
            <a href='<?php echo $imagePath ?>' class="poppto" rel="prettyPhoto[gallery<?php echo $i; ?>]"  title="<div class='pictureId' style='display:none'><?php if(empty($events['event_price'])){?><span class='pricpto'>$<?php echo number_format($list['media_price'], 2, ".",""); ?></span><?php } ?><div class='rgt'><a href=''><span class='icon'></span>Cherished Moments</a><a <?php if(!empty($events['event_price'])){?>class='disabled'<?php } ?> href='<?php echo base_url();?>cart/add/<?php echo $list['media_id'];?>'><span class='icon'></span>bUY nOW</a><a href=''><span class='icon'></span>Sample Download</a><a href=''><span class='icon'></span>share</a></div></div>"><img src='<?php echo $imagePath ?>'></a>	
			<?php  } ?>	
            </div>
			
		<a class="prev" href="#"></a>
		<a class="next" href="#"></a>
</div>
<a href="" class="zoom"><img src="<?php echo base_url(); ?>assets/images/zoom.png" width="44" height="44"></a>
<div class="bxtxt col-md-6"> <?php echo $events['event_name']; ?> <span><?php echo $events['location_name']; ?> <br/> <?php echo date("d-m-Y", strtotime($events['event_date'])); ?><br/> RFID: <?php if(!empty($locationDetails['cust_rf_id'])){echo $locationDetails['cust_rf_id'];}else{echo "NA";} ?> </span> <div class="bxbtn"><?php if(!empty($photographer[$events['photographer_id']])){echo $photographer[$events['photographer_id']]; } else {echo 'NA';}?></div></div></div>
<div class="boxrgt col-md-4">
<a href="" class="col-md-6 hovv"><span class="icon obld"><?php if(!empty($total_photo[$events['event_id']])){echo $total_photo[$events['event_id']]; } else {echo 'NA';}?></span><span class="atit">Total</span> <span class="atit sml">photo taken </span></a> 
<a href="<?php echo base_url(); ?>CustomerPhotos/photodetails/<?php echo $events['location_id']; ?>/<?php echo $events['event_id']; ?>" class="col-md-6 hovv"><span class="icon"></span><span class="atit">Details</span> <span class="atit sml">all your photograph</span></a> 
<a href="" class="col-md-6 hovv"><span class="icon"></span><span class="atit">make </span> <span class="atit sml">my frame</span></a> 
<a href="" class="col-md-6 hovv"><span class="icon"></span><span class="atit">share</span> <span class="atit sml">this album</span></a> 
</div>
<input type="hidden" id="l_id" value ="<?php echo $events['location_id']; ?>">
</div>
</div>

  <?php $i++; } 
  }
	else{
?>
	<div class="noimge">

		<h3>You have no photo on this location.</h3>

		<span>To see your photos of your location.Please <a class="book_submit" href="<?php echo base_url(); ?>CustomerPhotos/customerEventPhotoList/">click here</a>

	</div>
<?php		
	}

  }

}
}
?>
<div id="loadmoreajax"></div>
<?php if($loadmorecount > 0){ ?>
<div class="lodmor" id="loadmore"><a style="text-decoration:none" href="javascript:void(0)" onclick= "addMore();">load more</a></div> <?php  } ?>