<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

		 
		function Checkingform(event)
		{
			var pagetitle 	= jQuery(event).find('#ptitle').val();
			//var pagecontent = jQuery(event).find('#editor1').val();
			var pagecontent = $("#editorContainer iframe").contents().find("body").text();
			//alert(pagecontent);	
			if(pagetitle == '')
			{
				alert('Please enter faq question');
				return false;
			}
			if(pagecontent == '')
			{
				alert('Please enter faq answer');
				return false;
			}
		}	
		
</script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ADD New Privacy Policy Question
        
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

          <form role="form" method="post" action="<?php echo base_url().'Privacypolicy/addPrivacyPolicy/';?>" onsubmit="return Checkingform(this);" enctype="multipart/form-data">
           <!-- text input -->
                <div class="form-group">
                  <label>Privacy Policy Question</label>
                  <input type="text" class="form-control" id="ptitle" name="ptitle" placeholder="Enter your question...">
                </div>
                <!-- text input end -->
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Privacy Policy Answer</h3>
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