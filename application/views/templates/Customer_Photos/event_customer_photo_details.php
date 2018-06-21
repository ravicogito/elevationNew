<style>
.disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6;
    }
</style>
<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<div class="row">

<div class="toprowdtl ">
<div class="bdrsdo">
<div class="topinfortab clearfix">

<span class="col-md-4"><span class="icon"></span><?php echo $locationname; ?>  </span>
<span class="col-md-3"><span class="icon"></span><?php echo $resortname;?></span> 

<span class="col-md-3"><span class="icon"></span><?php echo date("d-m-Y", strtotime($event_date)); ?></span>
<span class="col-md-2"> <a class="linbtn" href="<?php echo base_url(); ?>CustomerPhotos/customerEventPhotoList/<?php echo $locationid; ?>/5">My others ski photo</a> </span></div>
<div class="event_detailsname"><strong>Event Name</strong> : <?php echo $event_name;?> &nbsp: <strong>Price</strong> : <?php if(!empty($event_price)){echo '$'. number_format($event_price,2);?> <a class="bih" href="<?php echo base_url();?>cart/eventadd/<?php echo $event_id;?>" title="<?php echo $event_id;?>"><span class="com ttx">Buy Now</span></a><?php } else { echo 'NA';}?> </div>
</div>
</div>

<div class="imgrow stli">
<?php 
$i=1;
if(!empty($eventAllImages))	{
foreach($eventAllImages as $list_images){
	$imgArr 		= explode(".",$list_images['file_name']);
	$extension 		= end($imgArr);
	$imagePath  = base_url()."uploads/customerImg_".$list_images['customer_id']."/"."thumb/".$imgArr[0]."-826X511.".$extension;	
	$file_name=$imgArr[0]."-826X511.".$extension;	
	
?>	

<figure class="col-md-4 col-sm-4 col-xs-6">  
<a class="" href="<?php echo $imagePath ?>" rel="prettyPhoto[gallery<?php if(!empty($list_images['customer_id'])){ echo $list_images['customer_id']; } ?>]" title="<div class='pictureId' style='display:none'><span class='pricpto'>$<?php if(!empty($list_images['media_price'])){ echo number_format($list_images['media_price'], 2, ".",""); } else{ echo '0'; }?> </span><div class='rgt'><a href='<?php echo base_url();?>wishlist/add/<?php echo $list_images['media_id'];?>'><span class='icon'></span>Cherished Moments</a><a <?php if(!empty($event_price)){?>class='disabled'<?php } ?> href='<?php echo base_url();?>cart/add/<?php echo $list_images['media_id'];?>'><span class='icon'></span>bUY nOW</a><a href='<?php echo base_url();?>profile/sample_download/<?php echo $list_images['customer_id'];?>/<?php echo $file_name; ?>'><span class='icon'></span>Sample Download</a><a href=''><span class='icon'></span>share</a></div></div>"><img src="<?php echo $imagePath ?>" ></a> 
<figcaption> 
<?php if(empty($event_price)){ ?> 
<span class="npppric">$<?php if(!empty($list_images['media_price'])){ echo number_format($list_images['media_price'], 2, ".",""); } else{ echo '0'; }?> </span>
<?php } ?>
Photography By: <strong><?php echo $photographer;?></strong>  <br/>
<a href="<?php echo base_url();?>wishlist/add/<?php echo $list_images['media_id'];?>" class="cris <?php if(!empty($event_price)){?>disabled<?php } ?>"><span class="icon"></span>Cherished Moments</a> <a class="bih <?php if(!empty($event_price)){?>disabled<?php } ?>" href="<?php echo base_url();?>cart/add/<?php echo $list_images['media_id'];?>" title="<?php echo $list_images['media_id'];?>"><span class="com ttx">Buy Now</span></a>
</figcaption>
</figure>



<?php $i++;} ?>
<div class="clearfix"></div>
<div class="paginatation ">
<?php echo $links; ?>


<div class="clearfix"></div>
</div>
<?php } else{ ?>
<figure class="col-md-4">
  No Images published for this Event................
</figure>  
<?php } ?>  
  </div>

</div>
</div>
</div>
</div>