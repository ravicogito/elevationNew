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
<h3><div class="sign"><span class="movsid"></span><span class="movpls"></span></div><span><?php echo $key+1; ?>.</span> <?php echo $list->faq_question; ?>  </h3>
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
<h3><div class="sign"><span class="movsid"></span><span class="movpls"></span></div><span><?php echo $key+1; ?>.</span> <?php echo $list->policy_question; ?>  </h3>
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


        
