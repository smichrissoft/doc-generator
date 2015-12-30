//Функция для автоматической генерации url
function getURL()
{
	//Получаем строку, начиная с корневого каталога.
	var root = location.pathname;
	//Регулярка. От слеша и до слеша, позвляет определить рабочую директорию
	var reg = /^[\/][-.a-zA-Z0-9]*[\/]/;
	var root = root.match(reg);
	//Полный путь: протокол, имя сервера, рабочая директория.
	var siteUrl = location.protocol+"//"+location.host+root;
	return siteUrl;
}