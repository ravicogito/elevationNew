<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>		
	function Checkingform(photographer)	{
		var photographer_name 	= jQuery(photographer).find('#photographer_name').val();
		var email 				= jQuery(photographer).find('#photographer_email').val();
		var atpos				= email.indexOf("@");
		var atlastpos			= email.lastIndexOf("@");	
		var dotpos				= email.indexOf(".");
		var dotlastpos			= email.lastIndexOf(".");
		var photographer_mobile	= jQuery(photographer).find('#photographer_mobile').val();			

		if(photographer_name == '')			
		{	alert('Please put photographer name');				
			return false;			
		}			
		if(atpos==0 || dotpos==0 || atlastpos==email.length-1 || dotlastpos==email.length-1 || atpos+1==dotpos || atpos-1==dotpos || atpos==-1 || dotpos==-1 || email=="" || dotlastpos==-1 || atlastpos==-1 || atpos!=atlastpos)			
		{				alert('Please put a valid email');				
			return false;			
		}			
		if(photographer_mobile == '' || !(photographer_mobile.match('[0-9]{10}')))  
		{       alert("Please put 10 digit mobile number");            				
				return false;			
		
		}
	}
		</script>
		<style>.hpanel {    background-color: none;    border: none;    box-shadow: none;    margin-bottom: 25px;}.hpanel.hblue .panel-body {    border-top: 2px solid #b00e4e;}.hpanel .panel-body {    background: #fff;    border: 1px solid #e4e5e7;        border-top-width: 1px;        border-top-style: solid;        border-top-color: rgb(228, 229, 231);    border-radius: 2px;    padding: 20px;    position: relative;}</style><!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
		<div class="content animate-panel"> 
		<div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
		<div class="hpanel hblue"> 
		<div class="panel-body">  
		<h3>Add New Photographer</h3>
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
		if ($failed_msg != "") {                        ?>
		<div class="alert alert-danger">
			<?php echo $failed_msg; ?>
		</div>
		<?php                    }                    ?>
        <form role="form" method="post" action="<?php echo base_url().'Photographer/addPhotographer/';?>" onsubmit="return Checkingform(this);" enctype="multipart/form-data">
            <!-- text input -->
            <div class="form-group">
                <label>Photographer Name</label>
                <input type="text" class="form-control" id="photographer_name" name="photographer_name" placeholder="Enter your name"> </div>
            <!--<div class="form-group">
                <label>Resort Name</label>
                <select name="resort_id" id="resort_name" class="form-control">
                    <option value="">Select</option>
                    <?php //if(!empty($resort_list)){ foreach ($resort_list as $vallist){									?>
                        <option value="<?php //echo $vallist->resort_id; ?>">
                            <?php //echo $vallist->resort_name; ?>
                        </option>
                        <?php//									}									} ?>
                </select>
            </div>-->
            <!-- text input -->
            <div class="form-group">
                <label>Photographer Email</label>
                <input type="text" class="form-control" id="photographer_email" name="photographer_email" placeholder="Enter your email"> </div>
            <!-- text input -->
            <div class="form-group">
                <label>Photographer Mobile</label>
                <input type="text" class="form-control" id="photographer_mobile" name="photographer_mobile" placeholder="Enter your mobile"> </div>
            <!-- text input end -->
			<!-- text input -->
            <div class="form-group">
                <label>Photographer UserName</label>
                <input type="text" class="form-control" id="photographer_userName" name="photographer_userName" placeholder="Enter your UserName"> </div>
            <!-- text input end -->
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Photographer Description							</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"> <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"> <i class="fa fa-times"></i></button>
                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body pad" id="editorContainer">
                    <textarea id="photographer_editor1" name="photographer_editor1" rows="10" cols="58"></textarea>
                </div>
            </div>
            <!-- /.box -->
            <div class="box-footer">
                <input type="submit" class="btn btn-success btn-block" value="Add"> </div>
        </form>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <!-- /.content-wrapper -->