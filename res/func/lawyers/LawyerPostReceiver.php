
<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php
$headhunt = new Headhunt; 
$headhunt->setConnect($server, $username, $password, $db);
$lawyersInfo = $headhunt->getFullArray();
$database = new DataBaseController;
$database->_constructor($server, $username, $password, $db);

//Получаем название страны по ее ID из массива с юристами.
function getCountryName($id, $lawyersInfo)
{
	for ($i=0; $i < count($lawyersInfo['countries']); $i++) { 
		if ($lawyersInfo['countries'][$i]['id'] == $id)
		{
			return $lawyersInfo['countries'][$i]['country'];
		}
	}
}

//Получаем название города по его ID из массива с юристами.
function getCityName($id, $lawyersInfo)
{
	for ($i=0; $i < count($lawyersInfo['cities']); $i++) 
	{ 
		if ($lawyersInfo['cities'][$i]['id'] == $id) 
		{
			return $lawyersInfo['cities'][$i]['city'];
		}
	}
}

//Если пришел любой пост запрос
	if (isset($_POST))
	{
		//Отправляем массив со всеми странами, если пришел запрос на страны.
		if (isset($_POST['getCountry']))
		{
			$result = json_encode($lawyersInfo['countries']);
			echo $result;
		}

		//Отправляем массив с теми городами, country-id которых равен присланному.
		if (isset($_POST['getCity']))
		{
			$toSend = array();
			$countryId = $_POST['id'];

			for ($i=0; $i < count($lawyersInfo['cities']); $i++) 
			{ 
				if ($lawyersInfo['cities'][$i]['country_id'] == $countryId) 
				{
					$cityId = $lawyersInfo['cities'][$i]['id'];
					$city = $lawyersInfo['cities'][$i]['city'];
					$result = array(
						'cityId' => $cityId,
						'countryId' => $countryId,
						'city' => $city
						);

					array_push($toSend, $result);
				}
			} 
			echo json_encode($toSend);
		}

		//Отправляем массив с адвокатами, city_id которых равен присланному.
		if (isset($_POST['getLawyersCity']))
		{
			$cityId = $_POST['id'];
			$toSend = array();
			for ($i=0; $i < count($lawyersInfo['lawyers']); $i++) 
			{ 
				if ($lawyersInfo['lawyers'][$i]['city_id'] == $cityId)
				{
					$lawyerId			=	$lawyersInfo['lawyers'][$i]['id'];
					$lawyerName 		= 	$lawyersInfo['lawyers'][$i]['name'];
					$lawyerSecondName 	= 	$lawyersInfo['lawyers'][$i]['second_name'];
					$lawyerSkype 		= 	$lawyersInfo['lawyers'][$i]['skype'];
					$lawyerEmail 		= 	$lawyersInfo['lawyers'][$i]['email'];
					$lawyerHangout 		= 	$lawyersInfo['lawyers'][$i]['hangout'];
					$result = array(
						'id'			=>	$lawyerId,
						'name' 			=> 	$lawyerName,
						'secondName' 	=> 	$lawyerSecondName,
						'skype' 		=> 	$lawyerSkype,
						'email' 		=> 	$lawyerEmail,
						'hangout' 		=> 	$lawyerHangout,
						'city'			=>  getCityName($cityId, $lawyersInfo)
						);
					array_push($toSend, $result);
				}
			}
			echo json_encode($toSend);
		}

		//Отправляем массив со списком адвокатов, которые проживают в присланной стране.
		if (isset($_POST['getLawyersCountry']))
		{
			$toSend = array();
			$countryId = $_POST['id'];
			for ($i=0; $i < count($lawyersInfo['lawyers']); $i++)
			{ 
				if ($lawyersInfo['lawyers'][$i]['country_id'] == $countryId)
				{
					$cityId 			= $lawyersInfo['lawyers'][$i]['city_id'];
					$lawyerId 			= $lawyersInfo['lawyers'][$i]['id'];
					$lawyerCountry 		= getCountryName($countryId, $lawyersInfo);
					$lawyerCity 		= getCityName($cityId, $lawyersInfo);
					$lawyerName 		= $lawyersInfo['lawyers'][$i]['name'];
					$lawyerSecondName 	= $lawyersInfo['lawyers'][$i]['second_name'];
					$lawyerSkype 		= $lawyersInfo['lawyers'][$i]['skype'];

					$result = array(
						"id"			=> $lawyerId,
						"country"		=> $lawyerCountry,
						"city"			=> $lawyerCity,
						"name"			=> $lawyerName,
						"secondName"	=> $lawyerSecondName,
						"skype"			=> $lawyerSkype
						);
					array_push($toSend, $result);
				}
			}
			echo json_encode($toSend);
		}

		//Отправляем всю инфу об конкретном адвокате.
		if (isset($_POST['getLawyerInfo']))
		{

			$lawyerId = $_POST['id'];

			for ($i=0; $i < count($lawyersInfo['lawyers']); $i++)
			{
				if ($lawyersInfo['lawyers'][$i]['id'] == $lawyerId)
				{
					$countryId 			= $lawyersInfo['lawyers'][$i]['country_id'];
					$cityId 			= $lawyersInfo['lawyers'][$i]['city_id'];
					$lawyerId 			= $lawyersInfo['lawyers'][$i]['id'];
					$lawyerName 		= $lawyersInfo['lawyers'][$i]['name'];
					$lawyerSecondName 	= $lawyersInfo['lawyers'][$i]['second_name'];
					$lawyerSkype 		= $lawyersInfo['lawyers'][$i]['skype'];
					$lawyerEmail 		= $lawyersInfo['lawyers'][$i]['email'];
					$lawyerHangout 		= $lawyersInfo['lawyers'][$i]['hangout'];
					$lawyerCountry 		= getCountryName($countryId, $lawyersInfo);
					$lawyerCity 		= getCityName($cityId, $lawyersInfo);
					$lawyerResume 		= file_get_contents(SITE_URL . 'store/lawyers-info/resumes/resume_'.$lawyerId . '.html');
					
					$result = array(
						'id' 			=> $lawyerId,
						'name' 			=> $lawyerName,
						'secondName' 	=> $lawyerSecondName,
						'skype' 		=> $lawyerSkype,
						'email' 		=> $lawyerEmail,
						'hangout' 		=> $lawyerHangout,
						'country' 		=> $lawyerCountry,
						'city' 			=> $lawyerCity,
						'resume' 		=> $lawyerResume
						);
				}
			}
			echo json_encode($result);
		}

		//Когда приходит запрос на изменение информации о конкретном юристе.
		if (isset($_POST['changeLawyerInfo']))
		{
			$database->connect();
			//Определяем значения для заполнения
			$lawyerId = $_POST["id"];
			$lawyerName = $_POST["name"];
			$lawyerSecondName = $_POST["second-name"];
			$lawyerSkype = $_POST["skype"];
			$lawyerEmail = $_POST["email"];
			$lawyerHangout = $_POST["hangout"];
			//Устанавливаем запрос на изменение.
			$database->setQuery("UPDATE lawyers SET name ='$lawyerName', second_name = '$lawyerSecondName', skype = '$lawyerSkype', email = '$lawyerEmail', hangout = '$lawyerHangout'  WHERE id = $lawyerId");
			//Выполняем запрос и пишем результат выполнения в result. Он будет либо true, либо текстом ошибки.
			$result = $database->execQuery();
			//Если пользователь выбирал фотку, значит перемещаем ее из временной директории в постоянную под определенным именем.
			//А если нет, то продолжаем выполнение.
			if (isset($_FILES['photo']))
			{
				move_uploaded_file($_FILES['photo']['tmp_name'], SITE_URL . "store/lawyers-info/photos/avatar_" . $lawyerId . ".jpg");
			}
			//Тоже самое, но для файла с резюме юриста.
			if (isset($_FILES['resume']))
			{
				move_uploaded_file($_FILES['resume']['tmp_name'], SITE_URL . "store/lawyers-info/resumes/resume_" . $lawyerId . ".html");
			}
			//Разрываем соединение с базой данных.
			$database->disconnect();

			//Если запрос выполнился успешно, перекидываем пользователя туда, откуда он пришел.
			if ($result == true)
			{
			header ('Location: '.$_SERVER["HTTP_REFERER"]);
			}
			//Иначе страница умирает с варнингом.
			else
			{
				die("Something went wrong!");
			}
		}
	}
?>