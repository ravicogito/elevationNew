<script type="text/javascript">
  $(document).ready(function() {
      $( "#sortable" ).sortable();    
  })
</script>
<style type="text/css">
  /*#draggable { width: 150px; height: 150px; padding: 0.5em; z-index: 2; border: 5px solid red; position: absolute; left: 0; top: 5;}*/
</style>

	<div class="leftpanel fix_we" id="canvasFrame">
		<div class="full_frame blue_matte" id="outerDivCollage">
		  <div id="sortable" class="">
		  <div class="row_2" id="">
			<img src="<?=base_url()?>assets/images/collage/noimage.png" style="">
			<span class="remove_frame"><img src="<?=base_url()?>assets/images/collage/delete.png" style=""></span>
		  </div> 
		   
		  <div class="row_2" id="0">
			<img src="<?=base_url()?>assets/images/collage/noimage.png" style="">
			<span class="remove_frame"><img src="<?=base_url()?>assets/images/collage/delete.png" style=""></span>
		  </div>
		  </div>
		</div>
	</div>
     <div class="rightpanel">
		<?php 
		$total_price = 0; 
		//pr($_SESSION['cartVal'],0);
		if(!empty($_SESSION['cartVal'])){
			$x =count($_SESSION['cartVal']);		
			$price    	       				    = $_SESSION['cartVal'][$x-1]['size_price'];
			$size     	      					= $_SESSION['cartVal'][$x-1]['size'];
			$images					   		    = $_SESSION['cartVal'][$x-1]['images'];
			$images_id 							= $_SESSION['cartVal'][$x-1]['imagesID'];
			$all_images 						= explode('~',$images);
			$all_images_id 						= explode('-',$images_id);
			$quantity  							= $_SESSION['cartVal'][$x-1]['quantity'];
			$event_id  							= $_SESSION['cartVal'][$x-1]['eventID'];
			$selected_photo  					= $_SESSION['cartVal'][$x-1]['selected_photo'];
			$fullPath							= $_SESSION['cartVal'][$x-1]['fullPath'];
			$image_path							= $_SESSION['cartVal'][$x-1]['imagePath'];
			####SUDHANSU#####################################
			//$dgtalpkg_price  				    = $_SESSION['cartVal']['dgimg_price'];
			####SUDHANSU#####################################
			if(($_SESSION['cartVal'][$x-1]['size'] =='series') || $_SESSION['cartVal'][$x-1]['size'] =='package' ){
				
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
        <br class="clear" />
        <div class="price">
          <input type="hidden" name="txtimgprice" id="imgPrice" value="">
          <input type="hidden" name="txteventid" id="eventID" value="">
          <input type="hidden" name="txtmediaid" id="mediaID" value="">          
          <input type="hidden" name="txtcollageframeprice" id="collageFramePrice" value="20">
			<div class="right_totalingsec"> 
			  <label id="lb_frame">Frame</label><span class="frameName">Blue Matte</span>
			   <br class="clear" />
			  <h4><?php echo $size; ?>  Print Only, <?php echo $_SESSION['cartVal'][$x-1]['selected_photo']; ?> Photos</h4>
				<?php if($_SESSION['cartVal'][$x-1]['size']=='5x7'){?>
				<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$20 each</span></p>
				<?php
				}else if($_SESSION['cartVal'][$x-1]['size']=='8x10'){ ?>
				<p>If  the customer orders more than one or adds to any other print or print package the price becomes<span>$25 each</span></p>
				<?php }else if($_SESSION['cartVal'][$x-1]['size']=='series'){ ?>
				<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
				<?php }
				else if($_SESSION['cartVal'][$x-1]['size']=='package'){ ?>
				<p>This must be the same boat and different images! - Customer can add additional 4x6's of different images for<span>$7/each</span></p>
				<?php }?>
				<h2>Total Price <span>$<?php echo number_format($total_price,2); ?></span></h2>  
			</div>
		</div>
	</div>
	<br class="clear" />
    
    <div class="option_frame_collage">     
	  <h3 rel="frame" class="active">Matte</h3>      
		<br class="clear" />
		<ul class="frame_collage">
		<?php if($selected_photo == 2){ ?>
		<li rel="blue_matte|2">
		  <img src="<?=base_url()?>assets/images/collage/blue_matte.png" id="">
		  <span><strong>5x7 blue matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="blue_matte" value="20">
		  </span>          
		</li>
		<li rel="green_matte|2">
		  <img src="<?=base_url()?>assets/images/collage/green_matte.png" id="">
		  <span><strong>5x7 green matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="green_matte" value="20">
		  </span>          
		</li> 
		<?php } ?>
		<?php if(($selected_photo == 5) && ($size == 'package')) { ?>
		<li rel="package_black_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/package_black_matte.png" id="">
		  <span><strong>package black matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="package_black_matte" value="20">
		  </span>          
		</li>
		<li rel="package_blue_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/package_blue_matte.png" id="">
		  <span><strong>package blue matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="package_blue_matte" value="20">
		  </span>          
		</li>
		<li rel="package_green_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/package_green_matte.png" id="">
		  <span><strong>package green matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="package_green_matte" value="20">
		  </span>          
		</li>
		<?php }
		if(($selected_photo == 5) && ($size == 'series')){ 
		?>
		<li rel="series_blue_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/series_blue_matte.png" id="">
		  <span><strong>series blue matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="series_blue_matte" value="20">
		  </span>          
		</li>
		<li rel="series_green_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/series_green_matte.png" id="">
		  <span><strong>series green matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="series_green_matte" value="20">
		  </span>          
		</li>
		<li rel="series_black_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/series_black_matte.png" id="">
		  <span><strong>series black matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="series_black_matte" value="20">
		  </span>          
		</li>  
		<?php } if($selected_photo == 5){ ?>
		<li rel="package_black_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/package_black_matte.png" id="">
		  <span><strong>package black matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="package_black_matte" value="20">
		  </span>          
		</li>
		<li rel="package_blue_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/package_blue_matte.png" id="">
		  <span><strong>package blue matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="package_blue_matte" value="20">
		  </span>          
		</li>
		<li rel="package_green_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/package_green_matte.png" id="">
		  <span><strong>package green matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="package_green_matte" value="20">
		  </span>          
		</li>	
		<li rel="series_blue_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/series_blue_matte.png" id="">
		  <span><strong>series blue matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="series_blue_matte" value="20">
		  </span>          
		</li>
		<li rel="series_green_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/series_green_matte.png" id="">
		  <span><strong>series green matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="series_green_matte" value="20">
		  </span>          
		</li>
		<li rel="series_black_matte|5">
		  <img src="<?=base_url()?>assets/images/collage/series_black_matte.png" id="">
		  <span><strong>series black matte</strong>
		  <br />
		  $20.00
		  <input type="hidden" name="" id="series_black_matte" value="20">
		  </span>          
		</li> 	
			
			
			
		<?php } ?>		
	  </ul> 
	</div>
