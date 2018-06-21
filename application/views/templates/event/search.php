  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--   <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    //$( "#datepicker" ).datepicker({ dateFormat: 'dd/mm/yy'});

    $("#cat_id").unbind().bind("change", function() {
      var optionName      = $("#cat_id option:selected").text();
      var optionArr       = $(this).val().split("||");
      var optionID        = optionArr[0];
      var optionName      = optionArr[1];
      //if(optionName == 'River Rafting') {
      if(optionID == '17') {
        //$("#event_time").show('slow');
      }
	  else{
		$("#event_time").hide(); 
		$("#guide_name").hide();
	  }
    })
	
	$( "#datepicker" ).datepicker({ dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	    onSelect: function (dateStr) {
		if($("#cat_id").val()=='17||River Rafting'){ 
		var optionName      = $("#cat_id").val();
		var optionArr       = optionName.split("||");
		var optionID        = optionArr[0];
		var optionCatName   = optionArr[1];
		var selectedDate    = $(this).val();
		$.ajax({
			url: _basePath+"category/populatecompany/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'cat_id': 17,
                    'date': selectedDate 					
				   },
			success: function(responce) {
						
				if(responce['process'] == 'success') {
					//$("#event_time").slideDown('slow');
					//$("#event_time").find("option:not(:first)").remove();
					$("#rafting_company").slideDown('slow');
					$("#rafting_company").find("option:not(:first)").remove();
					
					//var size = Object.keys(responce['timeslots']).length;
					//var i;
					//for(i=0; i<size+1; i++){
						//if(responce.timeslots[i]!='' && responce.timeslots[i]!=undefined){
								//$("#event_time").append("<option //value='"+responce['timeslots'][i].event_time+"'>"+responce['ti//meslots'][i].event_time+"</option>");
								
								
						//}
						
					//}
					var size = Object.keys(responce['companys']).length;
					var i;
					for(i=0; i<size+1; i++){
						if(responce.companys[i]!='' && responce.companys[i]!=undefined){
								$("#rafting_company").append("<option value='"+responce['companys'][i].raftingcompany_id+"'>"+responce['companys'][i].raftingcompany_name+"</option>");
								
								
						}
						
					}
					
          
						
				} else if(responce['process'] == 'fail') {
					$("#event_time").hide(); 
			        $("#rafting_company").hide();
					//alert("Unable to create event. Please try again.");
					return false;
				} 							
			}
		});
		}else{
			$("#event_time").hide(); 
			$("#rafting_company").hide();
		}
					
		
		}	 
	});
	
	
	$("#rafting_company").unbind().bind("change", function() {
	  var company_id = $("#rafting_company").val();
	  var event_date = $("#datepicker").val();

	  
	  	$.ajax({
			url: _basePath+"category/populatetime/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'company_id': company_id,
					'event_date': event_date				
				   },
			success: function(responce) {
						
				if(responce['process'] == 'success') {
				               
					$("#event_time").slideDown('slow');
					$("#event_time").find("option:not(:first)").remove();
					var size = Object.keys(responce['timeslots']).length;
					var i;
					for(i=0; i<size+1; i++){
						if(responce.timeslots[i]!='' && responce.timeslots[i]!=undefined){
								$("#event_time").append("<option value='"+responce['timeslots'][i].event_time+"'>"+responce['timeslots'][i].event_time+"</option>");
								
								
						}
						
					}

						
				} else if(responce['process'] == 'fail') {
			        $("#event_time").hide();
					return false;
				} 							
			}
		});
      
    })
	
	
	$("#event_time").unbind().bind("change", function() {
	  var event_time = $("#event_time").val();
	  var event_date = $("#datepicker").val();
	  
	  	$.ajax({
			url: _basePath+"category/populateguide/",
			type: 'POST',
			dataType: 'JSON',
			data:  { 
					'event_time': event_time,
					'event_date': event_date				
				   },
			success: function(responce) {
						
				if(responce['process'] == 'success') {
				               
					$("#guide_name").slideDown('slow');
					$("#guide_name").find("option:not(:first)").remove();
					var size = Object.keys(responce['guides']).length;
					var i;
					
					for(i=0; i<size+1; i++){
						if(responce.guides[i]!='' && responce.guides[i]!=undefined){
								$("#guide_name").append("<option value='"+responce['guides'][i].guide_id+"'>"+responce['guides'][i].guide_name+"</option>");
								
								
						}
						
					}

						
				} else if(responce['process'] == 'fail') {
			        $("#guide_name").hide();
					return false;
				} 							
			}
		});
      
    })
	
  });
  
  
  </script>


