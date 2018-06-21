<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
(function($){
	$(document).ready( function(){
		$('#example').DataTable();
	});
 })(jQuery)
</script>
  
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>Mailchimp List Subscribers</h1>
    <div class="box-tools pull-right" style="margin-bottom:10px">
	<a href="<?php echo base_url()."Customer/postMailchimpSubscription";?>">Export to Mailchimp </a>

	<?php //echo "<pre>"; print_r($mailchimplist); echo "<pre>";  ?>

	<!-- stdClass Object ( [lists] => Array ( [0] => stdClass Object ( [id] => 6ee04f9958 [web_id] => 62499 [name] => Software [contact] => stdClass Object ( [company] => Software [address1] => Salt Lake [address2] => [city] => Kolkata [state] => [zip] => 700028 [country] => IN [phone] => ) [permission_reminder] => You are receiving this email because you opted in via our website. [use_archive_bar] => 1 [campaign_defaults] => stdClass Object ( [from_name] => Cogito [from_email] => ravi.cogito@gmail.com [subject] => [language] => en ) [notify_on_subscribe] => [notify_on_unsubscribe] => [date_created] => 2018-01-08T13:12:36+00:00 [list_rating] => 0 [email_type_option] => [subscribe_url_short] => http://eepurl.com/dg3WOL [subscribe_url_long] => https://cogitosoftware.us17.list-manage.com/subscribe?u=cbf830cc704f657038f5d2de1&id=6ee04f9958 [beamer_address] => us17-f00e4eaa94-320a36f0e3@inbound.mailchimp.com [visibility] => pub [modules] => Array ( ) [stats] => stdClass Object ( [member_count] => 2 [unsubscribe_count] => 0 [cleaned_count] => 0 [member_count_since_send] => 2 [unsubscribe_count_since_send] => 0 [cleaned_count_since_send] => 0 [campaign_count] => 1 [campaign_last_sent] => [merge_field_count] => 3 [avg_sub_rate] => 0 [avg_unsub_rate] => 0 [target_sub_rate] => 0 [open_rate] => 0 [click_rate] => 0 [last_sub_date] => 2018-01-10T12:01:26+00:00 [last_unsub_date] => ) [_links] => Array ( [0] => stdClass Object ( [rel] => self [href] => https://us17.api.mailchimp.com/3.0/lists/6ee04f9958 -->

	</div><br> 
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
         
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>#</th>
				  <th>Customer Name</th>
				  <th>Customer Email</th>
				  <th>Customer Photograhp URL </th>
				 
				</tr>
			  </thead>

			  <tbody>
				<?php 
				if( !empty($mailchimplist) ){
					$i=1;
				foreach( $mailchimplist as $list ){ ?>
				<tr>
				  <td><?php echo $i; ?></td>
				  <td><?php echo $list['subs_details']->FNAME.' '. $list['subs_details']->LNAME; ?></td>
				  <td><?php echo $list['subs_email']; ?></td>
				  <td> <?php echo $list['subs_details']->MMERGE4; ?></td>				 
				</tr>
			  
			   <?php $i++; } } else { ?>

				<tr>
					 <td colspan="5" align="center"> There is no customer.</td>
				</tr>

			   <?php } ?> 
			  </tbody>

			</table>
					
		  
        </div>
                  
	  </div>
               
	</section>
              
  </div>
  
 <script>

function loginUser(mobile,password){
	
	var login_mobile = mobile;
	//alert(login_mobile);
	//return false
	var login_password = password;
	
	jQuery("#txtlogindata").val(login_mobile);
	jQuery("#txtpassword").val(login_password);
	
	$("#frmlogin").submit();
	
}
 </script>