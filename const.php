<?php 
	//В переменной shceme хранится протокол (http или https).
	$scheme = $_SERVER['REQUEST_SCHEME'].'://';
	//Имя сервера
	$serverName = $_SERVER['SERVER_NAME'];
	//Регулярка, вычленяет рабочий каталог 
	$reg = "/[\/][-_.a-zA-Z]*[\/]/";
	//Проверка на соответствие. В REQUEST_URI содержится путь, начиная от сервера. В root запишется рабочий каталог.
	$match = preg_match_all($reg, $_SERVER['REQUEST_URI'], $root);
	//Относительный путь формируется из протокола, имени сервера и рут директории.
	$relUrl = $scheme . $serverName . $root[0][0];

	define('SITE_URL', explode($root[0][0], __DIR__)[0].'/');

	define('REL_URL' , $relUrl);

	define('COOKIE_TIME', 7200); //Время хранения куков (120 минут).

	//На всякий случай, вариант с ручным прописыванием путей
	//define('SITE_URL', explode('ask-a-lawyer', __DIR__)[0].'ask-a-lawyer'.'/');
	//define('REL_URL', explode('ask-a-lawyer', __DIR__)[3].'http://local.loc/ask-a-lawyer'.'/');
?>