<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

<!------------------- Body start-------------------->

<div class="banner">
<div class="wrap">
<div class="txtprt">
<h2><span><em style="color:#e00b69; font-style:normal;">I’m</em> here </span>
to make your ski </h2>
<p>Register and be a member to make a memorable ski ...</p>
<!--<a href="">Register</a>--></div>
<div class="clearfix"></div>
<div class="tabwrap"><ul class="tabli">
<li data-id="tab1" class="col-md-2 tabeffect">Search  your  Ski Event</li>
<!--<li  class="col-md-2 tabeffect" data-id="tab2">Search  your  Photo</li>-->

</ul>
<div class="clearfix"></div>
<div class="tabcntwrap">
<!-------------------Search your Ski Event-------------------->
<div class="tabfulcont" id="tab1"><h3>Search your ski event photo shoot</h3>
<div class="sechfrm">
	<form id="locationeventsearch_form" action="<?php echo base_url(); ?>home/locationEventSearch" method="post">
	<select id="location_id" name="location_id" class="col-md-4">
	  <option value="" selected>Select your location ...</option>
	  <?php 
		if(!empty($location_lists)){
		foreach($location_lists as $location_list){ 
	 ?>
			<option value="<?php echo $location_list['location_id']; ?>"><?php echo $location_list['location_name']; ?></option>
		<?php } } ?>
	</select>
	<!--<input type="date"  placeholder="Date"  class="col-md-2"  name="event_date" class="inpu dat">
	<select id="resort_id" name="resort_id" class="col-md-4">
	  <option value="" selected>Select your Resort ...</option>
	  
	</select>-->
	<input name="eventSearch" id="eventSearch" onclick= "searchevent();" type="button" value="Search" class="pinkbtn">
	</form>
</div>
</div>
<!-------------------End Search -------------------->
<!--<div class="tabfulcont" id="tab2"><h3>Search your ski event photo shoot</h3>
	<div class="sechfrm">
	<form>
	<select name="" class="col-lg-5">
	  <option value="aa" selected>Select your location ...</option>
	  <option value="bbb">bb</option>
	</select>
	<input type="date"  placeholder="Date"  class="col-lg-2"  name="bday" class="inpu dat">
	<input name=""type="text"  placeholder="Hotel"  class="col-lg-3">
	<input name="" type="submit" value="Search" class="pinkbtn">
	</form>
	</div>
</div>--> 
</div>
  
  
  </div>
  <div class="clearfix"></div>
