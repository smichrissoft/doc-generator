//Проверка на заполнение формы.
function formValidator()
{
	var valide = 0;
	var valideEmail = false;

	//Тут довольно сложный цикл, поясняю построчно
	//Перебираем все дивы с классом registration, их несколько
	$('.registration').each(function(i){
		//В каждом из этих дивов получаем дочерние элементы
			$(this).children().each(function (i){ 	
			//Узнаем, чем является элемент			
				var tag = $(this)[0].tagName; 	
				//Если он является инпутом				
				if (tag == "INPUT")								
				{
					//Проверяем, является ли он полем имейла.
					if ($(this).attr("name") == "user-email")
					{
						//Получаем введенное значение
						var email = $(this).val();
						/*
						* Регулярное выражение. Сначала идет сколько угодно (но не менее 3) букв, цифр или тире с подчеркиванием
						* После него обязательно стоит "собака", после которой идет хотя бы 2 буквы домена
						* После которого стоит точка, а после нее доменное пространство от 2 до 7 латинских букв нижнего регистра
						* Если условие совпало, утверждаем email как верный.
						*/
						var regular = /^[-_a-zA-Z0-9]{3,}[@][a-zA-z]{2,}[.][a-z]{2,7}/;
							if (email.match(regular))
							{
								valideEmail = true;
								valide++;
								$(this).removeClass("bg-danger").addClass("bg-success");
							}	
							else
							{
								$(this).removeClass("bg-success").addClass("bg-danger");
								valideEmail = false;
							}		
					}
					//Если инпут не является полем email
					else
					{
						//Проверяем длину, и если она больше 2 символов
						if($(this).val().length > 2)			
						{
							//Инкрементируем счетчик
							valide++;			
							//И красим фон этого инпута в белый	
							$(this).removeClass("bg-danger").addClass("bg-success");
						}
						//Если он меньше 2 символов
						else									
						{
							//Красим инпут в красный
							$(this).removeClass("bg-success").addClass("bg-danger");	
						}
					}
						
				}
			});
	});
	if (valide != 6)										//Если хоть одно поле было неверно заполнено
	{

		if (valideEmail==true)
		{
			$('.warning-container').removeClass('bg-success').addClass('bg-danger');
			$('.warning-container').html("Invalid form. Please, check all field. Each field must be at least 3 characters.");
			var warning = ($('.warning-container').show('fast'));	

		}
		else
		{
			$('.warning-container').removeClass('bg-success').addClass('bg-danger');
			$('.warning-container').html("Invalid email!");
			var warning = ($('.warning-container').show('fast'));	
		}
		return false;
	}
	else
	{	
		//Если валидация прошла, то скрываем алерт, и возвращаем 1.
		var warning = ($('.warning-container').hide('fast'));
		return true;
	}
}

//Функция для добавления юзера
function createNewUser()
{
	var login = $('input[name = login-field]').val();
	var firstPassword = $('input[name = input-password]').val();
	var repeatPassword = $('input[name = repeat-password]').val();
	if (firstPassword == repeatPassword)
	{
		var userName = $('input[name = user-name]').val();
		var userSecondName = $('input[name = user-second-name]').val();
		var userEmail = $('input[name = user-email]').val();

		if (formValidator()==true)
		{
			$.ajax
			({
				type:'post',
				url: getURL()+'res/func/registration/RegistrationPostReceiver.php',
				data:
				{
					createNewUser:true,
					login:login,
					password:firstPassword,
					userName:userName,
					userSecondName:userSecondName,
					userEmail:userEmail
				},
				response:'text',
				success:function(data)
				{
					if (data == 1)
					{
						$('.warning-container').removeClass('bg-danger').addClass('bg-success');
						$('.warning-container').html("Your account succesfully created! You will be redirected automatically...");
						var warning = ($('.warning-container').show('fast'));
						$('.submit-button').attr("disabled",true);
						setTimeout(function(){
						document.location = getURL();
						}, 3000);
					}
					else
					{	
						if(data.length == 43)
						{
							$('.warning-container').removeClass('bg-success').addClass('bg-danger');
							$('.warning-container').html("This user already exists! Try to create an account with a different name");
							var warning = ($('.warning-container').show('fast'));
						}
						else
						{
							$('.warning-container').removeClass('bg-success').addClass('bg-danger');
							$('.warning-container').html("Something went wrong! We fix it...");
							var warning = ($('.warning-container').show('fast'));
						}
					}
				}
			});
	
		}
	}
	else
	{
		alert("Passwords must be match!");
	}
}

function autorizeUser()
{
	var login = $('.autorize-login').val();
	var password = $('.autorize-password').val();
	if (login.length != 0 && password.length != 0)
	{
		var warning = ($('.warning-container').hide('fast'));
		$.ajax
		({
			type:'post',
			url: getURL()+'res/func/registration/RegistrationPostReceiver.php',
			data:
			{
				autorizeUser:true,
				login:login,
				password:password
			},
			response:'text',
			success:function(data)
			{
				if (data != 0)
				{
					data = JSON.parse(data);
					$('.user-info-id p').html(data.id);
					$('.user-info-nickname p').html(data.login);
					$('.user-info-username p').html(data.name+' '+data.secondName);
					$('.user-info-role p').html(data.role);
					$('.warning-container').removeClass('bg-danger').addClass('bg-success');
					$('.warning-container').html("You are logged in");
					var warning = ($('.warning-container').show('fast'));
					$('.header-autorize-container').hide('fast');
					$('.header-user-info-container').show('fast');
					setTimeout(function(){
						var warning = ($('.warning-container').hide('fast'));
					}, 3000);
				}
				else
				{
					$('.warning-container').removeClass('bg-success').addClass('bg-danger');
					$('.warning-container').html("Invalid login or password");
					var warning = ($('.warning-container').show('fast'));
					$('.autorize-password').val('');
					setTimeout(function(){
						var warning = ($('.warning-container').hide('fast'));
					}, 3000);
				}
			}
		});
	}
	else
	{
		$('.warning-container').removeClass('bg-success').addClass('bg-danger');
		$('.warning-container').html("Fields must be filled!");
		var warning = ($('.warning-container').show('fast'));
	}
}



$(document).ready(function(){
	$('.submit-button').click(function(){
		createNewUser();
	});

	$(".autorize-button").click(function(){
		autorizeUser();
	});
});