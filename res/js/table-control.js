function deleteCity(id)
{
	if (confirm("You really want delete this city? IT'S IRREVERSIBLE!"))
	{
		$.ajax
		({
			type:'post',
			url: getURL()+'/res/func/database/FillAdminTableReceiver.php',
			data:{deleteCity:true,cityId:id},
			response:'text',
			success:function(data)
			{
				if (data)
				{
					$('.warning-container').removeClass('bg-danger').addClass('bg-success');	
					$('.warning-container').html("City "+data+" deleted.");
					$('.warning-container').show('fast');
					setTimeout(function(){
						$('.warning-container').hide('fast');
						//Жамкаем по кнопке и обновляем таблицу
						$(".fill-table-cities-button").click();
					},2000);
				}
				else
				{
					$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
					$('.warning-container').html("Something went wrong. We fix it...");
					$('.warning-container').show('fast');
					setTimeout(function(){
						$('.warning-container').hide('fast');
						//Жамкаем по кнопке и обновляем таблицу
						$(".fill-table-cities-button").click();
					},2000);
				}
				
			}
		});
	}
	else
	{
		$(".fill-table-cities-button").click();
	}
}

//Удаление страны при нажатии на кнопку.
function deleteCountry(id)
{
	if (confirm("You really want delete this country? IT'S IRREVERSIBLE!"))
	{
		$.ajax
		({
			type:'post',
			url: getURL()+'/res/func/database/FillAdminTableReceiver.php',
			data:{deleteCountry:true,countryId:id},
			response:'text',
			success:function(data)
			{
				if (data)
				{
					$('.warning-container').removeClass('bg-danger').addClass('bg-success');	
					$('.warning-container').html("Country "+data+" deleted.");
					$('.warning-container').show('fast');
					setTimeout(function(){
						$('.warning-container').hide('fast');
						//Жамкаем по кнопке и обновляем таблицу
						$(".fill-table-countries-button").click();
					},2000);
				}
				else
				{
					$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
					$('.warning-container').html("Something went wrong. We fix it...");
					$('.warning-container').show('fast');
					setTimeout(function(){
						$('.warning-container').hide('fast');
						//Жамкаем по кнопке и обновляем таблицу
						$(".fill-table-countries-button").click();
					},2000);
				}
			}
		});
	}
	//Если пользователь отклонил подтверждение
	else
	{
		//Жамкаем по кнопке и обновляем таблицу
		$(".fill-table-countries-button").click();
	}
}

//Функция для добавления нового города
function addNewCity()
{
	var regular = /[+=,._0-9]/;
	var countryId = $('.country-selector').val();
	var city = $('input.input-city-name').val();

	//Если была выбрана какая то страна
	if ($('.country-selector').val() != null)
	{
		//Если совпадает по регулярке и не равно пустоте
		if (!city.match(regular) && city != "")
		{
			//И если пользователь явно подтвердил добавление
			if (confirm("You really want add this city: "+city+"?"))
			{
				//Выполняем запрос на добавление
				$.ajax
				({
					type:'post',
					url: getURL()+'/res/func/database/FillAdminTableReceiver.php',
					data:{addNewCity:true,countryId:countryId,city:city},
					response:'text',
					success:function(data)
					{
						//Если ответ пришел не пустой, сообщаем об успехе
						if (data)
						{
							$('.warning-container').removeClass('bg-danger').addClass('bg-success');	
							$('.warning-container').html("City "+data+" succesfully added!");
							$('.warning-container').show('fast');
							setTimeout(function(){
								$('.warning-container').hide('fast');
								//Жамкаем по кнопке и обновляем таблицу
								$(".fill-table-cities-button").click();
							},2000);
						}
						//Если запрос пустой, предупреждаем
						else
						{
							$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
							$('.warning-container').html("Something went wrong. We fix it...");
							$('.warning-container').show('fast');
							setTimeout(function(){
								$('.warning-container').hide('fast');
								//Жамкаем по кнопке и обновляем таблицу
								$(".fill-table-cities-button").click();
							},2000);
						}
					}
				});
			}
			//Если юзверь не подтвердил добавление, просто обновляем таблицу
			else
			{
				$(".fill-table-cities-button").click();
			}
		}
		//Если пользователь ввел корявый город
		else
		{
			$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
			$('.warning-container').html("Invalid name of city!");
			$('.warning-container').show('fast');
			setTimeout(function(){
				$('.warning-container').hide('fast');
				//Жамкаем по кнопке и обновляем таблицу
				$(".fill-table-cities-button").click();
			},2000);
		}
	}
	//Если юзверь не выбрал страну
	else
	{
		$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
		$('.warning-container').html("Please, select a country!");
		$('.warning-container').show('fast');
		setTimeout(function(){
			$('.warning-container').hide('fast');
		},2000);
	}
}

