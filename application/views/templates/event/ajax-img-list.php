   <?php
		if($customer_id)
		{
			$category_class = 'imgDetails';
		}
		else{
			$category_class = 'imgDetails_login';
		}
		foreach($all_img_list as $img) {
			
			$imgarr = explode('.',$img['file_name']);
			//print_r($imgarr);die;
			$filename = $imgarr[0].'-400_400.'.$imgarr[1];
			
			//$imagePath     = base_url().'uploads/'.$img_path.$img['file_name'];
			$imagePath     = base_url().'uploads/'.$img_path.$filename;
			
		
		?>
		  <div class="nailthumb-container imgDisplay">
			
			<a rel="gallery" data-id="<?=$img['media_id'] ?>" class="fancybox" href="<?=$imagePath;?>"  data-fancybox-group="gallery" title="<?php echo $event_name; ?>"><img src="<?=thumb($imagePath, $img_path, '400', '400')?>" alt="" style="max-width:100%; position: relative;"></a>

			
			
			
			<?php
			if(!empty($customer_favourites)){
				if(in_array($img['media_id'],$customer_favourites))
				{
			?>
				<img class="favone" style="width:20px; position:inherit;" src="<?php echo base_url(); ?>assets/favourite/favourite1.png">
			<?php
				}
				else
				{
			?>
				<a class="<?php echo $category_class; ?>" id="<?=$img['media_id'] ?>" href=""><!--<img style="width:20px; position:inherit;" src="<?php //echo base_url(); ?>assets/favourite/favourite2.png">--></a>
			<?php }} else { ?>
				<a id="<?=$img['media_id'] ?>" class="<?php echo $category_class; ?>" href="<?=base_url();?>Category/allimages/<?=$event_id?>"><!--<img style="width:20px; position:inherit;" src="<?php //echo base_url(); ?>assets/favourite/favourite2.png">--></a>
			<?php } ?>
			

		  </div>
		<?php }?>		
		
		


			<div class="logform category_poplogfrm" id="category_poplogfrm">
				<form id="loginform" action="<?php echo base_url();?>Login" method="post" autocomplete="off">
				
					<h2><img style="width:auto; position:inherit;" src="<?php echo base_url();?>assets/images/blogin.png" ><br>Please Login First</h2>
				   
					<span class="erro_msg" style="color:red;font-size:15px;display:none"><strong>Your login credentials not matching! Please try again.</strong></span><br/><br/>
					<div class="frm_dve input-effect">
						  <input class="frm_dve_effect" size="40" id="customer_useremail" name="customer_useremail" type="text" placeholder="Enter Your Username">      
						  <span class="focus-border"></span> 
					</div>

					<div class="frm_dve input-effect">
						  <input class="frm_dve_effect" size="40" id="customer_password" name="customer_password" type="password" placeholder="Enter Your Password">     
						  <span class="focus-border"></span> 
					</div>

					<div class="clearfix compimg">
						<div class="com"><a class="register_here" href="javascript:void(0);">Click Here To Register</a></div>  
						<!--<input id="login_bttn" name="login_bttn" value="Login" class="book_submit rgt  col-md-5 loginbttn" type="button"  style="border:0;height: 50px;">-->
						<input id="login_bttn" name="login_bttn" value="Login" class="rgt  col-md-5 loginbuttn" type="button"  style="border:0;height: 50px; background: #bd125e none repeat scroll 0 0; color: #fff;">
					</div>
					
				</form>
				<a href="" class="pp_close" id="pp_close"></a>
			</div>
    
		<div style="text-align: center;" id="pagination_link"><?=$pagination?></div>
		
