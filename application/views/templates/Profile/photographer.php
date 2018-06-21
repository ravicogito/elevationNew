<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<?php if(!empty($photographer_info)){ foreach ($photographer_info as $photographer){ ?>
<div class="authorshot bdrsdo ">

<div class="col-md-4"><img src="<?php echo base_url();?>assets/images/profile.png"></div> 
<div class="col-md-6"><h5><?php echo $photographer['photographer_name']; ?><i>(Member Since. <?php echo date("d.m.Y", strtotime($photographer['member_on'])); ?>)</i></h5>
<p class="autodesc"><?php echo $photographer['photographer_description']; ?></p>

<div class="autinfo clearfix">
<a href=""><span class="icon"></span><strong><?php echo $photographer['photographer_email']; ?></strong></a>
<span class="rgt"><span class="icon"></span><?php echo $photographer['photographer_mobile']; ?></span>
</div>

</div>
<div class="col-md-2 cunt">
<div> &nbsp;</div>

<span>Ski Attend   <span><?php if(!empty($event_attened)){if(array_key_exists($photographer['photographer_id'],$event_attened)){ echo $event_attened[$photographer['photographer_id']]; } else{ echo 'NA' ;} }else{ echo 'NA' ;} ?></span></span>

<span>Total Photo  <span><?php if(!empty($total_photo)){if(array_key_exists($photographer['photographer_id'],$total_photo)){ echo $total_photo[$photographer['photographer_id']]; } else{ echo 'NA' ;} }else{ echo 'NA' ;} ?></span> </span>
</div>
</div>
<?php } }
else{
?>	
	<div class="noimge">
		<h3>You have no photographer on this location.</h3>
		<span>To choose another location.Please <a class="book_submit" href="<?php echo base_url(); ?>">click here</a>
	</div>
<?php } ?>
</div>
</div>

</div>


