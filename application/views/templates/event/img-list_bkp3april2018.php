<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.fancybox.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url()?>assets/js/jquery.fancybox.js"></script>

<!-- Add jQuery library -->
	<script type="text/javascript" src="<?=base_url()?>assets/lib/jquery-1.10.2.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="<?=base_url()?>assets/lib/jquery.mousewheel.pack.js?v=3.1.3"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="<?=base_url()?>assets/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="<?=base_url()?>assets/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="<?=base_url()?>assets/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="<?=base_url()?>assets/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

	<script src="https://rawgithub.com/kayahr/jquery-fullscreen-plugin/master/jquery.fullscreen.js"></script>

<style>
.expander {
    position: absolute;
    top: 5px;
    left: 5px;
    width: 128px;
    height: 128px;
    padding: 4px;
    background: url(<?php echo base_url(); ?>assets/favourite/favourite2.png) center center no-repeat;
    z-index: 99999;   
    cursor: pointer;
}
</style>


<script type="text/javascript">
  $(document).ready(function() {

$('.fancybox').click(function(){
	//var imgid = $(this).find('img').attr('alt');

  	$('.fancybox').fancybox({
  		 // API options
         openEffect: 'none',
    closeEffect: 'none',
    afterShow: function() { 
    	var imgId 				= $(this.element).data("id");
    	alert("hi - "+imgId);
    	$('<div class="expander">'+imgId+'</div>').appendTo(this.inner);
    	/*$('.fancybox').each(function(){
    		var imgid = $(this).find('img').attr('alt'); 
    		//alert(imgid);
    		//$('<div class="expander">'+imgid+'</div>').appendTo(this.inner);
    		
    	})*/
    	

    	
    		

    		//alert(imgid);

    		
    	

    	//$('.fancybox').click(function(){  });
            
        // $('<div class="expander"></div>').appendTo(this.inner).click(function() {
        //     //$(document).toggleFullScreen();
        //     //alert ('hi');
        //    //alert($(this).id);
        //   //alert('hi');
          
        // });
    },    
    afterClose: function() {
        $(document).fullScreen(false);
    }

  	});

  	})

    $("#datepicker").datepicker({dateFormat:"dd/mm/yy"});

   
	$(".imgDetails").unbind().bind("click", function(event) {
		
		event.preventDefault();
		var media_id = $(this).attr('id');
		var get_customer_id = $("#customer_id").val();
		var get_event_id = $("#event_id").val();
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>Category/addFavourite",
			dataType: "json",
			data:
			{
				media_id:media_id,
				get_customer_id:get_customer_id,
				get_event_id:get_event_id,
			},
			success:function(response)
			{
				if(response.get_favourite == 'exist_data')
				{
					alert('Image Already Add In Your Favourite List');
					return false;
				}
				else if(response.get_favourite == 'true')
				{
					//alert('Added To Favourite List');
					$("#"+media_id).html('<img style="width:20px; position:inherit;" src="<?php echo base_url(); ?>assets/favourite/favourite1.png">');
					//return false;
				}
				else if(response.get_favourite == 'false')
				{
					alert('Imgae Not Added Into Favourite List');
					return false;
				}
				
			},
		});
	});
  })

//   $(document).bind("fullscreenerror", function() {
//     alert("Browser rejected fullscreen change");
// });
  
  	$(window).load(function(e) {
		$(document).on("click", ".imgDetails_login", function(e){	
		
			e.preventDefault();
			
			//alert(arr['1']);
			$('#category_poplogfrm').toggleClass('poplogfrmopn');
			$('.overlay').toggle();
		});
		
		$('#pp_close').click( function(e){
			e.preventDefault();
			$(".erro_msg").hide();
			$('#useremail').val('');
			$('#password').val('');
			$('#category_poplogfrm').toggleClass('poplogfrmopn');
			$('.overlay').toggle();
			
		});
	});

$(document).on("click", ".loginbuttn", function(){	
	$(".erro_msg").hide();
	var email 				= $('#customer_useremail').val();
	var pass 				= $('#customer_password').val();
	
	var imgDetails_href = $(".imgDetails_login").attr("href");
	//alert(imgDetails_href);
	//return false;
	
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
				
			$("#category_poplogfrm").hide();
			$("#overlay").hide();
			document.location.href = imgDetails_href;
			//document.location.href= "<?php echo base_url();?>";	
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
		
});
</script>  

<style type="text/css">
  .imgDisplay {
    width: 19.4%;
    min-height: 100px;
    float: left;
    margin: 3px;
    border: 1px solid #D1DCE1;
    padding: 3px;
	height:180px;
  }
 /*.imgDisplay img{max-width:100%; height:100%;} */
  .category_poplogfrm {
    position: fixed;
    z-index: -1;
    display: none;
}

