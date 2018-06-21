<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<?php 
	if(!empty($photographer_info)) { 
		foreach($photographer_info as $key => $val) {
?> 
<div class="authorshot bdrsdo ">

<div class="col-md-4"><img src="<?php echo base_url();?>assets/images/profile.png"></div> 
<div class="col-md-6"><h5><?php echo $val['info']['name']; ?><i>(Member Since. <?php echo $val['info']['member_on']; ?>)</i></h5>
<p class="autodesc"><?php echo $val['info']['description']; ?></p>

<div class="autinfo clearfix">
<a href="mailto:<?=$val['info']['email'];?>"><span class="icon"></span><strong><?php echo $val['info']['email']; ?></strong></a>
<span class="rgt"><span class="icon"></span><?php echo $val['info']['phone']; ?></span>
</div>

</div>
<div class="col-md-2 cunt">
<div> &nbsp;</div>

<span>Ski Attend   <span><?php if(!empty($event_attened[$key])){ if(array_key_exists($key,$event_attened)){ echo $event_attened[$key]; } else{ echo 'NA' ;} }else{ echo 'NA' ;}  ?></span></span>

<span>Total Photo  <span><?php if(!empty($total_photo[$key])){ if(array_key_exists($key,$total_photo)){ echo $total_photo[$key]; } else{ echo 'NA' ;} }else{ echo 'NA' ;}  ?></span> </span>
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


