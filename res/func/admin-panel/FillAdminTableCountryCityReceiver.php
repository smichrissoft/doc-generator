<?php 
/*	Модуль-ответчик для запросов Ajax. Файл служит для формирования и управления
*	таблицы городов и стран в админ панели.
*/
?>

<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php 

//Создаем новый экземпляр класса DataBaseController.
$database = new DataBaseController;
//Определеем переменные класса.
$database->_constructor($server, $username, $password, $db);


//Функция принимает значение id определенной страны, и массив стран. 
//Возвращает название страны.

function getCountryName($id, $countries)
{
	for ($i=0; $i < count($countries); $i++)
	{ 
		if ($id == $countries[$i]['id'])
		{
			return $countries[$i]['country'];
		}
	}
}

//Если на страницу пришел запрос
if (isset($_POST))
{
	//И если он требует выдать информацию для заполнения таблица странами
	if (isset($_POST['fillTableCountries']))
	{
		//Массив, который будет отправлен в конце
		$toSend = array();

		//Устанавливаем соединение
		$database->connect();
		//Записываем все существующие в БД страны в массив.
		$countries = $database->getQuery("SELECT * FROM countries");

		//Цикл отработает столько раз, сколько стран мы получили.
		for ($i = 0; $i < count($countries); $i++)
		{

			$id = $countries[$i]['id'];
			$country = $countries[$i]['country'];
			//Определяем количество юристов в выбранной стране
			$lawyersCount = count($database->getQuery("SELECT * FROM lawyers WHERE country_id = $id"));
			//Этот массив станет одним из значений передаваемого массива
			$result = array(
				"id"			=> $id,
				"country" 		=> $country,
				"lawyersCount" 	=> $lawyersCount
				);

			//Вставляем результат в итоговый массив и возвращаемся в начало цикла.
			array_push($toSend, $result);
		}

		//Передаем итоговый массив ajax-скрипту в формате JSON.
		echo json_encode($toSend);
		//Разрываем соединение.
		$database->disconnect();
	}

	//Если пришел запрос на заполнение таблицы городами
	if (isset($_POST['fillTableCities']))
	{
		//Итоговый массив, который будет отправлен в ответе.
		$toSend = array();
		//Устанавливаем соединение с БД.
		$database->connect();
		//Получаем все города и страны в разные массивы.
		$cities = $database->getQuery("SELECT * FROM cities");
		$countries = $database->getQuery("SELECT * FROM countries");

		//Цикл выполнится пропорционально количеству существующих городов.
		for ($i = 0; $i < count($cities); $i++)
		{
			$cityId = $cities[$i]['id'];
			$countryId = $cities[$i]['country_id'];
			$cityName = $cities[$i]['city'];
			//Подсчет количества юристов, проживающих в городе
			$lawyersCount = count($database->getQuery("SELECT * FROM lawyers WHERE city_id = $cityId"));
			//Массив, который будет как значение в итоговый массив $toSend.
			$result = array(
				"id"			=> $cityId,
				"country" 		=> getCountryName($countryId, $countries),
				"city"			=> $cityName,
				"lawyersCount" 	=> $lawyersCount
				);
			//Вставляем значение в итоговый массив и возвращаемся к началу цикла
			array_push($toSend, $result);	
		}
		//Отправляем ответ ajax-скрипту в JSON формате.
		echo json_encode($toSend);
		//Разрываем соединение
		$database->disconnect();
	}

	//Если пришел запрос на добавление новой страны.
	if (isset($_POST['addNewCountry']))
	{
		$database->connect();
		//Название страны берется из полученного POST-запроса от Ajax, и приводится к виду
		//имени собственного. Первая буква становится строчной, остальные прописными.
		$country = ucfirst(strtolower($_POST['country']));
		//Передаем запрос классу.
		$database->setQuery("INSERT INTO countries (country) VALUES ('$country')");
		//Исполняем запрос. В result окажется либо ошибка, либо true.
		$result = $database->execQuery();
		//Если запрос выполнен, выводим имя введенной страны
		if ($result == true)
		echo $country;
		//Разрываем соединение с БД
		$database->disconnect();
	}

	//см. выше.
	if (isset($_POST['addNewCity']))
	{
		$countryId 	= $_POST['countryId'];
		$city 		= ucfirst($_POST['city']); 
		$database->connect();
		$database->setQuery("INSERT INTO cities (country_id, city) VALUES ($countryId, '$city')");
		$result = $database->execQuery();
		if ($result != false)
			echo $city;
		$database->disconnect();
	}


	//Если пришел запрос на удаление страны.
	if (isset($_POST['deleteCountry']))
	{
		//Определим, какую страну мы хотим удалить. Ее id приходит в POST запросе.
		$countryId = $_POST['countryId'];
		//Устанавливаем соединение с БД
		$database->connect();
		//Получаем информацию о выбранной стране.
		$result = $database->getQuery("SELECT * FROM countries WHERE id = $countryId");
		//Получаем так же список городов, находящихся в этой стране.
		$cities = $database->getQuery("SELECT * FROM cities WHERE country_id = $countryId");

		//Если в стране нет добавленных городов
		if (count($cities) == 0)
		{
			//Получаем название удаляемой страны. Оно прилетит на Ajax и покажет админу, что именно эта страна была удалена.
			$countryName = $result[0]['country'];
			//Подготавливаем запрос на удаление 
			$database->setQuery("DELETE FROM countries WHERE id = $countryId");
			//Выполняем запрос и запоминаем результат, который либо true, либо ошибка.
			$result = $database->execQuery();
			//Если запрос выполнился
			if ($result == true)
			//Отдаем Ajax-скрипту название страны. 
			echo count($countryName);
			//И разрываем соединение с БД.
			$database->disconnect();
		}
		//Если есть хоть один город, выходим из процедуры.
		else
		{
			echo 0;
		}
	}

	//Если пришел запрос на удаление города. Смотри выше.
	//Разница, что проверяется, есть ли адвокаты, живущие в городе. 
	//Если есть - прерываем скрипт, если нет - удаляем.
	if (isset($_POST['deleteCity']))
	{
		$cityId = $_POST['cityId'];
		$database->connect();
		$result = $database->getQuery("SELECT * FROM cities WHERE id = $cityId");
		$lawyers = $database->getQuery("SELECT * FROM lawyers WHERE city_id = $cityId");

		if (count($lawyers) == 0)
		{
		$cityName = $result[0]['city'];
		$database->setQuery("DELETE FROM cities WHERE id = $cityId");
		$result = $database->execQuery();
		if ($result == true)
		echo $cityName;
		$database->disconnect();
		}
		else
		{
			echo 0;
		}
		
	}
}
?>