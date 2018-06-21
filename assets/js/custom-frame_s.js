//Javascript
$(document).ready(function() {
  	var count = 0;
	$("#datepicker").datepicker({dateFormat:"dd/mm/yy"});

	$(".imgDetails").on("click", function(event) {
		event.preventDefault();
      	var imgSrc                = $(this).children('img').attr('src'); 
		//var imgAttArr             = $(this).attr('rel').split("|");
      	//var imgPrice              = imgAttArr[0];
      	//var eventID               = imgAttArr[1];
      	//var mediaID               = imgAttArr[2];
      	var flag 				  = 'general';
        alert(imgSrc);
		//var outerDivID          = $("#collage_div,#canvasFrame").children('div').attr('id');
		//sudhansu
		var outerDivID            = $(".collage div.fix_we div:eq(0)").attr('id');
		//sudhansu
		alert(outerDivID);
      	if(outerDivID == 'outerDivCollage') {
      		
        	var childDivCnt         = $("#sortable").children().length;
			
			if(childDivCnt == 0) {
        		childDivCnt         = 5;
        		flag 				= 'package';
        	}
        	var i;
        	
        	for (i = 0; i < childDivCnt; i++) {
        		var nestedDivObj 			= $("#sortable div:eq('"+i+"')");
        		var nestedObj 				= $("#sortable div:eq('"+i+"') img:eq(0)");
        		if(flag == 'package') {
        			if(i<=1) {
        				var nestedDivObj 	= $("#sortableLeft div:eq('"+i+"')");
        				var nestedObj 		= $("#sortableLeft div:eq('"+i+"') img:eq(0)");
        			} else {
        				j = i-2;        				
        				var nestedDivObj 	= $("#sortableRight div:eq('"+j+"')");
        				var nestedObj 		= $("#sortableRight div:eq('"+j+"') img:eq(0)");
        			}
        		}
          		var url               		= nestedObj.attr('src');
          		var parts             		= url.split("/");
          		var last_part         		= parts[parts.length-1];

          		if(nestedObj.attr('src').length == 0 || last_part == 'noimage.png') {
            		nestedObj.attr('src', imgSrc);
            		var mediaAttr			= imgPrice+"|"+eventID+"|"+mediaID;
            		nestedDivObj.attr('id', mediaAttr);
            		
            		// Create price Array
            		var exImgPrice 			= $("#imgPrice").val();
      		
		      		if(exImgPrice.length === 0) {
		      			var imgPriceArr			= new Array();
		      		} else {
		      			var imgPriceArr			= exImgPrice.split(',');
		      		}
		      		imgPriceArr.push(imgPrice);
					var imgCurPrice 			= imgPriceArr.join(',');
					//alert('hi - '+imgCurPrice);
		      		$("#imgPrice").val(imgCurPrice);

      				// Create event Array
      				var exEventID 			= $("#eventID").val();
      		
		      		if(exEventID.length === 0) {
		      			var eventIDArr			= new Array();
		      		} else {
		      			var eventIDArr			= exEventID.split(',');
		      		}
		      		eventIDArr.push(eventID);
					var curEventID 			= eventIDArr.join(',');
					//alert('hi - '+curEventID);
		      		$("#eventID").val(curEventID);

		      		// Create media Array
      				var exMediaID 			= $("#mediaID").val();
      		
		      		if(exMediaID.length === 0) {
		      			var mediaIDArr			= new Array();
		      		} else {
		      			var mediaIDArr			= exMediaID.split(',');
		      		}
		      		mediaIDArr.push(mediaID);
					var curMediaID 			= mediaIDArr.join(',');
					//alert('hi - '+curMediaID);
		      		$("#mediaID").val(curMediaID);

		      		var finalPrice      = totalCollagePrice();

	            	$.ajax({
		          		url: _basePath+"Favourite/cngImgCollage/",
		          		data: {img_name: imgSrc, img_price: imgCurPrice, event_id: curEventID, media_id: curMediaID, final_price: finalPrice},
		          		type: 'POST',        
		          		success: function(response) {     
		            		//alert("here");
		          		},
		        	}); 

            		break;
          		}
        	}         
     	} else {

	        $("#imgPrice").val(imgPrice);
	        $("#eventID").val(eventID);
	        $("#mediaID").val(mediaID);
	        $("#disImage").attr('src', imgSrc);
	        
	        var finalPrice      = totalPrice();

	        $.ajax({
	          url: _basePath+"Favourite/cngImg/",
	          data: {img_name: imgSrc, img_price: imgPrice, event_id: eventID, media_id: mediaID, final_price: finalPrice},
	          type: 'POST',        
	          success: function(response) {     
	            //alert("here");
	          },
	        });
      	}
      
    });

    

    $(".option").on("click", function() {
      var optionID        	 	  = $(this).attr('id');
      var imgSrc			      = $("#disImage").attr('src');
      if($("#disImage").length == 0) {
        var imgSrc              = $('div #country_table div:eq(0) a:eq(0) img').attr('src');
      } else {
        //
      }
      /*if(imgSrc.length == 0) {
        
      }*/
	  //alert('hi - '+optionID);
      //alert('hi - '+imgSrc);
      var imgPrice          	  = $("#imgPrice").val();  
	   
      if(optionID == 'collage') {

        $.ajax({
          url: _basePath+"Favourite_s/getCollageDetails/",
          data: {option_id: optionID},
          type: 'POST',
          dataType: "JSON",
          success: function(response) {     
            //alert(response['option_size']);
            $(".wraper_pan").html(response['HTML']);      
          },

        });
      } else {
        $.ajax({
          url: _basePath+"Favourite_s/getOptionDetails/",
          data: {option_id: optionID, image_src: imgSrc, img_price: imgPrice},
          type: 'POST',
          dataType: "JSON",
          success: function(response) {     
            //alert(response['option_size']);
            $(".wraper_pan").html(response['HTML']);      
          },

        });
      }
      

    	/*var optionName 		= $(this).text();
    	var newClass 		  = "_"+optionName.toLowerCase();
    	var curObj 			  = $("div.fix_we div:eq(0)");
    	var objClass 		  = curObj.attr('class');
    	if(optionName == 'Framing') {
    		$(".option_frame").slideDown('slow');
    		$("div.fix_we div:eq(1)").addClass('texture');
    		$("div.fix_we div:eq(2)").addClass('black');
    	} else {  
        $(".option_frame").slideUp('slow');  		
    		$("div.fix_we div:eq(1)").removeClass();
    		$("div.fix_we div:eq(2)").removeClass();
    	}
    	curObj.removeClass(objClass);
    	$("#outerDiv").addClass("full_frm"+newClass);*/
    })

})


