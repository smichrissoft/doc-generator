<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php 

$database = new DataBaseController;
$database->_constructor($server, $username, $password, $db);

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

if (isset($_POST))
{
	if (isset($_POST['fillTableCountries']))
	{
		$database->connect();
		$result = $database->getQuery("SELECT * FROM countries");
		echo json_encode($result);
		$database->disconnect();
	}

	if (isset($_POST['fillTableCities']))
	{
		$result = array();
		$database->connect();
		$cities = $database->getQuery("SELECT * FROM cities");
		$countries = $database->getQuery("SELECT * FROM countries");


		for ($i = 0; $i < count($cities); $i++)
		{
			$cityId = $cities[$i]['id'];
			$countryId = $cities[$i]['country_id'];
			$cityName = $cities[$i]['city'];
			$toSend = array(
				"id"	=> $cityId,
				"country" => getCountryName($countryId, $countries),
				"city"	=> $cityName
				);
			array_push($result, $toSend);	
		}
		echo json_encode($result);
		$database->disconnect();
	}

	if (isset($_POST['addNewCountry']))
	{
		$database->connect();
		$country = ucfirst($_POST['country']);
		$database->setQuery("INSERT INTO countries (country) VALUES ('$country')");
		$result = $database->execQuery();
		if ($result != false)
			echo $country;
		$database->disconnect();
	}

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

	if (isset($_POST['deleteCountry']))
	{
		$countryId = $_POST['countryId'];
		$database->connect();
		$result = $database->getQuery("SELECT * FROM countries WHERE id = $countryId");
		$countryName = $result[0]['country'];
		$database->setQuery("DELETE FROM countries WHERE id = $countryId");
		$result = $database->execQuery();
		if ($result != false)
			echo $countryName;
		$database->disconnect();
	}

	if (isset($_POST['deleteCity']))
	{
		$cityId = $_POST['cityId'];
		$database->connect();
		$result = $database->getQuery("SELECT * FROM cities WHERE id = $cityId");
		$cityName = $result[0]['city'];
		$database->setQuery("DELETE FROM cities WHERE id = $cityId");
		$result = $database->execQuery();
		if ($result)
			echo $cityName;
		$database->disconnect();
	}
}
?>