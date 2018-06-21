<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	(function($){
	 	$(document).ready( function(){
			$( "#datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
			$(".imgUpload").hide();
			$(".excelUpload").hide();

			$("#btnCreateEvent").on("click", function(event) {
				event.preventDefault();
				var errCnt									= 0;
				var cat_id									= $.trim($("#cat_id").val());
				var river_rafting_company_name				= $.trim($("#river_rafting_company_name").val());
				var guide_name								= $.trim($("#guide_name").val());
				var datepicker								= $.trim($("#datepicker").val());
				var guide_time								= $.trim($("#guide_time").val());
				var guide_name								= $.trim($("#guide_name").val());
				var guide_description						= $.trim($("#guide_description").val());
				if(cat_id == '') {
					alert('Please select category.');
					errCnt++;
				}
				
				if(river_rafting_company_name == '') {
					alert('Please select company.');
					errCnt++;
				}
				
				if(datepicker.length == '') {
					alert('Please enter date.');
					errCnt++;
				}
				
				if(guide_time.length == '') {
					alert('Please select time.');
					errCnt++;
				}
				
				if(guide_name.length == '') {
					alert('Please select guide name.');
					errCnt++;
				}

				if(errCnt == 0) {                    
					var frmVal				= $("#frmGuide").serialize();
					$.ajax({
						url: _basePath+"guide/do_add_event/",
						type: 'POST',
						dataType: 'JSON',
						data: frmVal,
						success: function(responce) {//alert("here"+responce['process']);
							if(responce['process'] == 'success') {
								$("#btnCreateEvent").hide();
								$("#guide_id").val(responce['event_id']);
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

	jQuery(document).ready(function() {
	    var img_zone = document.getElementById('img-zone'),
	        collect = {
	            filereader: typeof FileReader != 'undefined',
	            zone: 'draggable' in document.createElement('span'),
	            formdata: !!window.FormData
	        },
	        acceptedTypes = {
	            'image/png': true,
	            'image/jpeg': true,
	            'image/jpg': true,
	            'image/gif': true
	        };
	 
	    // Function to show messages
	    function ajax_msg(status, msg) {
	        var the_msg = '<div class="alert alert-' + (status ? 'success' : 'danger') + '">';
	        the_msg += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	        the_msg += msg;
	        the_msg += '</div>';
	        $(the_msg).insertBefore(img_zone);
	    }
	 
	    // Function to upload image through AJAX
	    function ajax_upload(files) {
	        $('.progress').removeClass('hidden');
	        $('.progress-bar').css({
	            "width": "0%"
	        });
	        $('.progress-bar span').html('0% complete');
	 
	        var formData = new FormData();
	        //formData.append('any_var', 'any value');
	        for (var i = 0; i < files.length; i++) {
	            //formData.append('img_file_' + i, files[i]); 
	            formData.append('img_file[]', files[i]);
	        }
	        var guideID 			= $("#guide_id").val();
	        var uploadPath 			= $("#upload_path").val();
	        formData.append('guide_id', guideID);
	        formData.append('upload_path', uploadPath);
	 		//alert("hi - "+formData);
	        $.ajax({
	            url: _basePath+"Guide/addImage/", // Change name according to your php script to handle uploading on server
	            type: 'post',
	            data: formData,
	            dataType: 'json',
	            processData: false,
	            contentType: false,
	            error: function(request) {
	                ajax_msg(false, 'An error has occured while uploading photo.');
	            },
	            success: function(json) {
	                var img_preview = $('#img-preview');
	                var col = '.col-sm-2';
	                $('.progress').addClass('hidden');
	                $(".excelUpload").slideDown('slow');
	                var photos = $('<div class="photos"></div>');
	                $(photos).html(json.img);
	                var lt = $(col, photos).length;
	                $('col', photos).hide();
	                $(img_preview).prepend(photos.html());
	                $(col + ':lt(' + lt + ')', img_preview).fadeIn(2000);
	                if (json.error != '')
	                    ajax_msg(false, json.error);
	            },
	            progress: function(e) {
	                if (e.lengthComputable) {
	                    var pct = (e.loaded / e.total) * 100;
	                    $('.progress-bar').css({
	                        "width": pct + "%"
	                    });
	                    $('.progress-bar span').html(pct + '% complete');
	                } else {
	                    console.warn('Content Length not reported!');
	                }
	            }
	        });
	    }
	 
	    // Call AJAX upload function on drag and drop event
	    function dragHandle(element) {
	        element.ondragover = function() {
	            return false;
	        };
	        element.ondragend = function() {
	            return false;
	        };
	        element.ondrop = function(e) {
	            e.preventDefault();
	            ajax_upload(e.dataTransfer.files);
	        }
	    }
	 
	    if (collect.zone) {
	        dragHandle(img_zone);
	    } else {
	        alert("Drag & Drop isn't supported, use Open File Browser to upload photos.");
	    }
	 
	    // Call AJAX upload function on image selection using file browser button
	    $(document).on('change', '.btn-file :file', function() {
	        ajax_upload(this.files);
	    });
	 
	    // File upload progress event listener
	    (function($, window, undefined) {
	        var hasOnProgress = ("onprogress" in $.ajaxSettings.xhr());
	 
	        if (!hasOnProgress) {
	            return;
	        }
	 
	        var oldXHR = $.ajaxSettings.xhr;
	        $.ajaxSettings.xhr = function() {
	            var xhr = oldXHR();
	            if (xhr instanceof window.XMLHttpRequest) {
	                xhr.addEventListener('progress', this.progress, false);
	            }
	 
	            if (xhr.upload) {
	                xhr.upload.addEventListener('progress', this.progress, false);
	            }
	 
	            return xhr;
	        };
	    })(jQuery, window);
	});
</script>
<style type="text/css">
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    
    .img-zone {
        background-color: #F2FFF9;
        border: 5px dashed #4cae4c;
        border-radius: 5px;
        padding: 20px;
    }
    
    .img-zone h2 {
        margin-top: 0;
    }
    
    .progress, #img-preview {
        margin-top: 15px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body">
                    <h3>Add New Rafting</h3>
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
					
                    <form name="frmGuide" id="frmGuide" method="post" action="" enctype="multipart/form-data">                    	
						<div class="form-group">
						  <label>Main Category</label>
						  <select name="cat_id" id="cat_id" class="form-control">
							<option value="">Select Category</option>
							<?php foreach ($all_category as $category) {?>
							<option value="<?php echo $category['id'].'||'.$category['cat_name'];?>"><?php echo $category['cat_name']; ?></option>
							<?php }?>
						  </select>
						</div>
						
						<div class="form-group">
							<label>River Rafting Company Name</label>
							<select name="river_rafting_company_name" id="river_rafting_company_name" class="form-control">
								<option value="">Select</option>
								<?php foreach ($raftingCompanylist as $raftingCompany) { ?>
								<option value="<?php echo $raftingCompany->raftingcompany_id.'||'.$raftingCompany->raftingcompany_name; ?>"><?php echo $raftingCompany->raftingcompany_name; ?></option>
								<?php }?>								
							</select>
						</div>
						
						<div class="form-group">
							<label>Guide Name</label>
							<select name="guide_name" id="guide_name" class="form-control">
								<option value="">Select</option>
								<?php foreach ($guidelist as $guide) { ?>
								<option value="<?php echo $guide->guide_id.'||'.$guide->guide_name; ?>"><?php echo $guide->guide_name; ?></option>
								<?php }?>								
							</select>
						</div>
						
						
						<div class="form-group">
						 <label>Guide Date</label>
						  <input type="text" class="form-control" id="datepicker" name="guide_date" placeholder="dd-mm-yy" readonly="">
						</div>
						
						<div class="form-group">
						 <label>Guide Time</label>
						  <select name="guide_time" id="guide_time" class="form-control">
								<option value="">Select</option>
								<?php foreach ($time_slot as $timeslot) { ?>
								<option value="<?php echo $timeslot; ?>"><?php echo $timeslot; ?></option>
								<?php } ?>

							</select>
						</div>
						
						
						<!--<div class="form-group">
						  <label>Guide Name</label>
						  <input type="text" class="form-control" id="guide_name" name="guide_name" placeholder="Put name">
						</div>-->
						<div class="form-group">
							<label for="catImage">Guide Description</label>
							<textarea class="form-control" id="guide_description" name="guide_description" rows="3" placeholder="Put description"></textarea>
						</div>
						
						<div class="form-group">
						  <label>Guide Price</label>
						  <input type="text" class="form-control" id="guide_price" name="guide_price" placeholder="Put price">
						</div>
						<button type="submit" name="btnCreateEvent" id="btnCreateEvent" class="btn btn-success btn-block">Create</button>
					</form>
					<div class="imgUpload">					
						<div class="form-group">
						  <label>Guide Images</label>
						  <!-- <input type="file" class="form-control" id="customerImage" name="customerImage[]" multiple="">-->
						  <div class="container-fluid">
							    <div class="row">
							        <div class="col-sm-8 col-sm-offset-2">
							            <div class="img-zone text-center" id="img-zone">
							                <div class="img-drop">
							                    <h2><small>Drag &amp; Drop Photos Here</small></h2>
							                    <p><em>- or -</em></p>
							                    <h2><i class="glyphicon glyphicon-camera"></i></h2>
							                    <span class="btn btn-success btn-file">
							                        Click to Open File Browser<input type="file" multiple="" accept="image/*">
							                    </span>
							                </div>
							            </div>
							            <div class="progress hidden">
							                <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar progress-bar-success progress-bar-striped active">
							                    <span class="sr-only">0% Complete</span>
							                </div>
							            </div>
							        </div>
							    </div>
							    <div id="img-preview" class="row">
							 
							    </div>
							</div>
						</div>
					</div>

					<div class="excelUpload">
					<form name="" id="" action="<?=base_url()?>Guide/do_upload" enctype="multipart/form-data" method="post">
						<input type="hidden" id="guide_id" name="guide_id" value="">
						<input type="hidden" id="upload_path" name="upload_path" value="">
						
						<div class="form-group">
						  <label>Guide Images(upload excel file only)</label>
						  <input name="excel" id="excel" type="file" />
						</div>

                        <button type="submit" name="submit_new_pass" class="btn btn-success btn-block">Assign</button>
                        
					</form>
					</div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->
