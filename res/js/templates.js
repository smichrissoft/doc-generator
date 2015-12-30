//Заполняем форму выбранного документа
function showTemplateInfo(data)
{
	var id 		= data.id;
	var name 	= data.name;
	var title	= data.title;
	var text	= data.text;
	$('.template-info-container').hide();
	$('.template-info-container .template-info-data-container p span').html("DD.MM.YYYY");
	$('.template-info-container .main-content-container pre h1').html(title);
	$('.template-info-container .main-content-container pre div').html(text);
	$('.download-button').attr('href',getURL()+'store/doc-templates/'+name+'/text.html');
	$('.template-id').val(data.id);
	$('.template-info-container').show('fast');
	$('a[href^="#"]').click();
}

//Получаем информацию о выбранном документе с помощью запроса
function getTemplateInfo(templateId)
{
	$(".preloader").show("fast");
	$.ajax
	({
		type: 'post',
		url: getURL()+'/res/func/builder/DocumentPostReciever.php',
		data:{getTemplateInfo:true, id:templateId},
		response:'text',
		success:function(data)
		{
			
			data = JSON.parse(data);
			showTemplateInfo(data);
		}
	});
	$(".preloader").hide("fast");
}

//Обработчик кнопки Previous
function previousTemplate(template)
{
	var firstId = $('.template-box-container:first .template-image-container').attr("id");
	var currentId = template.val();
	if (firstId != currentId)
	{
		currentId--;
		getTemplateInfo(currentId);
	} 
}

function nextTemplate(template)
{
	var lastId = $('.template-box-container:last .template-image-container').attr("id");
	var currentId = template.val();
	if (lastId != currentId)
	{
		currentId++;
		getTemplateInfo(currentId);
	} 

}

$(document).ready(function(){

	$('.template-image-container').click(function(){
		getTemplateInfo(this.id);	
	});

	$('.previous-button').click(function(){
		previousTemplate($(this).parent().parent().children('.template-id'));
	});

	$('.next-button').click(function(){
		nextTemplate($(this).parent().parent().children('.template-id'));
	});
});