<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.fancybox.css">
<!-- <script type="text/javascript" src="<?=base_url()?>assets/js/html2canvas.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.plugin.html2canvas.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url()?>assets/js/jquery.fancybox.js"></script>
<script src="<?=base_url()?>assets/js/custom-frame.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //$( "#draggable" ).draggable();
    
    /*$(".imgDetails").fancybox({
                              'width':605,
                              'height':680,
                              'autoSize':false, 
                              'scrolling':'no', 
                              'autoScale':false,  
                              afterLoad: function () {      
                                //$(".fancybox-overlay").addClass("plpbox");
                              }
                            });*/
                           
  })
</script>  
<!--<script>
$(document).ready(function(){
    $(".full_frm").css("background-image","url('http://192.168.2.160/elevation_new/assets/images/frame1.png')");
});
</script>-->
<style type="text/css">
  .imgDisplay {
    width: 19.4%;
    min-height: 100px;
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
<!-- <div id="draggable" class=""></div> -->

<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<div class="row">

<div class="col-md-12 full imgtop bdrsdo clearfix" style="height: auto;">

<div class="event_searchsec">
<h3>Search Event Here..</h3>
<form action="<?=$frmaction?>" method="post">
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
  
  <?php if($all_img_list)://echo"<pre>"; print_r($all_img_list);die;?>
    <div id="country_table">
    <?php $i = 0;foreach($all_img_list as $img) {
        $img_path         = $fullPath[$img['event_id']];
        $imagePath        = base_url().'uploads/'.$img_path.$img['file_name'];
        if($i < 1) {
          $f_img_path     = $fullPath[$img['event_id']];
          $firstImgPath   = base_url().'uploads/'.$img_path.$img['file_name']; 
        }if($i == 5) break;
        
    ?>
      <div class="nailthumb-container imgDisplay">
        <!-- <a class="imgDetails fancybox.ajax" href="<?=base_url();?>Category/details/<?=$img['media_id']?>"><img src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative;"></a> -->
        <a class="imgDetails" href="<?=base_url();?>Category/details/<?=$img['media_id']?>" rel="<?=$img['media_price']?>"><img src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative;"></a>
      </div>
    <?php $i++;}?>
  </div>
  
  <?php else: ?>
    <h2> You Don't have any favourite image </h2>
  <?php endif; ?>

</div>

<?php if($all_img_list):?>
<br style="clear: both;">

  <div class="frame">
  <div class="choose_frame"><h2>Choose Your Options</h2>
    <ul class="frame_selection">
      <?php if($option_list) {
              foreach ($option_list as $optionKey => $option) {
      ?>
      <li>
      <img src="<?=base_url()?>assets/images/<?=strtolower(str_replace(" ", "_", $option['option_name']))?>.png" id="">
      <span class="option" id="<?=$option['option_id']?>"><?=$option['option_name']?></span>
      </li>
      <?php }}?>      
    </ul></div>

    <div class="wraper_pan">
      <div class="leftpanel fix_we" id="canvasFrame">
        <div class="full_frm_canvas" id="outerDiv">
<div class="">
<div class="">
 <img src="<?=thumb($firstImgPath, $f_img_path, '400', '400')?>" style="max-width:100%; position: relative;" id="disImage">
</div>
</div>
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
          <input type="hidden" name="txtsizeprice" id="sizePrice" value="<?=$size_price?>">
          <input type="hidden" name="txtframeprice" id="framePrice" value="">
          <input type="hidden" name="txttopmatprice" id="topMatPrice" value="">
          <input type="hidden" name="txtmiddlematprice" id="middleMatPrice" value="">
          <input type="hidden" name="txtbottommatprice" id="bottomMatPrice" value="">
          
          <label>Your Price : </label><span class="totalPrice">$<?=$total_price;?></span>
          <p><form name="frmcanvas" id="frmcanvas" action="<?=base_url()?>Favourite/cart/" method="post">
            <input type="hidden" name="img_val" id="img_val" value="">
<input type="submit" name="btncart" value="Add To Cart" class="createCanvas">
          </form>
            </p>
        </div>
        <div class="about_product">
          <h2>About <?=$option_name;?></h2>
          <img src="<?=base_url()?>uploads/optionImg/<?=$option_image?>" id="">
          <p><?=nl2br($option_description);?></p>
        </div>
      </div>      
    </div>
    <br class="clear" />
<br />
  </div>

<?php endif; ?>

</div>
</div>
</div>

</div>
<div style="clear: both;"></div>
<div id="img-out"></div>
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

        
