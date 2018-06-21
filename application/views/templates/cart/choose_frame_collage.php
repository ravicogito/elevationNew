<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="<?=base_url()?>assets/js/custom-frame.js"></script>
<!--**********sreela(05/04/18)*********-->
<script src="<?=base_url()?>assets/js/jquery.carouFredSel-6.0.4-packed.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	 
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
	$( "#sortable" ).sortable();    

		$(".fbshare").unbind().bind("click", function() {
			var TheImg 	= $(this).parent('div').children('a:eq(0)').children('img');
			
			u			= TheImg.attr('src');
			//alert("hi - "+u);
			 // t=document.title;
			t			= TheImg.attr('alt');
			window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;
		})
		$("#print_ops").click(function() {
			
			$("#print_div").show();
			$("#frame_div").hide();			
			$("#collage_div").hide();
		});
		$("#frame_ops").click(function() {
			
			$("#frame_div").show();
			$("#collage_div").hide();
			$("#print_div").hide();
			
		});
		$("#collage_ops").click(function() {
			
			$("#frame_div").hide();
			$("#print_div").hide();
			$("#collage_div").show();
			var total_image_cnt = $('#total_img_cnt').val();
			//alert(total_image_cnt);
			if(total_image_cnt  < '5'){
				$("#outerDivCollage").removeClass().addClass('full_frame blue_matte');
				$(".pck_matte").hide();
				$(".series_matte").hide();
				$("#mattegreen").hide();
				$("#matteblue").hide();
				$("#5x7greenmatte").show();
				$("#5x7bluematte").show();
				
				
			}
			if(total_image_cnt == ''){
				var selectImg	= $("#selected_imgage").val();
				
				if(selectImg == 5){
					
					$("#outerDivCollage").removeClass().addClass('full_frame package_black_matte');
				}
				else{
					$("#outerDivCollage").removeClass().addClass('full_frame blue_matte');
					
				}
				$(".pck_matte").show();
				$(".series_matte").show();
				$("#5x7greenmatte").show();
				$("#5x7bluematte").show();
			}
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
<style type="text/css">
  .imgDisplay {
    /*width: 19.4%;*/
	width: 238px !important;
    height: 200px !important;
    float: left;
    margin: 3px;
    border: 1px solid #D1DCE1;
    padding: 3px;
  }
  .option{
    cursor: pointer;
  }
  /*#draggable { width: 150px; height: 150px; padding: 0.5em; z-index: 2; border: 5px solid red; position: absolute; left: 0; top: 5;}*/
</style>
<div id="myOverlay"></div>
<div id="loadingGIF"><img src="<?php echo base_url()?>assets/images/ajax-loader.gif" alt=""/><p style="font-size:28"><strong>PROCESSING, PLEASE WAIT...</strong></p></div>
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
//pr($_SESSION['productArry'],0);
if(!empty($_SESSION['productArry'])){
//pr($_SESSION['productArry'],0);
$x =count($_SESSION['productArry']);

		
		$price    	       				    = $_SESSION['productArry'][$x-1]['size_price'];
		$size     	      					= $_SESSION['productArry'][$x-1]['size'];
		$images					   		    = $_SESSION['productArry'][$x-1]['images'];
		$images_id 							= $_SESSION['productArry'][$x-1]['imagesID'];
		$all_images 						= explode('~',$images);
		$all_images_id 						= explode('-',$images_id);
		$quantity  							= $_SESSION['productArry'][$x-1]['quantity'];
		$event_id  							= $_SESSION['productArry'][$x-1]['eventID'];
		$selected_photo  					= $_SESSION['productArry'][$x-1]['selected_photo'];
		$fullPath							= $_SESSION['productArry'][$x-1]['fullPath'];
		$image_path							= $_SESSION['productArry'][$x-1]['imagePath'];
        ####SUDHANSU#####################################
        //$dgtalpkg_price  				    = $_SESSION['productArry']['dgimg_price'];
        ####SUDHANSU#####################################
		/*if(!empty($all_images)){
			foreach($all_images as $key => $image){
				
				$img_path         = $fullPath[$_SESSION['productArry'][$x-1]['eventID']];
				$imagePath        = $image_path[$_SESSION['productArry'][$x-1]['eventID']].'/'.$image;	
			}
		}*/
?>	

<!------------------------------CHOOSE FRAME/COLLAGE-------------------------------->


<div class="choose_frame"><h2>Choose Your Options</h2>
	<ul class="frame_selection">
	  <?php 

			if(($selected_photo == 1) && (($size != 'series')||($size != 'package'))){
				
				$colg_display	="display:none";
				$frm_display	="display:";
				$prnt_display	="display:";
				$frmopttype		='print';
			}
			else if(($selected_photo == 5) && (($size == 'series')||($size == 'package'))){
				
				
				$frm_display	="display:none";
				$colg_display	="display:";
				$prnt_display	="display:none";
				$frmopttype		='collage';
			}
			else if ((($selected_photo == 2) || ($selected_photo == 3) || ($selected_photo == 4) || ($selected_photo == 5)) && (($size != 'series')||($size != 'package'))){
				
				$colg_display	="display:";
				$frm_display	="display:";
				$prnt_display	="display:";
				$frmopttype		='print';				
				
			}
			
			if($option_list) {
			  foreach ($option_list as $optionKey => $option) {                
	  ?>
	  <li style="<?php echo $prnt_display ;?>">
	  <img src="<?=base_url()?>assets/images/printing.png" id="">
	  <span class="option" id="print_ops" >Only Print</span>
	  </li>
	  <li style="<?php echo $frm_display ;?>">
	  <img src="<?=base_url()?>assets/images/<?=strtolower(str_replace(" ", "_", $option['option_name']))?>.png" id="">
	  <span class="option" id="frame_ops" >Frame</span>
	  </li>
	  <?php }}?>
	  <li style="<?php echo $colg_display ;?>">
	  <img src="<?=base_url()?>assets/images/<?=strtolower(str_replace(" ", "_", $option['option_name']))?>.png" id="">
	  <span class="option" id="collage_ops" rel="<?php echo $selected_photo; ?>">Collage</span>
	  </li>
	</ul>
</div>
<!------------------------------End CHOOSE FRAME/COLLAGE-------------------------------->
<?php 
		
		
			if($size == 'series' || $size == 'package'){		
				
				$frm_div_display	="display:none";
				$colg_div_display	="display:block";
				$prnt_div_display	="display:none";
				$collage_class = ($size == 'series')?'series_blue_matte':'package_black_matte'; 
				
			}
			else{
				
				if(($selected_photo == 1) || ($selected_photo == 5)){
					
					$prnt_div_display	="display:block";
					$colg_div_display	="display:none";
					$frm_div_display	="display:none";
					$collage_class 		='package_black_matte';
				}
				else if(($selected_photo == 2) || ($selected_photo == 3) || ($selected_photo == 4)){
					
					$prnt_div_display	="display:block";
					$colg_div_display	="display:none";
					$frm_div_display	="display:none";
					$collage_class 		='blue_matte';
					
				}	
					
			}
			
			
			
?>
	<div id="print_div" style="<?php echo $prnt_div_display;?>">
		<div id="photo">
			<div class="leftpanel fix_we" id="canvasPrint">
				<div class="" id="outer_div">				  
				   <img src="<?=$image_path.'/'.$all_images[0]?>" style="max-width:100%;" id="displyImage">
				</div>
			</div>
		
		<!----#################### Right Panel Frameing ######################--->
		
			<div class="rightpanel">
				<?php 
				$total_price = 0; 
				//pr($_SESSION['productArry'],0);
				if(!empty($_SESSION['productArry'])){
					$x =count($_SESSION['productArry']);
				
						$price    	       				    = $_SESSION['productArry'][$x-1]['size_price'];
						$size     	      					= $_SESSION['productArry'][$x-1]['size'];
						$images					   		    = $_SESSION['productArry'][$x-1]['images'];
						$images_id 							= $_SESSION['productArry'][$x-1]['imagesID'];
						$all_images 						= explode('~',$images);
						$all_images_id 						= explode('-',$images_id);
						$quantity  							= $_SESSION['productArry'][$x-1]['quantity'];
						$event_id  							= $_SESSION['productArry'][$x-1]['eventID'];
						$selected_photo  					= $_SESSION['productArry'][$x-1]['selected_photo'];
						$fullPath							= $_SESSION['productArry'][$x-1]['fullPath'];
						$image_path							= $_SESSION['productArry'][$x-1]['imagePath'];
						####SUDHANSU#####################################
						//$dgtalpkg_price  				    = $_SESSION['productArry']['dgimg_price'];
						####SUDHANSU#####################################
						if(($_SESSION['productArry'][$x-1]['size'] =='series') || $_SESSION['productArry'][$x-1]['size'] =='series' ){
							
							$total_price = $price;
							
						}
						else{
							
							$total_price  += $price*$selected_photo;	
							
						}
						foreach($all_images as $key => $image){				
						
							$img_path         = $fullPath;
							$imagePath        = $image_path;	

						}

				}
				?>
				<div class="right_totalingsec">
					
					<input type="hidden" class="print_size" value= "<?php echo $size; ?>">
					<h4><?php echo $size; ?>  Print Only, <?php echo $_SESSION['productArry'][$x-1]['selected_photo']; ?> Photos</h4>
					<?php if($_SESSION['productArry'][$x-1]['size']=='5x7'){?>
					<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$20 each</span></p>
					<?php
					}else if($_SESSION['productArry'][$x-1]['size']=='8x10'){ ?>
					<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$25 each</span></p>
					<?php } ?>
					<input type="hidden" id="inp_print_price" value="<?php echo $price; ?>">
					
					<h4>Single print Price <span>$</span><span id="print_price"><?php echo number_format($price,2); ?></span></h4>
					<div class="qty_sec">
					<label>Quanity:</label>
						<img src="<?=base_url()?>assets/images/qty_minusicon.png" id="decrement_print" class="decreb">
						<input style="width:10%" name="qty" id="qty_print" type="text" value="1" />
						<img src="<?=base_url()?>assets/images/qty_plusicon.png" id="increment_print" class="increb">
					</div>			
				
				<br class="clear" />									   
					<p>	
					</p>				
					<form name="frmcanvas" id="frmcanvas" action="<?=base_url()?>CartAdd/placeOrder/" method="post">
					  <input type="submit" name="btncart" id="place_order_print" value="Place Order" class="place_order" style="display:none">
					</form>					
					<div><button name="btnconfm" class="place_order" id="confirmPrintbttn">Confirm Product</button></div>

				</div>				
			</div>
			  <?php //if($meta_data) {?>
			  <br class="clear" />
		</div>
	</div>
	<div id="frame_div" style="<?php echo $frm_div_display ;?>">
			<div id="photoframe">
				<div class="leftpanel fix_we" id="canvasFrame">
					<div class="" id="outerDiv">
					  
					   <img src="<?=$image_path.'/'.$all_images[0]?>" style="max-width:100%;" id="disImage">
					  
					</div>
				</div>
		
		<!----#################### Right Panel Frameing ######################--->
		
				<div class="rightpanel">
					<?php 
					$total_price = 0; 
					//pr($_SESSION['productArry'],0);
					if(!empty($_SESSION['productArry'])){
						$x =count($_SESSION['productArry']);
					
							$price    	       				    = $_SESSION['productArry'][$x-1]['size_price'];
							$size     	      					= $_SESSION['productArry'][$x-1]['size'];
							$images					   		    = $_SESSION['productArry'][$x-1]['images'];
							$images_id 							= $_SESSION['productArry'][$x-1]['imagesID'];
							$all_images 						= explode('~',$images);
							$all_images_id 						= explode('-',$images_id);
							$quantity  							= $_SESSION['productArry'][$x-1]['quantity'];
							$event_id  							= $_SESSION['productArry'][$x-1]['eventID'];
							$selected_photo  					= $_SESSION['productArry'][$x-1]['selected_photo'];
							$fullPath							= $_SESSION['productArry'][$x-1]['fullPath'];
							$image_path							= $_SESSION['productArry'][$x-1]['imagePath'];
							####SUDHANSU#####################################
							//$dgtalpkg_price  				    = $_SESSION['productArry']['dgimg_price'];
							####SUDHANSU#####################################
							if(($_SESSION['productArry'][$x-1]['size'] =='series') || $_SESSION['productArry'][$x-1]['size'] =='series' ){
								
								$total_price = $price;
								
							}
							else{
								$total_price  		= $price*$selected_photo;
								$dflt_total_price  	= ($price*$selected_photo)+41.41;	
								
							}
							foreach($all_images as $key => $image){				
							
								$img_path         = $fullPath;
								$imagePath        = $image_path;	

							}

					}
					?>
					<div class="right_totalingsec">
					<input type="hidden" class="print_size" value= "<?php echo $size; ?>">
						<h4><?php echo $size; ?>  Print Only, <?php echo $_SESSION['productArry'][$x-1]['selected_photo']; ?> Photos</h4>
						<?php if($_SESSION['productArry'][$x-1]['size']=='5x7'){?>
						<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$20 each</span></p>
						<?php
						}else if($_SESSION['productArry'][$x-1]['size']=='8x10'){ ?>
						<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$25 each</span></p>
						<?php } ?>
						<input type="hidden" id="inp_print_price" value="<?php echo $price; ?>">
						
						<h4>Single print Price <span>$</span><span id="print_price"><?php echo number_format($price,2); ?></span></h4>
						<h2>Frame Price <span>$</span><span id="frm_price">0</span></h2>
						<div class="qty_sec">
						<label>Quanity:</label>
							<img src="<?=base_url()?>assets/images/qty_minusicon.png" id="decrement_frame" class="decreb">
							<input style="width:10%" name="qty" id="qty_frame" type="text" value="1" />
							<img src="<?=base_url()?>assets/images/qty_plusicon.png" id="increment_frame" class="increb">
						</div>
						
					
					<br class="clear" />
					<div class="price">
					  <input type="hidden" name="txtimgprice" id="imgPrice" value="<?=$price?>">
					  <input type="hidden" name="txteventid" id="eventID" value="">
					  <input type="hidden" name="txtmediaid" id="mediaID" value="">
					  <input type="hidden" name="txtsizeprice" id="sizePrice" value="<?=$price?>">
					  
					  
					  <!--**********sreela(05/04/18)*********-->
					  
					  <!--**********End*********-->
					  
					  <input type="hidden" name="txttopmatprice" id="topMatPrice" value="">
					  <input type="hidden" name="txtmiddlematprice" id="middleMatPrice" value="">
					  <input type="hidden" name="txtbottommatprice" id="bottomMatPrice" value="">
					  
					  <!--**********sreela(05/04/18)*********-->
					
					  <label id="lb_frame"></label><span class="frameName"></span><!-- <br>		
					  
					  <label id="lb_topmat"></label><span class="topmatName"></span><br>
					  
					  <label id="lb_middlemat"></label><span class="middlematName"></span><br>
					  
					  <label id="lb_bottommat"></label><span class="bottommatName"></span><br> -->
					
					  <!--**********End*********-->
					   <br class="clear" />
							   
						<div>
							<input type="hidden" name="img_val" id="img_val" value="">
							<input type="hidden" name="img_name" id="img_name" value="">
							<input type="hidden" name="eventid" id="eventid" value="<?php echo $event_id; ?>">
							<input type="hidden" name="dig_total" id="dig_total" value="<?php echo $total_price; ?>">
							<input type="hidden" name="txtframeprice" id="framePrice" value="41.41">
							<?php $total_price = $total_price + 41.4; ?>
							<input type="hidden" name="inp_total_price" id="inp_total_price" value="<?php echo $total_price; ?>">
							<input type="hidden" name="txtframename" id="frameName" value="Soho Black">	
						</div>
						<form name="frmcanvas" id="frmcanvas" action="<?=base_url()?>CartAdd/placeOrder/" method="post">
						  <input type="submit" name="btncart"  id="place_order_bttn" value="Place Order" class="place_order" style="display:none">
						</form>
						<div><button name="btnconfm" class="place_order" id="confirmbttn" style="display:none">Confirm Product</button></div>
						</p>
					</div>
					</div>
					<?php if(!empty($option_description)) {?>
					<div class="about_product">
					<h2>About <?=$option_name;?></h2>
					<img src="<?=base_url()?>uploads/optionImg/<?=$option_image?>" id="">
					<p><?=nl2br($option_description);?></p>
					</div>
					<?php }?>
				</div>
				  <?php //if($meta_data) {?>
				  <br class="clear" />
				  
				<!----#################### Photoframe OPTION ######################--->
				
				<div class="option_frame" id="option_frame">
				  <?php if(array_key_exists('Frame', $meta_data)) {?>
				  <h3 rel="frame" class="active">Frame</h3>
				  <!-- <h3 rel="topmat">Top mat</h3>
				  <h3 rel="midmat">Middle mat</h3>
				  <h3 rel="botmat">Bottom mat</h3> -->
				   <br class="clear" />
				  <ul class="frame">
				  <?php foreach($meta_data['Frame'] as $fKey => $fVal) {?>
					<li rel="<?=strtolower(str_replace(" ", "_", $fVal['meta_value']));?>">
					  <img src="<?=base_url()?>uploads/metaImg/<?=$fVal['meta_image']?>" id="">
					  <span><strong><?=$fVal['meta_value'];?></strong>
					  <br />
						  <?="$".$fVal['meta_price']?></span>
					  <input type="hidden" name="" id="<?=strtolower(str_replace(" ", "_", $fVal['meta_value']));?>" value="<?=$fVal['meta_price']?>">
					</li>
				  <?php }?>      
				  </ul>
				  <?php }?>
				</div>
				<br class="clear" />
				<br />
			</div>
	</div>
	<input type="hidden" id="selected_imgage" value="<?php echo $selected_photo; ?>">
	<div id="collage_div" class="collage" style="<?php echo $colg_div_display ;?>">
		<div id="collageframe">
		   <div class="left_right_colg_div">
			<div class="leftpanel fix_we" id="canvasFrameCollg">
			<div class="" id="outerframeCollage">
				<div class="full_frame <?php echo $collage_class;?>" id="outerDivCollage">
		  <?php if($size != 'package'){?>
		  <div id="sortable" class="">
          <?php }?>

          <?php if($size == 'package'){?>
            <div id="sortableLeft" class="ui-sortable">
              <div class="row_5 leftBig ui-sortable-handle">
              <img src="<?=base_url()?>assets/images/collage/noimage.png" style="">
              <span class="remove_frame">
              <img src="<?=base_url()?>assets/images/collage/delete.png" style="">
              </span>
              </div>
              <div class="row_5 ui-sortable-handle">
              <img src="<?=base_url()?>assets/images/collage/noimage.png" style="">
              <span class="remove_frame">
              <img src="<?=base_url()?>assets/images/collage/delete.png" style="">
              </span>
              </div>
            </div>

            <div id="sortableRight" class="ui-sortable">
	            <div class="row_5 ui-sortable-handle">
	            <img src="<?=base_url()?>assets/images/collage/noimage.png" style="">
	            <span class="remove_frame">
	            <img src="<?=base_url()?>assets/images/collage/delete.png" style="">
	            </span>
	            </div>
	            <div class="row_5 ui-sortable-handle">
	            <img src="<?=base_url()?>assets/images/collage/noimage.png" style="">
	            <span class="remove_frame">
	            <img src="<?=base_url()?>assets/images/collage/delete.png" style="">
	            </span>
	            </div>
	            <div class="row_5 ui-sortable-handle">
	            <img src="<?=base_url()?>assets/images/collage/noimage.png" style="">
	            <span class="remove_frame">
	            <img src="<?=base_url()?>assets/images/collage/delete.png" style=""></span>
                </div>
            </div>
           <?php }
            if($size == 'series'){
           ?>
           <div class="row_5"><img src="<?php echo base_url()?>assets/images/collage/noimage.png" style=""><span class="remove_frame"><img src="http://senabidemoportal.com/elevation/assets/images/collage/delete.png" style=""></span>
           </div>
           <div class="row_5"><img src="<?php echo base_url()?>assets/images/collage/noimage.png" style=""><span class="remove_frame"><img src="http://senabidemoportal.com/elevation/assets/images/collage/delete.png" style=""></span>
           </div>
           <div class="row_5"><img src="<?php echo base_url()?>assets/images/collage/noimage.png" style=""><span class="remove_frame"><img src="http://senabidemoportal.com/elevation/assets/images/collage/delete.png" style=""></span>
           </div>
           <div class="row_5"><img src="<?php echo base_url()?>assets/images/collage/noimage.png" style=""><span class="remove_frame"><img src="http://senabidemoportal.com/elevation/assets/images/collage/delete.png" style=""></span>
           </div>
           <div class="row_5"><img src="<?php echo base_url()?>assets/images/collage/noimage.png" style=""><span class="remove_frame"><img src="http://senabidemoportal.com/elevation/assets/images/collage/delete.png" style=""></span>
           </div>
           <?php }?>
         
         <?php if($size != 'package'){?>
         </div>
         <?php }?>

		</div>
		</div>
			</div>
			<div class="rightpanel">
				<?php 
				$total_price = 0; 
				//pr($_SESSION['productArry'],0);
				if(!empty($_SESSION['productArry'])){
					$x =count($_SESSION['productArry']);		
					$price    	       				    = $_SESSION['productArry'][$x-1]['size_price'];
					$size     	      					= $_SESSION['productArry'][$x-1]['size'];
					$images					   		    = $_SESSION['productArry'][$x-1]['images'];
					$images_id 							= $_SESSION['productArry'][$x-1]['imagesID'];
					$all_images 						= explode('~',$images);
					$all_images_id 						= explode('-',$images_id);
					$quantity  							= $_SESSION['productArry'][$x-1]['quantity'];
					$event_id  							= $_SESSION['productArry'][$x-1]['eventID'];
					$selected_photo  					= $_SESSION['productArry'][$x-1]['selected_photo'];
					$total_image_cnt					= $_SESSION['productArry'][$x-1]['total_image_cnt'];
					$fullPath							= $_SESSION['productArry'][$x-1]['fullPath'];
					$image_path							= $_SESSION['productArry'][$x-1]['imagePath'];
					####SUDHANSU#####################################
					//$dgtalpkg_price  				    = $_SESSION['productArry']['dgimg_price'];
					####SUDHANSU#####################################
					if(($_SESSION['productArry'][$x-1]['size'] =='series') || $_SESSION['productArry'][$x-1]['size'] =='package' ){
						
						$total_price = $price;
						
					}
					else{
						
						$total_price  = '0';	
						
					}
					foreach($all_images as $key => $image){				
					
						$img_path         = $fullPath;
						$imagePath        = $image_path;	

					}

				}
				?>
				<br class="clear" />
				<div class="price">
				  <input type="hidden" name="txtimgprice" id="imgPrice" value="">
				  <input type="hidden" name="txteventid" id="eventID" value="">
				  <input type="hidden" name="txtmediaid" id="mediaID" value="">          
				  <input type="hidden" name="txtcollageframeprice" id="collageFramePrice" value="20">
					<div class="right_totalingsec"> 
					  <label id="lb_frame">Matte </label><span class="frameName">Blue Matte</span><br>
					  <label id="lb_matteframe"></label><span class="matteframeName"></span>
					   <br class="clear" />
					  <h4><?php echo $size; ?>  Print Only, <?php echo $_SESSION['productArry'][$x-1]['selected_photo']; ?> Photos</h4>
						<?php if($_SESSION['productArry'][$x-1]['size']=='5x7'){?>
						<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$20 each</span></p>
						<?php
						}else if($_SESSION['productArry'][$x-1]['size']=='8x10'){ ?>
						<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$25 each</span></p>
						<?php }else if($_SESSION['productArry'][$x-1]['size']=='series'){ ?>
						<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
						<?php }
						else if($_SESSION['productArry'][$x-1]['size']=='package'){ ?>
						<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
						<?php }?>
						<h2>Frame Price <span>$</span><span id="mattefrm_price">0</span></h2>
						<h2>Collage Price <span>$</span><span id="colg_total_price"><?php echo number_format($total_price,2); ?></span></h2>  
						<div class="qty_sec">
							<label>Quanity:</label>
							<img src="<?=base_url()?>assets/images/qty_minusicon.png" id="decrement_collage" class="decreb">
							<input style="width:10%" name="qty" id="qty_collage" type="text" value="1" />
							<img src="<?=base_url()?>assets/images/qty_plusicon.png" id="increment_collage" class="increb">
						</div>
					</div>
				</div>				
				<form name="frmcanvas" id="frmcanvas_colg" action="<?=base_url()?>CartAdd/placeOrder/" method="post">	
					<input type="submit" name="btncart"  id="place_order_collg_bttn" value="Place Order" class="place_order" style="display:none">
				</form>
				<input type="hidden" name="img_val" id="img_val_colag" value="">
				
				<input type="hidden" name="colg_img_id" id="colg_img_id" value="">
				
				<input type="hidden" name="colg_img_name" id="colg_img_name" value="">
				<input type="hidden" name="dig_total" id="dig_total" value="<?php echo $total_price; ?>">
				<input type="hidden" name="txtframeprice" id="matteframePrice" value="0">
				<?php $total_price = $total_price + 41.4; ?>
				<input type="hidden" name="inp_total_price" id="inp_total_price" value="<?php echo $total_price; ?>">
				<input type="hidden" name="txtframename" id="matteframeName" value="">	
				<input type="hidden" name="collage_price" id="collage_price" value="<?php if(!empty($_SESSION['productArry'][$x-1]['size']) && $_SESSION['productArry'][$x-1]['size'] =='series'){echo  '30'; }else if(!empty($_SESSION['productArry'][$x-1]['size']) && $_SESSION['productArry'][$x-1]['size'] =='package'){ echo '45'; }?>">
				<?php if($_SESSION['productArry'][$x-1]['size'] =='series'){ ?>
				<input type="hidden" name="collage_frame_name" id="collage_frame_name" value="series blue matte">
				<?php } ?>
				<?php if($_SESSION['productArry'][$x-1]['size'] =='package' ){ ?>
				<input type="hidden" name="collage_frame_name" id="collage_frame_name" value="package black matte">
				<?php } 
				else{ ?>
				<input type="hidden" name="collage_frame_name" id="collage_frame_name" value="5x7 blue matte">
				<?php } 					
				?>
				<input type="hidden" name="dig_total" id="dig_total_colg" value="">
				<input type="hidden" name="inp_total_price_collg" id="inp_total_price_collg" value="<?php echo $total_price; ?>">
				<div id='clickable'></div>
				<div><button name="btnconfm" class="place_order" id="confirmbttnCollage" disabled>Confirm Product</button></div>
			</div>
			<br class="clear" />
		   </div>
			<div class="tab_section" id="collage_matteoption">
				<div class="tab">
				  <button id="colg_matte" class="tablinks_collage active" onclick="openoption(event, 'option_frame_collage')">Matte</button>
				  <button id="frm_matte" class="tablinks_collage" onclick="openoption(event, 'option_frames')">Frame</button>
				</div>
			
			<div class="option_frame_collage tabcontent" id="option_frame_collage">     
						
				<ul class="frame_collage">		
						
				<li rel="blue_matte|2" id="5x7bluematte" style="display:none">
						  <img src="<?=base_url()?>assets/images/collage/blue_matte.png" id="">
						  <span><strong>5x7 blue matte</strong>
						  <br />
						  $20.00
						  <input type="hidden" name="" id="blue_matte" value="20">
						  </span>          
				</li>
				<li rel="green_matte|2" id="5x7greenmatte" style="display:none">
				  <img src="<?=base_url()?>assets/images/collage/green_matte.png" id="">
				  <span><strong>5x7 green matte</strong>
				  <br />
				  $20.00
				  <input type="hidden" name="" id="green_matte" value="20">
				  </span>          
				</li> 
				
				<?php
				
				if($selected_photo == 2 || $selected_photo == 3|| $selected_photo == 4){ ?>
				<li rel="blue_matte|2" id="matteblue">
				  <img src="<?=base_url()?>assets/images/collage/blue_matte.png" id="">
				  <span><strong>5x7 blue matte</strong>
				  <br />
				  $20.00
				  <input type="hidden" name="" id="blue_matte" value="20">
				  </span>          
				</li>
				<li rel="green_matte|2" id="mattegreen">
				  <img src="<?=base_url()?>assets/images/collage/green_matte.png" id="">
				  <span><strong>5x7 green matte</strong>
				  <br />
				  $20.00
				  <input type="hidden" name="" id="green_matte" value="20">
				  </span>          
				</li> 
				<?php } ?>
				<?php if(($selected_photo == 5) && ($size == 'package')) { ?>
				<li rel="package_black_matte|5" class="pck_matte">
				  <img src="<?=base_url()?>assets/images/collage/package_black_matte.png" id="">
				  <span><strong>package black matte</strong>
				  <br />
				  $45.00
				  <input type="hidden" name="" id="package_black_matte" value="45">
				  </span>          
				</li>
				<li rel="package_blue_matte|5" class="pck_matte">
				  <img src="<?=base_url()?>assets/images/collage/package_blue_matte.png" id="">
				  <span><strong>package blue matte</strong>
				  <br />
				  $45.00
				  <input type="hidden" name="" id="package_blue_matte" value="45">
				  </span>          
				</li>
				<li rel="package_green_matte|5" class="pck_matte">
				  <img src="<?=base_url()?>assets/images/collage/package_green_matte.png" id="">
				  <span><strong>package green matte</strong>
				  <br />
				  $45.00
				  <input type="hidden" name="" id="package_green_matte" value="45">
				  </span>          
				</li>
				<?php }
				else if(($selected_photo == 5) && ($size == 'series')){ 
				?>
				<li rel="series_blue_matte|5" class="series_matte">
				  <img src="<?=base_url()?>assets/images/collage/series_blue_matte.png" id="">
				  <span><strong>series blue matte</strong>
				  <br />
				  $30.00
				  <input type="hidden" name="" id="series_blue_matte" value="30">
				  </span>          
				</li>
				<li rel="series_green_matte|5" class="series_matte">
				  <img src="<?=base_url()?>assets/images/collage/series_green_matte.png" id="">
				  <span><strong>series green matte</strong>
				  <br />
				  $30.00
				  <input type="hidden" name="" id="series_green_matte" value="30">
				  </span>          
				</li>
				<li rel="series_black_matte|5" class="series_matte">
				  <img src="<?=base_url()?>assets/images/collage/series_black_matte.png" id="">
				  <span><strong>series black matte</strong>
				  <br />
				  $30.00
				  <input type="hidden" name="" id="series_black_matte" value="30">
				  </span>          
				</li>  
				<?php } 
				else if($selected_photo >= 5){ ?>
				<li rel="package_black_matte|5" class="pck_matte">
				  <img src="<?=base_url()?>assets/images/collage/package_black_matte.png" id="">
				  <span><strong>package black matte</strong>
				  <br />
				  $45.00
				  <input type="hidden" name="" id="package_black_matte" value="45">
				  </span>          
				</li>
				<li rel="package_blue_matte|5" class="pck_matte">
				  <img src="<?=base_url()?>assets/images/collage/package_blue_matte.png" id="">
				  <span><strong>package blue matte</strong>
				  <br />
				  $45.00
				  <input type="hidden" name="" id="package_blue_matte" value="45">
				  </span>          
				</li>
				<li rel="package_green_matte|5" class="pck_matte">
				  <img src="<?=base_url()?>assets/images/collage/package_green_matte.png" id="">
				  <span><strong>package green matte</strong>
				  <br />
				  $45.00
				  <input type="hidden" name="" id="package_green_matte" value="45">
				  </span>          
				</li>	
				<li rel="series_blue_matte|5" class="series_matte">
				  <img src="<?=base_url()?>assets/images/collage/series_blue_matte.png" id="">
				  <span><strong>series blue matte</strong>
				  <br />
				  $30.00
				  <input type="hidden" name="" id="series_blue_matte" value="30">
				  </span>          
				</li>
				<li rel="series_green_matte|5" class="series_matte">
				  <img src="<?=base_url()?>assets/images/collage/series_green_matte.png" id="">
				  <span><strong>series green matte</strong>
				  <br />
				  $30.00
				  <input type="hidden" name="" id="series_green_matte" value="30">
				  </span>          
				</li>
				<li rel="series_black_matte|5" class="series_matte">
				  <img src="<?=base_url()?>assets/images/collage/series_black_matte.png" id="">
				  <span><strong>series black matte</strong>
				  <br />
				  $30.00
				  <input type="hidden" name="" id="series_black_matte" value="30">
				  </span>          
				</li>	
				<?php } ?>		
			  </ul> 
			</div>
			<div class="option_frame tabcontent" id="option_frames" style="display: none;">
					
				<ul class="matte_frame">
				
				<li rel="P_blk_engraved_11x14" class="frame_opt" id="collg_frame_P_blk_engraved" style="display:none">
				  <img src="<?=base_url()?>uploads/metaImg/11x14_P_blk_engraved.png" id="" style="margin-bottom:40px">
				  <span><strong>11x14 P blk engraved</strong>
				  <br />
					  $50</span>
				  <input type="hidden" name="" id="P_blk_engraved_11x14" value="50">
				</li>
				<li rel="blk_engraved_8x23" class="frame_opt" style="display:none" id="collg_frame_blk_engraved">
				  <img src="<?=base_url()?>uploads/metaImg/8x23_blk_engraved.png" id="" style="margin-bottom:40px">
				  <span><strong>8x23 blk engraved</strong>
				  <br />
					  $65</span>
				  <input type="hidden" name="" id="blk_engraved_8x23" value="65">
				</li>
				<li rel="blk_engraved_better_16x20" class="frame_opt" style="display:none" id="collg_frame_blk_engraved_better">
				  <img src="<?=base_url()?>uploads/metaImg/16x20_blk_engraved_better.png" id="" style="margin-bottom:40px">
				  <span><strong>16x20 blk engraved better</strong>
				  <br />
					  $80</span>
				  <input type="hidden" name="" id="blk_engraved_better_16x20" value="80">
				</li>
				<li rel="blk_metal_16x20" class="frame_opt" style="display:none" id="collg_frame_blk_metal">
				  <img src="<?=base_url()?>uploads/metaImg/16x20_blk_metal.png" id="" style="margin-bottom:30px">
				  <span><strong>16x20 blk metal</strong>
				  <br />
					  $80</span>
				  <input type="hidden" name="" id="blk_metal_16x20" value="80">
				</li>
				<li rel="cedar_16x20" class="frame_opt" style="display:none" id="collg_frame_cedar">
				  <img src="<?=base_url()?>uploads/metaImg/16x20_cedar.png" id="" style="margin-bottom:30px">
				  <span><strong>16x20 cedar</strong>
				  <br />
					  $80</span>
				  <input type="hidden" name="" id="cedar_16x20" value="80">
				</li>
				<li rel="barnwwod_16x20" class="frame_opt" style="display:none" id="collg_frame_barnwwod">
				  <img src="<?=base_url()?>uploads/metaImg/barnwwod_16x20.png" id="" style="margin-bottom:40px">
				  <span><strong>barnwwod 16x20</strong>
				  <br />
					  $80</span>
				  <input type="hidden" name="" id="barnwwod_16x20" value="80">
				</li>
				</ul>				
			</div>
				<br class="clear" />
				<br />
			</div>
	</div>
</div>
<input type="hidden" id="total_img_cnt" value="">
<!-----################# selected Images #################------> 
<div class="bdrsdo fav_slider" id="selected_img">
	<div id="country_table">
		<?php $i = 0;
		if(!empty($all_img_list)){
		
		  foreach($all_img_list as $img) {       
			
			$total_price  += $price*$quantity;	
			$img_path         = $fullPath;
			$imagePath        = base_url().'uploads/'.$img_path.$img['file_name'];
			if($i < 1) {          
			  $f_img_path     = $fullPath;
			  $firstImgPath   = base_url().'uploads/'.$img_path.$img['file_name']; 
			}
			
		?>
		
		  <div id="imgDIV_<?php echo $img['media_id']?>" class="nailthumb-container imgDisplay">
			
			<a class="imgDetails" href="<?=base_url();?>Category/details/<?=$img['media_id']?>" rel="<?=$img['media_price']."|".$img['event_id']."|".$img['media_id']."|".$img['file_name']?>"><img style="height: 89%;" src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative;"></a>
			<input type="hidden" class="imgDetails" value="<?php echo $frmopttype?>">
			<div>
				<p><strong><?php echo $size; ?></strong></p>
				
			</div>
			<input type="hidden" name="img_id" id="img_id" value="<?php echo $img['media_id']; ?>">
			<input type="hidden" name="imge_name" id="imge_name" value="<?php echo $img['file_name']; ?>">
			<input type="hidden" name="event_id" id="event_id_<?php echo $img['media_id']; ?>" value="<?=$img['event_id']?>">
			
		  </div>
		  
		<?php } } ?>	
	</div>
<!--**********sreela(05/04/18)*********-->
	<span id="prev"><img src="<?=base_url()?>assets/images/prev_arrow.png" id=""></span>
	<span id="next"><img src="<?=base_url()?>assets/images/next_arrow.png" id=""></span>
	<!--**********end*********-->
</div>
<?php } else {?>
    
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
<style>
#clickable{
position:absolute;
    width:55px;
    height:25px;
}
</style>
<script>
     function fbs_click(TheImg) {alert("here");
	 alert("hi - "+$(this).parent('div').attr('id'));
     
	}
	
	$(document).on("click",".increb", function(event){
		  var boxname = $(this).attr('id').split("_");	  
		  var option_type		= boxname[1];		  
		 // alert(key+'##'+arraykey+'##'+cart_type);
		  var c= parseInt($('#qty_'+option_type).val());
		  c += 1;	  
		  $('#qty_'+option_type).val(c);
     
		});	 
		$(document).on("click",".decreb", function(event){
		  var boxname = $(this).attr('id').split("_");
		  var option_type		= boxname[1];
		  //alert(key+'##'+arraykey+'##'+cart_type);
		  var c= parseInt($('#qty_'+option_type).val());
		  c -= 1;
		  $('#qty_'+option_type).val(c);
		});
</script>
<script type="text/javascript">
	
	<!--**********sreela(05/04/18)*********-->
	$(function() {

	$('#country_table').carouFredSel({
		responsive: true,
		circular: true,
		infinite: false,
		auto: false,
		prev: '#prev',
		next: '#next',
		items: {
			visible: {
				min: 2,
				max: 5
			},
			width: 150,
			height: '66%'
		}
	});
		
});
function openoption(evt, optionName) {
	
    var i, tabcontent, tablinks;
	
	if(optionName == 'option_frames'){
		var colg_img_id 	= $("#colg_img_id").val();
		if(colg_img_id != ''){			
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks_collage");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace("active", "");
			}
			document.getElementById(optionName).style.display = "block";
			evt.currentTarget.className += " active";
		}
		else{
			alert("Please first select the matte with images");
		}
		
	}
	else{
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks_collage");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace("active", "");
		}
		document.getElementById(optionName).style.display = "block";
		evt.currentTarget.className += " active";		
	}
}
<!--**********end*********-->
</script>
