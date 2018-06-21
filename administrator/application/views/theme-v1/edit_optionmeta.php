<script>
	function Checkingform(option){
			var option_name 		= jQuery(option).find('#option_name').val();
			var option_head         = jQuery(option).find('#option_head').val();  
			var meta_value 	        = jQuery(option).find('#meta_value').val();
			var metaImage 	        = jQuery(option).find('#metaImage').val();
			var oldmetaImage 		= jQuery(option).find('#oldmetaImage').val();
			var meta_material 	    = jQuery(option).find('#meta_material').val();
			var meta_style      	= jQuery(option).find('#meta_style').val();
			var meta_color      	= jQuery(option).find('#meta_color').val();	
			var meta_finish      	= jQuery(option).find('#meta_finish').val();
			var meta_height      	= jQuery(option).find('#meta_height').val();
			var meta_width      	= jQuery(option).find('#meta_width').val();	
			var meta_price      	= jQuery(option).find('#meta_price').val();			
			
			if(option_name == ''){
				alert('Please put option name');
                return false;
			}
			
            if(option_head == ''){
				alert('Please put option head');
                return false;
			}
			
			if(meta_value == ''){
				alert('Please put option meta name');
                return false;
			}


             if(metaImage == '' && oldmetaImage == ''){
				alert('Please put option meta image');
                return false;
			}
			
			if(meta_material == ''){
				alert('Please put option meta material');
                return false;
			}
			if(meta_style == ''){
				alert('Please put option meta style');
                return false;
			}
			if(meta_color == ''){
				alert('Please put option meta color');
                return false;
			}
			if(meta_finish == ''){
				alert('Please put option meta finish');
                return false;
			}
			if(meta_height == ''){
				alert('Please put option meta height');
                return false;
			}
			if(meta_width == ''){
				alert('Please put option meta width');
                return false;
			}
			if(meta_price == ''){
				alert('Please put option meta price');
                return false;
			}
	}
	
