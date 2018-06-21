<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!empty($contentTitle)){ echo $contentTitle; } ?> </title>
<meta name="keywords" content="<?php if(!empty($contentKeywords)){ echo $contentKeywords; } ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="<?php echo base_url(); ?>assets/images/logo_fav.ico">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/responsiv.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>assets/js/jquery-1.10.2.js"></script>

<script>var _basePath = '<?php echo base_url(); ?>'</script>

<script>
$(document).ready(function(e) {
	$('.navbar ul > li').hover( function(){
		$(this).find('ul').stop().slideDown('slow');
	},function(){
		$(this).find('ul').stop().slideUp('slow');
	});
	
	$('.fqa h3').click(function(){
		$(this).find('.sign').toggleClass('oppn');
		$(this).next().slideToggle('slow');
	});
	
});
$(document).ready(function(e) {
	$('.navbar ul > li').hover( function(){
		$(this).find('ul').stop().slideDown('slow');
	},function(){
		$(this).find('ul').stop().slideUp('slow');
	});
	
	$('.fqa h3').click(function(){
		$(this).find('.sign').toggleClass('oppn');
		$(this).next().slideToggle('slow');
	});
	
	$("#show_popup").on("click", function() {
		$("#subscriber_form").show();
	});
	$("#kv_form_close").on('click', function(e){
		$('#subscriber_form').fadeOut('slow');
	});
	
	$(".remove_order").unbind().bind("click", function(){
		var remove_id = $(this).attr('id').split("_");
		var frame_key			= remove_id[1];
		var cart_key			= remove_id[2];
		var type                = remove_id[3];
		var result = confirm("Are you sure to delete?");
		if (result) {
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>CartAdd/removeProduct",
				dataType: "json",
				data:
				{
					frame_key: frame_key,
					cart_key: cart_key,
					cart_type: type 
				},
				success:function(response)
				{
					
					if(response['process'] == 'success') {
						location.reload();
					}
				},
				
			});
		}
	});
	
});
</script>
</head>
<style>

	#country-list {
	 padding: 0;
	}
	#country-list li {
	 list-style-type: none;
	 color: #515151 !important;
	}
 #subscriber_form{ display:none; }
	#subscriber_form {
		 margin: 0;
		width: 100%;
		z-index: 2;
		position: absolute;
		right: 0;
		top: 67px;
		width: auto;
	}
	#sub_div_form {
		width: 273px;
		max-height: 505px;
		margin: 0 auto;
		background: white;
		padding: 10px;
		border: 1px solid #9E9E9E;
		border-radius: 8px;
		text-align: center;
		box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
		margin-left: -1px;
		overflow-y: scroll;
		overflow-x: hidden;
	}
	#sub_div_form span {
		position: relative;
		float: right;
		font-weight: 700;
		margin-top: 0px;
		height: 15px;
		font-size: 18px;
		width: 15px;
		line-height: 15px;
		margin-right:0px;
		/* border: 2px solid; */
		border-radius: 90px;
		padding: 0;
		display:block;
	}

	span#kv_form_close:hover {
		color: #e0190b;
	}
	.last_div {

    clear: both;
	line-height: 14px;

	}	
	#subscriber_form .main_div {
		clear: left;
		overflow: hidden;
	}
	#subscriber_form .main_div .col-md-4 {
		padding: 0;
	}
	#subscriber_form .main_div .col-md-4 img{width:100%;}
	#subscriber_form .cart_title {
		width: 62%;
		margin-left: 7px;
		text-align:left;
	}
	#subscriber_form .cart_title p strong {
		width: auto;
		margin-right: 5px;
	}
	#subscriber_form .cart_title{margin-bottom:10px;}
	#subscriber_form .cart_title p {
		line-height: 14px;
	}	

	@media screen and (max-width: 440px) {
		#sub_div_form { 
			width: 290px; 
			padding: 35px;
		}
	}
	#subscriber_form::before {
		border-bottom: 10px solid #9E9E9E;
		border-left: 10px solid transparent;
		border-right: 10px solid transparent;
		content: "";
		position: absolute;
		top: -9px;
		right: 30px;
	}

</style>
<body class="backimg">
	<div class="ajax_overlay"></div>
<div class="allcntnr">
<div class="topclor"></div>
<header id="mainhead">
<div class="wrap">
<div class="row"><a href="<?=base_url()?>" class="logo col-md-2"><img src="<?php echo base_url(); ?>assets/images/logo.png" ></a> 
<nav class="col-md-7" id="mainnav">
<div class="drpmnu navicn"><div class="" id="nav-icon2">

    <span></span>

    <span></span>

    <span></span>

    <span></span>

    <span></span>

    <span></span>

