//Функция, которая предваряет отправку формы с изменениями. Делается проверка расширения файлов
//И вылетают варнинги в случае успеха
function executeLawyerChanges()
{
	if (validateFiles() == true)
	{
		$(".change-lawyer-info-container").hide("fast");
		$('.preloader').show("fast");
		$('.warning-container').removeClass('bg-danger').addClass('bg-success');
		$('.warning-container').html("Sending data... Please, check changes after reload page.");
		var warning = ($('.warning-container').show('fast'));
		setTimeout(function(){
		$("#change-lawyer").submit();
		}, 3000);
	}
}

//Валидатор выбранных файлов. Допускается использование jpg для фото и html для резюме.
function validateFiles()
{
	var photoExp	= $(".change-form-photo-input").val();
	var resumeExp 	= $(".change-form-resume-input").val();
	var photoReg 	= /[.][j][p][g]$/;
	var resumeReg	= /[.][h][t][m][l]$/;
	if (photoExp.match(photoReg) || photoExp == "")
	{
		if (resumeExp.match(resumeReg) || resumeExp == "")
		{
			return true;
		}
		else
		{
			$('.warning-container').removeClass('bg-success').addClass('bg-danger');
			$('.warning-container').html("Resume file must be .html!");
			var warning = ($('.warning-container').show('fast'));
			
			return false;
		}
	}
	else
	{
		$('.warning-container').removeClass('bg-success').addClass('bg-danger');
		$('.warning-container').html("Photo must be .jpg");
		var warning = ($('.warning-container').show('fast'));
			
		return false;
	}
}

//Функция срабатывает при клике на кнопку change
function showLawyerChangeForm()
{
	$(".preloader").show("fast");
	var lawyerId = $(".admin-lawyer-info-id").val();
	var container = $(".change-lawyer-info-container .form-group");

	$.ajax
	({
		type:"post",
		url: getURL()+"res/func/lawyers/LawyerPostReceiver.php",
		data:{getLawyerInfo: true, id:lawyerId},
		response:"text",
		success:function(data)
		{
			
			data = JSON.parse(data);
			container.children(".change-form-id").val(data.id);
			container.children(".change-form-name").val(data.name);
			container.children(".change-form-second-name").val(data.secondName);
			container.children(".change-form-skype").val(data.skype);
			container.children(".change-form-email").val(data.email);
			container.children(".change-form-hangout").val(data.hangout);
		}
		
	});
	$(".preloader").hide("fast");
	$(".change-lawyer-info-container").show("fast");
}

//Функция для понижения лоера в звании до юзера.
function reduceLawyer(lawyerId)
{
	$(".preloader").show("fast");

	if (confirm("Are you sure?"))
	{	
		$.ajax
		({
			type:'post',
			url:getURL()+'res/func/admin-panel/FillAdminTableLawyerReceiver.php',
			data:{reduceLawyer:true, id:lawyerId},
			response:'text',
			success:function(data)
			{
				
				if (data == true)
				{
					
						$('.warning-container').removeClass('bg-danger').addClass('bg-success');
						$('.warning-container').html("Lawyer successfully deleted!");
						var warning = ($('.warning-container').show('fast'));
						$('.select-right-table-preview').hide();
						$('h2.select-right-table-preview').html("Lawyers Panel");	
						$('.select-right-table-preview').show("fast");
						$('.new-lawyer-button').show("fast");
						$('.lawyers-table')				.hide('fast');
						getTableCountries();
					}
				}
		});
			$(".preloader").hide("fast");
	}
}

