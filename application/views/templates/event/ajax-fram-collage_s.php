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
        <br class="clear" />
        <div class="price">
          <input type="hidden" name="txtimgprice" id="imgPrice" value="">
          <input type="hidden" name="txteventid" id="eventID" value="">
          <input type="hidden" name="txtmediaid" id="mediaID" value="">          
          <input type="hidden" name="txtcollageframeprice" id="collageFramePrice" value="20">
		  
          <label id="lb_frame">Frame</label><span class="frameName">Blue Matte</span>
		   <br class="clear" />
		  <label>Your Price : </label><span class="totalPrice">$20.00</span>          
          <p><form name="frmcanvas" id="frmcanvas" action="<?=base_url()?>Favourite/cart/" method="post">
            <input type="hidden" name="img_val" id="img_val" value="">

      			<input type="hidden" name="collage_frame_name" id="collage_frame_name" value="5x7 blue matte">
			
            <input type="submit" name="btncart" value="Add To Cart" class="createCanvas">
          </form>
            </p>
        </div>

      </div>  
      <br class="clear" />
    
    <div class="option_frame_collage">     
      <h3 rel="frame" class="active">Frame</h3>      
        <br class="clear" />
        <ul class="frame_collage">
        <?php 
          ##############SUDHANSU###############################
           $packagetype = isset($_SESSION['cartVal']['packagetype'])?$_SESSION['cartVal']['packagetype']:'';
           if($packagetype != 'digitalpkg'){
          #####################################################
         ?>
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
        <li rel="triple|3">
          <img src="<?=base_url()?>assets/images/collage/bnwd_triple.png" id="">
          <span><strong>Triple</strong>
          <br />
          $50.00
          <input type="hidden" name="" id="triple" value="50">
          </span>          
        </li> 
        <li rel="double|2">
          <img src="<?=base_url()?>assets/images/collage/bnwd_double.png" id="">
          <span><strong>Double</strong>
          <br />
          $20.00
          <input type="hidden" name="" id="double" value="20">
          </span>          
        </li> 
        <?php }?>

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
      </ul>
      

      </div>