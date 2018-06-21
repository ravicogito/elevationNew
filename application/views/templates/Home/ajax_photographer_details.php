<div class="photod">
<?php if(!empty($photographer_info)){
		foreach($photographer_info as $key => $photographer_list){
?>
		<h5><?php echo $key +1 ;?>st Photographer Details </h5>
		<span class="photographer_name">Photographer name: <strong><?php echo  $photographer_list['photographer_name'] ?></strong></span>
		<span class="photographer_email">Photographer email: <strong><?php echo  $photographer_list['photographer_email'] ?></strong></span>
		<span class="photographer_mobile">Photographer contact no.: <strong><?php echo  $photographer_list['photographer_mobile'] ?></strong></span><br><br>

<?php } ?><?php } else { ?>
		
		<span>No photographer detail is available for this location</span>
<?php } ?>
</div>