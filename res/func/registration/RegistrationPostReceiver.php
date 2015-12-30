<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php 
//Полдотавливаем таблицу к работе.
$database = new DataBaseController;
$database->_constructor($server, $username, $password, $db);

if (isset($_POST))
{
	//Если пришла команда на добавление пользователя.
	if (isset($_POST['createNewUser'])) {
		//Логин записываем только с прописными буквами
		$login 			= strtolower($_POST['login']);
		//Пароль хеширует с помощью md5.
		$password 		= md5($_POST['password']);
		//Имя и фамилию делаем прописными, первая строчная
		$userName 		= ucfirst(strtolower($_POST['userName']));
		$userSecondName = ucfirst(strtolower($_POST['userSecondName']));
		//email превращаем в прописные.
		$userEmail		= strtolower($_POST['userEmail']);

		$database->connect();
		$result = $database->setQuery("INSERT INTO users (username,password,name,second_name,email,role_id) VALUES ('$login','$password','$userName','$userSecondName','$userEmail',2)");
		$result = $database->execQuery();
		$database->disconnect();
		echo $result;
	}	
	//Если пользователь пытается авторизоваться.
	if (isset($_POST['autorizeUser']))
	{
		//Введенный им логин превращаем в прописные.
		$login 		= strtolower($_POST['login']);
		//Пароль хешируем с помощью md5.
		$password 	= md5($_POST['password']);
		$database->connect();
		//Получаем пользователя с полученным именем.
		$result = $database->getQuery("SELECT * FROM users WHERE username = '$login'");
		//Если таковой существует
		if (count($result) != NULL)
		{
			//Если хешированный пароль из базы совпадает с хешированным паролем, который ввел пользователь.
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

				//Устанавливаем куки, в формате json.
				setcookie('userInfo',json_encode($result), time()+COOKIE_TIME, '/');
				//Устанавливаем сессию для авторизовавшегося пользователя.
				$_SESSION['userInfo'] = $result;
				//Возвращаем json инфу о пользователе пользователю.
				echo json_encode($_SESSION['userInfo']);
			}
			//Если пароли не совпали, обрываем выполнение.
			else
			{
				echo 0;
			}
		}
		//Если пользователя нет - обрываем выполнение.
		else
		{
			echo 0;
		}
	}

	//Если пришел запрос на напоминание пароля.
	if (isset($_POST['remindPasswordSend'])) 
	{
		$username = strtolower($_POST['username']);
		$database->connect();
		//Получаем пользователя с данным ником.
		$result = $database->getQuery("SELECT * FROM users WHERE username = '$username'");
		//Если таковой существует
		if (count($result) != NULL)
		{
			//Получаем email из базы.
			$email = $result[0]['email'];
			//Определяем текущее время.
			$now = time();
			//Шифруем текущее время и получаем токен.
			$token = md5($now);
			//Запоминаем токен в БД.
			$result = $database->setQuery("INSERT INTO remind_password (user_id, token, time_out) VALUES ($userId, '$token', $now+3600)");
			$result = $database->execQuery();
			//Если токен записан в БД успещно
			if ($result == 1)
			{
				//Пишем письмо на адрес пользователя, в котором будет ссылка на этот файл и токен в качестве GET-запроса.
				mail($email, "Remind Password", "Для восстановления пароля перейдите по ссылке: " 
					. REL_URL . 'page/registration/forgot-password.php?token='.$token
					, "From: no-reply@smichrissoft.com \r\n"
					."X-Mailer: PHP/" . phpversion());
			}
		}
		//Если пользователя не существует, предупредим.
		else
		{
			echo "User is not exist";
		}
	}

	//Если пользователь к нам пришел уже с токеном и попытался сменить пароль.
	if (isset($_POST['remindPasswordGet']))
	{
		$token 			= $_POST['token'];
		$newPassword 	= md5($_POST['newPassword']);

		$database->connect();
		//Выбираем из базы данных присланный токен.
		$result = $database->getQuery("SELECT * FROM remind_password WHERE token = '$token'");
		
		//Если таковой действительно найдется.
		if (count($result) != 0)
		{
			$userId 		= $result[0]['user_id'];
			$timeout 		= $result[0]['time_out'];
			$now 			= time();
			//Узнаем, не истек ли срок годности токена.
			$late 			= $timeout-$now;
		
			//Если нет, то сменим пароль, как и требуют.
			if ($late > 0) 
			{
				$database->setQuery("UPDATE users SET password = '$newPassword' WHERE id = $userId");
				$result = $database->execQuery();
				$database->setQuery("DELETE FROM remind_password WHERE token = '$token'");
				$result = $database->execQuery();
				echo 1;
			} 
			//Если опоздал, то пользователь залетный, и мы прогоним его.
			else 
			{
				echo 0;
			}	
		}
	}

	//Функция для регулярной очистки токенов. Срабатывает часто, почти при каждом изменении страницы.
	if (isset($_POST['deleteOldTokens']))
	{
		$database->connect();
		$result = $database->getQuery("SELECT * FROM remind_password");
		for ($i=0; $i < count($result); $i++) { 
			//Если истек срок годности токена, то мы его удалим.
			if ($result[$i]['time_out'] < time())
			{
				$id = $result[$i]['id'];
				$database->setQuery("DELETE FROM remind_password WHERE id = $id");
				$database->execQuery();
			}
		}
	}
}
?>