$(document).on('click', ".p2a_mto_ulsizeoptions li", function() {
	//alert('hi');
      var frmSize               = $(this).attr('sizeid');
      var sizePrice             = $(this).attr('rel');
      var widthArr              = frmSize.split("X");
      var width                 = (66-widthArr[0]);
      var disText 				      = $(this).text();
	  
	  //alert('Size'+frmSize+', Size Price'+sizePrice+'WidthArr'+widthArr+'width'+width+'distText'+disText);
      //$(".full_frm").removeClass('small').addClass(frmSize);
      
      var curObj 				= $("div.fix_we div:eq(0)");
      var objClass 				= curObj.attr('id');
		//alert("hi - "+objClass);
      //var widthTest = width+"px "+width+'px #423934';
	  //alert(width);
      $("#outerDiv").removeClass("full_frm_framing8_23");
      $("#outerDiv").removeClass("full_frm_framing5_7");
      $("#outerDiv").removeClass("full_frm_framing8_10");
      $("#outerDiv").removeClass("full_frm_framing16_20");
      $("#outerDiv").removeClass("full_frm_framing11_14");
      $("#outerDiv").css("border-width", width+"px");
      
      if(frmSize == '8X23') {
      	$("#outerDiv").addClass("full_frm_framing8_23");
      }
      else if(frmSize == '5X7'){
      	$("#outerDiv").addClass("full_frm_framing5_7");
      }
      else if(frmSize == '8X10'){
      	$("#outerDiv").addClass("full_frm_framing8_10");
      }
      else if(frmSize == '16X20'){
      	$("#outerDiv").addClass("full_frm_framing16_20");
      }
      else if(frmSize == '11X14'){
      	$("#outerDiv").addClass("full_frm_framing11_14");
      }
      //$("#outerDiv").css("box-shadow", widthTest);
      $("#sizePrice").val(sizePrice);
      $(".p2a_mto_ulsizeoptions").slideUp("slow", function() {
      	$(".listdiv")[0].childNodes[0].nodeValue = disText;
      });      
      var finalPrice			= totalPrice();
      $.ajax({
        url: _basePath+"Favourite/cngSize/",
        data: {frame_size: frmSize, size_price: sizePrice, final_price: finalPrice},
        type: 'POST',        
        success: function(response) {			
          //alert("here");
		  
		  //alert(response);
        },
      });

    });

