<?php
class DataBaseController{

//Переменные получаем из глобальной области путем выполнения функции _constructor.
	public $server = NULL; 
	private $username = NULL;
	private $password = NULL;
	private $db = NULL;
	public $connect = NULL;
	public $query = NULL;

//Устанавливаем переменные для коннекта к базе.
//ЭТО НЕ СТАНДАРТНЫЙ КОНСТРУКТОР PHP! ФУНКЦИЯ ВЫЗЫВАЕТСЯ ВРУЧНУЮ!
	
	function _constructor($server, $username, $password, $db){
		$this->server = $server;
		$this->username = $username;
		$this->password = $password;
		$this->db = $db;
	}

//Создаем соединение.  
	function connect()
	{
		$connect = new mysqli($this->server, $this->username, $this->password, $this->db);
		if (mysqli_connect_errno())
  			return 'Database is not connected! Error: ' . mysqli_connect_error();
  		else 
  			$this->connect = $connect;
	}

	//Отладочная функция, можно удалить после релиза.

	function getStatus(){
		return $this->connect;
	}

//Обрубаем соединение при необходимости.
	function disconnect()
	{
		$this->connect = $this->connect->close();
		$this->connect = NULL;
	}
//Принимаем запрос и устанавливаем его в переменную класса
	function setQuery($query)
	{
		$this->query = $query;
	}
//Выполняем запрос и возвращаем результат запроса.
	function execQuery()
	{
		if ($result = $this->connect->query($this->query))
		return $result;
		else
		return mysqli_error($this->connect);
	}
//Получаем всю выборку в форме ассоциативного массива
	function getArrayResult($result)
	{	
		$res = array();
		while ($row = mysqli_fetch_assoc($result)){
			array_push($res, $row);
		}
		return ($res);
	}



	
/*	Общая функция, последовательно выполняющая setQuery, execQuery, и getArrayResult. 
*	Для удобства вызова. Работает только на SELECT, для остальных запросов понадобится
*	ручной вызов. Это связано с тем, что getArrayResult возвращает массив данных, в то
*	время как execQuery может вернуть true или ошибку, которые в массив не положишь.
*/
	function getQuery($query)
	{
		$this->setQuery($query);
		$result = $this->execQuery();
		return $this->getArrayResult($result);
	}
	
}
?>
