<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!------------------- Body start-------------------->

<div class="banner">
<div class="wrap">
<div class="txtprt">
<h2><span><em style="color:#e00b69; font-style:normal;">I’m</em> here </span> to capture your ski </h2>
<p>make a memorable ski ...</p>
<!--<a href="">Register</a>--></div>
<div class="clearfix"></div>

<div class="tabwrap"><ul class="tabli">
<li data-id="tab1" class="col-md-2 tabeffect">Search Ski Event</li>
<!--<li  class="col-md-2 tabeffect" data-id="tab2">Search  your  Photo</li>-->

</ul>
<div class="clearfix"></div>
<div class="tabcntwrap">
<!-------------------Search your Ski Event-------------------->
<div class="tabfulcont" id="tab1"><h3>Search Ski Event..</h3>
<div class="sechfrm clearfix">
	<form id="locationeventsearch_form" autocomplete="off" action="<?php echo base_url(); ?>home" method="post">
	<input type="text" id="searchinput_box" name="location_name" value="<?php echo $this->input->post('location_name');?>" class="col-md-10 col-sm-9 col-xs-7">
	<input type="hidden" id="location_id" name="location_id" value="">
	<!--<input type="date"  placeholder="Date"  class="col-md-2"  name="event_date" class="inpu dat">
	<select id="resort_id" name="resort_id" class="col-md-4">
	  <option value="" selected>Select your Resort ...</option>
	  
	</select>-->
	<!--<input name="eventSearch" id="eventSearch" onclick= "searchevent();" type="button" value="Search" class="pinkbtn">-->
	<input name="eventSearch" id="eventSearch" type="submit" value="Search" class="pinkbtn">
	</form>

	<div id="suggesstion-box" class="col-md-4"></div>  
</div>

</div>

</div>
  
  
  </div>
	
    </div>

  <div class="clearfix"></div>
</div>
</div>
<div id="myOverlay"></div>
<div id="loadingGIF"><img src="<?php echo base_url()?>assets/images/ajax-loader.gif" alt=""/><p style="font-size:28"><strong>PROCESSING, PLEASE WAIT...</strong></p></div>
<div class="contwrap">
<div class="container-fluid" id="default_div">
<div class="wrap skievnt">
<div class="row">
<!------------------- Location -------------------->
<div>

<?php 

