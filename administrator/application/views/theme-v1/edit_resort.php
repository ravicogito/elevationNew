<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	 <script>

	

		 

		function Checkingform(banner)
		{
			var resort_name 		= jQuery(resort).find('#resort_name').val();
			var resort_location 	= jQuery(resort).find('#resort_location').val();
			var resort_mobile		= jQuery(resort).find('#resort_mobile').val();
			var email 				= jQuery(resort).find('#resort_email').val();			
			var atpos				= email.indexOf("@");
			var atlastpos			= email.lastIndexOf("@");
			var dotpos				= email.indexOf(".");
			var dotlastpos			= email.lastIndexOf(".");
			
			
			//var postcontent = $("#editorContainer iframe").contents().find("body").text();

			if(resort_name == '')
			{
				alert('Please put resort name');

				return false;
			}
			if(resort_location == '')
			{
				alert('Please put resort location');

				return false;
			}
			
			if(atpos==0 || dotpos==0 || atlastpos==email.length-1 || dotlastpos==email.length-1 || atpos+1==dotpos || atpos-1==dotpos || atpos==-1 || dotpos==-1 || email=="" || dotlastpos==-1 || atlastpos==-1 || atpos!=atlastpos)
			{
				alert('Please put a valid email');
				return false;
			}
			
			if(resort_mobile == '' || !(resort_mobile.match('[0-9]{10}')))  {
                alert("Please put 10 digit mobile number");
            
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
    border-top: 2px solid #3498db;
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
                    <h3>Edit Resort Information</h3>
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
                    <form role="form" method="post" action="<?php if(!empty($resort_data['resort_id'])){ echo base_url().'Resort/updateResort/'.$resort_data['resort_id']; } ?>" onsubmit="return Checkingform(this);" enctype="multipart/form-data">
					<div class="form-group">

						  <label>Select Location</label>

						  <select name="location_id" id="location_id" class="form-control">
								<option value="">Select</option>
									<?php if(!empty($location_list)){ foreach ($location_list as $vallist){
									?>
									<option value="<?php echo $vallist->location_id; ?>" <?php if(!empty($resort_data['location_id'])){ echo ($vallist->location_id == $resort_data['location_id'])?'selected':''; }?>><?php echo $vallist->location_name; ?></option>
									<?php
									}
									} ?>
							</select>

						</div>
						<div class="form-group">
						  <label>Resort Name</label>
						  <input type="text" class="form-control" id="resort_name" name="resort_name" value="<?php if(!empty($resort_data['resort_name'])){ echo $resort_data['resort_name'];}?>">
						</div>
						<div class="form-group">
							<label for="catImage">Resort Description</label>
							<textarea class="form-control" id="resort_location" name="resort_location" rows="3"><?php if(!empty($resort_data['resort_desc'])){ echo $resort_data['resort_desc'];}?></textarea>
						</div>
						
						<div class="form-group">
						  <label>Resort Email</label>
						  <input type="text" class="form-control" id="resort_email" name="resort_email" value="<?php if(!empty($resort_data['resort_email'])){ echo $resort_data['resort_email'];}?>">
						</div>
						
						<div class="form-group">
						  <label>Resort Contact no.</label>
						  <input type="text" class="form-control" id="resort_mobile" name="resort_mobile" value="<?php if(!empty($resort_data['resort_mobile'])){ echo $resort_data['resort_mobile'];}?>">
						</div>
						
						<div class="form-group">
						  <label>Resort Contact Person</label>
						  <input type="text" class="form-control" id="resort_contact_person" name="resort_contact_person" value="<?php if(!empty($resort_data['resort_contact_person'])){ echo $resort_data['resort_contact_person'];}?>">
						</div>
						<div class="form-group">

						  <label>Is RF ID Exists?</label>

							<input type="radio" name="resort_ref_id" value="Y" <?php if($resort_data['is_location_resort_refid_exists']=='Y'){echo "checked";} ?>>Yes
							<input type="radio" name="resort_ref_id" value="N" <?php if($resort_data['is_location_resort_refid_exists']=='N'){echo "checked";} ?>>No

						</div>
                        <button type="submit" name="submit_new_pass" class="btn btn-success btn-block">Update</button>    
                           
					</form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->