//Функция на добавление страны
function addNewCountry()
{
	var country = $('input.input-country-name').val();
	var regular = /[-+=,._0-9]/;

	//Если совпадает по регулярке и не равно пустоте
	if (!country.match(regular) && country != '')
	{
		//И если юзверь подтвердил добавление
		if (confirm("You really want add this country: "+country+"?"))
		{
			//Создаем запрос на добавление страны
			$.ajax
			({
				type:'post',
				url: getURL()+'/res/func/database/FillAdminTableReceiver.php',
				data:{addNewCountry:true,country:country},
				response:'text',
				success:function(data)
				{
					//Если ответ пришел не пустой
					if (data)
					{
						$('.warning-container').removeClass('bg-danger').addClass('bg-success');	
						$('.warning-container').html("Country "+data+" succesfully added!");
						$('.warning-container').show('fast');
						setTimeout(function(){
							$('.warning-container').hide('fast');
							//Жамкаем по кнопке и обновляем таблицу
							$(".fill-table-countries-button").click();
						},1000);
					}
					//Если запрос пустой, предупреждаем
					else
					{
						$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
						$('.warning-container').html("Something went wrong. We fix it...");
						$('.warning-container').show('fast');
						setTimeout(function(){
							$('.warning-container').hide('fast');
							//Жамкаем по кнопке и обновляем таблицу
							$(".fill-table-countries-button").click();
						},1000);
					}
				}
			});
		}
		//Если юзверь не подтвердил добавление обновляем таблицу
		else
		{
			$(".fill-table-countries-button").click();
		}
	}
	//Если юзверь накосячил во вводе, предупреждаем и выгоняем
	else
	{
		$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
		$('.warning-container').html("Invalid country name!");
		$('.warning-container').show('fast');
		setTimeout(function(){
			$('.warning-container').hide('fast');
		},1000);
	}
	
}

//Параметры отображения
function prepareForAdd(addCountry)
{
	//Показываем саму форму
	$('.add-form-submit').show();

	//Если перед этим были выбраны страны 
	if (addCountry)
	{
		$('.input-country-name')	.show();
		$('.country-selector')		.hide();
		$('.input-city-name')		.hide();
	}
	//Если были выбраны города
	else
	{
		$('.input-country-name')	.hide();
		$('.country-selector')		.show();
		$('.input-city-name')		.show();

		//Чистим Select
		$('.country-selector option').each(function(){
			$(this).remove();
		});
		//Выполняем запрос на получение всех стран
		$.ajax
		({
			type:'post',
			url: getURL()+'/res/func/database/FillAdminTableReceiver.php',
			data:{fillTableCountries:true},
			response:'text',
			success:function(data)
			{
				data = JSON.parse(data);
				//Добавляем дефолтный элемент
				$('.country-selector').append('<option disabled="disabled" selected="selected" value="">What country is this city?</option>');
				for (var i = 0; i < data.length; i++)
				{
					//Добавляем все пришедшие страны в качестве опции
					$('.country-selector').append('<option value="'+data[i].id+'">'+data[i].country+'</option>');
				}
			}
		});
	}
}