if(!empty($location)){
	foreach($location as $loc_list){		
		
?>
	<div class="boxsec col-md-12" >
	<div class="bdrsdo">	
	<div class="boxlft col-md-8 col-sm-8" style="background-image:url(<?php echo base_url();?>uploads/locations/<?php echo $loc_list['location_image'] ?>); background-repeat: no-repeat;"><img src="<?php echo base_url(); ?>assets/images/boxban.png" />
	<?php $customerID= $this->session->userdata('customer_id');
			if(isset($customerID)){ ?>
		<div class="bxtxt col-md-6 col-sm-6 col-xs-6"><?php echo $loc_list['location_name']; ?> <span><?php echo $loc_list['event_name']; ?></span><a href="<?php echo base_url();?>CustomerPhotos/customerEventPhoto/<?php echo $loc_list['location_id']; ?>"><div class="bxbtn">See your <strong>Event</strong> Section</div></a></div>
	<?php } else{?>
		<div class="bxtxt col-md-6 col-sm-6 col-xs-6"><?php echo $loc_list['location_name']; ?> <span><?php echo $loc_list['event_name']; ?></span><a href="" class="opnfrmm" id="opnfrmm_<?php echo $loc_list['location_id']; ?>"><div class="bxbtn">See your <strong>Event</strong> Section</div></a></div>
	<?php } ?>
	</div>
	<!------------------- Login -------------------->
	<div class="logform poplogfrm" id="poplogfrm_<?php echo $loc_list['location_id']; ?>">
	<form id="loginform" action="<?php echo base_url();?>Login" method="post" autocomplete="off">
	<h2><img src="<?php echo base_url();?>assets/images/blogin.png" ><br>User Login</h2>
	<span class="erro_msg" style="color:red;font-size:15px;display:none"><strong>Your login credentials not matching! Please try again.</strong></span><br/><br/>
	<div class="frm_dve input-effect">
		  <input class="frm_dve_effect" size="40" id="useremail_<?php echo $loc_list['location_id']; ?>" name="useremail" type="text" placeholder="Enter Your Username">      
		  <span class="focus-border"></span> 
		  </div>

	<div class="frm_dve input-effect">
		  <input class="frm_dve_effect" size="40" id="password_<?php echo $loc_list['location_id']; ?>" name="password" type="password" placeholder="Enter Your Password">     
		  <span class="focus-border"></span> 
		  </div>


	<div class="clearfix compimg">
	<div class="com"><a href="<?php echo base_url();?>Login/forgotpassword">Forgot your password?</a></div>
	<input id="login_bttn_<?php echo $loc_list['location_id']; ?>" name="login_bttn" value="Login" class="book_submit rgt  col-md-5 login_bttn" type="button" style="border:0;"> 
	</div>
	</form>
	<a href="" class="pp_close item_close" id="pp_close_<?php echo $loc_list['location_id']; ?>"></a>
	</div>
	
	<!------------------- End Login -------------------->
	<div class="boxrgt col-md-4 col-sm-4">
	<?php  //print_r($latlong); 
	if(!empty($weather_info)){ ?>
	<a href="javascript:void(0)" class="col-md-6 hovv col-sm-6"><span class="icon"><?php if($weather_info[$loc_list['location_id']] != 'NA'){ echo number_format($weather_info[$loc_list['location_id']], 0) ; ?> <sup>0</sup>C <?php } else { echo $weather_info[$loc_list['location_id']] ; }?></span><span class="atit">Today's</span> <span class="atit sml">weather report</span></a> <?php } ?>

	<a href="<?php echo base_url();?>home/photographereDetails/<?php echo $loc_list['location_id']; ?>" class="col-md-6 hovv col-sm-6 phtographer_data" id="phtographer"><span class="icon"></span><span class="atit">Contact</span> <span class="atit sml">with photographer</span></a>
	
	<!--<a href="#" class="col-md-6 hovv col-sm-6"><span class="icon"></span><span class="atit">track</span> <span class="atit sml">your location</span></a> -->
	<a href="<?php echo base_url(); ?>home/locationMap/<?php echo  $loc_list['location_name']; ?>"  class="col-md-6 hovv col-sm-6" id="location_map_<?php echo $loc_list['location_id']; ?>"><span class="icon"></span><span class="atit">track</span> <span class="atit sml">your location</span></a>

	<a href="" class="col-md-6 hovv col-sm-6"><span class="icon"></span><span class="atit">share</span> <span class="atit sml">this event</span></a> 
	</div>
	
	
</div>
</div>	
<?php } } else { ?>
<div class="boxsec col-md-12" >
<div class="bdrsdo">
<div class="noimge">
<h3>No Location Found</h3>
</div></div></div>
<?php } ?>

</div>
<!--<div id="ajax_div" style="display:none"></div>
----------------- End Location -------------------->

</div>
</div>
<div id="loadmoreajax"></div>
</div>
<?php if($loadmorecount > 0){ ?>
<div class="lodmor" id="loadmore"><a style="text-decoration:none" href="javascript:void(0)" onclick= "addMore();">load more</a></div> <?php  } ?>


</div>
</div>


<!------------------- Body end -------------------->
<script>
var start = 5;
function searchevent(){
	//alert("dsfgjhsg");
	$("#myOverlay").show();
	$("#loadingGIF").show();
	
	var data = $("#locationeventsearch_form").serialize();

	$.ajax({
	    type: 'POST',
	    url: $("#locationeventsearch_form").attr('action') + '/' + limit + '/1',
	    data: data,
		dataType:"HTML",
	    success: function(result){
		//alert(result);
		$("#myOverlay").hide();
		$("#loadingGIF").hide();
		$("#default_div").hide();		
		$("#loadmore").hide();
		$("#ajax_div").html(result);
		$("#location_id").val('');
		$("#ajax_div").show();
	    }
	});
}
  
function addMore(){
	//alert("dsfgjhsg");
	$("#myOverlay").show();
	$("#loadingGIF").show();
	start += 5;	
	//var data = $("#locationeventsearch_form").serialize();

	$.ajax({
	    type: 'POST',
	    url: '<?php echo base_url();?>home/Loadmorelocation',
	    data: {start : start},
		dataType:"HTML",
	    success: function(result){			
		$("#myOverlay").hide();
		$("#loadingGIF").hide();	
		$("#loadmore").hide();	
		$("#loadmoreajax").html(result);
	    }
	});
}
$(document).ready(function(e) {
	/*$("#locationeventsearch_form").submit(function(){
		
		alert("Please click SEARCH button, to get the result.");
		return false;
		
		
	});*/
	
	//$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
	
	$('#eventSearch').click(function(e){
	
	  if($.trim($('#searchinput_box').val())==""){
	   e.preventDefault();
	   alert('Please enter valid search keyword.');
	  }else if(/^[a-zA-Z0-9-\)\(,.:& ]*$/.test($.trim($('#searchinput_box').val())) == false) {
	   e.preventDefault();
		  alert('Please enter valid search keyword.');
	  }else{
	   return true;
	  }
	});
	
	$("#searchinput_box").keyup(function(){
		var search_value	= $(this).val();
		
		$.ajax({
		type: "POST",
		url: "<?php echo base_url()?>Home/locationName",
		data:{keyword:search_value},
		dataType:"HTML",
		beforeSend: function(){
			$("#searchinput_box").css("background","#FFF url(../image/ajax-loader_circle.gif) no-repeat 165px");
		},
		success: function(data){
			//alert(data);
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#suggesstion-box").css("background","#FFF");
		}
		});
	});

	$(window).load(function(e) {
	$(document).on("click", ".opnfrmm", function(e){	
	
		e.preventDefault();
		var location_id		= $(this).attr("id");
		//alert(location_id);
		var arr         	= location_id.split('_');
		//alert(arr['1']);
		$('#poplogfrm_'+arr['1']).show();
		$('#poplogfrm_'+arr['1']).toggleClass('poplogfrmopn');
		$('.overlay').toggle();
	});
	
	$('.item_close').click( function(e){
		
		var get_id = $(this).attr('id');
		var arr         	= get_id.split('_');
		//alert(arr['2']);
		e.preventDefault();
		$(".erro_msg").hide();
		$('#poplogfrm_'+arr['2']).hide();
		$('#poplogfrm_'+arr['2']).removeClass('poplogfrmopn');
		$('.overlay').toggle();
		
	});
	
	});

$(document).on("click", ".login_bttn", function(){	
	
	var location_id		= $(this).attr("id");
	var arr         	= location_id.split('_');
	var email 			= $('#useremail_'+arr['2']).val();
	var pass 			= $('#password_'+arr['2']).val();
	
	var atpos				= email.indexOf("@");
	var atlastpos			= email.lastIndexOf("@");
	var dotpos				= email.indexOf(".");
	var dotlastpos			= email.lastIndexOf(".");
	if(atpos==0 || dotpos==0 || atlastpos==email.length-1 || dotlastpos==email.length-1 || atpos+1==dotpos || atpos-1==dotpos || atpos==-1 || dotpos==-1 || email=="" || dotlastpos==-1 || atlastpos==-1 || atpos!=atlastpos )
		{
			alert('Please put a valid email');
			return false;
		}
	
	else if(pass ==''){
		alert('Please put a valid password');
			return false;
	}
	else{
		
		$("#myOverlay").show();
		$("#loadingGIF").show();
		//{useremail:email,password:pass}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>Login/',
			data:{useremail:email,password:pass},
			dataType:"html",
			success: function(result){
			//alert(result);
				$("#myOverlay").hide();
				$("#loadingGIF").hide();	
				if(result != 0){
				
				window.location.href= "<?php echo base_url();?>profile/myaccount";	
				}
				else{
					$(".erro_msg").show();

				}
			}
		});
	}
		
});
	
});

function selectCountry(val,lid) {
		$("#searchinput_box").val(val);
		
		$("#location_id").val(lid);
		$("#suggesstion-box").hide();
	}

function addOption(selectbox, value, text){
		var optn = document.createElement("option");
		optn.text = text;
		optn.value = value;
		selectbox.options.add(optn);
	}
</script>


<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJMZhj1LOlXpPsapzj3recS4C1x4aKK6U&callback=initMap">
    </script>



