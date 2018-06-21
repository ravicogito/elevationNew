//Javascript
$(document).ready(function() {
	$("#datepicker").datepicker({dateFormat:"dd/mm/yy"});

	$(".imgDetails").on("click", function(event) {
      event.preventDefault();
      var imgSrc                = $(this).children('img').attr('src'); 
      var imgAttArr             = $(this).attr('rel').split("|");
      var imgPrice              = imgAttArr[0];
      var eventID              = imgAttArr[1];
      var mediaID              = imgAttArr[2];
      
      $("#imgPrice").val(imgPrice);
      $("#eventID").val(eventID);
      $("#mediaID").val(mediaID);
      $("#disImage").attr('src', imgSrc);
      
      var finalPrice			= totalPrice();

      $.ajax({
        url: _basePath+"Favourite/cngImg/",
        data: {img_name: imgSrc, img_price: imgPrice, event_id: eventID, media_id: mediaID, final_price: finalPrice},
        type: 'POST',        
        success: function(response) {			
          //alert("here");
        },
      });
    });

    

    $(".option").on("click", function() {
      var optionID        	 	= $(this).attr('id');
      var imgSrc			    = $("#disImage").attr('src');
      var imgPrice          	= $("#imgPrice").val();	  
	 
      $.ajax({
        url: _basePath+"Favourite/getOptionDetails/",
        data: {option_id: optionID, image_src: imgSrc, img_price: imgPrice},
        type: 'POST',
        dataType: "JSON",
        success: function(response) {			
          //alert(response['option_size']);
		  $(".wraper_pan").html(response['HTML']);
		  
        },
      });
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
      var frmSize               = $(this).attr('sizeid');
      var sizePrice             = $(this).attr('rel');
      var widthArr              = frmSize.split("x");
      var width                 = (50-widthArr[0]);
      var disText 				= $(this).text();
      //$(".full_frm").removeClass('small').addClass(frmSize);
      
      var curObj 				= $("div.fix_we div:eq(0)");
      var objClass 				= curObj.attr('id');
//alert("hi - "+objClass);
      //var widthTest = width+"px "+width+'px #423934';
      $("#outerDiv").css("border-width", width+"px");
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
	var frameClass 			= $(this).attr('rel');
  	var framePrice    		= $("#"+frameClass).val();
	if($("div.fix_we div:eq(0)").hasClass('full_frm_framing')) {
			$("div.fix_we div:eq(0)").removeClass().addClass('full_frm_framing '+frameClass);
		}
    $("#framePrice").val(framePrice);
	$("#frameName").val(frameClass);
	
    var finalPrice 			= totalPrice();
	
      $.ajax({
        url: _basePath+"Favourite/cngFrame/",
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