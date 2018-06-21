//CK EDITOR ******************************************

 $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
   
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()

   
  })


// Page Adding Js******************************
$(document).on("click", "#btnPageSubmit", function(){

	//alert('hi');
	 
	var pagetitle = $("#ptitle").val();
	var content = CKEDITOR.instances.editor1.getData();
	//alert(pagetitle);
	

	$.ajax({

			url:"<?php echo base_url(); ?>"+'/Page/addPage/',
			data:{pagetitle:pagetitle, pagedesc:content},
			type:'POST',
			contentType: "text/plain; charset=utf-8",
			success: function(data){

				alert(data);

			},
			error:function(data){

				alert()

			}



	});

})