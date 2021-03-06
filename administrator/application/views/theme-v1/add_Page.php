  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Page
        <small>Version 2.0</small>
      </h1>
     
    </section>

    <!-- Main content -->
     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">

         <?php
         $errMsg = $this->session->flashdata('errorPageMessage');
         $successMsg =  $this->session->flashdata('sucessPageMessage');
       if(!empty($successMsg)) { ?>

       <div class="alert alert-success alert-dismissible" style="width:25%; margin-top: 16px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                <?php echo $successMsg; ?>
            </div>

      <?php } ?>

          <form role="form" method="post" action="<?php echo base_url().'Page/addPage/';?>">
           <!-- text input -->
			<div class="form-group">
			  <label>Title</label>
			  <input type="text" class="form-control" id="ptitle" name="ptitle" placeholder="Enter Page Title...">
			</div>
			
			<div class="form-group">
			  <label>Meta Title</label>
			  <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Page Meta Title...">
			</div>
			
			<div class="form-group">
			  <label>Meta Keywords</label>
			  <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter Page Meta Keywords...">
			</div>
			
			<div class="form-group">
			  <label>Meta Description</label>
			  <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Enter Page Meta Description...">
			</div>
			<!-- text input end -->
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Page Description
                </h3>
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
              <div class="box-body pad">
				<textarea id="editor1" name="editor1" rows="10" cols="80"></textarea>
              </div>
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