//Функция для заполнения таблиц
function fillTable(option, data)
{
	//Сначала чистим
	$('.table')			.hide('fast');
	$('.add-form')		.hide('fast');
	$('.add-button')	.html('Add');
	$('.table thead')	.html("");
	$('.table tbody')	.html("");

	//Если заполняем страны
	if (option == "countries")
	{
		//Добавляем дефолтную структуру
		var struct = "<tr><td>Id</td><td>Country</td><td>Use</td></tr>";
		$('.table thead').append(struct);
		//Сканим количество прилетевших записей
		for (var i = 0; i < data.length; i++)
		{
			//Задаем элементы на добавление
			var openRow = '<tr id = "'+data[i].id+'" class = "table-row">';
			var closeRow = '</tr>';
			var tdId = '<td class = "table-db-id">'+data[i].id+'</td>';
			var tdCountry = '<td class = "table-country-name">'+data[i].country+'</td>';
			var tdUse	= '<td class="table-use"><button class="btn btn-danger delete-country-button">Delete</button></td>';
			//Добавляем элементы в нужном порядке
			$('.table tbody').append(openRow+tdId+tdCountry+tdUse+closeRow);
		}
		
	}
	//Если заполняем таблицу городами
	if (option == "cities")
	{
		//Определяем дефолтную структуру и добавляем ее
		var struct = "<tr><td>Id</td><td>City</td><td>Country</td><td>Use</td></tr>";
		$('.table thead').append(struct);
		//Сканим количество прилетевших записей
		for (var i = 0; i<data.length; i++)
		{
			//Задаем отдельные элементы
			var openRow = '<tr id = "'+data[i].id+'" class = "table-row">';
			var closeRow = '</tr>';
			var tdId = '<td class = "table-db-id">'+data[i].id+'</td>';
			var tdCity = '<td class = "table-db-id">'+data[i].city+'</td>';
			var tdCountry = '<td class = "table-country-name">'+data[i].country+'</td>';
			var tdUse	= '<td class="table-use"><button class="btn btn-danger delete-city-button">Delete</button></td>';
			//Добавляем элементы в требуемом порядке.
			$('.table tbody').append(openRow+tdId+tdCity+tdCountry+tdUse+closeRow);
		}
	}

	//Кнопки удаления приходится определять тут.
	$('.delete-country-button').click(function(){
		var id = $(this).parent().parent()[0].id;
		deleteCountry(id);
	});

	$('.delete-city-button').click(function(){
		var id = $(this).parent().parent()[0].id;
		deleteCity(id);
	});
	//Показываем таблицу в любом случае
	$('.table').show('fast');
}

function getTableCountries()
{
	$.ajax
	({
		type:'post',
		url: getURL()+'/res/func/database/FillAdminTableReceiver.php',
		data:{fillTableCountries:true},
		response:'text',
		success:function(data)
		{
			data = JSON.parse(data);
			fillTable("countries", data);
		}
	});
}

function getTableCities()
{
	$.ajax
	({
		type:'post',
		url: getURL()+'/res/func/database/FillAdminTableReceiver.php',
		data:{fillTableCities:true},
		response:'text',
		success:function(data)
		{
			data = JSON.parse(data);
			fillTable("cities", data);

		}
	});
}

$(document).ready(function(){

	var addCountry = true;
	var addFormHide = true;

	$(".fill-table-countries-button").click(function(){
		getTableCountries();
		addFormHide = true;
		addCountry = true;
	});

	$(".fill-table-cities-button").click(function(){
		getTableCities();
		addFormHide = true;
		addCountry = false;
	});

	$(".add-button").click(function(){
		if (addFormHide)
		{
			$('.add-form').show('fast');
			$(this).html('Cancel');;
			addFormHide = false;
			prepareForAdd(addCountry);
		}
		else
		{
			$('.add-form').hide('fast');
			$(this).html('Add');
			addFormHide = true;
		}
	});

	$('.add-form-submit').click(function(){
		if (addCountry)
		{
			addNewCountry();
		}
		else
		{
			addNewCity();
		}
	});

	getTableCountries();

});