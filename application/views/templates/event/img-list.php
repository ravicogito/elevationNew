<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.fancybox.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url()?>assets/js/jquery.fancybox.js"></script>

<!-- Add jQuery library -->
	<!-- <script type="text/javascript" src="<?=base_url()?>assets/lib/jquery-1.10.2.min.js"></script> -->

	<!-- Add mousewheel plugin (this is optional) -->
	<!-- <script type="text/javascript" src="<?=base_url()?>assets/lib/jquery.mousewheel.pack.js?v=3.1.3"></script> -->

	<!-- Add fancyBox main JS and CSS files -->
	<!-- <script type="text/javascript" src="<?=base_url()?>assets/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" /> -->

	<!-- Add Button helper (this is optional) -->
	<!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="<?=base_url()?>assets/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script> -->

	<!-- Add Thumbnail helper (this is optional) -->
	<!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="<?=base_url()?>assets/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script> -->

	<!-- Add Media helper (this is optional) -->
	<!-- <script type="text/javascript" src="<?=base_url()?>assets/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script> -->

	<script src="https://rawgithub.com/kayahr/jquery-fullscreen-plugin/master/jquery.fullscreen.js"></script>

<style>
#expander {
    position: absolute;
    top: 5px;
    left: 5px;
    width: 92px;
    height: 71px;
    padding: 4px;
    background: url(<?php echo base_url(); ?>assets/favourite/favourite2.png) center center no-repeat;
    z-index: 99999;   
    cursor: pointer;
}

#expander1 {
    position: absolute;
    top: 5px;
    left: 5px;
    width: 92px;
    height: 71px;
    padding: 4px;
    background: url(<?php echo base_url(); ?>assets/favourite/favourites.png) center center no-repeat;
    z-index: 99999;   
    cursor: pointer;
}
.fancybox-inner
{
	border: 5px solid white;
}

#facebook_share_expander {
    position: absolute;
    top: 5px;
    height: 71px;
    background: url(<?php echo base_url(); ?>assets/favourite/facebook-share-icon.png) center center no-repeat;
    z-index: 99999;
    cursor: pointer;
    left: 96px;
    width: 72px;
    background-size: 90px;
    border: 2px solid #ccc;
    border-radius: 50%;
    z-index: 9999;
}

</style>