</div> <span class="men_txt">MENU</span></div>
<ul>
<li><a href="<?php echo base_url();?>">HOME</a></li>          
<li><a href="<?php echo base_url();?>page/about-us">ABOUT US</a></li>          
<li><a href="<?php echo base_url();?>page/faq">FAQ</a></li>          
<li><a href="<?php echo base_url();?>page/privacy-policy">PRIVACY POLICY</a></li>  
<li class="submenu"><a href="#">CATEGORY</a>
<ul>
		<!--<li><a href="<?php echo base_url(); ?>category">Event</a></li>-->
		<li><a href="<?php echo base_url(); ?>category">River Rafting</a></li>
</ul>
</li> 
<?php $customer_id	= $this->session->userdata('customer_id');
		if(isset($customer_id)){ ?>
<li><a href="<?php echo base_url();?>Favourite">Favourite</a></li>
<?php } ?>  
</ul>
</nav>

<?php $customer_id	= $this->session->userdata('customer_id');
	  $customer_fname	= $this->session->userdata('customer_fname');
			if(isset($_SESSION['cartVal']) && !empty($_SESSION['cartVal'])){
				$count          = $_SESSION['cartVal'];
				//$countVal       = explode('-',$count);
				$cartcnt = count($count);
			}else{
				$cartcnt = 0;
			}
		
 ?>
