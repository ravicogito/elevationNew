  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready( function(){
	$(".remove_order").unbind().bind("click", function(){
		//alert('Test');
		var remove_id = $(this).attr('id').split("_");
		var product_key			= remove_id[1];
		//alert(product_key);
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
	
	$(".update_order").unbind().bind("click", function(){
		var remove_id = $(this).attr('id').split("_");
		var product_key			= remove_id[1];
		//alert(product_key);
		
		var hiddenprice = $("#hiddenprice_"+product_key).val();
		var textVal	    = $("#textVal_"+product_key).val();
		/* alert(textVal);
			return false; */
		if(textVal == 0)
		{
			alert('Item Could not be Zero');
			return false;
		}
		if(parseInt(textVal) < 0 || isNaN(textVal))
		{
			alert('Item Could not be Negative');
			return false;
		}
		//var price_val   = textVal * hiddenprice;
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>CartAdd/updateQuantity",
			dataType: "json",
			data:
			{
				textVal:textVal,
				key:product_key,
				hiddenprice:hiddenprice,
			},
			success:function(response)
			{
				if(response['process'] == 'success') {
						location.reload();
					}
			},
			
		});
		//alert(price_val);
		//var price_val = $("price_"+product_key).html("Price:<span>$</span>");
	});
});
</script>

  <script>
  $( function() {
    //$( "#datepicker" ).datepicker({ dateFormat: 'dd/mm/yy'});

    $("#cat_id").unbind().bind("change", function() {
      var optionName      = $("#cat_id option:selected").text();
      var optionArr       = $(this).val().split("||");
      var optionID        = optionArr[0];
      var optionName      = optionArr[1];
      //if(optionName == 'River Rafting') {
      if(optionID == '17') {
        //$("#event_time").show('slow');
      }
	  else{
		$("#event_time").hide(); 
		$("#guide_name").hide();
	  }
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
	  var event_date = $("#datepicker").val();
	  
	  	$.ajax({
			url: _basePath+"category/populateguide/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'event_time': event_time,
					'event_date': event_date				
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
	
  });
  
  
  </script>

<div class="contwrap">
<div class="container-fluid">
<div class="wrap">

<div class="row" id="cartSec">

<div class="col-md-12">

<div class="event_searchsec">
<h3>Search Event Here..</h3>
<form action="<?=$frmaction?>" method="post" class="border_botm">
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


<input name="btnsearch" id="btnsearch" type="submit" value="Search"  />
</form>
</div>



<div class="col-md-12 full bdrsdo clearfix">
<?php 
$total_price = 0; 
pr($_SESSION['cartVal'],0);
if(!empty($_SESSION['cartVal']['images'])){
	$price    	       	= isset($_SESSION['cartVal']['size_price'])?$_SESSION['cartVal']['size_price']:'';
	$size     	      	= isset($_SESSION['cartVal']['size'])?$_SESSION['cartVal']['size']:'';
	$images				= isset($_SESSION['cartVal']['images'])?$_SESSION['cartVal']['images']:'';
	$images_id 			= isset($_SESSION['cartVal']['imagesID'])?$_SESSION['cartVal']['imagesID']:'';
	$all_images 		= explode('~',$images);
	$all_images_id 		= explode('-',$images_id);
	$quantity  			= isset($_SESSION['cartVal']['quantity'])?$_SESSION['cartVal']['quantity']:'';
	$event_id  			= isset($_SESSION['cartVal']['eventID'])?$_SESSION['cartVal']['eventID']:'';

?>
<div class="photo_detailsback">
<div class="left_sec">
<a href="<?php echo base_url(); ?>favourite_s" class="back_button">Back</a>
<p>Click back button to<br />
select more photos or change packages.</p>
</div>
<div class="right_sec">
<h3>Selected Photos - <span><?php echo $_SESSION['cartVal']['selected_photo']; ?></span> from <?php echo $_SESSION['cartVal']['total_photo']; ?></h3>
<h4><?php echo $size; ?>  Print Only <span>$<?php  echo $price; ?></span></h4>
<?php if($size=='5x7'){?>
<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$20 each</span></p>
<?php
}else if($size=='8x10'){ ?>
<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$25 each</span></p>
<?php }else if($size=='series'){ ?>
<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
<?php }
else if($size=='package'){ ?>
<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
<?php }?>
</div>
<br class="clear" />
</div>

	
	<?php 
		
        ####SUDHANSU#####################################
        $dgtalpkg_price  	= isset($_SESSION['cartVal']['dgimg_price'])?$_SESSION['cartVal']['dgimg_price']:'';
        ####SUDHANSU#####################################
		
		foreach($all_images as $key => $image){

			if(!empty($price)){	
				if($size == 'series' || $size == 'package'){
					$total_price  = $price;	
				}else{
					$total_price  += $price*$quantity;	
				}	
		    }
		
		$img_path         = $fullPath;
		$imagePath        = $image_path.'/'.$image;	

		
	?>
	<div class="cart_itemsec">
   <div class="left_pan"> 
   <img src="<?php echo $imagePath; ?>" height="80px;" width="80px;" class="left_thum" />
   <div class="left_details">
<!--<h4>River Rafting</h4>-->
<p><?php echo $image; ?></p>
<div class="qty_sec">
<?php if(!empty($size)){?>
<img src="<?=base_url()?>assets/images/qty_minusicon.png">
<input name="" type="text" value="1" />
<img src="<?=base_url()?>assets/images/qty_plusicon.png">
<?php }?>
<a href="javascript:void(0);" id="rmv_<?=$key?>" class="remove remove_order"><img src="<?=base_url()?>assets/images/qty_deleteicon.png" class="delete"></a>
</div>
</div>
   </div>
	

	<div class="right_pan">
	<p><strong><?php echo !empty($size)?$size:''; ?></strong></p>
    <?php if(!empty($size)){?><p><strong>1PC</strong></p><?php }?>
	<p class="price"><?php if(!empty($price)){echo '$'.number_format($price,2);} ?></div></p>
    <br class="clear" />
	</div>
	
    <?php }
    	################SUDHANSU#######################################
        if(!empty($dgtalpkg_price)){
        	$total_price  = $total_price + $dgtalpkg_price;	
        }
        ################SUDHANSU#######################################
    ?>
    <div class="total_printsec">
    <div class="left_banner">
    <!--<a href="#"><img src="<?=base_url()?>assets/images/choose_frameimg.png"></a>-->
    <div class="mflam">
<div class="mflam_lfe"><img src="<?=base_url()?>assets/images/text-ig.png" alt="" />
<strong>you need to pay<br />
only additional</strong>
<span>$30</span></div>
<div class="mflam_rit">
<p>Choose You Option from below</p>
<a href="#"><img src="<?=base_url()?>assets/images/mk-frm1.png" alt="" style="border:0;" /></a>
<a href="#"><img src="<?=base_url()?>assets/images/mk-frm2.png" alt="" /></a>
</div>
<div class="clear"></div>
</div>
    </div>
    <div class="right_totalingsec">
    <h4><?php echo $size; ?>  Print Only, <?php echo $_SESSION['cartVal']['selected_photo']; ?> Photos</h4>
<?php if($size=='5x7'){?>
<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$20 each</span></p>
<?php
}else if($size=='8x10'){ ?>
<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$25 each</span></p>
<?php }else if($size =='series'){ ?>
<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
<?php }
else if($size=='package'){ ?>
<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
<?php }?>
<h2>Total Price <span>$<?php echo number_format($total_price,2); ?></span></h2>
<a href="<?php echo base_url(); ?>favourite" class="add_morephoto">Add More Photos</a> 
<a href="<?php echo base_url(); ?>cartAdd" class="place_order">Place Order</a>
    </div>
    <br class="clear" />
    </div>
	<?php 

	
	} else {?>
    
	 <div class="bdrsdo" style="text-align: center;line-height: 215px;font-size: 22px;">
	 	<img src="<?=base_url()?>assets/images/empty_cart.jpeg" style="height: 215px;width: auto;">
	 </div>
	<?php } ?>
</div>
	


	<!--<div class="buy bdrsdo ">
		<div class="row">
			<div class="col-md-3"><img src="<?=$productDetail['cur_img'];?>" style="height: 150px;"></div> 
			<div class="col-md-9 photodtl">
               <div class="cart_title">
	               <p><strong>Title:</strong>Customer Photo</p>
				   <p><strong>Option:</strong><?php echo $productDetail['option']['name']; ?></p>
				   
   
				   
				   <?php if(!empty($productDetail['option']['meta']['frame_name'])){?>
				   <p><strong>Frame Name:</strong><?php echo $productDetail['option']['meta']['frame_name']; ?></p>
				   <?php } ?>
				   <?php if(!empty($productDetail['option']['meta']['top']['mat_name'])){?>
				   <p><strong>Top Mat:</strong><?php echo $productDetail['option']['meta']['top']['mat_name']; ?></p>
				   <?php } ?>
				   <?php if(!empty($productDetail['middlemat_name'])){?>
				   <p><strong>Middle Mat:</strong><?php echo $productDetail['option']['meta']['middle']['mat_name']; ?></p>
				   <?php } ?>
				   <?php if(!empty($productDetail['option']['meta']['bottom']['mat_name'])){?>
				   <p><strong>Bottom Mat:</strong><?php echo $productDetail['option']['meta']['bottom']['mat_name']; ?></p>
				   <?php } ?>
				   

				   <p><strong>Size:</strong><?php echo $productDetail['size']; ?></p>
	               <p>
	               	<strong>QTY:</strong>
	               	<input maxlength="3" type="text" class="qty_box" name="update_value" id="textVal_<?=$key?>" value="<?=(array_key_exists('quantity',$_SESSION['Usercart'][$key]))?$_SESSION['Usercart'][$key]['quantity']:"1";?>">
	               	<a href="javascript:void(0);" id="update_<?=$key?>" class="update_order">UPDATE</a>
	               	<a href="javascript:void(0);" id="rmv_<?=$key?>" class="remove remove_order">REMOVE</a>

	               	<span class="col-md-3 dtlpric" id="price_<?=$key?>">Price:
						<input type="hidden" name="hidds" id="hiddenprice_<?=$key?>" value="<?=$productDetail['price'];?>">
						<span>$<?=number_format(($productDetail['price']*$productDetail['quantity']),2);?></span>
					</span>	
	               </p>

               </div>				
				
                
			</div>

		</div>
	</div>
	
	<?php //}} else {?>
	 <div class="bdrsdo" style="text-align: center;line-height: 215px;font-size: 22px;">
	 	<img src="<?=base_url()?>assets/images/empty_cart.jpeg" style="height: 215px;width: auto;">
	 </div>
	<?php //} ?>-->
</div>



</div>
</div>
</div>
</div>
</div>