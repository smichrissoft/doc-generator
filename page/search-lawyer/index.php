<?php require("../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php getHead("Contact Lawyers"); ?>
	<?php echo '<script src="'.REL_URL.'res/js/lawyer-selectors.js'.'"></script>' ?>
</head>
<body>
	<div class="wrapper">
		<?php getHeader("Lawyers"); ?>
		<div class="warning-container container text-center">
			<div class="warning"><p>Alert!</p></div>	
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center lawyer-user-select">
					<div class="informer row text-center">
					<label class = "country-selector input-lg">Select country</label>
					<select name="country" class="selector form-control target country-selector"></select>
					</div>
					<div class="informer row text-center">
					<label class = "city-selector">Select city</label>
					<select name="country" class="selector form-control city-selector"></select>
					</div>
				</div>
							
			</div>
			<div class="row">
				<div class="col-lg-12 lawyer-preview-container">
				</div>
			</div>
			<div class="container lawyer-full-info">
				
				<div class="row lawyer-contacts">
				<a href="#anchor" id="anchor"></a>
					<div class="photo-container col-lg-6"><img class = "avatar" src="" height="300" width="300"></div>
					<div class="full-country-container col-lg-3 text-left">Country</div>
					<div class="full-city-container col-lg-3 text-right">City</div>
					<div class="full-name-container col-lg-6 text-center">Name Secondname</div>
					
					<div class="full-skype-container col-lg-6 text-center">
						<h2>Skype</h2>
						<div class="skype-address col-lg-9 bg-success text-left">name-secondname-91</div>
						<div class="skype-call col-lg-3 text-left"><a class="btn btn-success form-control">Call Skype</a></div>
					</div>
					<div class="full-email-container col-lg-6 text-center">
						<h2>E-mail</h2>
						<div class="email-address col-lg-9 text-left">name-secondname@email.com</div>
						<div class="email-send col-lg-3 text-left"><button class="btn btn-info form-control">Send Email</button></div>
					</div>
					<div class="full-hangout-container col-lg-6 text-center">
						<h2>Hangout</h2>
						<div class="email-address col-lg-9 text-left">name-secondname@hangout.com</div>
						<div class="email-send col-lg-3 text-left"><button class="btn btn-warning form-control">Call Hangout</button></div>
					</div>
				</div>
				<div class="lawyer-resume">
					<div class="col-lg-12 text-center">
					<pre>
						<div class="resume-header col-lg-12 text-center"><h1>Resume</h1></div>
						<div class="full-text-resume col-lg-12 text-justify">Resume text</div>
					</pre>
					</div>
				</div>
			</div>
		</div>
		<?php getFooter(); ?>
	</div>
</body>
</html>