</div>
</div>
<div id="myOverlay"></div>
<div id="loadingGIF"><img src="<?php echo base_url()?>assets/images/ajax-loader.gif" alt=""/><p style="font-size:28"><strong>PROCESSING, PLEASE WAIT...</strong></p></div>
<div class="contwrap">
<div class="container-fluid">
<div class="wrap skievnt">
<div class="row">
<!------------------- Location -------------------->
<div id="default_div">
<?php 
if(!empty($event_lists)){
	foreach($event_lists as $event_list){ 
?>
	<div class="boxsec col-md-12" >
	<div class="bdrsdo">	
	<div class="boxlft col-md-8" style="background-image:url(<?php echo base_url();?>uploads/locations/<?php echo $event_list['location_image'] ?>); background-repeat: no-repeat;"><div class="bxtxt col-md-6"><?php echo $event_list['location_name']; ?> <span><?php echo $event_list['event_name']; ?></span> <div class="bxbtn">Book your <strong>Free</strong> Section</div></div></div>
	<div class="boxrgt col-md-4">
	<?php if(!empty($weather_info)){ ?>
	<a href="javascript:void(0)" class="col-md-6 hovv"><span class="icon"><?php if($weather_info[$event_list['location_id']] != 'NA'){ echo number_format($weather_info[$event_list['location_id']], 1) ; ?> <sup>0</sup>C <?php } else { echo $weather_info[$event_list['location_id']] ; }?></span><span class="atit">Today's</span> <span class="atit sml">weather report</span></a> <?php } ?>

	<a href="#photographer_details_<?php echo $event_list['location_id']; ?>" rel="prettyPhoto" class="col-md-6 hovv phtographer_data inline" r id="phtographer_<?php echo $event_list['location_id']; ?>"><span class="icon"></span><span class="atit">Contact</span> <span class="atit sml">with photographer</span></a>
	
	<a href="" class="col-md-6 hovv"><span class="icon"></span><span class="atit">track</span> <span class="atit sml">your location</span></a> 
	<a href="" class="col-md-6 hovv"><span class="icon"></span><span class="atit">share</span> <span class="atit sml">this event</span></a> 
	</div>
	<div id="photographer_details_<?php echo $event_list['location_id']; ?>" style='display:none'> 
	</div>
	</div>
	</div>
<?php
	}
}
?>
</div>
<div id="ajax_div" style="display:none"></div>
<!------------------- End Location -------------------->

</div>
</div>
<div class="lodmor"><a style="text-decoration:none" href="javascript:void(0)" onclick= "addMore();">load more</a></div>
</div>
</div>
</div>
<div id="login" style="display:none;">
<div class="logform">
<form action="" method="">
<h2><img src="<?php echo base_url()?>assets/images/login.png" width="79" height="59"><br/>User Login</h2>

<div class="frm_dve input-effect">
      <input name="nam" value="" size="40" class="frm_dve_effect"  type="text">
      <label>User Name</i></label>
      <span class="focus-border"></span> 
      </div>

<div class="frm_dve input-effect">
      <input name="nam" value="" size="40" class="frm_dve_effect"  type="text">
      <label>Password</i></label>
      <span class="focus-border"></span> 
      </div>


<div class="clearfix compimg">
<div class="com"><input id="f2s"  type="checkbox"><label class="icon" for="f2s"></label> Forgot your password?</div>   
<input name="" value="Login" class="book_submit rgt  col-md-5" type="submit">
</div>
</form>
</div>
</div>
<!------------------- Body end -------------------->
<script>
var limit = 5;    
function searchevent(){
	alert("dsfgjhsg");
	$("#myOverlay").show();
	$("#loadingGIF").show();
	
	var data = $("#locationeventsearch_form").serialize();

	$.ajax({
	    type: 'POST',
	    url: $("#locationeventsearch_form").attr('action') + '/' + limit + '/1',
	    data: data,
		dataType:"HTML",
	    success: function(result){
		alert(result);
		$("#myOverlay").hide();
		$("#loadingGIF").hide();
		$("#default_div").hide();
		$("#ajax_div").html(result);
		$("#ajax_div").show();
	    }
	});
}    
function addMore(){
	//alert("dsfgjhsg");
	$("#myOverlay").show();
	$("#loadingGIF").show();
	limit += 4;
	var data = $("#locationeventsearch_form").serialize();

	$.ajax({
	    type: 'POST',
	    url: $("#locationeventsearch_form").attr('action') + '/' + limit + '/1',
	    data: data,
		dataType:"HTML",
	    success: function(result){
		$("#myOverlay").hide();
		$("#loadingGIF").hide();
		$("#default_div").hide();
		$("#ajax_div").html(result);
		$("#ajax_div").show();
	    }
	});
}
$(document).ready(function(e) {
	
	$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
	

/*$("#location_id").unbind().bind("change", function() {
  var locationID     = $(this).val();
  
  $.ajax({
	url: "<?php echo base_url();?>home/populateAjaxresort/",
	data:{location:locationID},
	type: "POST",
	dataType:"HTML",
	success:function(data) {
	  $("#resort_id").get(0).options.length=0;
	  addOption($("#resort_id").get(0), "", "-- Select state --", "");	
	  var arr = new Array();
	  if(data!="")
	  {
		arr = data.split("??");
		for(var i=0;i<arr.length;i++)
		{
		  var brr =  new Array();
		  brr = arr[i].split("|");
		  
		  addOption($("#resort_id").get(0), brr[0], brr[1], "");
		}
	  }         
	}
  }); 
});*/
$(".phtographer_data").click(function(){
	var loc_id	= this.id;
	var locn_id = loc_id.split('_');
	$.ajax({
	url: "<?php echo base_url();?>home/populateAjaxPhotographere/",
	data:{location:locn_id[1]},
	type: "POST",
	dataType: 'HTML',
	success:function(data) {
	
		$("#photographer_details_" + locn_id[1]).html(data);
		
	}
  });
	
	
});
});


function addOption(selectbox, value, text){
		var optn = document.createElement("option");
		optn.text = text;
		optn.value = value;
		selectbox.options.add(optn);
	}
</script>



