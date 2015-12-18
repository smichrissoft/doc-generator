<?php require("../../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<?php 
if (isset($_POST))
{
	if (isset($_POST['checkUserLogged']))
	{
		if (isset($_COOKIE['userInfo']))
		{
			echo $_COOKIE['userInfo'];
		}
		else
		{
			if (isset($_SESSION['userInfo']))
			{
				echo json_encode($_SESSION['userInfo']);
			}
			else
			{
				echo 0;
			}
		}
		
	}

	if (isset($_POST['setUserExit']))
	{
		unset($_SESSION['userInfo']);
		setcookie("userInfo", NULL, time()-COOKIE_TIME,'/');
		echo "Успешно";
	}
}
?>
