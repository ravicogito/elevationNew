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
						<h3>Change Password</h3>
						<hr>
						<?php
						$success_msg = $this->session->flashdata('pass_update');
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
						<br/>
						<form action="<?php echo base_url();?>Login/change_password" method="post">
							   <div class="form-group">
									<label class="control-label" for="password">Enter Old Password</label>
									<input title="Please enter your password" placeholder="******" value="" name="old_password" id="old_password" class="form-control required" type="password">
									<span class="help-block small text-danger errorMessage"></span>
								</div>
							   <div class="form-group">
									<label class="control-label" for="password">Enter New Password</label>
									<input title="Please enter your password" placeholder="******"  value="" name="password" id="password" class="form-control required" type="password">
									<span class="help-block small text-danger errorMessage"></span>
								</div>
								<div class="form-group">
									<label class="control-label" for="password">Confirm New Password</label>
									<input title="Please enter your password" placeholder="******" value="" name="confirm_password" id="confirm_password" class="form-control required" type="password">
									<span class="help-block small text-danger errorMessage"></span>
								</div>
							   
								<button type="submit" name="submit_new_pass" class="btn btn-success btn-block">Change Password</button>
							   
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
