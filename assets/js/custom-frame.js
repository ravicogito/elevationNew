//Javascript
$(document).ready(function() {
	$(".colg_matte_frame_img").load(function() {
		$(this).width(some).height(some).appendTo('#colg_matte_frame_div');
	})
  	var count = 0;
	$("#datepicker").datepicker({dateFormat:"dd/mm/yy"});

	$(".imgDetails").on("click", function(event) {

    	event.preventDefault();
      	var imgSrc                = $(this).children('img').attr('src'); 
      	var imgAttArr             = $(this).attr('rel').split("|");
      	var imgPrice              = imgAttArr[0];
      	var eventID               = imgAttArr[1];
      	var mediaID               = imgAttArr[2];
		var imgName               = imgAttArr[3];
      	var flag 				  = 'general';
		var frmtype				  =  $("input.imgDetails").val();
		if(frmtype == 'frame'){
			
			var outerDivID            = $("#canvasFrame").children('div').attr('id');
		}
		else if(frmtype == 'collage'){
			var outerDivID           = $(".collage div.fix_we div#outerframeCollage div:eq(0)").attr('id');
			
		}
		else{
			
			var outerDivID            = $("#canvasPrint").children('div').attr('id');
			
		}
      	
		
		var collg_img_id = '';
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
							var colgname 		= $("#collage_frame_name").val();
							
							$("#colg_img_name").val($("#colg_img_name").val()+','+imgName);
							$("#colg_img_id").val($("#colg_img_id").val()+','+mediaID);
							var arr 			=	curMediaID.split(",");								
							var frmset_count	=   arr.length;
							//alert(frmset_count);
							if((colgname == '5x7 green matte') || (colgname == '5x7 blue matte')){		
								
								if(frmset_count == 2){
									
									$("#confirmbttnCollage").prop('disabled', false);
								}
								else if(frmset_count < 2){
									
									$("#confirmbttnCollage").prop('disabled', true);
									
								}
							}
							else if((colgname == 'package black matte') || (colgname == 'package blue matte') || (colgname == 'package green matte') || (colgname == 'series blue matte') ||(colgname == 'series green matte') || (colgname == 'series black matte') ){
								if(frmset_count == 5){
									
									$("#confirmbttnCollage").prop('disabled', false);
								}
								else if(frmset_count < 5){
									
									$("#confirmbttnCollage").prop('disabled', true);
									
								}
								
							}
		            		//alert("here");
		          		},
		        	}); 

            		break;
          		}
        	}         
     	} 
		else if(outerDivID == 'outer_div'){			
			
	        $("#eventID").val(eventID);	        
	        $("#displyImage").attr('src', imgSrc);

	        $.ajax({
	          url: _basePath+"Favourite/cngprintImg/",
	          data: {img_name: imgSrc, event_id: eventID},
	          type: 'POST',        
	          success: function(response) {  
//alert(mediaID);			  
				$("#img_id").val(mediaID);
				$("#imge_name").val(imgName);
	          },
	        });			
		}
		else {

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
//alert(mediaID);			  
				$("#imge_name").val(imgName);
			    $("#img_id").val(mediaID);
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
          url: _basePath+"Favourite/getCollageDetails/",
          data: {option_id: optionID},
          type: 'POST',
          dataType: "JSON",
          success: function(response) {     
            //alert(response['option_size']);
            $(".wraper_pan").html(response['HTML']);      
          },

        });
      } 
	  else if(optionID == 'collage_ops'){
		
		$("input.imgDetails").val("collage");
		var noimge             = $(this).attr('rel');
		
		if(noimge == '2'){
			
			$("#colg_total_price").html(20);
			$("#inp_total_price_collg").val(20);
		}
		else if(noimge == '4'){
			
			$("#colg_total_price").html(20);
			$("#inp_total_price_collg").val(20);
		}
		else if(noimge == '5'){
			
			$("#colg_total_price").html(45);
			$("#inp_total_price_collg").val(45);
		}
		//$("#colg_total_price").val();
		$.ajax({
          url: _basePath+"Favourite/getCollageDetails/",
          data: {option_id: optionID},
          type: 'POST',
          dataType: "JSON",
          success: function(response) {     
            //alert(response['option_size']);
            $(".wraper_pan").html(response['HTML']);      
          },

        });  
		  
		  
	  }
	  else if(optionID == 'print_ops'){
		$("input.imgDetails").val("print");  
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
      }
	  else {
		$("input.imgDetails").val("frame");  
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
      }
      
    })

})