$(document).on("click", ".listdiv", function() {
	if($(".p2a_mto_ulsizeoptions").is(':visible')) {
		$(".p2a_mto_ulsizeoptions").slideUp("slow");
	} else {
		$(".p2a_mto_ulsizeoptions").slideDown("slow");
	}
	
})

$(document).on("click", "div.option_frame h3", function() {
	var actDiv					= $(this).attr('rel');
	$( "div.option_frame h3" ).each(function( index, element ) {
		$(this).removeClass('active');
		$("ul."+$(this).attr('rel')).hide();	    
  	})
	$("ul."+actDiv).show('slow');
	$(this).addClass('active');
})

$(document).on("click", "ul.frame li", function() {  
   alert('hereeee11111');
	var frameClass 			= $(this).attr('rel');
  	var framePrice    		= $("#"+frameClass).val();
	if($("div.fix_we div:eq(0)").hasClass('full_frm_framing')) {
			$("div.fix_we div:eq(0)").removeClass().addClass('full_frm_framing '+frameClass);
		}
    $("#framePrice").val(framePrice);
	$("#frameName").val(frameClass);
	
    var finalPrice 			= totalPrice();
	
	alert(frameClass);alert(framePrice);alert(finalPrice);
	
      $.ajax({
        url: _basePath+"Favourite_s/cngFrame/",
        data: {frame_name: frameClass, frame_price: framePrice, final_price: finalPrice},
        type: 'POST', 
		//**********sreela(05/04/18)*********
		dataType: "JSON",	
        success: function(response) {	
		if(response['frame_name'] != ""){
		  $("#lb_frame").html("Frame");	
          $(".frameName").html(response['frame_name']);
		  $("#frame_name").val(response['frame_name']);
		}
		//**********END*********
        },
      });
})

$(document).on("click", "ul.topmat li", function() {
	var topMatClass 			= $(this).attr('rel');
 	var topMatPrice    			= $("#"+topMatClass).val();
	$("div.fix_we div:eq(1)").removeClass().addClass(topMatClass);	
  	$("#topMatPrice").val(topMatPrice);
  	var finalPrice 				= totalPrice();

	$.ajax({
	    url: _basePath+"Favourite/cngMat/",
	    data: {mat_position: "top", mat_name: topMatClass, mat_price: topMatPrice, final_price: finalPrice},
	    type: 'POST',        
	    //**********sreela(05/04/18)*********
		dataType: "JSON",	
        success: function(response) {	
			if(response['topmat_name'] != ""){
			  $("#lb_topmat").html("Top mat");	
			  $(".topmatName").html(response['topmat_name']);
			  $("#topmat_name").val(response['topmat_name']);
			}
			//**********END*********
	    },
	});
})

$(document).on("click", "ul.midmat li", function() {
  var midMatClass       		= $(this).attr('rel');
  var midMatPrice    			= $("#"+midMatClass).val();
  $("div.fix_we div:eq(2)").removeClass().addClass(midMatClass);
  $("#middleMatPrice").val(midMatPrice);
  
  var finalPrice 				= totalPrice();

	$.ajax({
	    url: _basePath+"Favourite/cngMat/",
	    data: {mat_position: "middle", mat_name: midMatClass, mat_price: midMatPrice, final_price: finalPrice},
	    type: 'POST',        
	    //**********sreela(05/04/18)*********
		dataType: "JSON",	
        success: function(response) {	
			if(response['middlemat_name'] != ""){
			  $("#lb_middlemat").html("Middle mat");	
			  $(".middlematName").html(response['middlemat_name']);
			  $("#middlemat_name").val(response['middlemat_name']);
			}
			//**********END*********
	    },
	});
})

$(document).on("click", "ul.botmat li", function() {
	var bottomMatClass 			= $(this).attr('rel');
  	var bottomMatPrice    		= $("#"+bottomMatClass).val();
	$("div.fix_we div:eq(2)").removeClass().addClass(bottomMatClass);
	$("#bottomMatPrice").val(bottomMatPrice);
  	var finalPrice 				= totalPrice();

	$.ajax({
	    url: _basePath+"Favourite/cngMat/",
	    data: {mat_position: "bottom", mat_name: bottomMatClass, mat_price: bottomMatPrice, final_price: finalPrice},
	    type: 'POST',        
	    //**********sreela(05/04/18)*********
		dataType: "JSON",	
        success: function(response) {	
			if(response['bottommat_name'] != ""){
			  $("#lb_bottommat").html("Bottom mat");	
			  $(".bottommatName").html(response['bottommat_name']);
			  $("#bottommat_name").val(response['bottommat_name']);
			}
			//**********END*********
	    },
	});
})

