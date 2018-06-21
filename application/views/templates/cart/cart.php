  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready( function(){
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
	
	$(document).on("click",".increb", function(event){
      var boxname = $(this).attr('id').split("_");
  
	  var key			= boxname[1];
	  var arraykey      = boxname[2];
	  var cart_type     = boxname[3];
	 // alert(key+'##'+arraykey+'##'+cart_type);
      var c= parseInt($('#qty_'+key+'_'+arraykey+'_'+cart_type).val());
      c += 1;	  
	  var price = parseFloat($('#pricev_'+key+'_'+arraykey+'_'+cart_type).val());
	  var totprice = price * c;
	  var totp     =  totprice.toFixed(2);
	  $('#price_'+key+'_'+arraykey+'_'+cart_type).text(totp);
	  var pp = $("#tot").text();
	  var pt =  parseFloat(pp);
	  var final_total = parseFloat(pt+price);
	  var final_total = final_total.toFixed(2);
	  
	   	$.ajax({
			url: _basePath+"cartAdd/storetoal/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'total': final_total,
                    'price':totprice,
                    'arraykey':arraykey, 
					'key':key,
					'cartType':cart_type,
					'qty':c
				   },
			success: function(responce) {
				//alert(responce['key']);			
				if(responce['process'] == 'success') {
					
				    $("#tot").text(final_total);
		     		$('#qty_'+key+'_'+arraykey+'_'+cart_type).val(c);
						
				} 						
			}
		});
		
     
     })
	 
	 $(document).on("click",".decreb", function(event){
      var boxname = $(this).attr('id').split("_");
  
	  var key			    = boxname[1];
	  var arraykey			= boxname[2];
	  var cart_type     	= boxname[3];
	  //alert(key+'##'+arraykey+'##'+cart_type);
      var c= parseInt($('#qty_'+key+'_'+arraykey+'_'+cart_type).val());
      c -= 1;
	  var price = parseFloat($('#pricev_'+key+'_'+arraykey+'_'+cart_type).val());
	  var totprice = price * c;
	  var totp     =  totprice.toFixed(2);
	  $('#price_'+key+'_'+arraykey+'_'+cart_type).text(totp);
      var pp = $("#tot").text();
	  var pt =  parseFloat(pp);
	  var final_total = parseFloat(pt-price);
	  var final_total = final_total.toFixed(2);
	  	$.ajax({
			url: _basePath+"cartAdd/storetoal/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'total': final_total,
					'price':totprice,
                    'arraykey':arraykey,
					'key':key,
					'cartType':cart_type,
					'qty':c,					
				   },
			success: function(responce) {
				//alert(responce['key']);	
				if(responce['process'] == 'success') {
				    $("#tot").text(final_total);
					$('#qty_'+key+'_'+arraykey+'_'+cart_type).val(c);
						
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


<a href="<?php echo base_url(); ?>Favourite" class="place_order" style="width:190; margin-top:10px; margin-bottom:10px;">continue shopping</a>
<div class="col-md-12 full bdrsdo clearfix">
<?php 
$total_price = 0; 

if(!empty($_SESSION['cartVal'])){
	//unset($_SESSION['cartVal']);
	//pr($_SESSION['cartVal'],0);
?>
<!--<div class="photo_detailsback">
<div class="left_sec">
<a href="<?php echo base_url(); ?>favourite" class="back_button">Back</a>
<p>Click back button to<br />
select more photos or change packages.</p>
</div>
<div class="right_sec">
<h3>Selected Photos - <span><?php echo $_SESSION['cartVal'][0]['selected_photo']; ?></span> from <?php echo $_SESSION['cartVal'][0]['total_photo']; ?></h3>
<h4><?php echo $_SESSION['cartVal'][0]['size']; ?>  Print Only <span>$<?php  echo $_SESSION['cartVal'][0]['size_price']; ?></span></h4>
<?php if($_SESSION['cartVal'][0]['size']=='5x7'){?>
<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$20 each</span></p>
<?php
}else if($_SESSION['cartVal'][0]['size']=='8x10'){ ?>
<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$25 each</span></p>
<?php }else if($_SESSION['cartVal'][0]['size']=='series'){ ?>
<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
<?php }
else if($_SESSION['cartVal'][0]['size']=='package'){ ?>
<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
<?php }?>
</div>
<br class="clear" />
</div>-->

	
	<?php 
		
        ####SUDHANSU#####################################
        //$dgtalpkg_price  				    = $_SESSION['cartVal']['dgimg_price'];
        ####SUDHANSU#####################################
		$digital_price = 0;
		foreach($_SESSION['cartVal'] as $cartkey => $cartValue){
		$all_images_id = array();
		//$price    	       				    = $_SESSION['cartVal'][$cartkey]['size_price'];
		if(!empty($_SESSION['cartVal'][$cartkey]['dgimg_price'])){
		$digital_price+= $_SESSION['cartVal'][$cartkey]['dgimg_price'];	
		}		
		$size     	      					= $_SESSION['cartVal'][$cartkey]['size'];
		
		$images					   		    = $_SESSION['cartVal'][$cartkey]['images'];
		$images_id 							= $_SESSION['cartVal'][$cartkey]['imagesID'];
		$all_images 						= explode('~',$images);
		$all_images_id 						= explode('-',$images_id);
	
		
		$quantity  							= $_SESSION['cartVal'][$cartkey]['quantity'];
		$event_id  							= $_SESSION['cartVal'][$cartkey]['eventID'];
		
        if(!empty($_SESSION['cartVal'][$cartkey]['packagetype'])&& ($_SESSION['cartVal'][$cartkey]['packagetype']=='digital-pkg')){ ?>
			<p class="for_downloadimg">For Download Image: <?php echo '$';?><?php echo number_format($_SESSION['cartVal'][$cartkey]['dgimg_price'],2); ?></p>
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
		//echo $i ;
		$original_price = $frame['print_price']+$frame['frameprice'];
		/*if($_SESSION['cartVal'][$cartkey]['single_price'][$i]!=$_SESSION['cartVal'][$cartkey]['size_price']){
	    $finalp        =  $_SESSION['cartVal'][$cartkey]['single_price'][$i]+$frame['frameprice'];
		}
		else{
		$finalp        =  $_SESSION['cartVal'][$cartkey]['single_price'][$i]; 	
		}*/
		$finalp        =  $frame['print_price']+$frame['frameprice'];
		$total_price  +=  $finalp*$frame['qnty'];
		?>	

		<div class="cart_itemsec">
		<div class="left_pan"> 
   
		<img src="<?php echo $frame['img_val']; ?>" height="80px;" width="80px;" class="left_thum" />
		<div class="left_details">
		<p><?php echo $frame['framename']; ?></p>
		<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>
		<div class="qty_sec">
		<img src="<?=base_url()?>assets/images/qty_minusicon.png" id="decrement_<?php echo $i; ?>_<?php echo $cartkey; ?>_frmset" class="decreb">
		<input name="qty" id="qty_<?php echo $i; ?>_<?php echo $cartkey; ?>_frmset" type="text" value="<?=(array_key_exists('qty',$_SESSION['cartVal'][$cartkey]))?$frame['qnty']:"1";?>" />
		<img src="<?=base_url()?>assets/images/qty_plusicon.png" id="increment_<?php echo $i; ?>_<?php echo $cartkey; ?>_frmset" class="increb">
		<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_frmset" class="remove remove_order"><img src="<?=base_url()?>assets/images/qty_deleteicon.png" class="delete"></a>
		</div>
		<?php } ?>
		</div>
		   </div>
			
			<div class="right_pan">
			<p><strong><?php echo $size; ?></strong></p>
			<p><strong><?php echo $frame['qnty']; ?>PC</strong></p>
			<input type="hidden" id="pricev_<?php echo $i; ?>_<?php echo $cartkey; ?>_frmset" value="<?php echo $original_price; ?>"/>
			
			<p class="price"><?php echo '$';?><span id="price_<?php echo $i; ?>_<?php echo $cartkey; ?>_frmset"><?php echo number_format($finalp*$frame['qnty'],2); ?></span></div></p>
					
			<br class="clear" />
			
			</div>
		<?php 
		 
		 $i++; } } 
		 
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
		 
			$original_price = $collage['print_price']+$collage['frameprice'];
			$finalp        	= $collage['frameprice']+$collage['print_price'];
			
			$total_price  +=  $finalp*$collage['qnty'];
		?>	 
		<div class="cart_itemsec">
		<div class="left_pan"> 
   
		<img src="<?php echo $collage['img_val']; ?>" height="80px;" width="80px;" class="left_thum" />
		<div class="left_details">
		<p><?php echo $_SESSION['cartVal'][$cartkey]['collage'][$key]['framename']; ?></p>
		<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>
		<div class="qty_sec">
		<img src="<?=base_url()?>assets/images/qty_minusicon.png" id="decrement_<?php echo $i; ?>_<?php echo $cartkey; ?>_collage" class="decreb">
		<input name="qty" id="qty_<?php echo $i; ?>_<?php echo $cartkey; ?>_collage" type="text" value="<?=(array_key_exists('qty',$_SESSION['cartVal'][$cartkey]))?$collage['qnty']:"1";?>" />
		<img src="<?=base_url()?>assets/images/qty_plusicon.png" id="increment_<?php echo $i; ?>_<?php echo $cartkey; ?>_collage" class="increb">
		<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_collage" class="remove remove_order"><img src="<?=base_url()?>assets/images/qty_deleteicon.png" class="delete"></a>
		</div>
		<?php } ?>
		</div>
		   </div>
			
			<div class="right_pan">
			<p><strong><?php echo $size; ?></strong></p>
			<p><strong><?php echo $collage['qnty']; ?>PC</strong></p>
			<input type="text" id="pricev_<?php echo $i; ?>_<?php echo $cartkey; ?>_collage" value="<?php echo $original_price; ?>"/>
			
			<p class="price"><?php echo '$';?><span id="price_<?php echo $i; ?>_<?php echo $cartkey; ?>_collage"><?php echo number_format($finalp*$collage['qnty'],2); ?></span></div></p>

			<br class="clear" />
			</div>
			 
			 
		<?php	 
		 }
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
				
				$original_price = $print['print_price'];
				$finalp        	= $print['print_price'];
		
				$total_price  +=  $finalp*$print['qnty'];
		
		?>
				<div class="cart_itemsec">
				<div class="left_pan"> 
	   
				<img src="<?php echo $print['img_val']; ?>" height="80px;" width="80px;" class="left_thum" />
				<div class="left_details">
					<p><?php echo $print['imageName']; ?></p>
					<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>
					<div class="qty_sec">
					<img src="<?=base_url()?>assets/images/qty_minusicon.png" id="decrement_<?php echo $i; ?>_<?php echo $cartkey; ?>_print" class="decreb">
					<input name="qty" id="qty_<?php echo $i; ?>_<?php echo $cartkey; ?>_print" type="text" value="<?=(array_key_exists('qty',$_SESSION['cartVal'][$cartkey]))?$print['qnty']:"1";?>" />
					<img src="<?=base_url()?>assets/images/qty_plusicon.png" id="increment_<?php echo $i; ?>_<?php echo $cartkey; ?>_print" class="increb">
					<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" class="remove remove_order"><img src="<?=base_url()?>assets/images/qty_deleteicon.png" class="delete"></a>
					</div>
					<?php } ?>
				</div>
				</div>
		
				<div class="right_pan">
				<p><strong><?php if(!empty($size)){echo $size; } ?></strong></p>
				<p><strong><?php echo $print['qnty']; ?>PC</strong></p>
				<input type="hidden" id="pricev_<?php echo $i; ?>_<?php echo $cartkey; ?>_print" value="<?php echo $_SESSION['cartVal'][$cartkey]['size_price']; ?>"/>
				
				<p class="price"><?php if(!empty($_SESSION['cartVal'][$cartkey]['download']) && ($_SESSION['cartVal'][$cartkey]['download']=='yes') && ($_SESSION['cartVal'][$cartkey]['single_price']=='0')){echo 'No print price'; } else{?><?php echo '$';?><span id="price_<?php echo $i; ?>_<?php echo $cartkey; ?>_print"><?php echo number_format($finalp*$print['qnty'],2); ?></span><?php } ?></div></p>
		<br class="clear" />
		</div>
		
	<?php $i++; 
			} 
		}	
		else{

			$j      = 0;
			foreach($_SESSION['cartVal'][$cartkey]['single_price'] as $key=> $single_price)
			{
			 $price       = $single_price;  
			}
			foreach($_SESSION['cartVal'][$cartkey]['qty'] as $qty)
			{
				$qtyn      = $qty;              
			}	
			if(!empty($all_images)){		
				foreach($all_images as $key =>  $image){
					
				$total_price  += $_SESSION['cartVal'][$cartkey]['single_price'][$key]*$_SESSION['cartVal'][$cartkey]['quantity'];
				$img_path         = $_SESSION['cartVal'][$cartkey]['fullPath'];
				$imagePath        = $_SESSION['cartVal'][$cartkey]['imagePath'].'/'.$image;	
				
			?>
					<div class="cart_itemsec">
					<div class="left_pan"> 
				   
						<img src="<?php echo $imagePath; ?>" height="80px;" width="80px;" class="left_thum" />
						<div class="left_details">
							<p><?php echo $image; ?></p>
							<?php if(!empty($_SESSION['cartVal'][$cartkey]['packagetype']) && $_SESSION['cartVal'][$cartkey]['packagetype']=='printing-pkg'){?>
							<div class="qty_sec">
								<img src="<?=base_url()?>assets/images/qty_minusicon.png" id="decrement_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" class="decreb">
								<input name="qty" id="qty_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" type="text" value="<?=(array_key_exists('qty',$_SESSION['cartVal'][$cartkey]))?$_SESSION['cartVal'][$cartkey]['qty'][$key]:"1";?>" />
								<img src="<?=base_url()?>assets/images/qty_plusicon.png" id="increment_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" class="increb">
								<a href="javascript:void(0);" id="rmv_<?php echo $key; ?>_<?php echo $cartkey; ?>_print" class="remove remove_order"><img src="<?=base_url()?>assets/images/qty_deleteicon.png" class="delete"></a>
							</div>
							<?php } ?>
						</div>
					</div>
					
					<div class="right_pan">
					<p><strong><?php if(!empty($size)){echo $size; } ?></strong></p>
					<p><strong>1PC</strong></p>
					<input type="hidden" id="pricev_<?php echo $j; ?>_<?php echo $cartkey; ?>_print" value="<?php echo $_SESSION['cartVal'][$cartkey]['size_price']; ?>"/>
					
					<p class="price"><?php if(!empty($_SESSION['cartVal'][$cartkey]['download']) && ($_SESSION['cartVal'][$cartkey]['download']=='yes') || ($_SESSION['cartVal'][$cartkey]['single_price']=='0')){echo 'No print price'; } else{?><?php echo '$';?><span id="price_<?php echo $j; ?>_<?php echo $cartkey; ?>_print"><?php echo number_format($_SESSION['cartVal'][$cartkey]['single_price'][$key],2); ?></span><?php } ?></div></p>
					<br class="clear" />
					</div>
			
				<?php $j++; 
				}
			}
		}
		
		} 		
		
} ?>
    <!--<div class="total_printsec">
    <div class="left_banner">
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
    </div>-->
	
    <div class="right_totalingsec">
	
    <!--<h4><?php echo $size; ?>  Print Only, <?php echo $_SESSION['cartVal'][0]['selected_photo']; ?> Photos</h4>
