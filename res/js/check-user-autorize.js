function setUserExit()
{
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
			$(".header-autorize-container").show();
			setTimeout(function(){
			var warning = ($('.warning-container').hide('fast'));
			}, 3000);
		}
	})
}

function checkUserLogged()
{
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
	});
});


