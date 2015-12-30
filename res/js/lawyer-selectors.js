	
	//Функция для формирования карточек-визиток адвокатов.
	function buildDiv(id, name, secondName, skype, email, hangout, i)
	{
		var openRowDiv = '<div class="row">';
		var closeDiv = '</div>';
		var mainContainer = '<div class="col-lg-3 lawyer-container" id = "'+id+'">';
		var avatarContainer = '<div class="col-lg-7 avatar-container"><img class = "avatar" src="'+getURL()+'store/lawyers-info/photos/avatar_'+id+'.jpg"></div>';
		var nameContainer = '<div class="col-lg-5 name-container"><div class="row name">'+name+'</div><div class="row second-name">'+secondName+'</div></div>';
		var skypeContainer = '<div class="row text-center col-lg-6 skype-container"><a class = "btn btn-success form-control" href = "skype:'+skype+'?call">Call Skype</a></div>';
		var emailContainer = '<div class="col-lg-12 bg-info text-center email-container"><span class = "email-icon glyphicon glyphicon-envelope"></span><p class = "email-text">'+email+'</p></div>';
		var hangoutContainer = '<div class="col-lg-12 bg-warning text-center hangout-container"><span class = "email-icon glyphicon glyphicon-pencil"></span><p class = "email-text">'+hangout+'</p></div>';
		var showInfoButton = '<div class="col-lg-12 text-center"><button href = "#anchor" class="btn btn-info form-control info-button">About</button></div>';
		
		var prepare = mainContainer + avatarContainer+nameContainer+skypeContainer+emailContainer+hangoutContainer+showInfoButton+closeDiv;
		
		//Параметры отображения по трое в ряд.
		switch (i%3)
		{
			case 0: 
				return openRowDiv+prepare; 
			break;
			case 2:
				return prepare+closeDiv;
			break;
			default:
				return prepare;
			break;
		}
		
	}

	//Функция возвращает юристов, живущих в полученном городе.
	function getAvailableLawyers(cityId)
	{
		$(".preloader").show("fast");
		$('div.lawyer-preview-container div').each(function(){
			$(this).remove();
		});
		var lawyerContainer = '';

		$.ajax
		({
			type:'post',
			url: getURL()+'/res/func/lawyers/LawyerPostReceiver.php',
			data:{getLawyersCity:true, id:cityId},
			response:'text',
			success:function(data)
			{
				data = JSON.parse(data);
				if (data[0] != undefined)
				{
					for (var i = 0; i < data.length; i++)
					{
						//Вывод дива с лоерами начинается отсюда
						var lawyerDiv = $('div.lawyer-preview-container');
						var id = data[i].id;
						var name = data[i].name;
						var secondName = data[i].secondName;
						var skype = data[i].skype;
						var email = data[i].email;
						var hangout = data[i].hangout;
						lawyerContainer += buildDiv(id, name, secondName, skype, email, hangout, i);
					}
					$('.warning-container').removeClass('bg-danger').addClass('bg-info');	
					$('.warning-container').html("Result of your search:");
					$('.warning-container').show('fast');
					lawyerDiv.append(lawyerContainer);
					$('.lawyer-container img, .info-button').click(function(){
						showLawyerInfo(this);
					});
					$(".preloader").hide("fast");
				}	
				else
				{
					$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
					$('.warning-container').html("Have no lawyers in this city!.");
					$('.warning-container').show('fast');
					$('.city-selector').val("");
					$(".preloader").hide("fast");
				}
			}
		});
	}

	//Получаем города, айди страны которых совпадает с выбранной
	function getAvailableCities(countryId){
		$(".preloader").show("fast");
		$('select.city-selector option').each(function(){
			$(this).remove();
		});
		$('select.city-selector').show();

		$.ajax
		({
			type:'post',
			url: getURL()+'res/func/lawyers/LawyerPostReceiver.php',
			data:{getCity:true, id:countryId},
			response:'text',
			success:function(data)
			{
				data = JSON.parse(data);
				if(data != false)
				{
					
					$('select.city-selector').append('<option disabled selected value="">SELECT CITY</option>');
					for (var i = 0; i < data.length; i++)
					{
						$('select.city-selector').append('<option data-country-id = "'+data[i].countryId+'" value="'+data[i].cityId+'">'+data[i].city+'</option>');	
					}
					$(".preloader").hide("fast");
				}
				else
				{
					$('.warning-container').removeClass('bg-success').addClass('bg-danger');	
					$('.warning-container').html("There is no citi in the chosen country where registered lawyers live...");
					$('.warning-container').show('fast');
					$('.city-selector').hide();
					$('.country-selector').val("");
					$(".preloader").hide("fast");
				}
			}
		});
	}

	//Выбрать все доступные страны.
	function getCountryOptions()
	{
		$(".preloader").show("fast");
		$.ajax
		({
			type:'post',
			url: getURL()+'res/func/lawyers/LawyerPostReceiver.php',
			data:{getCountry:true},
			response:'text',
			success:function(data)
			{
				data = JSON.parse(data);
				$('select.country-selector').append('<option disabled="disabled" selected="selected" value="">SELECT COUNTRY</option>');
				for (var i = 0; i < data.length; i++) 
				{		
					$('select.country-selector').append('<option value="'+data[i].id+'">'+data[i].country+'</option>');	
				};
				$(".preloader").hide("fast");
			}
		});
	}

	function showLawyerInfo(lawyer)
	{
		var lawyerId =	$(lawyer).parent().parent().attr("id");

		$(".preloader").show("fast");
		$.ajax
		({
			type:'post',
			url: getURL()+'res/func/lawyers/LawyerPostReceiver.php',
			data:{getLawyerInfo:true, id: lawyerId},
			response:'text',
			success:function(data)
			{
				data = JSON.parse(data);
				$('.lawyer-full-info').hide('fast');
				$(".photo-container .avatar").attr('src',getURL()+'store/lawyers-info/photos/avatar_'+data.id+'.jpg');
				$('.full-country-container').html(data.country);
				$('.full-city-container').html(data.city);
				$('.full-name-container').html(data.name + ' '+data.secondName);
				$('.skype-address').html(data.skype);
				$('.skype-call a').attr('href','skype:'+data.skype+'?call');
				$('.email-address').html(data.email);
				$('.hangout-address').html(data.hangout);
				$('.resume-header h1').html(data.name + ' '+data.secondName+'\'s Resume');
				$('.full-text-resume').html(data.resume);
				$('.lawyer-full-info').show('fast');
				$('a[href^="#"]').click();
				$(".preloader").hide("fast");
			}
		});
	}

$(document).ready(function(){
	getCountryOptions();
	$('.country-selector').change(function(){
		$('.city-selector').val();
		$('div.lawyer-preview-container div').each(function(){
			$(this).hide('fast');
		});
		$('.lawyer-full-info').hide('fast');
		getAvailableCities(this.value);
	});
	$('.city-selector').change(function(){
		$('.lawyer-full-info').hide('fast');
		getAvailableLawyers(this.value);
	});
});



	