<div class="usersec col-md-3"><?php if(isset($customer_id)){ ?><span class="opnlogfrmm"><span class="icon"></span><span class="usr"><span>Welcome </span> <a href="<?php echo base_url();?>profile/myaccount"><?php if(!empty($customer_fname)){	echo $customer_fname; }?></a> </span><a  href="<?php echo base_url();?>Login/logout">Logout</a></span><?php } else{ ?><a href="" class="opnlogfrmm" id='opnlogfrmm_id'><span class="icon"></span>Login</a><?php } ?><a id="show_popup" href="javascript:void(0);"><span class="icon"></span><span><?php echo $cartcnt;?> item(s)</span></a>
	<div id="subscriber_form" > 
		<div id="sub_div_form"> 
			<a href="javascript:void(0);"><span id="kv_form_close">  X </span></a>
			 <?php $total_price = 0; 
			if(!empty($_SESSION['cartVal'])){
				$digital_price = 0;
			   foreach($_SESSION['cartVal'] as $cartkey => $cartValue){
				$all_images_id = array();
				//$price    	       				    = $_SESSION['cartVal'][$cartkey]['size_price'];
				if(!empty($_SESSION['cartVal'][$cartkey]['dgimg_price'])){
				$digital_price+= $_SESSION['cartVal'][$cartkey]['dgimg_price'];	
				}
				$size     	      					= $_SESSION['cartVal'][$cartkey]['size'];
				if(!empty($_SESSION['cartVal'][$cartkey]['images'])){
				$images					   		    = $_SESSION['cartVal'][$cartkey]['images'];
				$images_id 							= $_SESSION['cartVal'][$cartkey]['imagesID'];
				$all_images 						= explode('~',$images);
				$all_images_id 						= explode('-',$images_id);
				}
				
				$quantity  							= $_SESSION['cartVal'][$cartkey]['quantity'];
				$event_id  							= $_SESSION['cartVal'][$cartkey]['eventID'];
				if(!empty($_SESSION['cartVal'][$cartkey]['packagetype'])&& ($_SESSION['cartVal'][$cartkey]['packagetype']=='digital-pkg')){?>
				<p class="for_cartdownloadimg">For Download Image: <?php echo '$';?><?php echo number_format($_SESSION['cartVal'][$cartkey]['dgimg_price'],2); ?></p>
			   <?php } 
				if(array_key_exists('frmset',$_SESSION['cartVal'][$cartkey])){
					
				$i       = 0;
				foreach($_SESSION['cartVal'][$cartkey]['single_price'] as $key=> $single_price)
				{
				 $price       = $single_price;  
				}
				foreach($_SESSION['cartVal'][$cartkey]['qty'] as $qty)
				{
					$qtyn      = $qty;              
				}
				foreach($_SESSION['cartVal'][$cartkey]['frmset'] as $key => $frame){ 
				
				$finalp        =  $_SESSION['cartVal'][$cartkey]['single_price'][$i]+$frame['frameprice'];
				$total_price  +=  $finalp*$quantity;
				?>
			<div class="main_div" style="margin-top:0px;">
				<div class="col-md-4">
					<img src="<?php echo $frame['img_val']; ?>" height="80px;" width="80px;" style="">
				</div> 
				<div class="cart_title" style="margin-top:0px;float: left;">

					<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $size; ?></p>
						   
					<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($finalp*$quantity),2);?></p>
						   
					<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$_SESSION['cartVal'][$cartkey]['qty'][$i];?></p>
					<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
					<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_frmset" class="remove remove_order">&nbsp;</a>
					<?php } ?>
				</div>
			</div>
					
			   <?php $i++; } } 
			   if(array_key_exists('collage',$_SESSION['cartVal'][$cartkey])){
			
				foreach($_SESSION['cartVal'][$cartkey]['single_price'] as $key=> $single_price)
				{
				 $price       = $single_price;  
				}
				foreach($_SESSION['cartVal'][$cartkey]['qty'] as $qty)
				{
					$qtyn      = $qty;              
				}
				$i       = 0;
				foreach($_SESSION['cartVal'][$cartkey]['collage'] as $key => $collage){ 
		 
				$original_price = $collage['frameprice'];
				$finalp        	=  $collage['frameprice'];
				
				$total_price  +=  $finalp*$quantity;
				?>
				<div class="main_div" style="margin-top:0px;">
					<div class="col-md-4">
						<img src="<?php echo $collage['img_val']; ?>" height="80px;" width="80px;" style="">
					</div> 
					<div class="cart_title" style="margin-top:0px;float: left;">

						<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $size; ?></p>
							   
						<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($finalp*$quantity),2);?></p>
							   
						<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$_SESSION['cartVal'][$cartkey]['qty'][$i];?></p>
						<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
							<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_collage" class="remove remove_order">&nbsp;</a>
						<?php } ?>
					</div>
					
				</div>
				  
				 <?php 
				 
				 $i++;}
			  
			    }
				if(array_key_exists('print',$_SESSION['cartVal'][$cartkey])){
			 
					if($_SESSION['cartVal'][$cartkey]['print']!='onlyprint'){
					$i      = 0;
					foreach($_SESSION['cartVal'][$cartkey]['single_price'] as $key=> $single_price)
					{
					 $price       = $single_price;  
					}
					foreach($_SESSION['cartVal'][$cartkey]['qty'] as $qty)
					{
						$qtyn      = $qty;              
					}	
							
					foreach($_SESSION['cartVal'][$cartkey]['print'] as $key => $print){
						
						$total_price  += $_SESSION['cartVal'][$cartkey]['single_price'][$key]*$_SESSION['cartVal'][$cartkey]['quantity'];
		
				?>
					<div class="main_div" style="margin-top:0px;">
						<div class="col-md-4">
							<img src="<?php echo $print['img_val']; ?>" height="80px;" width="80px;" style="">
						</div> 
						<div class="cart_title" style="margin-top:0px;float: left;">

							<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $size; ?></p>
								   
							<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($price*$quantity),2);?></p>
								   
							<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$_SESSION['cartVal'][$cartkey]['qty'][$i];?></p>
								   
							<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
								<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" class="remove remove_order">&nbsp;</a>
							<?php } ?>
						</div>
					</div>



					<?php $i++; 
						} 
					}	
					else {	
					$j      = 0;
					
						foreach($_SESSION['cartVal'][$cartkey]['single_price'] as $key=> $single_price)
						{
						 $price      = $single_price;  
						}
						if(!empty($all_images)){				
						foreach($all_images as $key =>  $image){
								//pr($_SESSION['cartVal'],0);
							$total_price  += $_SESSION['cartVal'][$cartkey]['single_price'][$key]*$quantity;
							$img_path         = $_SESSION['cartVal'][$cartkey]['fullPath'];
							$imagePath        = $_SESSION['cartVal'][$cartkey]['imagePath'].'/'.$image;	 
							?> 				
						<div class="main_div" style="margin-top:0px;">
							<div class="col-md-4">
								<img src="<?php echo $imagePath; ?>" height="80px;" width="80px;" style="">
							</div> 
							<div class="cart_title" style="margin-top:0px;float: left;">

								<p style="margin-top: 5px;"><strong>Size:</strong><?php echo $size; ?></p>
								<?php if(!empty($_SESSION['cartVal'][$cartkey]['download']) && $_SESSION['cartVal'][$cartkey]['download']=='yes'){echo 'No print price'; } else{?>	   
								<p style="margin-top: 5px;"><strong>Price:</strong>$<?=number_format(($_SESSION['cartVal'][$cartkey]['single_price'][$key]*$quantity),2);?></p>
								<?php } ?>
									   
								<p style="margin-top: 5px;"><strong>Quantity:</strong><?=$_SESSION['cartVal'][$cartkey]['qty'][$key];?></p>
								<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>	   
								<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" class="remove remove_order">&nbsp;</a>
								<?php } ?>
							</div>
						</div>   
							   
						<?php $j++;   
						} 
						}
					}
				}
			}
			   $_SESSION['subtotal']    = $total_price;?>
			   <?php $finalprice =  $total_price+$digital_price; ?>
			<div class="last_div">
				<p class="prcese">Total Price : <strong>$<?=number_format($finalprice, 2, ".","")?></strong></p>
				<a href="<?php echo base_url(); ?>cartAdd/placeOrder/" class="btn btn-info">View Cart</a> <a class="btn btn-success" href="<?php echo base_url(); ?>cartAdd/billingCheckout">Checkout</a>
			</div>
			<?php } else {?>
			 <div class="bdrsdo" style="text-align: center;line-height: 150px;font-size: 22px;">
				<p>Your cart is empty</p>
				<!--<img src="<?=base_url()?>assets/images/empty_cart.jpeg" style="height: 215px;width: auto;">!-->
			 </div>
			<?php } ?>
		</div>
	</div>
