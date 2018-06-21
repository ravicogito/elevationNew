//Javascript
$(document).ready(function() {
	$("#datepicker").datepicker({dateFormat:"dd/mm/yy"});

	$(".imgDetails").on("click", function(event) {
      event.preventDefault();
      var imgSrc                = $(this).children('img').attr('src'); 

      $("#sanjay").attr('src', imgSrc)
    });

    $(".p2a_mto_ulsizeoptions li").on('click', function() {
      var frmSize               = $(this).attr('sizeid');
      var widthArr              = frmSize.split("x");
      var width                 = (50-widthArr[0]);
      var disText 				= $(this).text();
      //$(".full_frm").removeClass('small').addClass(frmSize);
      
      var curObj 			= $("div.fix_we div:eq(0)");
      var objClass 			= curObj.attr('id');
//alert("hi - "+objClass);
      //var widthTest = width+"px "+width+'px #423934';
      $("#outerDiv").css("border-width", width+"px");
      //$("#outerDiv").css("box-shadow", widthTest);
      
      $(".p2a_mto_ulsizeoptions").slideUp("slow", function() {
      	$(".listdiv")[0].childNodes[0].nodeValue = disText;
      });      
      
    });

    $(".listdiv").on("click", function() {
    	if($(".p2a_mto_ulsizeoptions").is(':visible')) {
    		$(".p2a_mto_ulsizeoptions").slideUp("slow");
    	} else {
    		$(".p2a_mto_ulsizeoptions").slideDown("slow");
    	}
    	
    })

    $(".option").on("click", function() {
      var optionID        = $(this).attr('id');
      $.ajax({
        url: _basePath+"Favourite/getOptionDetails/",
        data: {option_id: optionID},
        type: 'POST',
        dataType: "JSON",
        success: function(responce) {
          $.each( response, function( key, value ) {
			 alert(response.option_size);
		  }
        }
      })
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

    $("ul.frame li").on("click", function() {
    	var newClass 			= $(this).attr('rel');
    	if($("div.fix_we div:eq(0)").hasClass('full_frm_framing')) {
    			$("div.fix_we div:eq(0)").removeClass().addClass('full_frm_framing '+newClass);
    		} 
    })

    $("ul.topmat li").on("click", function() {
    	var newClass 			= $(this).attr('rel');
    	$("div.fix_we div:eq(1)").removeClass().addClass(newClass);
    	
    })

    $("ul.midmat li").on("click", function() {
    	var newClass 			= $(this).attr('rel');
    	$("div.fix_we div:eq(2)").removeClass().addClass(newClass);
    	
    })

})