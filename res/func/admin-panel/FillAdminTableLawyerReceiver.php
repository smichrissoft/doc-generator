<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php 

//Создаем экземпляр бд-контроллера и готовимся к коннекту
$database = new DataBaseController;
$database->_constructor($server, $username, $password, $db);

if (isset($_POST))
{
	//Если пришел запрос на выборку всех юзеров-не юристов и не админов
	if (isset($_POST['getAvailableUsers']))
	{
		$database->connect();
		$result = $database->getQuery("SELECT * FROM users WHERE (role_id<> 4 and role_id<>1)");
		echo json_encode($result);
		$database->disconnect();
	}

//Если пришел запрос на выборку юристов.
	if (isset($_POST['getLawyers']))
	{
		$toSend = array();
		$database->connect();
		//Проверяем, установлен ли айди города.
		//Если да, то делаем выборку по городу
		if ($_POST['cityId'] === true)
		{
			$cityId = $_POST['cityId'];
			$lawyers  = $database->getQuery("SELECT * FROM lawyers WHERE city_id = $cityId");
		}
		//Если нет, то гребем всех подряд.
		else
		{
			$lawyers  = $database->getQuery("SELECT * FROM lawyers");
		}
		

		for ($i=0; $i < count($lawyers); $i++)
		{ 
			$lawyerId = $lawyers[$i]['id'];
			$userId = $lawyers[$i]['user_id'];
			$countryId = $lawyers[$i]['country_id'];
			$cityId = $lawyers[$i]['city_id'];

			$result = $database->getQuery("SELECT * FROM countries WHERE id = $countryId");
			$lawyerCountry 	= $result[0]['country'];
			$result = $database->getQuery("SELECT * FROM cities WHERE id = $cityId");
			$lawyerCity 	= $result[0]['city'];
			$lawyerName = $lawyers[$i]['name'];
			$lawyerSecondName = $lawyers[$i]['second_name'];
			$lawyerSkype = $lawyers[$i]['skype'];

			$result = array(
				"id" 		=> $lawyerId,
				"country"	=> $lawyerCountry,
				"city"		=> $lawyerCity,
				"name"		=> $lawyerName,
				"secondName"=> $lawyerSecondName,
				"skype"		=> $lawyerSkype
				);
			array_push($toSend, $result);
		}
		echo json_encode($toSend);
	}

	//Если пришел запрос на добавление нового юриста
	if (isset($_POST['addNewLawyer']))
	{
		try 
		{
			$userId 		= $_POST['userId'];
			$countryId 		= $_POST['countryId'];
			$cityId 		= $_POST['cityId'];
			$database->connect();
			$result 		= $database->getQuery("SELECT * FROM users WHERE id = $userId");
			if (!$result) throw new Exception("ERROR: User have't selected from BD!");
			$userName 		= $result[0]['name'];
			$userSecondName = $result[0]['second_name'];
			$userEmail		= $result[0]['email'];
			$database->setQuery("INSERT INTO lawyers (city_id, country_id, user_id, name, second_name, email) VALUES ($cityId, $countryId, $userId, '$userName', '$userSecondName', '$userEmail')");
			$result = $database->execQuery();
			if ($result != true) throw new Exception("User hasn't added to lawyers!");
			$result = $database->getQuery("SELECT * FROM lawyers WHERE user_id = $userId");
			if (!$result) throw new Exception("Cannot select lawyer from BD!");
			$lawyerId = $result[0]['id'];
			$avatar = file_get_contents(SITE_URL . "res/pictures/lawyer-placeholder.jpg");
			file_put_contents(SITE_URL . "store/lawyers-info/photos/avatar_" . $lawyerId . ".jpg", $avatar);
			file_put_contents(SITE_URL . "store/lawyers-info/resumes/resume_" . $lawyerId . ".html", "Resume will be here");
			$database->setQuery("UPDATE users SET role_id = 4 WHERE id = $userId");
			$result = $database->execQuery();
			if ($result != true) throw new Exception("User's status hasn't updated!");
			$database->disconnect();
			echo true;	
		} 
		catch (Exception $e) 
		{
			echo $e->getMessage();	
		}				
	}
	//Если пришел запрос на удаление юриста из базы.
	if (isset($_POST['reduceLawyer']))
	{
		$lawyerId = $_POST['id'];
		$database->connect();
		$result = $database->getQuery("SELECT * FROM lawyers WHERE id = $lawyerId");
		$userId = $result[0]['user_id'];
		$database->setQuery("UPDATE users SET role_id = 2 WHERE id = $userId");
		$database->execQuery();
		$database->setQuery("DELETE FROM lawyers WHERE id = $lawyerId");
		$database->execQuery();
		unlink(SITE_URL . "store/lawyers-info/photos/avatar_" . $lawyerId . ".jpg");
		unlink(SITE_URL . "store/lawyers-info/resumes/resume_" . $lawyerId . ".html");
		echo true;
		$database->disconnect();
	}
}
?>