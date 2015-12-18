
<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php
$headhunt = new Headhunt; 
$headhunt->setConnect($server, $username, $password, $db);
$lawyersInfo = $headhunt->getFullArray();

//Получаем название страны по ее ID из массива
function getCountryName($id, $lawyersInfo)
{
	for ($i=0; $i < count($lawyersInfo['countries']); $i++) { 
		if ($lawyersInfo['countries'][$i]['id'] == $id)
		{
			return $lawyersInfo['countries'][$i]['country'];
		}
	}
}

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
		if (isset($_POST['getLawyers']))
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
						'hangout' 		=> 	$lawyerHangout
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
	}
?>