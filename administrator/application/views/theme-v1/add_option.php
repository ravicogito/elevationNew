<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<script>
	function Checkingform(option){
			var option_name 		= jQuery(option).find('#option_name').val();
			var option_desc         = jQuery(option).find('#option_desc').val();  
			var option_size_type 	= jQuery(option).find('#option_size_type').val();
			var option_feeting_fee 	= jQuery(option).find('#option_feeting_fee').val();
			var print_area_status 	= jQuery(option).find('#print_area_status').val();
			var metaImage 	        = jQuery(option).find('#metaImage').val();			
			
			if(option_name == ''){
				alert('Please put option name');
                return false;
			}
			
            if(option_desc == ''){
				alert('Please put option descriptions');
                return false;
			}
			if(metaImage == ''){
				alert('Please put option image');
                return false;
			}
			
			if(option_size_type == ''){
				alert('Please put option size type');
                return false;
			}
			
			if(option_feeting_fee == ''){
				alert('Please put option fee');
                return false;
			}
			if(print_area_status == ''){
				alert('Please put print area status');
                return false;
			}
	}
	


$(document).ready( function(){  
  $('#option_feeting_fee').keypress(function (event) {
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
                    <h3>Add New Option</h3>

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

                    <form role="form" method="post" action="<?php echo base_url().'Options/addOption/';?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
						
						<div  id='div_id'>

						<div class="form-group">

						  <label id="cname">Option Name</label>

						  <input type="text" class="form-control" id="option_name" name="option_name" placeholder="Enter option name" value="">

						</div>
					   
					   <div class="form-group">
							<label for="catImage">Option Description</label>
							<textarea class="form-control" id="option_desc" name="option_desc" rows="3" placeholder="Put event description"></textarea>
						</div>
						
						<div class="form-group" id="option_fitting_div">

						  <label>Option Image</label>

						 <input type="file" id="metaImage" name="metaImage">	

						</div>
						
						<div class="form-group" id="s1_id">
							<label>Option Size Type</label>
							<select name="option_size_type" id="option_size_type" class="form-control">
							<option value="">Select</option>
							<option value="Finished">Finished</option>
							<option value="Print">Print</option>
							</select>
						</div>

						<div class="form-group" id="option_fitting_div">

						  <label>Option Feeting Fee</label>

						  <input type="text" class="form-control" id="option_feeting_fee" name="option_feeting_fee" placeholder="Enter Option Feeting Fee" value="">

						</div>

						<div class="form-group" id="s1_id">
						<label>Option Print Area Status</label>
						<select name="print_area_status" id="print_area_status" class="form-control">
							<option value="0">Inactive</option>
							<option value="1">Active</option>
						</select>
						</div>
						
						<div class="box-footer">

							<input type="submit" class="btn btn-success btn-block" value="Add">

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