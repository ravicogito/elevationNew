$(document).ready(function() {
	
});

function getDigitalPackage(cntimg,prcimg){
	//alert(cntimg+'SSSSSUUUU'+prcimg);
	var favcnt = $('#photo_no').html();
	//alert('favcnt'+favcnt);
	var toteventImg = $('.totalevntimg').val();
	//alert('TotalEventImg'+toteventImg);
    
    if(favcnt> 0){
    	if(parseInt(cntimg) == 1){
		    if(parseInt(cntimg) != parseInt(favcnt)){
		      //alert('Please add '+cntimg+ ' image in the favourite list of this guide.');
		      alert('The favourite list image should be '+cntimg+' of this guide.');
		      return false;
		    }else{
		      //alert('Ok 1');
		      $('.countdg_img').val(cntimg);
		      $('.dgimg_price').val(prcimg);
		      $('.alimges').html('<h4>'+cntimg+' Image Package <span>Download of '+cntimg+' image for that boat</span></h4><strong>$'+prcimg+'</strong>');
		      $('.digital_allimgpackage').hide();
			  $('#formdigital_series').hide();
			  $('#formdigital_package').hide();
			  $('.checkboxClass').attr('disabled','disabled');
			  $('.digital_process').show();
		    }
	    }

	    if(parseInt(cntimg) == 5){
		    if(parseInt(cntimg) != parseInt(favcnt)){
		     //alert('Please add '+cntimg+ ' images in the favourite list of this guide.');
		     alert('The favourite list image should be '+cntimg+' of this guide.');
		     return false;
		    }else{
		      //alert('Ok 5')
		      $('.countdg_img').val(cntimg);
		      $('.dgimg_price').val(prcimg);
		      $('.alimges').html('<h4>'+cntimg+' Image Package <span>Download of '+cntimg+' image for that boat</span></h4><strong>$'+prcimg+'</strong>');
		      $('.digital_allimgpackage').hide();
			  $('.checkboxClass').attr('disabled','disabled');
			 // $(".checkboxClass").removeAttr('disabled');
		      $('.digital_process').show();
		    }
	    }

	    if(cntimg == 'all'){
	    	if(parseInt(toteventImg) != parseInt(favcnt)) {
		       alert('Please add all images in the favourite list of this guide.');
		       return false;
		    }else{
		      //alert('Ok All');
		      $('.countdg_img').val(toteventImg);
		      $('.dgimg_price').val(prcimg);
		      $('.alimges').html('<h4>All Images Package <span>Download of all images for that boat</span></h4><strong>$'+prcimg+'</strong>');
		      $('.digital_allimgpackage').hide();
			  $('.checkboxClass').attr('disabled','disabled');
			  //$(".checkboxClass").removeAttr('disabled');
		      $('.digital_process').show();
	        }
	    }

   }else{
   	    alert('Please select boat image in the favourite list.');
	    return false;
   }
}