window.onload = function() {
	//alert('hi');
      var frmSize               = $(".print_size").val();
	 // alert(frmSize);
      var sizePrice             = $(this).attr('rel');
      var widthArr              = frmSize.split('x');
	  //alert("shagfh-"+widthArr[1]);
      var width                 = (66-widthArr[0]);
      var disText 				= $(this).text();
	  
	  
      
      if(frmSize == '8x23') {
      	$("#outerDiv").addClass("full_frm_framing8_23");
		$("#outer_div").addClass("full_frm_framing8_23");
      }
      else if(frmSize == '5x7'){
		 // alert("46456");
      	$("#outerDiv").addClass("full_frm_framing5_7");
		$("#outer_div").addClass("full_frm_framing5_7");
      }
      else if(frmSize == '8x10'){
      	$("#outerDiv").addClass("full_frm_framing8_10");
		$("#outer_div").addClass("full_frm_framing8_10");
      }
      else if(frmSize == '16x20'){
      	$("#outerDiv").addClass("full_frm_framing16_20");
		$("#outer_div").addClass("full_frm_framing16_20");
      }
      else if(frmSize == '11x14'){
		  //alert("njdfhsjk");
      	$("#outerDiv").addClass("full_frm_framing11_14");
		$("#outer_div").addClass("full_frm_framing11_14");
      }
	  else if(frmSize == '20x24'){
		  //alert("njdfhsjk");
      	$("#outerDiv").addClass("full_frm_framing20_24");
		$("#outer_div").addClass("full_frm_framing20_24");
      }
	  else if(frmSize == '20x30'){
		  //alert("njdfhsjk");
      	$("#outerDiv").addClass("full_frm_framing20_30");
		$("#outer_div").addClass("full_frm_framing20_30");
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

    };

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
	var tlPrice				= $("#dig_total").val();
	
	
	$("#inp_total_price").val(tlPrice);
	
			//alert("haribol");
	$("div#canvasFrame  div:eq(0)").removeClass().addClass('full_frm_framing '+frameClass);

    $("#framePrice").val(framePrice);
	$("#frameName").val(frameClass);
	$("#frm_price").html(framePrice);
    var finalPrice 			= totalPrice();
	
      $.ajax({
        url: _basePath+"Favourite/cngFrame/",
        data: {frame_name: frameClass, frame_price: framePrice, final_price: finalPrice},
        type: 'POST', 
		//**********sreela(05/04/18)*********
		dataType: "JSON",	
        success: function(response) {	
		if(response['frame_name'] != ""){
			
		//var print_price	= $("#inp_print_price").val();
		var	tPrice		=	$("#inp_total_price").val();
		var total_price	= parseInt(tPrice) +  parseInt(framePrice);
		// alert(print_price +"@@@@"+tprice);
		  $("#lb_frame").html("Frame");
		  $("#inp_total_price").val(total_price);
		  $("#total_price_frm").html(total_price);		 
          $(".frameName").html(response['frame_name']);
		  //$("#frame_name").val(response['frame_name']);
		  $("#confirmbttn").show();
		}
		//**********END*********
        },
      });
})
$(document).on("click", "#confirmPrintbttn", function() {
		$("#myOverlay").show();
		$("#loadingGIF").show();
		html2canvas($("#canvasPrint"), {
		onrendered: function(canvas) {
		//Canvas2Image.saveAsPNG(canvas);
		$("#img-out").append(canvas);
		var imgageData = canvas.toDataURL('image/png');
		var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
		//console.log(newData);
		$('#img_val').val(newData);
		//Submit the form manually
		var qty 			= $("#qty_print").val();
		//alert(qty);
		var imgVal 			= $("#img_val").val();			
		var imgId 			= $("#img_id").val();
		var imgName			= $("#imge_name").val();
		//alert(imgId+'###'+imgName);
		$.ajax({
			type:"POST",
			url:_basePath+'CartAdd/frmarrayMake',
			dataType: "json",
			data:
			{
				ops_type:'print',img_val:imgVal,img_id:imgId,img_name:imgName,qnty:qty
			},
			success:function(response)
			{
				$("#myOverlay").hide();
				$("#loadingGIF").hide();
				$('#total_img_cnt').val(response['frmset_count']);
				if(response['msg'] =='disabled'){
					
					$("#imgDIV_"+imgId).hide();
					$("#inp_total_price").val(totalPrice);
					$("#total_price").html(totalPrice);
					$("#confirmbttn").hide();
				}
				else if(response['msg'] ==''){
					
					$("#selected_img").hide();					
					$("#inp_total_price").val(totalPrice);
					$("#total_price").html(totalPrice);
					$("#confirmPrintbttn").hide();
					$("#place_order_print").show();
				}
			},
			
		});
	  }
	});	

});
$(document).on("click", "#confirmbttn", function() {
	$("#myOverlay").show();
	$("#loadingGIF").show();	
	html2canvas($("#canvasFrame"), {
	onrendered: function(canvas) {
	//Canvas2Image.saveAsPNG(canvas);
	$("#img-out").append(canvas);
	var imgageData = canvas.toDataURL('image/png');
	var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
	//console.log(newData);
	$('#img_val').val(newData);
	//Submit the form manually
	var qty 			= $("#qty_frame").val();
	//alert(qty);
	var frmprice		= $("#framePrice").val(); 
	var frmname 		= $("#frameName").val(); 
	var totalPrice 		= $("#inp_total_price").val();
	var imgVal 			= $("#img_val").val();			
	var imgId 			= $("#img_id").val();
	var imgName			= $("#imge_name").val();
	//alert(imgId);
	$.ajax({
		type:"POST",
		url:_basePath+'CartAdd/frmarrayMake',
		dataType: "json",
		data:
		{
			ops_type:'frame',frm_name:frmname,frm_price:frmprice,total_price:totalPrice,img_val:imgVal,img_id:imgId,img_name:imgName,qnty:qty
		},
		success:function(response)
		{
			$("#myOverlay").hide();
			$("#loadingGIF").hide();
			$('#total_img_cnt').val(response['frmset_count']);
			if(response['msg'] =='disabled'){
				//alert(imgId);
				$("#imgDIV_"+imgId).hide();
				$("#inp_total_price").val(totalPrice);
				$("#total_price").html(totalPrice);
				$("#confirmbttn").hide();
			}
			else if(response['msg'] ==''){
				
				$("#selected_img").hide();					
				$("#option_frame").hide();
				$("#inp_total_price").val(totalPrice);
				$("#total_price").html(totalPrice);
				$("#confirmbttn").hide();
				$("#place_order_bttn").show();
			}
		},
		
	});
  }
});	

});
$(document).on("click", "#confirmbttnCollage", function() {
	$("#myOverlay").show();
	$("#loadingGIF").show();
	html2canvas($("#canvasFrameCollg"), {
	onrendered: function(canvas) {
	//Canvas2Image.saveAsPNG(canvas);
	$("#img-out").append(canvas);
	var imgageData = canvas.toDataURL('image/png');
	var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
	//console.log(newData);
	$('#img_val_colag').val(newData);
	//alert(newData);
	//Submit the form manually
	var qty 				= $("#qty_collage").val();
	//alert(qty);
	var collagePrice		= $("#collage_price").val(); 			 			
	var imgName				= $("#imge_name").val();
	var totalPrice 			= $("#inp_total_price_collg").val();
	var imgVal 				= $("#img_val_colag").val();
	var tmpcolgimgId		= $("#colg_img_id").val(); 
	if(tmpcolgimgId.charAt(0) == ','){
	var colgimgId			= tmpcolgimgId.substring(1);
	}
	else{
		var colgimgId		= $("#colg_img_id").val();				
	}
	var tmpcolgimgName		= $("#colg_img_name").val(); 
	if(tmpcolgimgName.charAt(0) == ','){
		var colgimgName			= tmpcolgimgName.substring(1);
	}
	else{
		var colgimgName			= $("#colg_img_name").val(); 
		
	}
	var imgId 				= $("#img_id").val();			
	var imgRootPath    	 	= _basePath+"assets/images/collage/";
	var imgPath         	= imgRootPath+"noimage.png";			
	var tmp_colgImgId       = colgimgId.split(",");
	var tmp_colgImgName     = colgimgName.split(",");			
	var colgname 			= $("#collage_frame_name").val();
	var frmName 			= $("#matteframeName").val();
	var noElement			= tmp_colgImgId.length;
	var frmPrice			= $("#matteframePrice").val();	
	//alert(colgname);
	if(colgname =='5x7 blue matte' || colgname == '5x7 green matte'){				
		if(noElement != 2){
			
			alert("Please select image for all the collage section.");
			$("#confirmbttnCollage").prop("disabled",true);
		}
		else{
			
			$.ajax({
				type:"POST",
				url:_basePath+'CartAdd/frmarrayMake',
				dataType: "json",
				data:
				{
					ops_type:'collage',frm_name:frmName,colg_name:colgname,frm_price:frmPrice,colg_price:collagePrice,total_price:totalPrice,img_val:imgVal,img_id:colgimgId,img_name:tmp_colgImgName,qnty:qty
				},
				success:function(response)
				{
					//alert(imgId);
					//alert(response['msg']);
					$("#myOverlay").hide();
					$("#loadingGIF").hide();
					$('#total_img_cnt').val(response['frmset_count']);
					
					if(response['msg'] =='disabled'){
						
						//alert(colgimgId);
						var arr 			=	colgimgId.split(",");								
						var frmset_count	=   arr.length;
						//alert(frmset_count);
						var i ;
						for(i = '0';i< frmset_count;i++){
							
						$("#imgDIV_"+arr[i]).hide();
						}
						if((colgname == '5x7 green matte') || (colgname == '5x7 blue matte')){						
						
							$("#confirmbttnCollage").prop('disabled', true);
						}
						
						$("#colg_img_id").val(''); 
						$("#inp_total_price_collg").val(totalPrice);
						$("#total_price").html(totalPrice);						
						
					}
					else if(response['msg'] ==''){
						
						var arr 			=	colgimgId.split(",");								
						var frmset_count	=   arr.length;
						//alert(frmset_count);
						/*var i ;
						for(i = '0';i< frmset_count;i++){
							
						$("#imgDIV_"+arr[i]).hide();
						}*/
						$("#selected_img").hide();					
						$("#collage_matteoption").hide();
						if((colgname == '5x7 green matte') || (colgname == '5x7 blue matte')){						
						
							$("#confirmbttnCollage").prop('disabled', true);
						}
						$("#selected_img").hide();
						$("#confirmbttnCollage").hide();
						$("#place_order_collg_bttn").show();
					}
				},
				
			});
			
		}
	}
	else if(colgname =='package green matte' || colgname == 'package blue matte' || colgname == 'package black matte' || colgname =='series blue matte' || colgname =='series green matte' || colgname =='series black matte' ){
		//alert(noElement);
		if(noElement != 5){
			
			alert("Please select image for all the collage section.");
			$("#confirmbttnCollage").prop("disabled",true);
		}
		else{
			
			$.ajax({
				type:"POST",
				url:_basePath+'CartAdd/frmarrayMake',
				dataType: "json",
				data:
				{
					ops_type:'collage',frm_name:frmName,colg_name:colgname,frm_price:frmPrice,colg_price:collagePrice,total_price:totalPrice,img_val:imgVal,img_id:colgimgId,img_name:tmp_colgImgName,qnty:qty
				},
				success:function(response)
				{
					//alert(imgId);
					//alert(response['msg']);
					$("#myOverlay").hide();
					$("#loadingGIF").hide();
					$('#total_img_cnt').val(response['frmset_count']);
					if(response['msg'] =='disabled'){
						
						//alert(colgimgId);
						var arr 			=	colgimgId.split(",");								
						var frmset_count	=   arr.length;
						//alert(frmset_count);
						var i ;
						for(i = '0';i< frmset_count;i++){
							
						$("#imgDIV_"+arr[i]).hide();
						}
											
						$("#colg_img_id").val(''); 
						$("#inp_total_price_collg").val(totalPrice);
						$("#total_price").html(totalPrice);						
						
					}
					else if(response['msg'] ==''){
						
						var arr 			=	colgimgId.split(",");								
						var frmset_count	=   arr.length;
						//alert(frmset_count);
						/*var i ;
						for(i = '0';i< frmset_count;i++){
							
						$("#imgDIV_"+arr[i]).hide();
						}*/
						$("#selected_img").hide();					
						$("#collage_matteoption").hide();						
						$("#confirmbttnCollage").hide();
						$("#place_order_collg_bttn").show();
					}
				},
				
			});
			
		}
		
	}
	
  }
});	

});
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
	
	$("#collage_price").val(framePrice);	  
	
	$("#collage_frame_name").val(frameClass);
	$("#imgPrice").val('');
	$("#eventID").val('');
	$("#mediaID").val('');  
	//$("div.fix_we div:eq(0)").removeClass().addClass('full_frame '+frameClass);
	
	$("#outerDivCollage").removeClass().addClass('full_frame '+frameClass);
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
$(document).on("click", ".frame_collage", function() {
	var collage_name = $("#collage_frame_name").val();
	if(collage_name == '5x7 blue matte' || collage_name == '5x7 green matte'){
		
		$("#collg_frame_P_blk_engraved").show();
		$("#collg_frame_blk_engraved").hide();
		$("#collg_frame_blk_engraved_better").hide();		
		$("#collg_frame_blk_metal").hide();
		$("#collg_frame_cedar").hide();
		$("#collg_frame_barnwwod").hide();
	}
	else if(collage_name == 'package black matte' || collage_name == 'package blue matte' || collage_name == 'package green matte'){
		
		$("#collg_frame_P_blk_engraved").hide();
		$("#collg_frame_blk_engraved").hide();		
		$("#collg_frame_blk_engraved_better").show();
		$("#collg_frame_blk_metal").show();
		$("#collg_frame_cedar").show();		
		$("#collg_frame_barnwwod").show();
		
		
	}
	else if(collage_name == 'series blue matte' || collage_name == 'series black matte' || collage_name == 'series green matte'){
		
		$("#collg_frame_blk_engraved_better").hide();
		$("#collg_frame_blk_metal").hide();
		$("#collg_frame_cedar").hide();
		$("#collg_frame_barnwwod").hide();
		$("#collg_frame_P_blk_engraved").hide();
		$("#collg_frame_blk_engraved").show();
	}
	else{
		
		alert("no option");
	}
});
$(window).load(function() {
	var opt_name			= $("#outerDivCollage").attr('class');
	var collg_opt_name	= opt_name.split(" ");
	if(collg_opt_name[1] == 'blue_matte'){		
		$("#collg_frame_P_blk_engraved").show();
		$("#collg_frame_blk_engraved").hide();
		$("#collg_frame_blk_engraved_better").hide();		
		$("#collg_frame_blk_metal").hide();
		$("#collg_frame_cedar").hide();
		$("#collg_frame_barnwwod").hide();
	}
	else if(collg_opt_name[1] == 'series_blue_matte'){
		$("#collg_frame_blk_engraved_better").hide();
		$("#collg_frame_blk_metal").hide();
		$("#collg_frame_cedar").hide();
		$("#collg_frame_barnwwod").hide();
		$("#collg_frame_P_blk_engraved").hide();
		$("#collg_frame_blk_engraved").show();
	}
	else if(collg_opt_name[1] == 'package_black_matte'){
		$("#collg_frame_P_blk_engraved").hide();
		$("#collg_frame_blk_engraved").hide();		
		$("#collg_frame_blk_engraved_better").show();
		$("#collg_frame_blk_metal").show();
		$("#collg_frame_cedar").show();		
		$("#collg_frame_barnwwod").show();
	}
});
$(document).on("click", "ul.matte_frame li", function() {  
	
	var frameClass 			= $(this).attr('rel');
  	var framePrice    		= $("#"+frameClass).val();	
	var tlPrice				= $("#dig_total").val();
	$("#inp_total_price").val(tlPrice);
	$("div#canvasFrameCollg  div:eq(0)").removeClass().addClass('full_frm_framing '+frameClass);
	$("div#canvasFrameCollg").removeClass().addClass('leftpanel fix_we '+frameClass);
	$("div#collageframe").children('div:eq(1)').addClass(frameClass);
    $("#matteframePrice").val(framePrice);
	$("#matteframeName").val(frameClass);
	var mattefrme_name	= frameClass.replace(/_/g,' ');
	$("#mattefrm_price").html(framePrice);   
	$("#lb_matteframe").html("Frame ");
	$(".matteframeName").html(mattefrme_name);
    
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
		
		var colg_imgId				= $("#colg_img_id").val();
		if(colg_imgId.charAt(0) == ','){
			var tmp_colg_imgId			= colg_imgId.substring(1);
		}		
		var tmp_colgImgId           = tmp_colg_imgId.split(",");
		var tmpColgImgId 			= tmp_colgImgId.indexOf(mediaID);
		tmp_colgImgId.splice(tmpColgImgId, 1);
		var colg_imgName				= $("#colg_img_name").val();
		if(colg_imgName.charAt(0) == ','){
			var tmp_colg_imgName	= colg_imgName.substring(1);
		}		
		var tmp_colgImgName         = tmp_colg_imgName.split(",");
		var tmpColgImgName			= tmp_colgImgName.indexOf(mediaID);
		tmp_colgImgName.splice(tmpColgImgName, 1);
		
		var noElement				= tmp_colgImgId.length;
		
		if(noElement > 1){
			
			var colgImgId 			= tmp_colgImgId.join(',');
			var colgImgName			= tmp_colgImgName.join(',');
			$("#colg_img_id").val(colgImgId);
			$("#colg_img_name").val(colgImgName);
			
		}
		else{
			
			$("#colg_img_id").val(tmp_colgImgId[0]);
			$("#colg_img_name").val(tmp_colgImgName[0]);
			$("#confirmbttnCollage").prop("disabled",false);
		}
  		var url               		= $(this).parent('div').children('img').attr('src');
	    var parts             		= url.split("/");
	    var last_part         		= parts[parts.length-1];
		//alert(mediaID);
		$("#imgDIV_"+mediaID).show();
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
	var imgPriceArr           	= $("#imgPrice").val().split(',');
  	var imgPrice 				= 0;
	for (var i = 0; i < imgPriceArr.length; i++) {
    	imgPrice 				+= imgPriceArr[i] << 0;
	}  
  	var framePrice            	= $("#collageFramePrice").val();  
 
  	var totalPrice            	= parseFloat(imgPrice)+parseFloat(framePrice);
  	var finalPrice            	= parseFloat(totalPrice).toFixed(2);
  
  	$(".totalPrice").html("$"+finalPrice);
  	return finalPrice;
} 