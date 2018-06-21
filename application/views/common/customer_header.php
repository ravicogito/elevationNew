<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!empty($contentTitle)){ echo $contentTitle; } ?> </title>
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<body class="backimg">
<div class="topclor"></div>
<header id="mainhead">
<div class="wrap">
<div class="row"><a href="" class="logo col-md-2"><img src="<?php echo base_url(); ?>assets/images/logo.png" ></a> 
<nav id="mainnav"  class="col-md-8">
<ul>
<li><a href="<?php echo base_url();?>">HOME</a></li>          
<li><a href="<?php echo base_url();?>content/page/about-us">ABOUT US</a></li>          
<li><a href="<?php echo base_url();?>content/page/faq">FAQ</a></li>          
<li><a href="<?php echo base_url();?>content/page/privacy-policy">PRIVACY POLICY</a></li>
</ul>
</nav>
<div class="usersec col-md-2"><a href="<?php echo base_url();?>Login/logout" rel="prettyPhoto" class="inline"><span class="icon"></span>Logout</a>  <a href=""><span class="icon"></span>3item(s)</a></div></div>
</div>

<div class="clearfix"></div>
</header>
<!--header section end-->

<!--body section-->