//Выполняем при нажатии на кнопку Confirm and Submit
function addNewLawyer()
{
	//Получаем значения ID из таблицы.
	var userId 		= $('.add-lawyer-user-selector').val();
	var countryId 	= $('.add-lawyer-country-selector').val();
	var cityId 		= $('.add-lawyer-city-selector').val();

	//Если выбран хоть какой-то юзер
	if (userId != null)
	{
		$(".preloader").show("fast");
		$.ajax
		({
			type:'post',
			url: getURL()+'res/func/admin-panel/FillAdminTableLawyerReceiver.php',
			data:{addNewLawyer:true,userId:userId,cityId:cityId,countryId:countryId},
			response:'text',
			success:function(data)
			{
				//Если пришел утвердительный ответ без ошибок
				if (data == true)
				{
					$('.warning-container').removeClass('bg-danger').addClass('bg-success');
					$('.warning-container').html("Lawyer successfully added!");
					var warning = ($('.warning-container').show('fast'));	
					$(".lawyer-add-form").hide("fast");
					$(".new-lawyer-button").removeClass("btn-danger").addClass("btn-success");
					$(".new-lawyer-button").html("Add new lawyer");
					getTableCountries();
					$(".preloader").hide("fast");
					setTimeout(function(){
						$('.warning-container').hide('fast')
					}, 3000);
				}
				else
				{
					$('.warning-container').removeClass('bg-success').addClass('bg-danger');
					$('.warning-container').html("Something went wrong!");
					$(".preloader").hide("fast");
				}
			}
		});
	}
	else
	{
		$('.warning-container').removeClass('bg-success').addClass('bg-danger');
		$('.warning-container').html("Users isn't selected!");
		var warning = ($('.warning-container').show('fast'));
		$(".preloader").hide("fast");
	}
}

//Получаем список городов, совпадающий выбранной стране. Происходит при выборе страны.
function getAvailableCities(cityId)
{
	$(".preloader").show("fast");
	//Чистим селектор
	$(".add-lawyer-city-selector option").each(function(){
		$(this).remove();
	});
	//Добавляем заглушку в селектор
	$(".add-lawyer-city-selector").append('<option selected="selected" disabled="disabled" value="">SELECT CITY</option>');
	
	
	$.ajax
	({
		type:'post',
		url: getURL()+'res/func/lawyers/LawyerPostReceiver.php',
		data:{getCity:true, id:cityId},
		response:'text',
		success: function (data)
		{	
			data = JSON.parse(data);
			//В цикле добавляем новые опции в селектор
			for (var i = 0; i < data.length; i++)
			{
				$(".add-lawyer-city-selector").append('<option value="'+data[i].cityId+'">'+data[i].city+'</option>');	
			};
			$(".preloader").hide("fast");
		}
	});
}

//Выборка и заполнения селектора юзерами, которые пока не являются адвокатами
function getAvailableUsers()
{
	$(".preloader").show("fast");
	//Чистим селектор стран и юзеров
	$(".add-lawyer-country-selector option").each(function(){
		$(this).remove();
	});
	$(".add-lawyer-user-selector option").each(function(){
		$(this).remove();
	});
	$(".add-lawyer-city-selector option").each(function(){
		$(this).remove();
	});
	$(".lawyer-add-form .add-form-submit").show();

	//Добавляем заглушки на селекторы
	$(".add-lawyer-country-selector").append('<option selected="selected" disabled="disabled" value="">SELECT COUNTRY</option>');
	$(".add-lawyer-user-selector").append('<option selected="selected" disabled="disabled" value="">SELECT USER</option>');
	

	$.ajax
	({
		type:'post',
		url: getURL()+'res/func/admin-panel/FillAdminTableLawyerReceiver.php',
		data:{getAvailableUsers:true},
		response:'text',
		success: function (data)
		{
			data = JSON.parse(data);
			//В цикле заполняем селектор юзерами
			for (var i = 0; i < data.length; i++)
			{
				$(".add-lawyer-user-selector").append('<option value="'+data[i].id+'">'+data[i].username+'</option>');
			};
			$(".preloader").hide("fast");
		}
	});

	$(".preloader").show("fast");
	$.ajax
	({
		type:'post',
		url: getURL()+'res/func/lawyers/LawyerPostReceiver.php',
		data:{getCountry:true},
		response:'text',
		success: function (data)
		{
			$(".preloader").hide("fast");
			data = JSON.parse(data);
			for (var i = 0; i < data.length; i++)
			{
				$(".add-lawyer-country-selector").append('<option value="'+data[i].id+'">'+data[i].country+'</option>');
			};
			
		}
	});
}

