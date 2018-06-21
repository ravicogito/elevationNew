<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
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
	 
	        $.ajax({
	            url: _basePath+"Event/upload/", // Change name according to your php script to handle uploading on server
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
                    <h3>Upload</h3>
                    
                    <br/>
                    
                    
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

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->