/*----------------------- Collage Section -----------------*/
$(document).on("click", "ul.frame_collage li", function() {
	var collageFrameName 		= $(this).children('span').children('strong').html();
	var relArr        			= $(this).attr('rel').split('|');
	var frameClass    			= relArr[0];
	var divCnt        			= relArr[1];
	var framePrice        		= $("#"+frameClass).val();
	
	//alert(collageFrameName);alert(relArr);alert(frameClass);alert(divCnt);alert(framePrice);

	$("#imgPrice").val('');
	$("#eventID").val('');
	$("#mediaID").val('');  
	//$("div.fix_we div:eq(0)").removeClass().addClass('full_frame '+frameClass);
	//sudhansu-25-05-2018
	$(".collage div.fix_we div:eq(0)").removeClass().addClass('full_frame '+frameClass);
	//sudhansu-25-05-2018
	$("#collage_frame_name").val(collageFrameName);
	$("#collageFramePrice").val(framePrice);
	var i; 
	var newHtml           = '';
	$("#sortable").html(''); 
	var colArr              = ['triple', 'double'];
	var frameArr 			= ['package_black_matte', 'package_blue_matte', 'package_green_matte']	;
	if(frameClass == 'triple' || frameClass == 'double') {
	    className         = "col_"+divCnt;
	} else {
	    className         = "row_"+divCnt;  
	}
	if($.inArray(frameClass, frameArr) !== -1 ) {

		$("#sortable").removeAttr('class');
		newHtml				+= '<div id="sortableLeft" class="ui-sortable">';
		for (i = 0; i < divCnt; i++) {
		  	var imgRootPath     = _basePath+"assets/images/collage/";
		  	var imgPath         = imgRootPath+"noimage.png";
		  	var delImgPath      = imgRootPath+"delete.png";
//
			if(i == 0) {
				newHtml             += '<div class="'+className+' leftBig"><img src="'+imgPath+'" style=""><span class="remove_frame"><img src="'+delImgPath+'" style=""></span></div>';
			} else {
				newHtml             += '<div class="'+className+'"><img src="'+imgPath+'" style=""><span class="remove_frame"><img src="'+delImgPath+'" style=""></span></div>';
			}
		    
		    if(i == 1) {
		  		newHtml				+= '</div> <div id="sortableRight" class="ui-sortable">';
		  	}
		}
		newHtml				+= '</div>';
		$("#sortable").html(newHtml);
		
		$("#sortable").removeAttr('id');
		$( "#sortableLeft, #sortableRight" ).sortable();
	} else {
		$("#outerDivCollage div:eq(0)").attr('id', 'sortable');
		for (i = 0; i < divCnt; i++) {
		  	var imgRootPath     = _basePath+"assets/images/collage/";
		  	var imgPath         = imgRootPath+"noimage.png";
		  	var delImgPath      = imgRootPath+"delete.png";
		    newHtml             += '<div class="'+className+'"><img src="'+imgPath+'" style=""><span class="remove_frame"><img src="'+delImgPath+'" style=""></span></div>';
		}

		$("#sortable").html(newHtml);
  	}
  
    var finalPrice      = totalCollagePrice();
  
    $.ajax({
    	url: _basePath+"Favourite/cngColageFrame/",
        data: {frame_name: frameClass, frame_price: framePrice, final_price: finalPrice},
        type: 'POST',     
    	dataType: "JSON", 
        success: function(response) { 
    		if(response['frame_name'] != "") {
      			$("#lb_frame").html("Frame"); 
          		$(".frameName").html(response['frame_name']);
      			$("#frame_name").val(response['frame_name']);
    		}
        },
    });
})