//Получаем необходимую инфу об выбранном адвокате при клике на таблицу
function getOnceLawyer(lawyerId)
{
	$(".preloader").show("fast");
	//Скрываем, чтобы без палева, если лагает
	$(".admin-lawyer-info-container").hide();
	
	
	$.ajax
	({
		type:'post',
		url:getURL()+'res/func/lawyers/LawyerPostReceiver.php',
		data:{getLawyerInfo:true, id:lawyerId},
		response:'text',
		success:function(data)
		{
			data = JSON.parse(data);
			//Заполняем контейнер инфой
			$(".admin-lawyer-info-avatar img").attr("src",getURL()+'store/lawyers-info/photos/avatar_'+data.id+'.jpg');
			$(".admin-lawyer-info-country").html(data.country);
			$(".admin-lawyer-info-city").html(data.city);
			$(".admin-lawyer-info-name").html(data.name+" "+data.secondName);
			$(".admin-lawyer-info-id").val(data.id);
			if (data.skype != "")
			{
				$(".admin-lawyer-info-skype a").attr("href","skype:"+data.skype+"?call");
				$(".admin-lawyer-info-skype").show();
			}
			else
				$(".admin-lawyer-info-skype").hide();

			if (data.email != "")
			{
				$(".admin-lawyer-info-email p").html(data.email);
				$(".admin-lawyer-info-email").show();
			}
			else
				$(".admin-lawyer-info-email").hide();

			if (data.hangout != "")
			{
				$(".admin-lawyer-info-hangout p").html(data.hangout);
				$(".admin-lawyer-info-hangout").show();
			}
			else
			$(".admin-lawyer-info-hangout").hide();
			$(".admin-lawyer-info-resume h3").html(data.name+" "+data.secondName+"'s resume");
			$(".admin-lawyer-info-resume pre").html(data.resume);
			$(".admin-lawyer-info-container").show("fast");

			$(".preloader").hide("fast");
		}
	});
}

//Функция для выборки юристов по конкретному городу
function selectLawyersToCity(cityId)
{
	$(".preloader").show("fast");
	$.ajax
	({
		type:'post',
		url:getURL()+'res/func/lawyers/LawyerPostReceiver.php',
		data:{getLawyersCity:true, id:cityId},
		response:'text',
		success:function(data)
		{
			$(".preloader").hide("fast");
			data = JSON.parse(data);
			//Если ответ хоть чо-то содержит
			if (data != "")
			{
				//Переводим таблицу в режим городов и заполняем
				$('.lawyers-table').removeClass("country").addClass("city");
				fillLawyerTable(data);
			}
			//Если сломалось, выкидываем ахтунг
			else
			{
				$(".preloader").hide("fast");
				$('.warning-container').removeClass('bg-success').addClass('bg-danger');
				$('.warning-container').html("Have no lawyers in this city!");
				var warning = ($('.warning-container').show('fast'));
				$('.lawyers-table')	.hide('fast');
				$('.select-right-table-preview').hide();
				$('.new-lawyer-button').hide();
				$('h2.select-right-table-preview').html("Lawyers Panel");
				$('.select-right-table-preview').parent().removeClass("col-lg-12").addClass("col-lg-9");
				$('.submit-button').attr("disabled",true);
				setTimeout(function(){
				$('.select-right-table-preview').show("fast");
				$('.new-lawyer-button').show("fast");
				$('.lawyers-table')				.hide('fast');
				}, 2000);
			}
			
		}
	});
}

