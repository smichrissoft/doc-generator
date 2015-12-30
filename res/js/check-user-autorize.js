function deleteOldTokens()
{
	$.ajax
	({
		type:'post',
		url: getURL()+"res/func/registration/RegistrationPostReceiver.php",
		data:{deleteOldTokens:true},
		response:'text',
		success:function(data)
		{
		}
	});
}

function setUserExit()
{
	$(".preloader").show("fast");

	deleteOldTokens();

	$.ajax
	({
		type: 'post',
		url: getURL()+'/res/func/registration/UserAutorizePostReceiver.php',
		data:{setUserExit:true},
		response:'text',
		success:function(data)
		{
			$('.warning-container').removeClass('bg-danger').addClass('bg-success');
			$('.warning-container').html("You are logged out!");
			var warning = ($('.warning-container').show('fast'));
			$(".header-user-info-container").hide();
			$(".preloader").hide("fast");
			$(".header-autorize-container").show();
			setTimeout(function(){
			var warning = ($('.warning-container').hide('fast'));
			document.location = getURL();
			}, 1000);
		}
	})
}

function checkUserLogged()
{
	deleteOldTokens();

	$.ajax
	({
		type: 'post',
		url: getURL()+'res/func/registration/UserAutorizePostReceiver.php',
		data:{checkUserLogged:true},
		response:'text',
		success:function(data)
		{
			if (data == 0)
			{
				$(".header-user-info-container").hide();
				$(".header-autorize-container").show();
			}
			else
			{
				data = JSON.parse(data);
				$(".header-autorize-container").hide();
				$(".header-user-info-container").show();
				$('.user-info-id p').html(data.id);
				$('.user-info-nickname p').html(data.login);
				$('.user-info-username p').html(data.name+' '+data.secondName);
				$('.user-info-role p').html(data.role);
			}
		}
	});
}

$(document).ready(function(){
	checkUserLogged();

	$('.exit-from-login-button').click(function(){
		setUserExit();
		$(".preloader").show("fast");
	});

	$(".warning-container").click(function(){
		$(this).hide("fast");
	});
});


