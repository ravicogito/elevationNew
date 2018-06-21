<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	(function($){
	 	$(document).ready( function(){
			$( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
			$(".imgUpload").hide();

			$("#btnCreateEvent").on("click", function(event) {
				event.preventDefault();
				var errCnt				= 0;
				var cat_id				= $.trim($("#cat_id").val());
				var datepicker			= $.trim($("#datepicker").val());
				var photographer_id		= $.trim($("#photographer_id").val());
				var event_name			= $.trim($("#event_name").val());
				var event_description	= $.trim($("#event_description").val());
				if(cat_id == '') {
					alert('Please select category.');
					errCnt++;
				}
				if(datepicker.length == '') {
					alert('Please enter event date.');
					errCnt++;
				}
				if(photographer_id == '') {
					alert('Please select photographer.');
					errCnt++;
				}
				if(event_name.length == '') {
					alert('Please enter event name.');
					errCnt++;
				}

				if(errCnt == 0) {                    
					var frmVal				= $("#frmEvent").serialize();

					$.ajax({
						url: _basePath+"event/do_add_event/",
						type: 'POST',
						dataType: 'JSON',
						data: frmVal,
						success: function(responce) {//alert("here"+responce['process']);
							if(responce['process'] == 'success') {
								$("#btnCreateEvent").hide();
								$("#event_id").val(responce['event_id']);
								$("#upload_path").val(responce['final_path']);
								$(".imgUpload").slideDown('slow');
							} else if(responce['process'] == 'fail') {
								alert("Unable to create event. Please try again.");
								return false;
							} else if(responce['process'] == 'exists') {
								$("#frmEvent")[0].reset();
								alert("Same event already exists in the database. Please try new one.");
								return false;
							}								
						}
					});

				} else {
					// Do nothing
				}
				
			})
	 	});
	})(jQuery)
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body">
                    <h3>Add New Event</h3>
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
                    <br/>
                    <form name="frmEvent" id="frmEvent" method="post" action="" enctype="multipart/form-data">                    	
						<div class="form-group">
						  <label>Main Category</label>
						  <select name="cat_id" id="cat_id" class="form-control">
							<option value="">Select Category</option>
							<?php foreach ($all_category as $category) {?>
							<option value="<?=$category['id'].'||'.$category['cat_name'];?>"><?=$category['cat_name']; ?></option>
							<?php }?>
						  </select>
						</div>
						<div class="form-group">
						 <label>Event Date</label>
						  <input type="text" class="form-control" id="datepicker" name="event_date" placeholder="dd-mm-yy" readonly="">
						</div>
						<div class="form-group">
							<label>Photographer Name</label>
							<select name="photographer_name" id="photographer_id" class="form-control">
								<option value="">Select</option>
								<?php foreach ($all_photographers as $all_photographer) { ?>
								<option value="<?php echo $all_photographer->photographer_id.'||'.$all_photographer->photographer_name; ?>"><?php echo $all_photographer->photographer_name; ?></option>
								<?php }?>								
							</select>
						</div>
						<div class="form-group">
						  <label>Event Name</label>
						  <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Put event name">
						</div>
						<div class="form-group">
							<label for="catImage">Event Description</label>
							<textarea class="form-control" id="event_description" name="event_description" rows="3" placeholder="Put event description"></textarea>
						</div>
						
						<div class="form-group">
						  <label>Event Price</label>
						  <input type="text" class="form-control" id="event_price" name="event_price" placeholder="Put event price">
						</div>
						<button type="submit" name="btnCreateEvent" id="btnCreateEvent" class="btn btn-success btn-block">Create</button>
					</form>
					<div class="imgUpload">
					<form name="" id="" action="<?=base_url()?>event/addImage" enctype="multipart/form-data" method="post">
						<input type="hidden" id="event_id" name="event_id" value="">
						<input type="hidden" id="upload_path" name="upload_path" value="">
						
						<div class="form-group">
						  <label>Event Images</label>
						  <input type="file" class="form-control" id="customerImage" name="customerImage[]" multiple="">
						</div>

                        <button type="submit" name="submit_new_pass" class="btn btn-success btn-block">Add</button>
                        
					</form>
					</div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->