//Выборка юристов по выбранно стране
function selectLawyersToCountry(countryId)
{
	$(".preloader").show("fast");
	$.ajax
	({
		type:'post',
		url:getURL()+'res/func/lawyers/LawyerPostReceiver.php',
		data:{getLawyersCountry:true, id:countryId},
		response:'text',
		success:function(data)
		{
			data = JSON.parse(data);
			//Если ответ не пустой
			if (data != "")
			{
				//Переводим таблицу в режим стран, и заполняем адвокатами.
				$('.lawyers-table').removeClass("city").addClass("country");
				fillLawyerTable(data);
			}
			//Если чот не так, выкидываем ахтунг
			else
			{
				$(".preloader").hide("fast");
				$('.warning-container').removeClass('bg-success').addClass('bg-danger');
				$('.warning-container').html("Have no lawyers in this country!");
				var warning = ($('.warning-container').show('fast'));
				$('.lawyers-table')				.hide('fast');
				$('.select-right-table-preview').hide();
				$('.new-lawyer-button').hide("fast");
				$('h2.select-right-table-preview').html("Lawyers Panel");	
				$('.submit-button').attr("disabled",true);
				$('.select-right-table-preview').parent().removeClass("col-lg-12").addClass("col-lg-9");

				setTimeout(function(){
				$('.select-right-table-preview').show("fast");
				$('.new-lawyer-button').show("fast");
				$('.lawyers-table')				.hide('fast');
				$('.warning-container').hide('fast');
				}, 2000);
			}	
		}
	});
$(".preloader").hide("fast");
}

//Функция для непосредственного заполнения таблицы
function fillLawyerTable(data)
{
	//Сначала чистим все ненужное
	$('.lawyers-table')				.hide('fast');
	$('.lawyers-table thead')		.html("");
	$('.lawyers-table tbody')		.html("");
	$('.select-right-table-preview').hide("fast");
	$('.select-right-table-preview').parent().removeClass("col-lg-9").addClass("col-lg-12");

	//Если мы добавляем выборку по стране
	if ($('.lawyers-table').hasClass("country"))
	{
		//Формируем структуру таблицы, заголовки и добавляем
		var struct = "<tr><td>Id</td><td>Second Name</td><td>Name</td><td>City</td><td>Skype</td><td>Use</td></tr>";
		$('.lawyers-table thead').append(struct);
	
		//Заполняем значения прилетевшими данными, и выливаем в таблицу построчно
		for (var i = 0; i < data.length; i++)
		{
			var openRow = '<tr id = "'+data[i].id+'" class = "lawyers-table-row">';
			var closeRow = '</tr>';
			var tdId = '<td class = "lawyers-table-db-id">'+data[i].id+'</td>';
			var tdName = '<td class = "lawyers-table-name">'+data[i].name+'</td>';
			var tdSecondName = '<td class = "lawyers-table-second-name">'+data[i].secondName+'</td>';
			var tdCity = '<td class = "lawyers-table-country-name">'+data[i].city+'</td>';
			var tdSkype = '<td class="lawyers-table-skype"><a href="skype:'+data[i].skype+'?call"><button class="btn btn-success lawyer-skype-button form-control"><span class = "glyphicon glyphicon-earphone"></span></button></a></td>';
			var tdUse	= '<td class="lawyers-table-use"><button class="btn btn-danger reduce-lawyer-button form-control"><span class = "glyphicon glyphicon-arrow-down"></span>Reduce to User</button></td>';
			$('.lawyers-table tbody').append(openRow+tdId+tdSecondName+tdName+tdCity+tdSkype+tdUse+closeRow);	
		}

		//Показываем красоту и полученную инфу
		$('h2.select-right-table-preview').html("Result of search lawyers in the "+data[0].country);	
		$('h2.select-right-table-preview').show("fast");
		$('.lawyers-table').show('fast');
	}
	//Если мы добавляем города
	if ($('.lawyers-table').hasClass("city"))
	{
		var struct = "<tr><td>Id</td><td>Name</td><td>SecondName</td><td>Skype</td><td>Use</td></tr>";
		$('.lawyers-table thead').append(struct);

		for (var i = 0; i < data.length; i++)
		{
			var openRow = '<tr id = "'+data[i].id+'" class = "lawyers-table-row">';
			var closeRow = '</tr>';
			var tdId = '<td class = "lawyers-table-db-id">'+data[i].id+'</td>';
			var tdName = '<td class = "lawyers-table-name">'+data[i].name+'</td>';
			var tdSecondName = '<td class = "lawyers-table-second-name">'+data[i].secondName+'</td>';
			var tdSkype = '<td class="lawyers-table-skype"><a href="skype:'+data[i].skype+'"><button class="btn btn-success lawyer-skype-button form-control"><span class = "glyphicon glyphicon-earphone"></span></button></a></td>';
			var tdUse	= '<td class="lawyers-table-use"><button class="btn btn-danger reduce-lawyer-button form-control"><span class="glyphicon glyphicon-arrow-down"></span>Reduce to User</button></td>';
			$('.lawyers-table tbody').append(openRow+tdId+tdName+tdSecondName+tdSkype+tdUse+closeRow);	
		}

		$('h2.select-right-table-preview').html("Result of search lawyers in the city: "+data[0].city);	
		$('h2.select-right-table-preview').show("fast");
		$('.lawyers-table').show('fast');
	}

	$(".reduce-lawyer-button").on("click", this, function(){
		var id = $(this).parent().parent().children(".lawyers-table-db-id").html();
		reduceLawyer(id);
	});
}

