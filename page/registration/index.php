<?php require("../../const.php"); ?>
<?php require(SITE_URL . "init.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php getHead("Joining"); ?>
</head>
<body>
	<div class="wrapper">
	<?php getHeader(); ?>
		<div class="row"></div>
		<div class="warning-container container text-center">
			<div class="warning"><p>Alert!</p></div>	
		</div>
		<div class="container registration-form">
			<div class="row">
				<div class="registration text-center registration-header-container">
					<h2>Registration</h2>
					<p>Please, fill in all the fields, and click to "Ready"</p>
				</div>
			</div>
			<div class="row">
				<div class="registration text-center registration-login-container">
					<input required = "required" type="text" name = "login-field" placeholder = "Your Nickname">
				</div>
			</div>
			<div class="row">
				<div class="registration text-center registration-password-container">
					<input required = "required" type="password" name = "input-password" placeholder="Your password">
					<input required = "required" type="password" name = "repeat-password" placeholder="Repeat your password">
				</div>
			</div>
			<div class="row">
				<div class="registration text-center registration-user-info-container">
					<input required = "required" type="text" name="user-name" placeholder = "Your real name">
					<input required = "required" type="text" name="user-second-name" placeholder = "Your real second name">
					<input required = "required" type="text" name="user-email" placeholder = "Your E-mail">
				</div>
			</div>
			<div class="row">
				<div class="registration text-center registration-submit">
					<button class = "btn btn-lg btn-success submit-button">Ready</button>
				</div>
			</div>
		</div>
		<?php getFooter(); ?>
	</div>
</body>
</html>