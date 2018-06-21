<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
  .leftPortion{
    float: left;
    position: relative;
    width: 60%;
    padding: 5px 5px;
  }
  .rightPortion{
    float: left;
    position: relative;
    width: 40%;
  }

  #draggable { width: 145px; height: 183px; padding: auto; z-index: 2; position: absolute; top: 5px; cursor: move; display: none; }
</style>
<script type="text/javascript">
  $("#draggable").on("click", function(){
      $(this).draggable(); 
      //alert($("#draggable").draggable( "option", "axis", "x" ));
  })  
    
  $(".clickon").on("click", function() {
    var divColor          = $(this).attr('value');
    $("#draggable").css({border: '1px solid '+divColor});
    $("#draggable").show();
    var position = $("#draggable").position();
    alert(position.left+" - "+position.top);
  })  
</script>
<div style="background-color: ffffff;">
  <div class="leftPortion">
    <?php 
      $file_name      = $img_details['file_name'];
      $imagePath     = base_url().'uploads/'.$img_path.$file_name;?>
    <img src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative;">
    <div id="draggable"><img src="<?=base_url()?>assets/images/f1.png"></div>
  </div>
  <div class="rightPortion">
    <ul>
    <?php for($i=1; $i<3; $i++) {if($i ==1) {$classLi = "red";} else {$classLi = "blue";}?>
      <li class="clickon" value="<?=$classLi?>">Fram <?=$i;?></li>
    <?php }?>  
    </ul>
  </div>
  <br style="clear: both;">
  <div class="">
    Attribute section
  </div>
</div>
  