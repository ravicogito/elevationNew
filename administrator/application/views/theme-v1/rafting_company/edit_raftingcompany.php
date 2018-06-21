<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script>		
	function Checkingform(raftingcompany)	{
		var raftingcompany_name 	= jQuery(raftingcompany).find('#raftingcompany_name').val();
		var raftingcompany_email	= jQuery(raftingcompany).find('#raftingcompany_email').val();
		var raftingcompany_mobile	= jQuery(raftingcompany).find('#raftingcompany_mobile').val();			

		if(raftingcompany_name == '')			
		{	alert('Please put Rafting Company name');				
			return false;			
		}

        if(raftingcompany_email == '')			
		{	alert('Please put Rafting Company Email ID');				
			return false;			
		}
 		
		if( !validateEmail(raftingcompany_email)){

			alert('Please put Rafting Company valid Email Id');				
			return false;	

		} 			
		if(raftingcompany_mobile == '' || !(raftingcompany_mobile.match('[0-9]{10}')))  
		{       alert("Please put 10 digit mobile number");            				
				return false;			
		
		}
	}
	
	function validateEmail($email) {

		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

		return emailReg.test( $email );

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
                    <h3>Edit Rafting Company</h3>
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
		
                    <form role="form" method="post" action="<?php if(!empty($raftingcompany_data['raftingcompany_id'])){ echo base_url().'Riverraftingcompany/updateRaftingCompany/'.$raftingcompany_data['raftingcompany_id']; } ?>" onsubmit ="return Checkingform(this);" enctype="multipart/form-data">
						<!-- text input -->
				
							<div class="form-group">

							  <label>Rafting Company Name</label>

							  <input type="text" class="form-control" id="raftingcompany_name" name="raftingcompany_name" value="<?php if(!empty($raftingcompany_data['raftingcompany_name'])){ echo $raftingcompany_data['raftingcompany_name'];}?>">

							</div>
							
							
						<!-- text input -->

							<div class="form-group">

							  <label>Rafting Company Email</label>

							  <input type="text" class="form-control" id="raftingcompany_email" name="raftingcompany_email" value="<?php if(!empty($raftingcompany_data['raftingcompany_email'])){ echo $raftingcompany_data['raftingcompany_email']; }?>">

							</div>
							
						<!-- text input -->

							<div class="form-group">

							  <label>Rafting Company Mobile</label>

							  <input type="text" class="form-control" id="raftingcompany_mobile" name="raftingcompany_mobile" value="<?php if(!empty($raftingcompany_data['raftingcompany_mobile'])){ echo $raftingcompany_data['raftingcompany_mobile']; }?>">

							</div>
				
							<!-- text input end -->
							

							<div class="box box-info">

							<div class="box-header">

							<h3 class="box-title">Rafting Company Description

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

							<div class="box-body pad" id="editorContainer">
								  <textarea id="photographer_editor1" name="raftingcompany_editor1" rows="10" cols="58"><?php if(!empty($raftingcompany_data['raftingcompany_description'])){ echo $raftingcompany_data['raftingcompany_description']; }?></textarea>
							</div>

							</div>

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