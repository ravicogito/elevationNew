<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script>
	(function($){
		$(document).ready( function() {
			$('div.upload_form').hide();
			$(".selType").on("change", function() {
				$('div.upload_form,div.assign_form').hide();
				$("#frmAssign")[0].reset();
				$("#frmUpload")[0].reset();
				if($(this).val() == 'upload') {
					$('div.upload_form').slideDown('slow');
				} else {
					$('div.assign_form').slideDown('slow');
				}
			});

			$("#txtsearch").on("keyup", function() {
				var serchText 				= $(this).val();
				var eventID 				= $("#event_id").val();
				$.ajax({
						url: _basePath+"guide/search_user/",
						type: 'POST',
						dataType: 'JSON',
						data: {search_text: serchText, event_id: eventID},
						success: function(responce) {
							if(responce['process'] == 'success') {
								$(".assign_listleft").html(responce['HTML']);
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
			})
			
			$("#upload_file").click( function() {
				var excel = $("#excel").val();
				
				if(excel == '')
				{
					alert('Please choose some file for upload');
					return false;
				}
			});
			
			$("#assign_user").click( function() {
				var all_checkboxes = $('.assign_userlist input[type="checkbox"]');
				var all_checkboxes = all_checkboxes.filter(":checked").length;
				if(all_checkboxes == 0)
				{
					alert("Please Checked any assign User");
					return false;
				}
				
			});
		}); 
	})(jQuery)
</script>
<style type="text/css">
	.hpanel.hblue{animation-delay: 0.1s;
background: #f5f5f5;
border: 1px solid #cfcfcf;}
.hpanel.hblue h3{margin: -14px;
padding: 15px 20px;
background: #222d32;
color: #fff;
margin-bottom: 5px;}
.btn.btn-success.btn-block, .btn.btn-success.btn-viewimages{    display: inline-block;
    width: 49.5%;
    vertical-align: top;
    margin: 0;
}
.btn.btn-success.btn-block{background: #222d32; border:1px solid #222d32; margin-right:2px;}
label{width: 140px; text-align: right;
margin-right: 20px;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 animated-panel zoomIn" style="animation-delay: 0.1s;">
            <div class="hpanel hblue">
                <div class="panel-body">
                    <h3>Guide [<?=$event_data['event_name']?>]</h3>
                    
                    <br/>                                        	
						<div class="form-group">
						  <label>Main Category : </label>
						  <?=$event_data['cat_name']?>
						</div>
						<div class="form-group">
						 <label>Event Date : </label>
						  <?=$event_data['event_date']?>
						</div>
						<div class="form-group">
							<label>Rafting Company Name : </label>
							<?=$event_data['raftingcompany_name']?>
						</div>
						<div class="form-group">
						  <label>Event Name : </label>
						  <?=$event_data['event_name']?>
						</div>
						<!-- <div class="form-group">
							<label for="catImage">Event Description : </label>
							<?=$event_data['event_description']?>
						</div>
						
						<div class="form-group">
						  <label>Event Price : </label>
						  <?=$event_data['event_price']?>
						</div> -->
                </div>

            </div>
        </div>
    </div>
</div>
	<div class="assign_section">
		<div class="assign_uploadsec">
		<p><input name="optType" type="radio" value="upload" class="selType" />Upload</p>
		<p><input name="optType" type="radio" value="assign" class="selType" <?=($action == 'edit')?"checked":""?> />Assign</p>
		</div>
		<div class="upload_form">
			<form action="<?=$actionUpload?>" method="post" name="frmUpload" id="frmUpload" enctype="multipart/form-data">
				<input type="hidden" name="event_id" value="<?=$event_id?>">
				<input name="excel" id="excel" type="file" />
				<input name="btnUpload" type="submit" id="upload_file" value="Upload" />
			</form>
		</div>
		<div class="assign_form" style="display: <?=($action == 'edit')?"block":"none"?>">
			<form action="<?=$actionAssign?>" method="post" name="frmAssign" id="frmAssign">
				<input type="hidden" name="event_id" id="event_id" value="<?=$event_id?>">
				<div class="ass_userheading"><h2>Assign User</h2>
					<div class="search_assignuser">
						<input name="txtsearch" id="txtsearch" type="text" placeholder="Search User Here" /><!-- <input name="" type="submit" value="search" /> -->
					</div>
				</div>
			<div class="assign_listleft">
				<?php if($custList) {
						foreach ($custList as $key => $value) {

				?>
				<div class="userGroup">
				<h3><?=strtoupper($key);?></h3>
				<?php foreach($value as $customer) {?>
				<div class="assign_userlist">
					<input name="chkCustomer[]" type="checkbox" id="checkbox_customer" value="<?=$customer['customer_id'];?>" <?=(in_array($customer['customer_id'], $assign_list))?"checked":""?> /><label><?=$customer['name']?></label>
				</div>
				<?php }?>
				</div>
				<?php }}?>
			</div>			
				<input name="" type="submit" id="assign_user" value="Assign" class="assign" />
			</form>
		</div>

	</div>
</div>

  <!-- /.content-wrapper -->
