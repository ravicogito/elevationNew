  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>
	Privacy Policy Management

	</h1>
    <div class="box-tools pull-right">
		<a class="btn btn-block btn-default" href="<?php echo base_url().'Faq/addFaq/'; ?>"><i class="fa fa-plus-square"></i>&nbsp;Add FAQ</a>
	</div><br><br>
    </section>

    <!-- Main content -->
     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         
<!-- Default box -->
<!-- ********************** GRID LAYOUT **********************-->
<div class="box">                             
<div class="box-body table-responsive no-padding">
  <table class="table table-hover">
	<tr>
	  <th>#</th>
	  <th>Questions</th>
	  <th>Answers</th>
	  <th>Action</th>
	</tr>

	<?php 
	if(!empty($contents)){
	$i=1;
	foreach($contents as $content) { ?>
	<tr>
	  <td><?php echo $i; ?></td>
	  <td><?php echo $content->faq_question; ?></td>
	  <td><?php $faq_answer = strip_tags($content->faq_answer); 
	  
			$total_words = str_word_count($faq_answer);
			if($total_words > 20)
			{
				$explode_words = explode(' ',$faq_answer,20);
				array_pop($explode_words);
				
				echo implode(' ',$explode_words).'.........';
			}
			else{
				echo $faq_answer;
				
			}
			
	  ?></td>
	  <td><a href="<?php echo base_url().'Faq/editFaq/'.$content->faq_id; ?>" class="label label-success">Edit</a>&nbsp;<a href="<?php echo base_url().'Faq/deleteFaq/'.$content->faq_id; ?>" onClick="javascript: return confirm('Are you sure you want to delete this record?');" class="label label-danger">Delete</a></td>
	</tr>
  
   <?php $i++; } } else { ?>

	<tr>
		 <td colspan="5" align="center"> There is no pages.</td>
	</tr>

   <?php } ?>

  </table>
</div>
<!-- /.box-body -->
</div>
<!-- ******************** END **************************-->
</section>

</div>
