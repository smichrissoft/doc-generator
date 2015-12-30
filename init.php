<?php 
/*	В этом файле происходится загрузка тех модулей, которые должны присутствовать на всех
*	страницах сайта. По порядку.
*	show_errors.php - 			Выводит ошибки на экран. 
*	DataBaseConfig.php - 		Доступы к базе данных.
*	DataBaseController/php -	Основной модуль взаимодействия с базами данных.
*	blocks.php - 				Формирует неизменяемые элементы страницы: head, header, footer.
*	Builder.php - 				Требуется для вывода шаблонов на экран, построения DOM.
*	Headhunt.php - 				Требуется для получения полного списка юристов.
*/
?>

<?php require(SITE_URL . "res/func/show_errors.php") ?>
<?php require(SITE_URL . "DataBaseConfig.php"); ?>
<?php require(SITE_URL . "res/func/database/DataBaseController.php") ?>
<?php require(SITE_URL . "res/blocks/blocks.php"); ?>
<?php require(SITE_URL . "res/func/builder/Builder.php"); ?>
<?php require(SITE_URL . "res/func/lawyers/Headhunt.php"); ?>
<?php session_start(); ?>