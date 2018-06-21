<script>
	function Checkingform(option){
			var option_name     = jQuery(option).find('#option_name').val();
			var option_size     = jQuery(option).find('#option_size').val(); 
			var print_min_dpi   = jQuery(option).find('#print_min_dpi').val();
			var print_min       = jQuery(option).find('#print_min').val();
		var print_optimal_dpi   = jQuery(option).find('#print_optimal_dpi').val();
            var print_optimal   = jQuery(option).find('#print_optimal').val();
			
			var print_size_type  = jQuery(option).find('#print_size_type').val();
			var print_size_dp 	 = jQuery(option).find('#print_size_dp').val();
			var print_size_np    = jQuery(option).find('#print_size_np').val();
			var acrylic_price    = jQuery(option).find('#acrylic_price').val();
			

            if(option_name == ''){
				alert('Please put option name');
                return false;
			}
			
            if(option_size == ''){
				alert('Please put print option size');
                return false;
			}
			
			if(print_min_dpi == ''){
				alert('Please put print minimum dpi');
                return false;
			}

			if(print_min == ''){
				alert('Please put print minimum');
                return false;
			}

			if(print_optimal_dpi == ''){
				alert('Please put print optimal dpi');
                return false;
			}
			
			if(print_optimal == ''){
				alert('Please put print optimal');
                return false;
			}

			if(print_size_type == ''){
				alert('Please put print size type');
                return false;
			}

			if(print_size_dp == ''){
				alert('Please put print size Dp');
                return false;
			}

			if(print_size_np == ''){
				alert('Please put print size Np');
                return false;
			}

			if(acrylic_price == ''){
				alert('Please put acrylic price');
                return false;
			}
			
	}
	


$(document).ready( function(){  
  $('#acrylic_price').keypress(function (event) {
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
                    <h3>Add Option Print Size</h3>

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

                    <form role="form" method="post" action="<?php echo base_url().'ManageOptionPrint/addOptionPrint/';?>" onsubmit ="" enctype="multipart/form-data">
						<!-- text input -->
						
						<div  id='div_id'>

						<div class="form-group" id="s1_id">
							<label>Option Name</label>
							<select name="option_name" id="option_name" class="form-control">
								<option value="">Select</option>
								<?php foreach($get_frame_options as $val){?>
								<option value="<?php echo $val['option_id'];?>"><?php echo $val['option_name'];?></option>
								<?php }?>
							</select>
						</div>
						
						<div class="form-group">

						  <label id="cname">Print Option Size</label>

						  <input type="text" class="form-control" id="option_size" name="option_size" placeholder="Enter option print size" value="">

						</div>
						
						<div class="form-group">

						  <label id="cname">Print Minimum DPI</label>

						  <input type="text" class="form-control" id="print_min_dpi" name="print_min_dpi" placeholder="Enter print min dpi" value="">

						</div>
						
						<div class="form-group">

						  <label id="cname">Print Minimum</label>

						  <input type="text" class="form-control" id="print_min" name="print_min" placeholder="Enter print min" value="">

						</div>
						
						<div class="form-group">

						  <label id="cname">Print Optimal DPI</label>

						  <input type="text" class="form-control" id="print_optimal_dpi" name="print_optimal_dpi" placeholder="Enter print optimal dpi" value="">

						</div>
						
						<div class="form-group">

						  <label id="cname">Print Optimal</label>

						  <input type="text" class="form-control" id="print_optimal" name="print_optimal" placeholder="Enter print optimal" value="">

						</div>
						
						<div class="form-group">

						  <label id="cname">Print Size Type</label>

							<select name="print_size_type" id="print_size_type" class="form-control">
								<option value="">Select</option>
								<option value="rectangle">Rectangle</option>
								<option value="square">Square</option>
								<option value="panoramic">Panoramic</option>
							</select>

						</div>
						
						<div class="form-group">

						  <label id="cname">Print size Price</label>

						  <input type="text" class="form-control" id="print_size_dp" name="print_size_dp" placeholder="Enter print size price" value="">

						</div>

						<div class="form-group">

						<label id="cname">Acrylic Price</label>

						<input type="text" class="form-control" id="acrylic_price" name="acrylic_price" placeholder="Enter print acrylic price" value="">

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