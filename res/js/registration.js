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
						* Регулярное выражение. Сначала идет сколько угодно (но не менее 3) букв, цифр или тире с точкой, подчеркиванием
						* Первый символ должен быть буквой или цифрой. 
						* После него обязательно стоит "собака", после которой идет хотя бы 2 буквы домена
						* После которого стоит точка, а после нее доменное пространство от 2 до 7 латинских букв нижнего регистра
						* Минимум - ru, максимум museum.
						* Если условие совпало, утверждаем email как верный.
						*/
						var regular = /^[a-zA-Z0-9][-_.a-zA-Z0-9]{3,}[@][a-zA-z]{2,}[.][a-z]{2,7}/;
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
	//Если хоть одно поле было неверно заполнено
	if (valide != 6)										
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
	$(".preloader").show("fast");
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
					$(".preloader").hide("fast");
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
		$('.warning-container').removeClass('bg-success').addClass('bg-danger');
		$('.warning-container').html("Password must be match!");
		var warning = ($('.warning-container').show('fast'));
	}
		$(".preloader").hide("fast");

}


function autorizeUser()
{
	$(".preloader").show("fast");
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
					$('.warning-container').html("You are logged in as "+data.role);
					var warning = ($('.warning-container').show('fast'));
					$('.header-autorize-container').hide('fast');
					$('.header-user-info-container').show('fast');
					setTimeout(function(){
						var warning = ($('.warning-container').hide('fast'));
						if (data.roleId == 1)
						{
							document.location = getURL()+'admin-panel/';
						}
					}, 1000);
				}
				else
				{
					$('.warning-container').removeClass('bg-success').addClass('bg-danger');
					$('.warning-container').html("Invalid login or password");
					var warning = ($('.warning-container').show('fast'));
					$('.autorize-password').val('');
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
	$(".preloader").hide("fast");
}

//Напоминание пароля
function remindPassword(userConfirmed)
{
	$(".preloader").show("fast");
	//Если пользователь ввел ник и нажал на кнопку.
	if (userConfirmed == 0)
	{
		var username = $("input[name=remind-username-field]").val();

		$.ajax
		({
			type:"post",
			url: getURL()+'res/func/registration/RegistrationPostReceiver.php',
			data:{remindPasswordSend:true,username:username},
			response:"text",
			success:function(data)
			{
				$(".preloader").hide("fast");
				$('.warning-container').removeClass('bg-danger').addClass('bg-success');
				$('.warning-container').html("Remind password procedure has been send to your email.");
				var warning = ($('.warning-container').show('fast'));
				setTimeout(function(){
					document.location = getURL();
				}, 3000);

			}
		});
	}
	//Если пользователь уже вводил имя, и перешел на страницу по токену.
	else
	{
	 	$(".preloader").show("fast");
		var url = document.location.href;
		var index = url.indexOf("?");
		var token = url.substring(index+7, url.length);
		
		var newPassword = $("input[name=remind-input-password]").val();
		var newRepeatPassword = $("input[name=remind-repeat-password]").val();
		if (newPassword == newRepeatPassword)
		{

			$.ajax
			({
				type:"post",
				url: getURL()+"res/func/registration/RegistrationPostReceiver.php",
				data:{remindPasswordGet:true,token:token,newPassword:newPassword},
				response:"text",
				success:function(data)
				{
					if (data == 1)
					{
						$('.warning-container').removeClass('bg-danger').addClass('bg-success');
						$('.warning-container').html("Password successfully changed! You will be redirected automatically...");
						var warning = ($('.warning-container').show('fast'));
						setTimeout(function(){
							var warning = ($('.warning-container').hide('fast'));
							document.location = getURL();
						}, 3000);
					}
					else
					{
						$('.warning-container').removeClass('bg-success').addClass('bg-danger');
						$('.warning-container').html(" Your timebased activation key has expired! Try send a password restore request again");
						var warning = ($('.warning-container').show('fast'));	
					}
				}
			});
		}
		else
		{
			$('.warning-container').removeClass('bg-success').addClass('bg-danger');
			$('.warning-container').html("Passwords must be match!");
			var warning = ($('.warning-container').show('fast'));
		}
	}
	$(".preloader").hide("fast");
}

function confirmUser()
{
	var regular = /[?]/;
	var url = document.location.href;
	if (url.match(regular))
	{
		$("input[name = remind-username-field]").hide();
		$("input[name = remind-input-password]").show();
		$("input[name = remind-repeat-password]").show();
		return 1;
	}
	else
	{
		$("input[name = remind-username-field]").show();
		$("input[name = remind-input-password]").hide();
		$("input[name = remind-repeat-password]").hide();
		return 0;
	}
}

$(document).ready(function(){
	$('.submit-button').click(function(){
		createNewUser();
	});

	$(".autorize-button").click(function(){
		autorizeUser();
	});

	$(".remind-submit-button").click(function(){
		remindPassword(userConfirmed);
	});

	$(".autorize-password").keypress(function(eventObject){
		if(eventObject.which == 13)
		{
			$(".autorize-button").click();
		}
	});

	var userConfirmed = confirmUser();
});