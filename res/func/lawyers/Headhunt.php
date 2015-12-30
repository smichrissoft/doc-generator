<?php 
class Headhunt {
	private $connect = NULL;
	public $lawyers = NULL;
	public $countries = NULL;
	public $cities = NULL;

	//Устанавливаем соединение с базой данных
	function setConnect($server, $username, $password, $db)
	{
		$database = new DataBaseController;
		$database->_constructor($server, $username, $password, $db);
		$database->connect();
		$this->connect = $database;

		if ($this->connect) return true;	
		else return false;

	}

	//Получаем список адвокатов в массиве, и пишем в переменную класса.
	function setLawyers()
	{
		$result = $this->connect->getQuery("SELECT * FROM lawyers");
		$this->lawyers = $result;
	}

	//Получаем список стран в массиве, и пишем в переменную класса.
	function setCountries()
	{
		$result = $this->connect->getQuery("SELECT * FROM countries");
		$this->countries = $result;
	} 

	//Получаем список городов в массиве, и пишем в переменную класса.
	function setCities()
	{
		$result = $this->connect->getQuery("SELECT * FROM cities");
		$this->cities = $result;
	}

	//Возвращаем результат в одном общем массиве.
	function getFullArray()
	{
		$this->setLawyers();
		$this->setCountries();
		$this->setCities();
		$result = array(
			'lawyers' => 	$this->lawyers,
			'countries' => 	$this->countries,
			'cities' => 	$this->cities
			);
		return $result;
	}



}

?>