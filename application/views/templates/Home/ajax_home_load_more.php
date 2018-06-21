<script>
$(document).ready(function(e) {
	
	$('.item_close').click( function(e){
		//alert('Test');
		var get_id = $(this).attr('id');
		var arr         	= get_id.split('_');
		
		e.preventDefault();
		$(".erro_msg").hide();
		$('#poplogfrm_'+arr['2']).hide();
		$('#poplogfrm_'+arr['2']).removeClass('poplogfrmopn');
		$('.overlay').toggle();
		
	});
	
});
</script>

<div class="wrap skievnt">
<div class="row">
<!------------------- Location -------------------->
<div>

<?php 

if(!empty($result)){

	foreach($result as $loc_list){ 

?>
<div class="boxsec col-md-12" >
	<div class="bdrsdo">
	<div class="boxlft col-md-8 col-sm-8" style="background-image:url(<?php echo base_url();?>uploads/locations/<?php echo $loc_list['location_image'] ?>); background-repeat: no-repeat;"><img src="<?php echo base_url(); ?>assets/images/boxban.png" />
	<?php $customerID= $this->session->userdata('customer_id');
			if(isset($customerID)){ ?>
		<div class="bxtxt col-md-6 col-sm-6 col-xs-6"><?php echo $loc_list['location_name']; ?> <span><?php echo $loc_list['event_name']; ?></span><a href="<?php echo base_url();?>CustomerPhotos/customerEventPhoto/<?php echo $loc_list['location_id']; ?>"><div class="bxbtn">See your <strong>Event</strong> Section</div></a></div>
	<?php } else{?>
		<div class="bxtxt col-md-6 col-sm-6 col-xs-6"><?php echo $loc_list['location_name']; ?> <span><?php echo $loc_list['event_name']; ?></span><a href="" class="opnfrmm" id="opnfrmm_<?php echo $loc_list['location_id']; ?>"><div class="bxbtn">See your <strong>Event</strong> Section</div></a></div>
	<?php } ?>
	</div>
	<!------------------- Login -------------------->
	<div class="logform poplogfrm" id="poplogfrm_<?php echo $loc_list['location_id']; ?>">
		<form id="loginform" action="<?php echo base_url();?>Login" method="post" autocomplete="off">
		<h2><img src="<?php echo base_url();?>assets/images/blogin.png" ><br>User Login</h2>
		<span class="erro_msg" style="color:red;font-size:15px;display:none"><strong>Your login credentials not matching! Please try again.</strong></span><br/><br/>
		<div class="frm_dve input-effect">
			  <input class="frm_dve_effect" size="40" id="useremail_<?php echo $loc_list['location_id']; ?>" name="useremail" type="text" placeholder="Enter Your Username">      
			  <span class="focus-border"></span> 
			  </div>

		<div class="frm_dve input-effect">
			  <input class="frm_dve_effect" size="40" id="password_<?php echo $loc_list['location_id']; ?>" name="password" type="password" placeholder="Enter Your Password">     
			  <span class="focus-border"></span> 
			  </div>


		<div class="clearfix compimg">
		<div class="com"><a href="<?php echo base_url();?>Login/forgotpassword">Forgot your password?</a></div>
		<input id="login_bttn_<?php echo $loc_list['location_id']; ?>" name="login_bttn" value="Login" class="book_submit rgt  col-md-5 login_bttn" type="button" style="border:0;"> 
		</div>
		</form>
		<a href="" class="pp_close item_close" id="pp_close_<?php echo $loc_list['location_id']; ?>"></a>
	</div>
	
	<!------------------- End Login -------------------->
	<div class="boxrgt col-md-4">
	<?php  //print_r($latlong); 
	if(!empty($weather_info)){ ?>
	<a href="javascript:void(0)" class="col-md-6 hovv"><span class="icon"><?php if($weather_info[$loc_list['location_id']] != 'NA'){ echo number_format($weather_info[$loc_list['location_id']], 1) ; ?> <sup>0</sup>C <?php } else { echo $weather_info[$loc_list['location_id']] ; }?></span><span class="atit">Today's</span> <span class="atit sml">weather report</span></a> <?php } ?>

	<a href="<?php echo base_url();?>home/photographereDetails/<?php echo $loc_list['location_id']; ?>" class="col-md-6 hovv phtographer_data" id="phtographer"><span class="icon"></span><span class="atit">Contact</span> <span class="atit sml">with photographer</span></a>
	
	<a href="#location_map_<?php echo $loc_list['location_id']; ?>" rel="prettyPhoto" class="col-md-6 hovv inline"><span class="icon"></span><span class="atit">track</span> <span class="atit sml">your location</span></a> 
	<a href="" class="col-md-6 hovv"><span class="icon"></span><span class="atit">share</span> <span class="atit sml">this event</span></a> 
	</div>
	
	</div>
</div>
<?php
	}
}else { ?>
<div class="boxsec col-md-12" >
<div class="bdrsdo">
<div class="noimge">
<h3>No Location Found</h3>
</div></div></div>
<?php } ?>
</div>
</div>
</div>

<?php if($loadmorecount > 0){ ?>
<div class="lodmor" id="loadmore_ajax"><a style="text-decoration:none" href="javascript:void(0)" onclick= "addMore();">load more</a></div> <?php  } ?>