</div>
</div>
</div>

<div class="clearfix"></div>
</header>
<div id="myOverlay"></div>
<div id="loadingGIF"><img src="<?php echo base_url()?>assets/images/ajax-loader.gif" alt=""/><p style="font-size:28"><strong>PROCESSING, PLEASE WAIT...</strong></p></div>
<!--header section end-->
<!------------------- Login -------------------->

	<div class="logform poplogfrm" id="poplogfrm">
	<form id="loginform" action="<?php echo base_url();?>Login" method="post" autocomplete="off">
	<h2><img src="<?php echo base_url();?>assets/images/blogin.png" ><br>User Login</h2>
   
	<span class="erro_msg" style="color:red;font-size:15px;display:none"><strong>Your login credentials not matching! Please try again.</strong></span><br/><br/>
	<div class="frm_dve input-effect">
		  <input class="frm_dve_effect" size="40" id="useremail" name="useremail" type="text" placeholder="Enter Your Username">      
		  <span class="focus-border"></span> 
		  </div>

	<div class="frm_dve input-effect">
		  <input class="frm_dve_effect" size="40" id="password" name="password" type="password" placeholder="Enter Your Password">     
		  <span class="focus-border"></span> 
		  </div>


	<div class="clearfix compimg">
	<div class="com"><a href="<?php echo base_url();?>Login/forgotpassword">Forgot your password?</a></div> 
	<input id="login_bttn" name="login_bttn" value="Login" class="book_submit rgt  col-md-5 loginbttn" type="button"  style="border:0;">
	

	</div>
	</form>
	<a href="" class="pp_close" id="pp_close"></a>
	</div>
	
	<!------------------- End Login -------------------->
<!--body section-->
<script>
$(window).load(function(e) {
	$(document).on("click", "#opnlogfrmm_id", function(e){	
	
		e.preventDefault();
		
		//alert(arr['1']);
		$('#poplogfrm').toggleClass('poplogfrmopn');
		$('.overlay').toggle();
	});
	
	$('#pp_close').click( function(e){
		e.preventDefault();
		$(".erro_msg").hide();
		$('#useremail').val('');
		$('#password').val('');
		$('#poplogfrm').toggleClass('poplogfrmopn');
		$('.overlay').toggle();
		
	});
	});

$(document).on("click", ".loginbttn", function(){	
	$(".erro_msg").hide();
	var email 			= $('#useremail').val();
	var pass 			= $('#password').val();
	
	var atpos				= email.indexOf("@");
	var atlastpos			= email.lastIndexOf("@");
	var dotpos				= email.indexOf(".");
	var dotlastpos			= email.lastIndexOf(".");
	if(atpos==0 || dotpos==0 || atlastpos==email.length-1 || dotlastpos==email.length-1 || atpos+1==dotpos || atpos-1==dotpos || atpos==-1 || dotpos==-1 || email=="" || dotlastpos==-1 || atlastpos==-1 || atpos!=atlastpos )
		{
			
			alert('Please put a valid email');
			return false;
		}
	
	else if(pass ==''){
		
		alert('Please put a valid password');
			return false;
	}
	else{
	
		$("#myOverlay").show();
		$("#loadingGIF").show();
		//{useremail:email,password:pass}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>Login/',
			data:{useremail:email,password:pass},
			dataType:"html",
			success: function(result){
            //alert(result);		
			if(result != 0){
			//$("#myOverlay").hide();
			//$("#loadingGIF").hide();	
			$("#poplogfrm").hide();
			$("#overlay").hide();
			document.location.href= "<?php echo base_url();?>";	
			//alert(result);
			}
			else{
			$("#myOverlay").hide();
			$("#loadingGIF").hide();	
			$(".erro_msg").show();
			}
			}
		});
	}
		
});</script>