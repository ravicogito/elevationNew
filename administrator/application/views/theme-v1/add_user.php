<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


	<script>
	function Checkingform(user)
	{
		    var role_id 			= jQuery(user).find('#role_id').val();
			var name 				= jQuery(user).find('#name').val();
			var username 			= jQuery(user).find('#username').val();
			var password 			= jQuery(user).find('#password').val();
			var email 				= jQuery(user).find('#email').val();
			var atpos				= email.indexOf("@");
			var atlastpos			= email.lastIndexOf("@");
			var dotpos				= email.indexOf(".");
			var dotlastpos			= email.lastIndexOf(".");
			
			if(role_id == '')
			{
				alert('Please select role');

				return false;
			}
            if(name == '')
			{
				alert('Please enter name');

				return false;
			}
			
			if(username == '')
			{
				alert('Please enter username');

				return false;
			}
			
			if(password == '')
			{
				alert('Please enter password');

				return false;
			}
			
			if(atpos==0 || dotpos==0 || atlastpos==email.length-1 || dotlastpos==email.length-1 || atpos+1==dotpos || atpos-1==dotpos || atpos==-1 || dotpos==-1 || email=="" || dotlastpos==-1 || atlastpos==-1 || atpos!=atlastpos)
			{
				alert('Please put a valid email');
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
                    <h3>Add New User</h3>

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

                    <form role="form" method="post" action="<?php echo base_url().'User/addUser/';?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
						
                        <div class="form-group">

						  <label>Select Role</label>
						   <select name="role_id" id="role_id" class="form-control">
								<option value="">Select</option>
								<?php if(!empty($role_list)){ foreach ($role_list as $rolelist){
								?>
								<option value="<?php echo $rolelist->role_id; ?>"><?php echo $rolelist->role_name; ?></option>
								<?php
								}
								} ?>
							</select>

						</div> 
						
						<div class="form-group">

						  <label>Name</label>

						  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">

						</div>
						
						
						<div class="form-group">

						  <label>Username</label>

						  <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">

						</div>
						
						<div class="form-group">

						  <label>Password</label>

						  <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">

						</div>
						
						<div class="form-group">

						  <label>Email</label>

						  <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">

						</div>
						
						

					  <!-- /.box -->
						<div class="box-footer">

							<input type="submit" class="btn btn-success btn-block" value="Add">

						</div>
				

					</form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->