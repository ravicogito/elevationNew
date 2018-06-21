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
                    <h3>Event [<?=$event_data['event_name']?>]</h3>
                    
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
							<label>Photographer Name : </label>
							<?=$event_data['photographer_name']?>
						</div>
						<div class="form-group">
						  <label>Event Name : </label>
						  <?=$event_data['event_name']?>
						</div>
						<div class="form-group">
							<label for="catImage">Event Description : </label>
							<?=$event_data['event_description']?>
						</div>
						
						<div class="form-group">
						  <label>Event Price : </label>
						  <?=$event_data['event_price']?>
						</div>
					<a href="<?=$back_link?>"><button type="button" name="btnBackEvent" id="btnBackEvent" class="btn btn-success btn-block">Back</button></a>
					<a href="<?=$img_list;?>"><button type="button" name="btnEventImg" id="btnEventImg" class="btn btn-success btn-viewimages">View Images</button></a>
					
					
                </div>

            </div>
        </div>
    </div>
</div>
</div>
  <!-- /.content-wrapper -->
