<?php 

	if (isset($_SESSION['userInfo']))
	{
		if ($_SESSION['userInfo']['roleId'] != 1)
		{
			die("You are not admin!<br/><a href=".REL_URL.">Back</a>");
		}
	}
	else
	{
		die("You are not admin!<br/><a href=".REL_URL.">Back</a>");
	}
?>