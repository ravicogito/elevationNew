<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<div class="contwrap">
<div class="container-fluid">
<div class="wrap">
<div class="row">

<div class="col-md-12 full imgtop bdrsdo clearfix">
<img src="<?php echo base_url();?>uploads/bannerImg/<?php if(!empty($banner_info)){ echo $banner_info['banner_image'];}?> " width="1226" height="500">
<div class="col-md-5 rgt col-md-pull-1">
  <!--<h1 class="mntil"><span><span>Ski</span> Photography</span>
About elevation</h1>-->
<h1 class="mntil"><?php if(!empty($banner_info)){ echo $banner_info['banner_title']; } ?></h1>
<p><?php if(!empty($banner_info)){ echo $banner_info['banner_content']; } ?>
</p>
</div>
</div>


<div class="col-md-12 full">
<?php if(!empty($page_content)){ echo $page_content['sub_heading']; }?>
</div>


<div class="aboutcont clearfix">

<?php if(!empty($page_content)){ echo $page_content['page_description']; }?>

</div>

<?php if(!empty($questionlist)){ ?>
	
<div class="faqcont">


	<?php foreach($questionlist as $key => $list){ ?>
    <div class="col-md-12 full fqa">
<h3><span><?php echo $key+1; ?>.</span> <?php echo $list->faq_question; ?>  <div class="sign"><span class="movsid"></span><span class="movpls"></span></div></h3>
<div class="accorcont"><?php echo $list->faq_answer; ?>
</div>
</div>	
<?php } ?>

</div>
<?php } ?>


<?php if(!empty($questionlistpolicy)){ ?>
	
<div class="faqcont">


	<?php foreach($questionlistpolicy as $key => $list){ ?>
    <div class="col-md-12 full fqa">
<h3><span><?php echo $key+1; ?>.</span> <?php echo $list->policy_question; ?>  <div class="sign"><span class="movsid"></span><span class="movpls"></span></div></h3>
<div class="accorcont"><?php echo $list->policy_answer; ?>
</div>
</div>
	<?php } ?>

</div>
<?php } ?>
<!--<div class="col-md-12 full">
<h2 class="mntil"><span>Ski Photography</span>
Gallery</h2>
</div>


<div class="slidera clearfix">

<div class="carousel">
<figure><a href="images/about5.png" rel="prettyPhoto[gal1]"><img src="images/about5.png" width="370" height="296"></a>
<figcaption><span>Photography By:</span> Thomas Johnson</figcaption></figure>

<figure><a href="images/about5.png" rel="prettyPhoto[gal1]"><img src="images/about5.png" width="370" height="296"></a>
<figcaption><span>Photography By:</span> Thomas Johnson</figcaption></figure>

<figure><a href="images/about5.png" rel="prettyPhoto[gal1]"><img src="images/about5.png" width="370" height="296"></a>
<figcaption><span>Photography By:</span> Thomas Johnson</figcaption></figure>

<figure><a href="images/about5.png" rel="prettyPhoto[gal1]"><img src="images/about5.png" width="370" height="296"></a>
<figcaption><span>Photography By:</span> Thomas Johnson</figcaption></figure>

<figure><a href="images/about5.png" rel="prettyPhoto[gal1]"><img src="images/about5.png" width="370" height="296"></a>
<figcaption><span>Photography By:</span> Thomas Johnson</figcaption></figure>

<figure><a href="images/about5.png" rel="prettyPhoto[gal1]"><img src="images/about5.png" width="370" height="296"></a>
<figcaption><span>Photography By:</span> Thomas Johnson</figcaption></figure>

</div>
<a class="prev" href="#"></a>
		<a class="next" href="#"></a>
</div>-->







</div>



</div>
</div>

</div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.carouFredSel-6.0.4-packed.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
        
<script>
$(document).ready(function(e) {
	$("a[rel^='prettyPhoto']").prettyPhoto({theme:'light_square',slideshow:100, autoplay_slideshow: false, animation_speed: 'fast',
	image_markup: '<img id="fullResImage" src="{path}" /><span class="download-btn"></span>',
	changepicturecallback: function () {
		$('.pp_pic_holder').addClass('listng');
       var id = $(".pp_details .pp_description .pictureId").html();
	   $('.download-btn').append(id);

        }   
	
	});
	
});
$(document).ready(function(e) {
	
	$('.fqa h3').click(function(){
		$(this).find('.sign').toggleClass('oppn');
		$(this).next().slideToggle('slow');
	});
	
	
	$(".inline[rel^='prettyPhoto']").prettyPhoto({theme:'light_square', default_width: 400,
	changepicturecallback: function () {
		$('.pp_pic_holder').addClass('inline');
		$(".frm_dve input").val("");
		$(".input-effect input").focusout(function(){
			if($(this).val() != ""){
				$(this).addClass("has-content");
			}else{
				$(this).removeClass("has-content");
			}
		})
		$(".frm_dve textarea").val("");
		$(".input-effect textarea").focusout(function(){
			if($(this).val() != ""){
				$(this).addClass("has-content");
			}else{
				$(this).removeClass("has-content");
			}
		})			
        }
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
});



$(function() {

				//	create carousel
				$('.carousel').carouFredSel({
					responsive: true,
					items: {
						width: 237,
						height: '100%',
						visible: 4
					},
					auto: {
						duration: 550,
						timeoutDuration: 2500
					},
scroll  : {
    items   : 1,
    pauseOnHover    : true,
    duration    : 100
},
					prev    : {
    button  : function(){
        return $(this).parents('.albumrow ').find('.prev');
    },
    key     : "left"
},
next    : {
    button  : function(){
        return $(this).parents('.albumrow').find('.next');
    },
    key     : "right"
}
				});

				//	re-position the carousel, vertically centered
				//var $elems = $('.slidera'),/*, .prev, .next*/
					$image = $('.carousel figure:first')

				$(window).bind( 'resize.example', function() {
					var height = $image.outerHeight( true );

					$elems
						.height( height )
						.css( 'marginTop', -( height/2 ) );

				}).trigger( 'resize.example' );

			});


</script>