.logform.category_poplogfrm.poplogfrmopn{
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		margin: auto;
		height: 435px;
		z-index: 99;
		display: block;
	}
	
	.category_poplogfrm .pp_close {
		top: -16px !important;
		right: -38px !important;
		display: block;
	}
	
	.logform.category_poplogfrm.poplogfrmopn h2 {
		padding: 0 0 15px;
	}
  /*#draggable { width: 150px; height: 150px; padding: 0.5em; z-index: 2; border: 5px solid red; position: absolute; left: 0; top: 5;}*/
</style>
<!-- <div id="draggable" class=""></div> -->

<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<div class="row">

<div class="col-md-12 full imgtop bdrsdo clearfix" style="height: auto;">


	


<div class="event_searchsec">
<h3>Search Event Here..</h3>
<form action="<?=$frmaction?>" method="post">
  <input type="hidden" name="event_id" id="event_id" value="<?=$event_id?>">
  <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" id="customer_id">
<select name="cat_id" id="cat_id">
  <option value="">Select Category</option>
  <?php foreach ($all_category as $category) {?>
    <option value="<?=$category['id'].'||'.$category['cat_name'];?>" <?=($category['id'] == $cat_id)?"selected":""?>><?=$category['cat_name']; ?></option>
  <?php }?>
</select>
<input name="event_date" type="text" placeholder="Select Date" id="datepicker" value="<?=$event_date?>" />
<input name="btnsearch" id="btnsearch" type="submit" value="Search"  />
</form>
</div>

<br class="clear"/>

<a href="<?php echo base_url(); ?>Favourite">Favourite Images</a>
    <div id="country_table">
		<?php
		if($customer_id)
		{
			$category_class = 'imgDetails';
		}
		else{
			$category_class = 'imgDetails_login';
		}
		foreach($all_img_list as $img) {
			$imagePath     = base_url().'uploads/'.$img_path.$img['file_name'];
		?>
		  <div class="nailthumb-container imgDisplay">
			<!-- <a class="imgDetails fancybox.ajax" href="<?=base_url();?>Category/details/<?=$img['media_id']?>"><img src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative;"></a> -->
			<a rel="gallery" data-id="<?=$img['media_id'] ?>" class="fancybox" href="<?=$imagePath;?>"  data-fancybox-group="gallery" title="Lorem ipsum dolor sit amet"><img src="<?=thumb($imagePath, $img_path, '400', '400')?>" alt="" style="max-width:100%; position: relative;"></a>

			
			
			
			<?php
			if(!empty($customer_favourites)){
				if(in_array($img['media_id'],$customer_favourites))
				{
			?>
				<img style="width:20px; position:inherit;" src="<?php echo base_url(); ?>assets/favourite/favourite1.png">
			<?php
				}
				else
				{
			?>
				<a class="<?php echo $category_class; ?>" id="<?=$img['media_id'] ?>" href=""><img style="width:20px; position:inherit;" src="<?php echo base_url(); ?>assets/favourite/favourite2.png"></a>
			<?php }} else { ?>
				<a id="<?=$img['media_id'] ?>" class="<?php echo $category_class; ?>" href="<?=base_url();?>Category/allimages/<?=$event_id?>"><img style="width:20px; position:inherit;" src="<?php echo base_url(); ?>assets/favourite/favourite2.png"></a>
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
						<div class="com"><a href="<?php echo base_url();?>Login/register">Click Here To Register</a></div> 
						<!--<input id="login_bttn" name="login_bttn" value="Login" class="book_submit rgt  col-md-5 loginbttn" type="button"  style="border:0;height: 50px;">-->
						<input id="login_bttn" name="login_bttn" value="Login" class="rgt  col-md-5 loginbuttn" type="button"  style="border:0;height: 50px; background: #bd125e none repeat scroll 0 0; color: #fff;">
					</div>
					
				</form>
				<a href="" class="pp_close" id="pp_close"></a>
			</div>
    
		<div style="text-align: center;" id="pagination_link"><?=$pagination?></div>
	</div>
  
</div>

<br style="clear: both;">






</div>
</div>
</div>

</div>
<script type="text/javascript">
  function load_image(page) {
      var eventID         = $("#event_id").val();
      $(".ajax_overlay").show();
      $.ajax({
        url:"<?php echo base_url(); ?>Category/pagination/"+eventID+"/"+page,
        method:"GET",
        dataType:"json",
        success:function(data)
        {
          $(".ajax_overlay").hide();
          $('#country_table').html(data['HTML']);
          $('#pagination_link').html(data.pagination_link);
        }
      });  }

  $(document).on("click", ".pagination li a", function(event){
      event.preventDefault();
      var page = $(this).data("ci-pagination-page");
      if ($.isNumeric(page)) {
        load_image(page); 
      } else {
        return false;
      }
      
    });
</script>

        
