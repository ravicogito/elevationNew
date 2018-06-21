<div class="leftpanel fix_we" id="canvasFrame">
  <div class="full_frm_<?=strtolower(str_replace(" ", "_", $option_name));?>" id="outerDiv">
      <!-- <div class="<?=$texture_class?>">
      <div class="<?=$border_frame?>"> -->
       <img src="<?=$image_src?>" style="max-width:100%; position: relative;" id="disImage">
      <!-- </div>
      </div> -->
  </div>
      </div>
      <div class="rightpanel">
        <div class="choose_size">
        <label><?=$option_size_text;?> Size:</label>
       <div class="listdiv"><?=$option_size[0]['size']?>
       <ul id="p2a_mto_ulsizeoptions" class="p2a_mto_ulsizeoptions" style="display: none;">
		  <?php foreach($option_size as $sizeKey => $sizeVal){ ?>
          <li class="lisizeoptions" sizeid="<?php echo $sizeVal['size']; ?>" rel="<?=$sizeVal['price']?>"><?php echo $sizeVal['size']; ?></li>
		  <?php } ?>         
        </ul>
        </div>
        </div>
        <br class="clear" />
        <div class="price">
          <input type="hidden" name="txtimgprice" id="imgPrice" value="<?=$img_price?>">
          <input type="hidden" name="txteventid" id="eventID" value="">
          <input type="hidden" name="txtmediaid" id="mediaID" value="">
          <input type="hidden" name="txtsizeprice" id="sizePrice" value="<?=$size_price?>">
          <input type="hidden" name="txtframeprice" id="framePrice" value="">
		  
		  <!--**********sreela(05/04/18)*********-->
		  <input type="hidden" name="txtframename" id="frameName" value="">
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
		  <label>Your Price : </label><span class="totalPrice">$<?=$total_price?></span>          
          <p><form name="frmcanvas" id="frmcanvas" action="<?=base_url()?>Favourite/cart/" method="post">
            <input type="hidden" name="img_val" id="img_val" value="">
			
			<!--//**********sreela(05/04/18)*********-->
			<input type="hidden" name="frame_name" id="frame_name" value="">
			<input type="hidden" name="topmat_name" id="topmat_name" value="">
			<input type="hidden" name="middlemat_name" id="middlemat_name" value="">
			<input type="hidden" name="bottommat_name" id="bottommat_name" value="">
			<!--**********End*********-->
			
            <input type="submit" name="btncart" value="Add To Cart" class="createCanvas">
          </form>
            </p>
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
      <div class="option_frame">
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
      <?php //if(array_key_exists('Top Mat', $meta_data)) {?>
      <!-- <ul class="topmat" style="display:none;">
      <?php foreach($meta_data['Top Mat'] as $tmKey => $tmVal) {?>  
      <li rel="<?=strtolower(str_replace(" ", "_", $tmVal['meta_value']));?>">
        <img src="<?=base_url()?>uploads/metaImg/<?=$tmVal['meta_image']?>" id="">
        <span><?="$".$tmVal['meta_price']?></span>
        <input type="hidden" name="" id="<?=strtolower(str_replace(" ", "_", $tmVal['meta_value']));?>" value="<?=$tmVal['meta_price']?>">
      </li>
      <?php }?>
      </ul> -->
      <?php //}?>
      <?php //if(array_key_exists('Middle Mat', $meta_data)) {?>
      <!-- <ul class="midmat" style="display:none;">
      <?php foreach($meta_data['Middle Mat'] as $mmKey => $mmVal) {?>  
      <li rel="<?=strtolower(str_replace(" ", "_", $mmVal['meta_value']));?>">
        <img src="<?=base_url()?>uploads/metaImg/<?=$mmVal['meta_image']?>" id="">
        <span><?="$".$mmVal['meta_price']?></span>
        <input type="hidden" name="" id="<?=strtolower(str_replace(" ", "_", $mmVal['meta_value']));?>" value="<?=$mmVal['meta_price']?>">
      </li>
      <?php }?>
      </ul> -->
      <?php //}?>
      <?php //if(array_key_exists('Bottom Mat', $meta_data)) {?>
      <!-- <ul class="botmat" style="display:none;">
      <?php foreach($meta_data['Bottom Mat'] as $bmKey => $bmVal) {?>  
      <li rel="<?=strtolower(str_replace(" ", "_", $bmVal['meta_value']));?>">
        <img src="<?=base_url()?>uploads/metaImg/<?=$bmVal['meta_image']?>" id="">
        <span><?="$".$bmVal['meta_price']?></span>
        <input type="hidden" name="" id="<?=strtolower(str_replace(" ", "_", $bmVal['meta_value']));?>" value="<?=$bmVal['meta_price']?>">
      </li>
      <?php }?>
      </ul> -->
      <?php //}?>

      </div>

      <?php //}?>