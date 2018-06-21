<div class="contwrap">

<div class="container-fluid">

<div class="wrap forgotpass_page">

<div class="row">



<h1 class="ttl">Forgot Password</h1>

<?php

	

	if ($succmsg != "") {

		?>

		<div class="alert alert-success"><?php echo $succmsg; ?></div>

		<?php

	}

	?>

	<?php



	if ($errmsg != "") {

		?>

		<div class="alert alert-danger"><?php echo $errmsg; ?></div>

		<?php

	}

?>

<div class="login_userform forgotpass">

<form name="frmforgotpassword" id="frmforgotpassword" action="<?php echo base_url(); ?>login/chkforgotpassword/" method="post">

<label>Email ID</label>

<input name="userId" id="userId" type="text" placeholder="enter your email ID" required/>

<input name="" type="submit" value="Submit" />

</form>

<br class="clr" /></div>

<br class="clr" />

</div>

</div>

</div></div>