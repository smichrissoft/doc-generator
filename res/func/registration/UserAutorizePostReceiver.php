<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php 
if (isset($_POST))
{

	//Если пришел запрос на проверку, авторизован ли пользователь. Срабатывает при переходе на любую страницу.
	if (isset($_POST['checkUserLogged']))
	{
		//Если установлены куки, то их и возвратим Ajax-скрипту.
		if (isset($_COOKIE['userInfo']))
		{
			echo $_COOKIE['userInfo'];
		}
		//Если куков нет, проверим сессии
		else
		{
			//Если сессии существуют
			if (isset($_SESSION['userInfo']))
			{
				//Вернем сесси в JSon формате.
				echo json_encode($_SESSION['userInfo']);
			}
			//Если и сессии нету, значит пользователь не зарегестрирован, о чем ему и сообщим.
			else
			{
				echo 0;
			}
		}
		
	}

	//Если пользовать разлогинился
	if (isset($_POST['setUserExit']))
	{
		//Удаляем сессию, и удаляем куки.
		unset($_SESSION['userInfo']);
		setcookie("userInfo", NULL, time()-COOKIE_TIME,'/');
	}
}
?>
