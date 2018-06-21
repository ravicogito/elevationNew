<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script>
	
	function Checkingform(guide)
	{
			
		var guide_name 		= jQuery(location).find('#guide_name').val();
		
		

		if(guide_name == '')
		{
			alert('Please enter Guide name');

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
				<?php if(!empty($all_guide['guide_id'])): ?>
                    <h3>Edit Guide</h3>
					<?php else: ?>
					<h3>Add Guide</h3>
				<?php endif; ?>
                    <br>
					<div>
                    <?php
                    $success_msg = $this->session->flashdata('ins_success');
                    if ($success_msg != "") {
                        ?>
                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                        <?php
                    }
                    ?>
                    <?php
                    $failed_msg = $this->session->flashdata('ins_failed');
                    if ($failed_msg != "") {
                        ?>
                        <div class="alert alert-danger"><?php echo $failed_msg; ?></div>
                        <?php
                    }
                    ?>
					</div>
                    <form role="form" method="post" name="guide" action="<?php echo base_url().'Guide/guideManagementadd/';?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
						<input type="text" name="hid" value="<?php if(!empty($all_guide['guide_id'])){echo $all_guide['guide_id'];}else{}  ?>">
						<div class="form-group">

						  <label>Guide Name</label>

						  <input type="text" class="form-control" id="guide_name" value="<?php if(!empty($all_guide['guide_name'])){echo $all_guide['guide_name'];}else{} ?>" name="guide_name" placeholder="Enter Guide name">

						</div>
						<div class="box-footer">

						<?php if(!empty($all_guide['guide_id'])): ?>
							<input type="submit" class="btn btn-success btn-block" value="Update">
						<?php else: ?>
							<input type="submit" class="btn btn-success btn-block" value="Add">
						<?php endif; ?>

						</div>

					</form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->