<?php if($_SESSION['cartVal'][0]['size']=='5x7'){?>
<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$20 each</span></p>
<?php
}else if($_SESSION['cartVal'][0]['size']=='8x10'){ ?>
<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$25 each</span></p>
<?php }else if($_SESSION['cartVal'][0]['size']=='series'){ ?>
<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
<?php }
else if($_SESSION['cartVal'][0]['size']=='package'){ ?>
<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
<?php }?>
<h2>Total Price <span>$<?php echo number_format($total_price,2); ?></span></h2>
<a href="<?php echo base_url(); ?>favourite" class="add_morephoto">Add More Photos</a> -->

<?php $_SESSION['subtotal']    = $total_price; ?>
<?php $finalprice =  $total_price+$digital_price; ?>
<h2>Total Price <span>$</span><span id="tot"><?php echo number_format($finalprice,2); 
?></span></h2>
<a href="<?php echo base_url(); ?>cartAdd/emptycart" class="place_order" style="width:190; margin-top:10px; margin-bottom:10px;">Empty Cart</a>
<a href="<?php echo base_url(); ?>cartAdd/billingCheckout" class="place_order" style="width:190; margin-top:10px; margin-bottom:10px;">Proceed to Checkout</a>
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
	


</div>



</div>
</div>
</div>
</div>
</div>