<?php require("../../../const.php"); ?>
<?php require(SITE_URL . 'init.php'); ?>

<?php 

$builder = new Builder;
$builder->setConnect($server, $username, $password, $db);
$allTemplates = $builder->getTemplates();

function getAvailableTemplate($id, $allTemplates)
{
	for ($i=0; $i < count($allTemplates); $i++) 
	{ 
		if ($allTemplates[$i]['id'] == $id) 
		{
			$templateName 	= $allTemplates[$i]['name'];
			$templateTitle 	= $allTemplates[$i]['title'];
			$templateText	= file_get_contents(SITE_URL . 'store/doc-templates/' . $templateName . "/text.html");
			$result = array(
				"id"		=> $id,
				"title" 	=> $templateTitle,
				"name"	 	=> $templateName,
				"text"	 	=> $templateText
				);
			return $result;
		}
	}	
}

if (isset($_POST))
{
	if (isset($_POST['getTemplateInfo']))
	{
	 $result = getAvailableTemplate($_POST['id'], $allTemplates);
	 echo json_encode($result);
	}
}

?>