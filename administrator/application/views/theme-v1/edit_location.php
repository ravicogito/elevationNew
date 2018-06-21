<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script>
	
	function Checkingform(location)
	{
			
			var location_name 		= jQuery(location).find('#location_name').val();
			//var location_image 		= jQuery(location).find('#location_image').val();
			var location_ref_id 	= jQuery(location).find('#location_ref_id').val();			
			

			if(location_name == '')
			{
				alert('Please enter location name');

				return false;
			}
			
			/*if(location_image == '')
			{
				alert('Please upload location image');

				return false;
			}*/
			
			if(location_ref_id == '')
			{
				alert('Please select is ref id exists or not??');

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
                    <h3>Edit Location</h3>
                    <hr>
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

                    <form role="form" method="post" action="<?php if(!empty($location_data['location_id'])){ echo base_url().'Locations/updateLocation/'.$location_data['location_id']; } ?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
						<div class="form-group">

						  <label>Location Name</label>

						  <input type="text" class="form-control" id="location_name" name="location_name" placeholder="Enter location name" value="<?php if(!empty($location_data['location_name'])){ echo $location_data['location_name'];}?>">

						</div>

						<div class="form-group">

						  <label>Change Location Image</label>

						  <input type="file" id="location_image" name="location_image">
						  <br/>
						  
						  <img src="<?php echo $front_url; ?>uploads/locations/<?php echo $location_data['location_image']; ?>" height="80px" width="80px"/>

						</div>
						
						<!--<div class="form-group">

						  <label>Is RF ID Exists?</label>

<input type="radio" name="location_ref_id" value="Y" <?php if($location_data['is_location_refid_exists']=='Y'){echo "checked";} ?>>Yes
<input type="radio" name="location_ref_id" value="N" <?php if($location_data['is_location_refid_exists']=='N'){echo "checked";} ?>>No

						</div>-->
						
						
						

					  <!-- /.box -->
						<div class="box-footer">

							<input type="submit" class="btn btn-success btn-block" value="Update">

						</div>

					</form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->