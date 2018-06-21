<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready( function(){
	$(".img_show").click( function(){
		var get_id = $(this).attr('id');
		$("#gal_image_id").val(get_id);
		$("#image_decs_post").val("0");
		
			$.ajax({
						url: _basePath+"event/imageDetails/",
						type: 'POST',
						dataType: 'JSON',
						data:  { 
							'id': get_id 
						},
						success: function(responce) {
							if(responce['process'] == 'success') {
								$("#photo_size").val(responce['imagedata'][0]['photo_size']);
								$("#digital_format").val(responce['imagedata'][0]['digital_format']);
								$("#photo_resolution").val(responce['imagedata'][0]['photo_resolution']);
								$("#media_price").val(responce['imagedata'][0]['media_price']);
								$("#photo_title").val(responce['imagedata'][0]['media_title']);
								$("#photo_description").val(responce['imagedata'][0]['media_description']);
						    }
							else if(responce['process'] == 'fail') {
								alert("Unable to create event. Please try again.");
								return false;
							}							
														
						}
					});
					
	});
	
	$(".set_all_img").click( function(){
		$("#image_decs_post").val("1");
	});
	
	
});

function Checkingform(event)
{
	    var gal_image_id 			= $("#gal_image_id").val();
		var event_id 				= $("#event_id").val();
		var media_price 			= $("#media_price").val();
		var image_decs_post 		= $("#image_decs_post").val();
		var photo_resolution 		= $("#photo_resolution").val();
		var photo_size 				= $("#photo_size").val();
		var digital_format 			= $("#digital_format").val();
		var photo_title				= $("#photo_title").val();
		var photo_description 		= $("#photo_description").val();

		$.ajax({
			type:"POST",
			dataType: 'JSON',
			url:"<?php echo base_url(); ?>Event/imageDataPost",
			data:
			{
				event_id:event_id,
				gal_image_id:gal_image_id,
				media_price:media_price,
				image_decs_post:image_decs_post,
				photo_resolution:photo_resolution,
				photo_size:photo_size,
				digital_format:digital_format,
				photo_title:photo_title,
				photo_description:photo_description,
			},
			
			success:function(response)
			{
				if(response['process'] == 'single') {
					$("#msg").text(response['msg']);
				}	
				else if(response['process'] == 'all'){
					$("#msg").text(response['msg']);
				}
				$('#myModal').modal('hide');
			},
			
			
		});
		
}
</script>
<style type="text/css">
	.imgDisplay{
		width: 19.4%;
min-height: 100px;
float: left;
margin: 3px;
border: 1px solid #D1DCE1;
padding: 3px;
height:180px;
	}
.imgDisplay img{max-width:100%; height:100%;}
.set_all_img {
    background: #535e63 none repeat scroll 0 0;
    border-radius: 2px;
    color: #fff;
    display: inline-block;
    font-size: 16px;
    margin: 0 0 4px;
    padding: 5px 30px;
}
.see_all_frm .col-md-6{}
.see_all_frm .col-md-6 label {
    display: block;
    margin-top: 14px;
}
.see_all_frm .col-md-6 input[type="text"] {
    padding: 2%;
    width: 96%;
}
.see_all_frm .col-md-12{text-align:center;}
.see_all_frm .col-md-12 button{
    background: #008d4c none repeat scroll 0 0;
    border-radius: 2px;
    color: #fff;
    font-size: 16px;
    padding: 5px 30px;
	margin:14px auto;
	border:0;
}
</style>
<?php //echo"<pre>";print_r($img_list);die; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content animate-panel">
    <div class="row">
    	<div class="panel-body">
    		<h3 style="padding: 15px 20px; background: #222d32; color:#fff;">Event [<?=$event_data['event_name']?>] <span style="float: right;position: relative; color:#fff;"><a href="<?=$back_link?>" style="color: #fff; font-size: 16px; background: #008d4c; padding: 5px 30px; border-radius: 2px;">Back</a></span></h3> 
            <a data-toggle="modal" href="" class="set_all_img" data-target="#myModal">Set Info For All Images</a>
            <br style="clear: both;" />        
			
			<?php foreach($img_list as $img) {
			  $file_name      = $img['file_name'];
			  $imagePath     = $front_url.'uploads/'.$img_path.$file_name;
			  
			  //$img_path       = 'Action/2018-03-05/Photographer4/Ski Action/';
			  //$file_name      = "elev-02.png";
			 // $imagePath     = base_url().'uploads/'.$img_path.$file_name;
				?>
			<div class="imgDisplay">
				<a data-toggle="modal" href="" id="<?php echo $img['media_id']; ?>" class="img_show" data-target="#myModal"><img src="<?=thumbcreate($imagePath, $img_path, '400', '400')?>" style="max-width: 100%;"></a>
			</div>
			
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Details</h4>
					<div id="msg" style="font-color:green;"></div>
				  </div>
				  <div class="modal-body see_all_frm">
				   <form method="post" name="media_data">
					<input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id; ?>">
					<input type="hidden" name="gal_image_id" id="gal_image_id" value="">
					<input type="hidden" name="image_decs_post" id="image_decs_post" value="0">
					<div class="col-md-6"><label>Media Price:</label> 
					<input type="text" name="media_price" id="media_price" value="<?php //echo (!empty($img['media_price'])) ? $img['media_price'] : ''; ?>"></div>
					<div class="col-md-6"><label>Photo Resolution:</label>
					<input type="text" name="photo_resolution" id="photo_resolution" value="<?php  ?>"></div>
                    <div class="clearfix"></div>
					<div class="col-md-6"><label>Photo Size:</label>
					<input type="text" name="photo_size" id="photo_size" value=""></div>
					<div class="col-md-6"><label>Digital Format:</label>
					<input type="text" name="digital_format" id="digital_format" value=""></div>
                    <div class="clearfix"></div>
					<div class="col-md-6"><label>Photo Title:</label>
					<input type="text" name="photo_title" id="photo_title" value=""></div>
					<div class="col-md-6"><label>Photo Description:</label>
					<input type="text" name="photo_description" id="photo_description" value=""></div>
                    <div class="clearfix"></div>

					<div class="col-md-12"><input type="button" name="img_value_submit" id="<?php echo $img['file_name'];?>" value="Save" class="img_value_submit"   onclick="return Checkingform(this);"/></div>
                    <div class="clearfix"></div>
				   </form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				</div>

			  </div>
			</div>
			<?php }?>
        </div>
    </div>
</div>
</div>


  <!-- /.content-wrapper -->
