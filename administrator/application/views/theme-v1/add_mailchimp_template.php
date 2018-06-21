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

       <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $successMsg; ?>
            </div>

      <?php } ?>

          <form role="form" method="post" action="">
           <!-- text input -->
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" id="ptitle" name="ptitle" placeholder="Enter ..." value="<?php if(!empty($mailchimp_row_data['title'])){ echo $mailchimp_row_data['title']; } ?>">
                  <input type="hidden" class="form-control" id="hidds" name="hidds" value="<?php if(!empty($mailchimp_row_data['id'])){ echo $mailchimp_row_data['id']; } ?>">
                </div>
                <!-- text input end -->
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">For Implementing web url use *|MERGE4|* Into Ckeditor Body 
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
                
                      <textarea id="editor1" name="editor1" rows="10" cols="80"><?php if(!empty($mailchimp_row_data['content'] )){ echo $mailchimp_row_data['content']; } ?></textarea>

                
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