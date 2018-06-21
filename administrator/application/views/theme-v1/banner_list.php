<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>
	Banners List     
	</h1>	<div class="box-tools pull-right">
	<a class="btn btn-block btn-default" href="<?php echo base_url().'Banner/addBanner/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add Banner</a><br>
	</div>
     
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
				  <?php if(!empty($errMsg)) { ?>

				   <div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $errMsg; ?>
						</div>

				  <?php } ?>
         
               <!-- Default box -->
<!-- ********************** GRID LAYOUT **********************--><div class="box">
<div class="box-body table-responsive no-padding">
	<table class="table table-hover">
		<tr>
		  <th>#</th>
		  <th>Banner Type</th>
		  <th>Banner Image</th>
		  <th>Banner Title</th>
		  <th>Banner Content</th>
		  <th>Action</th>
		</tr>

		<?php 
		if(!empty($banner_lists)){
		$i=1;
		foreach($banner_lists as $list) { ?>
		<tr>
		  <td><?php echo $i; ?></td>
		  <td><?php if($list->banner_type=='1'){echo 'About Us';} elseif($list->banner_type=='2') {echo "FAQ";} elseif($list->banner_type=='3'){echo 'Privacy Policy'; }?></td>
		  <?php
					$url_tmp  = base_url();
					$front_url = str_replace("/administrator", "", $url_tmp);
			?>	
		  <td><img src="<?php echo $front_url;?>/uploads/bannerImg/<?php echo $list->banner_image;?>" height="80px;" width="80px;"/></td>
		  
		  <td><?php echo $list->banner_title; ?> </td>
		  
		   <td><?php echo $list->banner_content; ?> </td>

		  <td width="13%"><a href="<?php echo base_url().'banner/editBanner/'.$list->banner_id; ?>" class="label label-success">Edit</a>&nbsp;<a href="<?php echo base_url().'banner/deleteBanner/'.$list->banner_id; ?>" onClick="javascript: return confirm('Are you sure you want to delete this record?');" class="label label-success">Delete</a></td>
		  </tr>
	  
	   <?php $i++; } } else { ?>

		<tr>
			 <td colspan="5" align="center"> There is no banner.</td>
		</tr>

	   <?php } ?>

	</table>
</div>
<!-- /.box-body -->
</div>
<!-- ******************** END **************************--></section> </div>