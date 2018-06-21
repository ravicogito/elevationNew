<script>
	function Checkingform(option){
			var option_name 		= jQuery(option).find('#option_name').val();
			var option_head         = jQuery(option).find('#option_head').val();  
			
			if(option_name == ''){
				alert('Please put option name');
                return false;
			}
			
            if(option_head == ''){
				alert('Please put option head name');
                return false;
			}
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
                    <h3>Add New Option Head</h3>

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

                    <form role="form" method="post" action="<?php echo base_url().'Options/addOptionHead/';?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
						
						<div  id='div_id'>

						<div class="form-group" id="s1_id">
							<label>Option Name</label>
							<select name="option_name" id="option_name" class="form-control">
								<option value="">Select</option>
								<?php foreach($option_list as $val){?>
								<option value="<?php echo $val['option_id'];?>"><?php echo $val['option_name'];?></option>
								<?php }?>
							</select>
						</div>

						<div class="form-group">

						  <label id="cname">Option Head Name</label>

						  <input type="text" class="form-control" id="option_head" name="option_head" placeholder="Enter option head name" value="">

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