$(document).ready( function(){  
  $('#meta_price').keypress(function (event) {
      return isNumberFloat(event, this)
  });

})

 function isNumberFloat(evt, element) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (
        (charCode != 8 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK BACKSPACE, AND ONLY ONE.
        (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
        (charCode < 48 || charCode > 57))
        return false;
        return true;
    } 

 //Get Option Head List
 function showOptionHead(val){
	   // alert(val);return false;
	  var optionId = val;
	   $.ajax({
	        type: "POST",
	        url: '<?php echo base_url();?>options/ajax_optionheadDetails',
	        dataType: 'html',
	        data: {optionId:optionId},
	        success: function(result){//alert(result);
	          if(result!=""){
	            $('#ajxophead').html(result);
	          }
	        } 
	  }) 
   }          
</script>
<style>
.hpanel {
    background-color: none;
    border: none;
    box-shadow: none;
    margin-bottom: 25px;
}
.hpanel.hblue .panel-body {
    border-top: 2px solid #b00e4e;
}
.hpanel .panel-body {
    background: #fff;
    border: 1px solid #e4e5e7;
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color: rgb(228, 229, 231);
    border-radius: 2px;
    padding: 20px;
    position: relative;
}

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body">
                    <h3>Edit New Option Meta</h3>

                    <?php
                    $success_msg = $this->session->flashdata('sucessPageMessage');
                    if ($success_msg != "") {
                        ?>
                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                        <?php
                    }
                    ?>
                    <?php
                    $failed_msg = $this->session->flashdata('pass_inc');
                    if ($failed_msg != "") {
                        ?>
                        <div class="alert alert-danger"><?php echo $failed_msg; ?></div>
                        <?php
                    }
                    ?>

                    <form role="form" method="post" action="<?php echo base_url().'Options/updateOptionMeta/'.$optionmeta_data[0]['option_meta_id'];?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
						
						<div  id='div_id'>

						<div class="form-group" id="s1_id">
							<label>Option Name</label>
							<select name="option_name" id="option_name" class="form-control" onchange="showOptionHead(this.value);">
								<option value="">Select Option</option>
								<?php foreach($option_list as $val){?>
								<option value="<?php echo $val['option_id'];?>" <?php if($val['option_id'] == $optionmeta_data[0]['option_id']){echo 'selected';}?>><?php echo $val['option_name'];?></option>
								<?php }?>
							</select>
						</div>

						<div class="form-group" id="ajxophead">

						  <label id="cname">Option Head Name</label>

						  <select name="option_head" id="option_head" class="form-control">
                            <option value="">Select Option Head</option>
                            <?php foreach($optionhead_list as $val){?>
								<option value="<?php echo $val['option_meta_head_id'];?>" <?php if($val['option_meta_head_id'] == $optionmeta_data[0]['option_meta_head_id']){echo 'selected';}?>><?php echo $val['option_meta_head_name'];?></option>
							<?php }?>
						  </select>

						</div>

                        <div class="form-group" id="option_fitting_div">

						  <label>Option Meta Name</label>

						  <input type="text" class="form-control" id="meta_value" name="meta_value" placeholder="Enter Option Meta Name" value="<?php echo $optionmeta_data[0]['option_meta_value'];?>">

						</div>

                        <div class="form-group" id="option_fitting_div">

						  <label>Option Meta Image</label>

						 <input type="file" id="metaImage" name="metaImage">	

						</div>
						
                       <div>
                       	<input type="hidden" id="oldmetaImage" name="oldmetaImage" value="<?php echo $optionmeta_data[0]['option_meta_image']; ?>">

                       <img src="<?php echo $front_url; ?>uploads/metaImg/<?php echo $optionmeta_data[0]['option_meta_image']; ?>" height="50px" width="50px"/>

                        </div>
                        <div>&nbsp;&nbsp;</div>

						 <div class="form-group" id="option_fitting_div">

						  <label>Option Meta Material</label>

						  <input type="text" class="form-control" id="meta_material" name="meta_material" placeholder="Enter Option Meta Material" value="<?php echo $optionmeta_data[0]['option_meta_material'];?>">

						</div>

						 <div class="form-group" id="option_fitting_div">

						  <label>Option Meta Style</label>

						  <input type="text" class="form-control" id="meta_style" name="meta_style" placeholder="Enter Option Option Meta Style" value="<?php echo $optionmeta_data[0]['option_meta_style'];?>">

						</div>

						 <div class="form-group" id="option_fitting_div">

						  <label>Option Meta Color</label>

						  <input type="text" class="form-control" id="meta_color" name="meta_color" placeholder="Enter Option Meta Color" value="<?php echo $optionmeta_data[0]['option_meta_color'];?>">

						</div>

						<div class="form-group" id="option_fitting_div">

						  <label>Option Meta Finish</label>

						  <input type="text" class="form-control" id="meta_finish" name="meta_finish" placeholder="Enter Option Meta Finish" value="<?php echo $optionmeta_data[0]['option_meta_finish'];?>">

						</div>

						<div class="form-group" id="option_fitting_div">

						  <label>Option Meta height</label>

						  <input type="text" class="form-control" id="meta_height" name="meta_height" placeholder="Enter Option Meta height" value="<?php echo $optionmeta_data[0]['option_meta_height'];?>">

						</div>

						<div class="form-group" id="option_fitting_div">

						  <label>Option Meta Width</label>

						  <input type="text" class="form-control" id="meta_width" name="meta_width" placeholder="Enter Option Meta Width" value="<?php echo $optionmeta_data[0]['option_meta_width'];?>">

						</div>

						<div class="form-group" id="option_fitting_div">

						  <label>Option Meta Price</label>

						  <input type="text" class="form-control" id="meta_price" name="meta_price" placeholder="Enter Option Meta Price" value="<?php echo $optionmeta_data[0]['option_meta_price'];?>">

						</div>
						
						<div class="box-footer">

							<input type="submit" class="btn btn-success btn-block" value="Update">

						</div>
					</div>	

					</form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->