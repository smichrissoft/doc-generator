<?php require("../../const.php"); ?>
<?php require(SITE_URL . "init.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php getHead("Remind password"); ?>
</head>
<body>
<div class="wrapper">
	<?php getHeader(); ?>
	<div class="row"></div>
	<div class="warning-container container text-center">
		<div class="warning"><p>Alert!</p></div>	
	</div>
	<div class="container registration-form">
		<div class="registration text-center registration-header-container">
			<h2>We remind you your password</h2>
			<p>Please, fill in all the fields, and click to "Send"</p>
		</div>
		<div class="registration text-center registration-login-container">
			<input required = "required" type="text" name = "remind-username-field" placeholder = "Your Nickname">
		</div>
		<div class="registration text-center registration-password-container">
			<input required = "required" type="password" name = "remind-input-password" placeholder="Your new password">
			<input required = "required" type="password" name = "remind-repeat-password" placeholder="Repeat your password">
		</div>
		<div class="registration text-center registration-submit">
			<button class = "btn btn-lg btn-success remind-submit-button">Send</button>
		</div>
	</div>
		<?php getFooter(); ?>
</div>
</body>
</html>