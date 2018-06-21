<link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/moment/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datetimepicker.js"></script>
<script>
		var j = jQuery.noConflict();		
		j(function () {
				j('#datetimepicker2').datetimepicker({
					format: 'YYYY-MM-DD'
			   
				});
			
            });
		 
		function Checkingform(event)
		{
			var cat_name = jQuery(event).find('#ptitle').val();
			var catInputFile = jQuery(event).find('#catImage').val();
			
			
			if(cat_name == '')
			{
				alert('Please enter Category Title');
				return false;
			}
			if(catInputFile == '')
			{
				alert('Please enter category image');
				return false;
			}
		}	
		
      </script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category

      </h1>
     
    </section>

    <!-- Main content -->

    <section class="content">
      <div class="row">
        <div class="col-md-12">

         <?php
         $errMsg = $this->session->flashdata('errorPageMessage');
         $successMsg =  $this->session->flashdata('sucessPageMessage');
       if(!empty($successMsg)) { ?>

       <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $successMsg; ?>
            </div>

      <?php } ?>

          <form role="form" method="post" action="<?php echo base_url().'Category/addCategory/';?>" onsubmit="return Checkingform(this);" enctype="multipart/form-data">
           <!-- text input -->
                <div class="form-group">
                  <label>Category Title</label>
                  <input type="text" class="form-control" id="ptitle" name="ptitle" placeholder="Enter Category Title...">
                </div>
				<div class="form-group">
					<label for="catImage">Category Image</label>
					<input type="file" id="catImage" name="catImage">
				</div>
                <!-- text input end -->
				<div class="box box-info">

					<div class="box-header">

					<h3 class="box-title">Category Content</h3>

					<!-- tools box -->

					<div class="pull-right box-tools">

					  <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"

							  title="Collapse">

						<i class="fa fa-minus"></i></button>

					  <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"

							  title="Remove">

						<i class="fa fa-times"></i></button>

					</div>

					<!-- /. tools -->

				  </div>

				  <!-- /.box-header -->

				  <div class="box-body pad" id="editorContainer">
						  <textarea id="editor1" name="editor1" rows="10" cols="80"></textarea>
				  </div>

				</div>
				<div class="form-group">
				  <label>Date</label>
				  <div class="input-group date" id="datetimepicker2">
					<input class="form-control" name="category_evnt_date" type="text">
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span> </span> </div>
				</div>
          <!-- /.box -->

                <div class="box-footer">
                <input type="submit" class="btn btn-primary" value="Submit">
              </div>
        </form>
        
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->