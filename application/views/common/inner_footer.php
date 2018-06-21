<footer id="mainfoot">  
<div class="wrap">
<div class="row">
 
<nav id="footnav">
<ul>
<li><a href="<?php echo base_url();?>">home</a></li>          
<li><a href="<?php echo base_url();?>content/page/about-us">about us</a></li>          
<li><a href="<?php echo base_url();?>content/page/faq">faq</a></li>          
<li><a href="<?php echo base_url();?>content/page/privacy-policy">privacy policy</a></li>            
<!--<li><a href="<?php echo base_url();?>Home/gallery">GALLERY</a></li>-->
</ul>
</nav>


<div class="socil">
<a href="https://www.facebook.com/" class="fb">fb</a>
<a href="https://twitter.com/" class="tw">tw</a>
<a href="https://www.linkedin.com/" class="in">in</a>
<a href="https://www.pinterest.com/" class="pn">pn</a>
<a href="https://www.instagram.com/" class="ins">ins</a>
</div>

<div class="copy">Copyright © 2017 Elevation, All Right Reserved.</div>

</div>
</div>
</footer>


<script src="<?php echo base_url(); ?>assets/js/jquery.carouFredSel-6.0.4-packed.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/prettyPhoto.css" type="text/css" media="screen"  />

		<script src="<?php echo base_url(); ?>assets/js/jquery.prettyPhoto-listing.js" type="text/javascript" charset="utf-8"></script>
<script>
$(window).load(function() {
	
		/*$("a[rel^='prettyPhoto']").hover(function(){

        // Get the current title
        var title = $(this).attr("title");

        // Store it in a temporary attribute
        $(this).attr("tmp_title", title);

        // Set the title to nothing so we don't see the tooltips
        $(this).attr("title","");
        
    },
	
	
	);*/
	
	
	
	$("a[rel^='prettyPhoto']").hover(function(){

        // Get the current title
        var title = $(this).attr("title");

        // Store it in a temporary attribute
        $(this).attr("tmp_title", title);

        // Set the title to nothing so we don't see the tooltips
        $(this).attr("title","");
        
    });

  $("a[rel^='prettyPhoto']").click(function(){// Fired when we leave the element

        // Retrieve the title from the temporary attribute
        var title = $(this).attr("tmp_title");

        // Return the title to what it was
        $(this).attr("title", title);
        
    });
	
	
	

	
	
	
	/*$(".zoom").click(function(e) {
		e.preventDefault();
		//$("a[rel^='prettyPhoto']:first").click();
		var rrel = $(this).parent().attr('id');
		//alert(rrel);
   $("#" + rrel + " " +  "a[rel^='prettyPhoto']:first").click();
 // $(this).before().find("a[rel^='prettyPhoto']:first").click();
});*/


$('.navicn').click(function(){
        $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').toggleClass('open');
		$(this).next().slideToggle();
    });


/*if($('.navbar ul > li').find("ul").length){
	$(this).addClass('submenu');
}*/

$('.navbar ul > li').hover( function(){
	$(this).find('ul').stop().slideDown('slow');
},function(){
	$(this).find('ul').stop().slideUp('slow');
});



	$('.tabfulcont:nth-child(1)').show('slow');
		$('.tabeffect:nth-child(1)').addClass('activ');
    $('.tabeffect').click( function(){
		$('.tabfulcont').hide('slow');
		$('.tabeffect').removeClass('activ');
		$(this).addClass('activ');
		var idd = $(this).attr('data-id');
		$('#'+idd).show('slow');
		
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






				//	create carousel
				$('.carousel').carouFredSel({
					responsive: true,
					items: {
						width: 825,
						height: '60%',
						visible: 1
					},
					auto: {
						duration: 550,
						timeoutDuration: 2500
					},
scroll  : {
    items   : 1,
    pauseOnHover    : true,
    duration    : 100,
	fx : "crossfade" 
},
					prev    : {
    button  : function(){
        return $(this).parents('.slider').find('.prev');
    },
    key     : "left"
},
next    : {
    button  : function(){
        return $(this).parents('.slider').find('.next');
    },
    key     : "right"
}
				});

				//	re-position the carousel, vertically centered
				var $elems = $('.wrapper'),/*, .prev, .next*/
					$image = $('.carousel a:first')

				$(window).bind( 'resize.example', function() {
					var height = $image.outerHeight( true );

					$elems
						.height( height )
						.css( 'marginTop', -( height/2 ) );

				}).trigger( 'resize.example' );

			
			
			$("a[rel^='prettyPhoto']").prettyPhoto({theme:'light_square', deeplinking:false, slideshow:0, autoplay_slideshow: false, animation_speed: 'fast',default_height: 447,
	image_markup: '<div class="mxhgt"><img id="fullResImage" src="{path}" /></div><span class="download-btn"></span>',
	changepicturecallback: function () {
		$('.pp_pic_holder').addClass('listng');
       var id = $(".pp_details .pp_description .pictureId").html();
	   $('.download-btn').append(id);

        }  ,
		 callback: function() {window.location;}  
	
	});	
			
			
			
			
			});
	
function selectCountry(val,lid) {
		$("#searchinput_box").val(val);
		
		$("#location_id").val(lid);
		$("#suggesstion-box").hide();
	}	




</script>


</div>
</body>
</html>