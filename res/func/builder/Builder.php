<?php 
class Builder
{	//В переменной хранится доступ к БД
	private $connect = '';

	//Устанавливает соединение с базой данных через класс DataBaseController
	function setConnect($server, $username, $password, $db)
	{
		$database = new DataBaseController;
		$database->_constructor($server, $username, $password, $db);
		$database->connect();
		$this->connect = $database;
	}
	//Получат информацию о всех шаблонах из базы данных, и отдает получившийся массив.
	function getTemplates()
	{
		$result = $this->connect->getQuery("SELECT * FROM templates");
		return $result;
	}
	//Формирует массив со ссылками на картинку и текст шаблона.
	function buildTemplatePreview($templates)
	{
		$result =array();
		$count = count($templates);
		for ($i=0; $i<$count; $i++)
		{	
			$templateId = $templates[$i]['id'];
			$templateName = $templates[$i]['name'];
			$title = $templates[$i]['title'];
			$pic = REL_URL.'store/doc-templates/'.$templateName.'/pic.png';
			$fill = array('id' => $templateId, 'name' => $templateName,'title'=>$title, 'pic'=>$pic);
			array_push($result, $fill);
		}
		return $result;
	}

	//Генерирует отдельный контейнер с выбранным шаблоном
	function getTemplateBox($i, $templates)
	{
		$result = '';
		$openRowDiv = '<div class="row template-row">';
		$closeRow = '</div>';
		$templateBox = '<div class="col-lg-3 template-box-container text-center">
						<div class="row">
							<div class="col-lg-12">'.$templates[$i]['title'].'</div>
						</div>
						<div id = "'.($templates[$i]['id']).'" class="template-image-container row text-center">
							<img class = "template-image" src="'.$templates[$i]['pic'].'" />
						</div>
						<div class="row download-button-container">
							<a download = "download" href = "'.REL_URL.'store/doc-templates/'.$templates[$i]['name'].'/text.html" class="btn btn-default btn-success form-control"><span class="glyphicon glyphicon-download-alt download-icon">&nbsp;Download</span></a>
						</div>
					</div>';

		switch ($i%3)
		{
			case 0:
				return $openRowDiv . $templateBox;
			break;
			case 2:
				return $templateBox . $closeRow;
			break;
			default:
				return $templateBox;
			break;
		}
	}

	//Генерирует html для отображения шаблонов. 
	function compileTemplatePreview($templates)
	{
		$result = '';
		for ($i=0; $i < count($templates); $i++) 
		{ 
			$result .= $this->getTemplateBox($i ,$templates);
		}
		return $result;
	}

	//Выводит получившуюся страницу на экран.
	function printTemplatePreview($server, $username, $password, $db)
	{
		$this->setConnect($server, $username, $password, $db);
		$templates = $this->getTemplates();
		$result = $this->buildTemplatePreview($templates);
		$result = $this->compileTemplatePreview($result);
		return $result;
	}
}
?>