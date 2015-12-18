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
				$userId = $result[0]['id'];
				$userName = $result[0]['name'];
				$userSecondName = $result[0]['second_name'];
				$userEmail = $result[0]['email'];	
				$userRoleId = $result[0]['role_id'];
				$result = $database->getQuery("SELECT * FROM roles WHERE id = '$userRoleId'");
				$userRole = $result[0]['role'];
				
				$result = array(
					"id" => $userId,
					"login" => $login,
					"password" => $password,
					"name" => $userName,
					"secondName" => $userSecondName,
					"email" => $userEmail,
					"role" => $userRole
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
}
?>