<script type="text/javascript">
  $(document).ready(function() {

  	$("#cat_id").unbind().bind("change", function() {
      var optionName      = $("#cat_id").val();
      var optionArr       = $(this).val().split("||");
      var optionID        = optionArr[0];
      var optionName      = optionArr[1];
      if(optionID == '17') {
        
      }
	  else{
		  $("#event_time").hide(); 
		  $("#rafting_company").hide();
	  }
    })
	

$('.fancybox').click(function(){
	//alert('Test');
	var imgid = $(this).find('img').attr('alt');

  	$('.fancybox').fancybox({
  		 // API options
         openEffect: 'none',
    closeEffect: 'none',
	autoSize: true,
	minWidth: 700,
	minHeight: 200,
	
    afterShow: function() { 
    	var imgId 				= $(this.element).data("id");
		var imagsplit = imgId.split('_');
		
		//alert(imagsplit['1']);
		//return false;
		
		var img_id = imagsplit['0'];
		var full_img_name = imagsplit['1'];
		
		var img_name_split = full_img_name.split('.');
		var img_name = img_name_split['0'];
		
    	 var get_media_id = img_id;
             var get_customer_id = $("#customer_id").val();
			var get_event_id = $("#event_id").val();

			console.log(get_media_id);
			console.log(get_customer_id);
			console.log(get_event_id);
    	//$('<div class="expander">'+imgId+'</div>').appendTo(this.inner);
    	if(get_customer_id!=''){

    		var media_cat = 'imgDetails_favourite';
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>Category/checkFavourite",
				dataType: "json",
				data:
				{
					media_id:get_media_id,
					customer_id:get_customer_id,
					event_id:get_event_id,
				},
				success:function(response)
				{
					//alert(response.get_favourite);
					if(response.get_favourite == 'get_img')
					{
						$('.'+media_cat).attr('id','expander1');
					}
					
					$(".child").html(img_name);
					
				},
			});
			
			
    	} else{
			$(".child").html(img_name);
    		 var media_cat = 'imgDetails_login';
    	}
		
		$('<div class="facebook_share" id="facebook_share_expander"></div>').appendTo(this.inner);
		
    	$('<div class="'+media_cat+'" id="expander"></div>').appendTo(this.inner).click(function() {
            
            if(get_customer_id!=''){
             
             $.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>Category/addFavourite",
			dataType: "json",
			data:
			{
				media_id:get_media_id,
				get_customer_id:get_customer_id,
				get_event_id:get_event_id,
			},
			success:function(response)
			{
				if(response.get_favourite == 'add_favourite_true')
				{
					alert('Added To Favourite List');
     				//$('.'+media_cat).html('<span style="font-size:8px; position:relative; top:120px;">cheers moment!.</span>');
					$('.'+media_cat).attr('id','expander1');
				}
				if(response.get_favourite == 'remove_favourite_true')
				{
					alert('Remove To Favourite List');
     				//$('.'+media_cat).html('<span style="font-size:8px; position:relative; top:120px;">cheers moment!.</span>');
					$('.'+media_cat).attr('id','expander');
				}
				
			},
		});

         } else{


         		$.fancybox.close();
				

         }

          
        });

    },
    afterClose: function() {
        $(document).fullScreen(false);
    }

  	});

  	})

    	$( "#datepicker" ).datepicker({ dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	    onSelect: function (dateStr) {
		if($("#cat_id").val()=='17||River Rafting'){ 
		var optionName      = $("#cat_id").val();
		var optionArr       = optionName.split("||");
		var optionID        = optionArr[0];
		var optionCatName   = optionArr[1];
		var selectedDate    = $(this).val();
		$.ajax({
			url: _basePath+"category/populatecompany/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'cat_id': 17,
                    'date': selectedDate 					
				   },
			success: function(responce) {
						
				if(responce['process'] == 'success') {
					//$("#event_time").slideDown('slow');
					//$("#event_time").find("option:not(:first)").remove();
					$("#rafting_company").slideDown('slow');
					$("#rafting_company").find("option:not(:first)").remove();
					
					//var size = Object.keys(responce['timeslots']).length;
					//var i;
					//for(i=0; i<size+1; i++){
						//if(responce.timeslots[i]!='' && responce.timeslots[i]!=undefined){
								//$("#event_time").append("<option //value='"+responce['timeslots'][i].event_time+"'>"+responce['ti//meslots'][i].event_time+"</option>");
								
								
						//}
						
					//}
					var size = Object.keys(responce['companys']).length;
					var i;
					for(i=0; i<size+1; i++){
						if(responce.companys[i]!='' && responce.companys[i]!=undefined){
								$("#rafting_company").append("<option value='"+responce['companys'][i].raftingcompany_id+"'>"+responce['companys'][i].raftingcompany_name+"</option>");
								
								
						}
						
					}
					
          
						
				} else if(responce['process'] == 'fail') {
					$("#event_time").hide(); 
			        $("#rafting_company").hide();
					//alert("Unable to create event. Please try again.");
					return false;
				} 							
			}
		});
		}else{
			$("#event_time").hide(); 
			$("#rafting_company").hide();
		}

		}	 
	});
	
	
		$("#rafting_company").unbind().bind("change", function() {
	  var company_id = $("#rafting_company").val();
	  var event_date = $("#datepicker").val();

	  
	  	$.ajax({
			url: _basePath+"category/populatetime/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'company_id': company_id,
					'event_date': event_date				
				   },
			success: function(responce) {
						
				if(responce['process'] == 'success') {
				               
					$("#event_time").slideDown('slow');
					$("#event_time").find("option:not(:first)").remove();
					var size = Object.keys(responce['timeslots']).length;
					var i;
					for(i=0; i<size+1; i++){
						if(responce.timeslots[i]!='' && responce.timeslots[i]!=undefined){
								$("#event_time").append("<option value='"+responce['timeslots'][i].event_time+"'>"+responce['timeslots'][i].event_time+"</option>");
								
								
						}
						
					}

						
				} else if(responce['process'] == 'fail') {
			        $("#event_time").hide();
					return false;
				} 							
			}
		});
      
    })
	
	

	$("#event_time").unbind().bind("change", function() {
	  var event_time = $("#event_time").val();
	  
	  	$.ajax({
			url: _basePath+"category/populateguide/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'event_time': event_time				
				   },
			success: function(responce) {
						
				if(responce['process'] == 'success') {
				               
					$("#guide_name").slideDown('slow');
					$("#guide_name").find("option:not(:first)").remove();
					var size = Object.keys(responce['guides']).length;
					var i;
					
					for(i=0; i<size+1; i++){
						if(responce.guides[i]!='' && responce.guides[i]!=undefined){
								$("#guide_name").append("<option value='"+responce['guides'][i].guide_id+"'>"+responce['guides'][i].guide_name+"</option>");
								
								
						}
						
					}

						
				} else if(responce['process'] == 'fail') {
			        $("#guide_name").hide();
					return false;
				} 							
			}
		});
      
    })
	
		  
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
	
	$(".remove_order").unbind().bind("click", function(){
		//alert('Test');
		var remove_id = $(this).attr('id').split("_");
		var product_key			= remove_id[1];
		//alert(product_key);
		var result = confirm("Are you sure to delete?");
		if (result) {
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>CartAdd/removeProduct",
				dataType: "json",
				data:
				{
					product_key:product_key,
				},
				success:function(response)
				{
					//$("#cartSec").html(responce['HTML']);
					//alert(response.process);
					if(response['process'] == 'success') {
						location.reload();
					}
				},
				
			});
		}
	});
	
  });
 $(document).on("click", ".register_here", function(){
	   var category_img_href = $(".imgDetails_login").attr("href");
	  //alert(imgDetails_href);
	  //return false;
	  $.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>Category/imgHref",
			dataType: "json",
			data:
			{
				category_img_href:category_img_href,
			},
			success:function(response)
			{
				if(response.img_href == 'true')
				{
					window.location.href = '<?php echo base_url(); ?>Register';
					//alert('Test');
				}
			},
		});
	  
  });

  
  	$(window).load(function(e) {
		$(document).on("click", ".imgDetails_login", function(e){	
		
			e.preventDefault();
			
			//alert(arr['1']);
			$('#category_poplogfrm').toggleClass('poplogfrmopn');
			$("#category_poplogfrm").css("display", "block");
			$('.overlay').toggle();
		});
		
		$('#pp_close').click( function(e){
			e.preventDefault();
			$(".erro_msg").hide();
			$(".category_poplogfrm").hide();
			$(".overlay").css("display", "none");
			//$(".logform poplogfrm").hide();
			$('#useremail').val('');
			$('#password').val('');
			
			//$('.overlay').toggle();
			
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
	/* $(document).on("click", ".fancybox", function(){
		//alert('Test');
		var imgid = $(this).find('img').attr('alt');

		$('.fancybox').fancybox({
			 // API options
			 openEffect: 'none',
		closeEffect: 'none',
		afterShow: function() { 
			var imgId 				= $(this.element).data("id");
			 var get_media_id = imgId;
				 var get_customer_id = $("#customer_id").val();
				var get_event_id = $("#event_id").val();

				console.log(get_media_id);
				console.log(get_customer_id);
				console.log(get_event_id);
			//$('<div class="expander">'+imgId+'</div>').appendTo(this.inner);
			if(get_customer_id!=''){

				var media_cat = 'imgDetails_favourite';
				$.ajax({
					type:"POST",
					url:"<?php echo base_url(); ?>Category/checkFavourite",
					dataType: "json",
					data:
					{
						media_id:get_media_id,
						customer_id:get_customer_id,
						event_id:get_event_id,
					},
					success:function(response)
					{
						//alert(response.get_favourite);
						if(response.get_favourite == 'get_img')
						{
							$('.'+media_cat).attr('id','expander1');
						}
						
					},
				});
				
				
			} else{
				 var media_cat = 'imgDetails_login';
			}
			
			
			
			$('<div class="'+media_cat+'" id="expander"></div>').appendTo(this.inner).click(function() {
				
				if(get_customer_id!=''){
				 
				 $.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>Category/addFavourite",
				dataType: "json",
				data:
				{
					media_id:get_media_id,
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
						alert('Added To Favourite List');
						//$('.'+media_cat).html('<span style="font-size:8px; position:relative; top:120px;">cheers moment!.</span>');
						$('.'+media_cat).attr('id','expander1');
					}
					else if(response.get_favourite == 'false')
					{
						alert('Imgae Not Added Into Favourite List');
						return false;
					}
					
				},
			});

			 } else{


					$.fancybox.close();
					

			 }

			  
			});

		},
		afterClose: function() {
			$(document).fullScreen(false);
		}

		});
	}); */
	
	
	$(document).on('click', '.facebook_share', function() {
		var TheImg 	= $(this).parent('div').children('img:eq(0)');
			
			u			= TheImg.attr('src');
			//alert("hi - "+u);
			 // t=document.title;
			t			= TheImg.attr('alt');
			window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;
	})
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
		top: 7px !important;
		right: 0px !important;
		display: block;
		position: absolute;
	}
	
	.logform.category_poplogfrm.poplogfrmopn h2 {
		padding: 0 0 15px;
	}
	.fancybox-wrap.fancybox-desktop.fancybox-type-image.fancybox-opened{z-index:99999;}
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
<select name="rafting_company" id="rafting_company" style="display: <?php if($event_time!="0" && $categoryID=='17'){?>block<?php } else{?>none<?php }?>;">
  <option value="">Select Company</option>
  <?php if(!empty($companys)){ ?>
  <?php foreach($companys as $company){?>
  <option value="<?=$company['raftingcompany_id'];?>" <?=($company['raftingcompany_id'] == $company_id)?"selected":""?>><?=$company['raftingcompany_name']; ?></option>
  <?php }}?>
</select>

<select name="event_time" id="event_time" style="display: <?php if($event_time!="0" && $categoryID=='17'){?>block<?php } else{?>none<?php }?>;">
  <option value="">Select Time</option>
  <?php if(!empty($times)){ ?>
  <?php foreach($times as $time){?>
  <option value="<?=$time['event_time'];?>" <?=($time['event_time'] == $event_time)?"selected":""?>><?=$time['event_time']; ?></option>
  <?php }}?>
</select>

<!--<select name="guide_name" id="guide_name" style="display: <?=(!empty($event_time))?"block":"none";?>;">
  <option value="">Select Guide</option>
   <?php if(!empty($guides)){ ?>
   <?php foreach($guides as $guide){?>
   <option value="<?=$guide['guide_id'];?>" <?=($guide['guide_id'] == $guide_id)?"selected":""?>><?=$guide['guide_name']; ?></option>
  <?php }}?>
  
</select>-->

<input name="btnsearch" id="btnsearch" type="submit" value="Search"  />
</form>
</div>

<br class="clear"/>

<a class="fav_bnt" href="<?php echo base_url(); ?>Favourite">Favourite Images</a>

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
			
			$imgarr = explode('.',$img['file_name']);
			//print_r($imgarr);die;
			$linkFileName = $imgarr[0].'-800_800.'.$imgarr[1];
			$filename = $imgarr[0].'.'.$imgarr[1];
			
			//$imagePath     = base_url().'uploads/'.$img_path.$img['file_name'];
			$imagePath     	= base_url().'uploads/'.$img_path.$filename;
			$linkFilePath 	= base_url().'uploads/'.$img_path.$linkFileName;
		
		?>
		  <div class="nailthumb-container imgDisplay">
			
			<a rel="gallery" data-id="<?=$img['media_id'].'_'.$filename ?>" class="fancybox" href="<?=$linkFilePath;?>"  data-fancybox-group="gallery" title="<?php echo $event_name; ?>"><img src="<?=thumb($imagePath, $img_path, '800', '800')?>" alt="" style="max-width:100%; position: relative;"></a>

			
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

        