$(document).on("click", ".remove_frame", function() {
	var imgRootPath     			= _basePath+"assets/images/collage/";
  	var imgPath         			= imgRootPath+"noimage.png";
  	var mediaAttr 					= $(this).parent('div').attr('id');
	if (confirm('Are you sure you want to delete this?')) {
  	if($(this).parent('div').attr('id')) {
  		var mediaAttrArr 			= mediaAttr.split('|');
	  	var imgPrice              	= mediaAttrArr[0];
	  	var eventID               	= mediaAttrArr[1];
	  	var mediaID               	= mediaAttrArr[2];
	  	//alert($(this).parent('div').children('img').attr('src'));
  		var url               		= $(this).parent('div').children('img').attr('src');
	    var parts             		= url.split("/");
	    var last_part         		= parts[parts.length-1];
	    
	    if(last_part == 'noimage.png') {
	    	//Do nothing
	    } else {

	    	// Remove image Price
			var exImgPrice 			= $("#imgPrice").val();
			var imgPriceArr			= exImgPrice.split(',');
			var indexOfPArr	= $.inArray(imgPrice, imgPriceArr);	
			if(indexOfPArr !== -1) {
				imgPriceArr.splice(indexOfPArr, 1);
			}			
			var imgCurPrice 			= imgPriceArr.join(',');
			//alert('hi - '+imgCurPrice);
			$("#imgPrice").val(imgCurPrice);

			// Remove event ID
			var exEventID 				= $("#eventID").val();
			var eventIDArr			= exEventID.split(',');
			var indexOfArr	= $.inArray(eventID, eventIDArr);	
			if(indexOfArr !== -1) {
				eventIDArr.splice(indexOfArr, 1);
			}			
			var curEventID 			= eventIDArr.join(',');
			//alert('hi - '+curEventID);
			$("#eventID").val(curEventID);

			// Remove media ID
			var exMediaID 			= $("#mediaID").val();
			var mediaIDArr			= exMediaID.split(',');
			var indexOfMArr	= $.inArray(mediaID, mediaIDArr);	
			if(indexOfMArr !== -1) {
				mediaIDArr.splice(indexOfMArr, 1);
			}			
			var curMediaID 			= mediaIDArr.join(',');
			//alert('hi - '+curMediaID);
      		$("#mediaID").val(curMediaID);

      		$(this).parent('div').children('img').attr('src', imgPath);

      		var finalPrice      = totalCollagePrice();
	    }
  	} else {
  		// Do nothing
  	}
	}
})

$(document).on("click", ".createCanvas", function(event) {
	//var element = $("#canvasFrame"); // global variable	
	event.preventDefault();
	//var redirectUrl 				= $(this).attr('href');
	/*$("#canvasFrame").html2canvas({
          onrendered: function (canvas) {               
            //Set hidden field's value to image data (base-64 string)
            theCanvas = canvas;
            document.body.appendChild(canvas);

            // Convert and download as image 
            Canvas2Image.saveAsPNG(canvas); 
            $("#img-out").append(canvas);
            alert("here - "+canvas.toDataURL("image/png"));
            $('#img_val').val(canvas.toDataURL("image/png"));
            //Submit the form manually
            $("#frmcanvas").submit();
          }
      });*/

      html2canvas($("#canvasFrame"), {
      onrendered: function(canvas) {
        //Canvas2Image.saveAsPNG(canvas);
        $("#img-out").append(canvas);
        var imgageData = canvas.toDataURL('image/png');
        var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
        //console.log(newData);
        $('#img_val').val(newData);
        //Submit the form manually
        $("#frmcanvas").submit();
      }
    });;

	
	//window.location = redirectUrl;
})

function totalPrice() {
  var imgPrice              = ($("#imgPrice").val() == '')?"0.00":$("#imgPrice").val();
  var sizePrice             = ($("#sizePrice").val() == '')?"0.00":$("#sizePrice").val();
  var framePrice            = ($("#framePrice").val() == '')?"0.00":$("#framePrice").val();
  var topMatPrice           = ($("#topMatPrice").val() == '')?"0.00":$("#topMatPrice").val();
  var middleMatPrice        = ($("#middleMatPrice").val() == '')?"0.00":$("#middleMatPrice").val();
  var bottomMatPrice        = ($("#bottomMatPrice").val() == '')?"0.00":$("#bottomMatPrice").val();
 
  var totalPrice            = parseFloat(imgPrice)+parseFloat(sizePrice)+parseFloat(framePrice)+parseFloat(topMatPrice)+parseFloat(middleMatPrice)+parseFloat(bottomMatPrice);
  var finalPrice            = parseFloat(totalPrice).toFixed(2);
  
  $(".totalPrice").html("$"+finalPrice);
  return finalPrice;
}

function totalCollagePrice() {
	//var imgPriceArr           	= $("#imgPrice").val().split(',');
  	var imgPrice 				= 0;
	/*for (var i = 0; i < imgPriceArr.length; i++) {
    	imgPrice 				+= imgPriceArr[i] << 0;
	} */ 
	//sudhansu-25-05-2018
	imgPrice = $("#imgPriceCollage").val();
	//sudhansu-25-05-2018
  	var framePrice            	= $("#collageFramePrice").val();  
    //alert('imgPrice'+imgPrice);
  	var totalPrice            	= parseFloat(imgPrice)+parseFloat(framePrice);
  	var finalPrice            	= parseFloat(totalPrice).toFixed(2);
  
  	$(".totalPrice").html("$"+finalPrice);
  	return finalPrice;
} 