<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<div class="row">

<div class="col-md-12 full bdrsdo clearfix">

<div class="event_searchsec">
<h3>Search Event Here..</h3>
<form action="<?=$frmaction?>" method="post">
<select name="cat_id" id="cat_id">
  <option value="">Select Category</option>
  <?php foreach ($all_category as $category) {?>
    <option value="<?=$category['id'].'||'.$category['cat_name'];?>" <?=($category['id'] == $cat_id)?"selected":""?>><?=$category['cat_name']; ?></option>
  <?php }?>
</select>
<input name="event_date" type="text" placeholder="Select Date" id="datepicker" value="<?=$event_date?>" />


<select name="rafting_company" id="rafting_company" style="display: <?php if($event_time!="0" && $categoryID=='17'){?>block<?php } else{?>none<?php }?>;">
  <option value="">Select Company</option>
  <?php if(!empty($companys)){ ?>
  <?php foreach($companys as $company){?>
  <option value="<?=$company['raftingcompany_id'];?>" <?=($company['raftingcompany_id'] == $company_id)?"selected":""?>><?=$company['raftingcompany_name']; ?></option>
  <?php }}?>
</select>

<select name="event_time" id="event_time" style="display: <?php if($event_time!="0" && $categoryID=='17'){?>block<?php } else{?>none<?php }?>;">
  <option value="">Select Time</option>
  <?php if(!empty($times)){ ?>
  <?php foreach($times as $time){?>
  <option value="<?=$time['event_time'];?>" <?=($time['event_time'] == $event_time)?"selected":""?>><?=$time['event_time']; ?></option>
  <?php }}?>
</select>

<!--<select name="guide_name" id="guide_name" style="display: <?php if($event_time!="0" && $categoryID=='17'){?>block<?php } else{?>none<?php }?>;">
  <option value="">Select Guide</option>
   <?php //if(!empty($guides)){ ?>
   <?php //foreach($guides as $guide){?>
   <option value="<?=$guide['guide_id'];?>" <?=($guide['guide_id'] == $guide_id)?"selected":""?>><?php //echo $guide['guide_name']; ?></option>
  <?php //}}?>
  
</select>-->
<input name="btnsearch" id="btnsearch" type="submit" value="Search"  />
</form>
</div>
<?php if($action == 'search') {?>
<div class="event_resultsec">
<h3>Your Date Matches For: <?=$event_date?></h3>
<?php if($event_list) {?>
<ul style="text-align: center;">
<?php foreach($event_list as $event) {
        $img_path         = $event['img_path'];
        $imagePath        = base_url().$event['path'].'/'.$event['file_name'];
?>
<li style="width: 24.5%;">
    <a href="<?=base_url().'Category/allimages/'.$event['event_id']?>">
      <img src="<?=thumb($imagePath, $img_path, '400', '400')?>" style="max-width:100%; position: relative;"> 
      <span style="background: #002152; color: #fff; display: block; margin-top: 1px;"><?=$event['event_name']?></span>
    </a>
</li>
<?php } ?>
</ul>
<?php } else {?>
<p>Sorry, There Were No Matches For: <?=$event_date?>. Please Try Another Date. </p>
<?php }?>
</div>
<?php }?>
</div>







</div>
</div>
</div>

</div>


        