$(document).ready(function(){

	//Клик по строке таблицы со странами-городами
	$(".location-table tbody").on("click", "td", function(){
		//Если при этом у нее есть класс стран, выбираем адвокатов по странам
    	if ($(".location-table").hasClass("countries"))
    	{
    		var countryId = $(this).parent().children($(".country-city-table-db-id")).html();
    		selectLawyersToCountry(countryId);
    	}
    	//Если же в таблице класс городов, выбираем юристов по городам
    	else
    	{
    		var cityId = $(this).parent().children($(".country-city-table-db-id")).html();
    		selectLawyersToCity(cityId);
    	}
	});

	//Обработка клика по таблице лоеров. При этом показывается инфа о выбранном лоере.
	$(".lawyers-table tbody").on("click", "td", function(){
		var lawyerId = $(this).parent().children($(".lawyers-table-db-id")).html();
		getOnceLawyer(lawyerId);
	});

	//Когда изменяем значение селектора стран
	$(".add-lawyer-country-selector").change(function(){
		var cityId = $(".add-lawyer-country-selector").val();
		getAvailableCities(cityId);
	});

	//Когда изменяем значение селектора городов
	$('.add-lawyer-city-selector').change(function(){
		$('.add-form-submit').show("fast");
	});

	//Когда кликаем по добавлению нового юриста
	$(".new-lawyer-button").click(function(){
		//Если кнопка не была нажата
		if (addFormHide)
		{
			//Меняем переменную, показываем форму добавления, рубим первоначальную выборку,красим кнопку.
			addFormHide = false;
			$(".lawyer-add-form").show("fast");
			getAvailableUsers();
			$(this).removeClass("btn-success").addClass("btn-danger");
			$(this).html("Cancel");
		}
		//Если кнопка уже нажата, то делаем наоборот
		else
		{
			addFormHide = true;
			$(".lawyer-add-form").hide("fast");
			$(this).removeClass("btn-danger").addClass("btn-success");
			$(this).html("Add new lawyer");
		}	
	});

	//Когда подтверждаем добавление, щелкнув по кнопке - добавляем юриста
	$(".add-form-submit").click(function(){
		addNewLawyer();
	});

	//Когда жамкаем по аватарке - тупо скрываем превьюшку.
	$(".admin-lawyer-info-avatar").click(function(){
		$(".admin-lawyer-info-container").hide("fast");
	});

	var addFormHide = true;

	$(".wrapper").click(function(){
		$(".admin-lawyer-info-container").hide("fast");
	});

	$(".lawyer-change-button").click(function(){
		showLawyerChangeForm();
	});

	$(".change-form-photo-button").click(function(){
		$(".change-form-photo-input").click();
	});

	$(".change-form-resume-button").click(function(){
		$(".change-form-resume-input").click();
	});

	$(".change-form-submit-button").click(function(){
		executeLawyerChanges();

	});

	$("#change-lawyer").submit(function(){
		return true;
	});
});
