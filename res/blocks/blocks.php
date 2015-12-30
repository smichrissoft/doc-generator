<?php 

//Получаем Head, по пути подключая все необходимые функции и библиотеки.
//REL_URL - константа, в ней находится относительный путь до корневого каталога.

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
			<!--Help container-->
		</div>
		<div class="logo-container col-lg-4 col-lg-offset-1">
		';
		if (isset($_COOKIE['userInfo'])) 
		{
			$cookie = json_decode($_COOKIE['userInfo'], true);

			if ($cookie['roleId'] != 1)
				echo '<a href="'.REL_URL.'">';
			else
				echo '<a href="'.REL_URL.'admin-panel/">';
		}
		else
		{
			echo '<a href = "'.REL_URL.'">';
		}
		echo '<img src="'.REL_URL.'res/pictures/logo.png" />
			</a>
		</div>
		<div class="header-reg-container col-lg-3 col-lg-offset-1">
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
			<div class="header-user-info-container col-lg-12">
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
<div class="preloader">
	<img src="'.REL_URL.'res/pictures/preloader.gif" alt="" class="preloader-gif">
</div>
';
}

//Получаем подвал сайта.
function getFooter()
{
	echo ' 
		<footer class = "row left-side">
			<a class = "copyright" href="http://smichrissoft.com">
				<div class="col-lg-12 left-side">
					SmiChrisSoft(c)
				</div>
			</a>
		</footer>
	';
}
?>