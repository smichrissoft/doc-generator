<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php 
$database = new DataBaseController;
$database->_constructor($server, $username, $password, $db);

if (isset($_POST))
{
	//Если пришла команда на добавление пользователя.
	if (isset($_POST['createNewUser'])) {
		$login 			= strtolower($_POST['login']);
		$password 		= md5($_POST['password']);
		$userName 		= ucfirst(strtolower($_POST['userName']));
		$userSecondName = ucfirst(strtolower($_POST['userSecondName']));
		$userEmail		= strtolower($_POST['userEmail']);

		$database->connect();
		$query = "INSERT INTO users (username,password,name,second_name,email,role_id) VALUES ('$login','$password','$userName','$userSecondName','$userEmail',2)";
		$result = $database->setQuery($query);
		$result = $database->execQuery();
		$database->disconnect();
		echo $result;
	}	

	if (isset($_POST['autorizeUser']))
	{
		$login 		= strtolower($_POST['login']);
		$password 	= md5($_POST['password']);
		$database->connect();
		$result = $database->getQuery("SELECT * FROM users WHERE username = '$login'");
		if (count($result) != NULL)
		{
			if ($result[0]['password'] == $password)
			{
				$userId			= $result[0]['id'];
				$userName 		= $result[0]['name'];
				$userSecondName = $result[0]['second_name'];
				$userEmail 		= $result[0]['email'];	
				$userRoleId 	= $result[0]['role_id'];
				$result 		= $database->getQuery("SELECT * FROM roles WHERE id = '$userRoleId'");
				$userRole 		= $result[0]['role'];
				
				$result = array(
					"id" 			=> $userId,
					"login" 		=> $login,
					"password" 		=> $password,
					"name" 			=> $userName,
					"secondName" 	=> $userSecondName,
					"email" 		=> $userEmail,
					"role" 			=> $userRole,
					"roleId" 		=> $userRoleId
					);

				setcookie('userInfo',json_encode($result), time()+COOKIE_TIME, '/');
				$_SESSION['userInfo'] = $result;
				echo json_encode($_SESSION['userInfo']);
			}
			else
			{
				echo 0;
			}
		}
		else
		{
			echo 0;
		}
	}

	if (isset($_POST['remindPasswordSend'])) 
	{
		$username = strtolower($_POST['username']);
		$database->connect();
		$result = $database->getQuery("SELECT * FROM users WHERE username = '$username'");
		if (count($result) != NULL)
		{
			$email = $result[0]['email'];
			$userId = $result[0]['id'];
			$now = time();
			$token = md5($now);
			$result = $database->setQuery("INSERT INTO remind_password (user_id, token, time_out) VALUES ($userId, '$token', $now+3600)");
			$result = $database->execQuery();
			if ($result == 1)
			{
				//echo $email;
				mail($email, "Remind Password", "Для восстановления пароля перейдите по ссылке: " 
					. REL_URL . 'page/registration/forgot-password.php?token='.$token.'&userId=' . $userId
					, "From: no-reply@smichrissoft.com \r\n"
					."X-Mailer: PHP/" . phpversion());
			}
		}
		else
		{
			echo "User is not exist";
		}
	}

	if (isset($_POST['remindPasswordGet']))
	{
		$token 			= $_POST['token'];
		$userId 		= $_POST['userId'];
		$newPassword 	= md5($_POST['newPassword']);

		$database->connect();
		$result = $database->getQuery("SELECT * FROM remind_password WHERE token = '$token'");
		
		$timeout 		= $result[0]['time_out'];
		$now 			= time();
		$late 			= $timeout-$now;

		if ($late > 0) 
		{
			$result = $database->setQuery("UPDATE users SET password = '$newPassword' WHERE id = $userId");
			$result = $database->execQuery();
			echo 1;
		} 
		else 
		{
			echo 0;
		}
	}
}
?>