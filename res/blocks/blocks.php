<?php 
//Получаем Head
function getHead($title)
{
	echo '		
<meta charset="UTF-8">
<link rel="stylesheet" href="'.REL_URL.'res/lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="'.REL_URL.'res/lib/bootstrap/fonts/glyphicons-halflings-regular.ttf">
<link rel="stylesheet" href="'.REL_URL.'res/lib/animate-css/animate.css">
<link rel = "stylesheet" href="'.REL_URL.'res/css/big.css">
<script src="'.REL_URL.'res/js/getURL.js"></script>
<script src="'.REL_URL.'res/lib/jquery/jquery-2.1.4.min.js"></script>
<script src="'.REL_URL.'res/lib/parallax/parallax.min.js"></script>
<script src="'.REL_URL.'res/lib/bootstrap/css/bootstrap.min.js"></script>
<script src="'.REL_URL.'res/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="'.REL_URL.'res/js/anchor.js"></script>
<script src="'.REL_URL.'res/js/registration.js"></script>
<script src="'.REL_URL.'res/js/check-user-autorize.js"></script>
<script src="'.REL_URL.'res/js/table-control.js"></script>
<title>SmiChrisSoft - '.$title.'</title>
';
}

//Получаем шапку сайта
function getHeader()
{
	echo '
<header>
	<div class="row">
		<div class="help-and-contact-container col-lg-3">
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="help-container col-lg-8 text-center">
					<h1>Help</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="contact-container col-lg-8 text-center">
					<h1>Contacts</h1>
				</div>
			</div>
		</div>
		<div class="logo-container col-lg-5">
		';
		if (isset($_SESSION['userInfo'])) 
		{
			if ($_SESSION['userInfo']['roleId'] != 1)
			echo '<a href="'.REL_URL.'">';
		else
			echo '<a href="'.REL_URL.'admin-panel/">';
		}
		else
		{
			echo '<a href = "'.REL_URL.'">';
		}
		echo '	<img src="https://api.fnkr.net/testimg/500x250/EEE/000/?text=Site+Logo" />
			</a>
		</div>
		<div class="header-reg-container col-lg-3">
			<div class="header-autorize-container">
				<div class="row">
					<div class="header-login-container text-center">
						<div class="col-lg-3 label-container login-label text-right">
							<p>Login:</p>
						</div>
						<div class="col-lg-9 input-container login-input">
							<input placeholder = "Login" required = "required" class = "autorize-login form-control" type="text" name = "login" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="header-login-container text-center">
						<div class="col-lg-3 label-container password-label text-right">
							<p>Password:</p>
						</div>
						<div class="col-lg-9 input-container password-input">
							<input placeholder = "Password" required = "required" class = "autorize-password form-control" type="password" name = "password" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="submit-container col-lg-9 col-lg-offset-3">
						<button class = "btn btn-success form-control autorize-button"><span class = "glyphicon glyphicon-log-in">&nbsp;Log-in</span></button>
					</div>
				</div>
				<div class="row forgot-password-container">
					<div class="col-lg-4 forgot-container sign-up text-right">
						<a class = "text-link" href="'.REL_URL.'page/registration/">Sign up</a>
					</div>
					<div class="col-lg-8 forgot-container forgot text-center">
						<a class = "text-link" href="'.REL_URL.'page/registration/forgot-password.php">Forgot your password?</a>
					</div>
				</div>
			</div>	
			<div class="header-user-info-container">
				<div class="col-lg-6 label-container login-label text-left">
					<p>Nickname:</p>
				</div>
				<div class="col-lg-6 label-container login-label text-left user-info-nickname">
					<p>nickname</p>
				</div>
				<div class="col-lg-6 label-container login-label text-left">
					<p>Your ID:</p>
				</div>
				<div class="col-lg-6 label-container login-label text-left user-info-id">
					<p>ID</p>
				</div>
				<div class="col-lg-6 label-container login-label text-left">
					<p>Name:</p>
				</div>
				<div class="col-lg-6 label-container login-label text-left user-info-username">
					<p></p>
				</div>
				<div class="col-lg-6 label-container login-label text-left">
					<p>Role:</p>
				</div>
				<div class="col-lg-6 label-container login-label text-left user-info-role">
					<p>user</p>
				</div>
				<div class="submit-container col-lg-12">
						<button class = "btn btn-success form-control exit-from-login-button"><span class = "glyphicon glyphicon-log-out">&nbsp;Log-out</span></button>
					</div>
			</div>
		</div>
	</div>
</header>
';
}

function getFooter()
{
	echo ' 
		<footer class = "row">
			<a class = "copyright" href="http://smichrissoft.com">
				<div class="col-lg-12 left-side">
					SmiChrisSoft©
				</div>
			</a>
		</footer>
	';
}
?>