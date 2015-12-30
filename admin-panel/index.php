<?php require("../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>
<?php require(SITE_URL . "res/func/registration/CheckAdminRights.php"); ?>

<?php  ?>
<!DOCTYPE html5>
<html lang="en">
<head>
	<?php getHead("Admin Panel"); ?>
	<?php echo '<script src = "'.REL_URL.'res/js/country-city-table-control.js"></script>'; ?>
	<?php echo '<script src = "'.REL_URL.'res/js/lawyers-table-control.js"></script>'; ?>
</head>
<body>
	<div class="wrapper">
		<?php getHeader(); ?>
		<div class="row"></div>
		<div class="warning-container container bg-danger text-center">
			<div class="warning">
				<p>Alert!</p>
			</div>
		</div>
		<div class="fluid-container">
			<div class="row">
				<div class="col-lg-7 admin-controls-container">
					<div class="admin-controls admin-lawyers-control">
						<div class="row">
							<div class="col-lg-9 text-center">
								<h2 class = "select-right-table-preview">Lawyers Panel</h2>
								<span style = "font-size: 10.0em;" class="select-right-table-preview glyphicon glyphicon-hand-right"></span>
								<h1 class = "select-right-table-preview">Select city or country in right table</h1>
								<div class="admin-lawyer-table-container">			
									<table class="table text-center table-striped table-bordered lawyers-table">
									<thead>
									</thead>
									<tbody>
									</tbody>
									</table>
									
								</div>
								<button class = "btn btn-success form-control new-lawyer-button">Add new lawyer</button>
								<div class="col-lg-12 lawyer-add-form">
									<select class = "add-lawyer-user-selector form-control add-form-item"></select>
									<select class = "add-lawyer-country-selector form-control add-form-item"></select>
									<select class = "add-lawyer-city-selector form-control add-form-item"></select>
									<button class="col-lg-6 col-lg-offset-3 btn btn-info add-form-submit add-form-item">Confirm and Submit</button>
								</div>
							</div>
							<div class="col-lg-3 admin-placeholder-preview-container">
								<?php echo '<img class = "select-right-table-preview" src = "'.REL_URL.'res/pictures/lawyer-placeholder.png" />
								'; ?>
							</div>
						</div>
					</div>
					<hr />
					<div class="admin-controls admin-templates-control">
						<div class="row">
							<div class="col-lg-8 text-center">
								<div class="admin-button-container">
									<button class="btn btn-lg btn-success">
										<span class = "glyphicon glyphicon-plus">&nbsp;Add Template</span>
									</button>
								</div>
								<div class="admin-button-container">
									<button class="btn btn-lg btn-warning" onclick = "document.location = getURL()+'page/download-templates/';">
										<span class = "glyphicon glyphicon-search">&nbsp;Select Template</span>
									</button>
								</div>
								<div class="admin-button-container">
									<button class="btn btn-lg btn-danger">
										<span class = "glyphicon glyphicon-remove">&nbsp;Delete Template</span>
									</button>
								</div>
							</div>
							<div class="col-lg-4 admin-preview-container">
								<?php echo '<img src = "'.REL_URL.'res/pictures/template-placeholder.jpg" />
								'; ?>
							</div>
						</div>
					</div>
					<div class="admin-controls admin-users-control">
						<div class="row">
							<div class="col-lg-8 text-center">
								<div class="admin-button-container">
									<button class="btn btn-lg btn-success">
										<span class = "glyphicon glyphicon-ok">&nbsp;Unlock User</span>
									</button>
								</div>
								<div class="admin-button-container">
									<button class="btn btn-lg btn-warning">
										<span class = "glyphicon glyphicon-refresh">&nbsp;Change Rights</span>
									</button>
								</div>
								<div class="admin-button-container">
									<button class="btn btn-lg btn-danger">
										<span class = "glyphicon glyphicon-remove">&nbsp;&nbsp;Block User</span>
									</button>
								</div>
							</div>
							<div class="col-lg-4 admin-preview-container">
								<?php echo '<img src = "'.REL_URL.'res/pictures/user-placeholder.png" />
								'; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 admin-location-container">
					<div class="col-lg-6">
						<button class="btn btn-info form-control fill-table-countries-button show">Show All Countries</button>
					</div>
					<div class="col-lg-6">
						<button class="btn btn-info form-control fill-table-cities-button show">Show All Cities</button>
					</div>
					<div class="col-lg-12 admin-location-table-container">
						<table class="table table-striped table-bordered text-center location-table">
						<thead>
						</thead>
						<tbody>
						</tbody>
						</table>
						<div class="table table-bottom-container">
							<button class="btn btn-success form-control country-city-add-button">Add</button>
						</div>
						<div class="col-lg-12 country-city-add-form">
							<label class = "input-country-name">Add new country</label>
							<input placeholder = "Select country" type="text" class="input-country-name form-control add-form-item">
							<label class="input-city-name">Add new city</label>
							<select class = "country-selector form-control add-form-item">Select a country</select>
							<input placeholder = "City name" type="text" class="input-city-name form-control add-form-item">
							<button class="btn btn-info form-control add-form-submit add-form-item">Confirm and Submit</button>
						</div>
					</div>
				</div>
				<div class="admin-lawyer-info-container col-lg-4 text-center">
					<div class="row">
						<div class="col-lg-6 admin-lawyer-info-avatar">
							<img class = "img-fluid" src="" alt="Avatar"/>
						</div>
						<div class="col-lg-6 admin-lawyer-info-person">
							<div class="col-lg-6 admin-lawyer-info-country">Country</div>
							<div class="col-lg-6 admin-lawyer-info-city">City</div>
							<div class="col-lg-12 admin-lawyer-info-name">Name</div>
							<div class="admin-lawyer-change-button-container"><button class="btn btn-warning form-control lawyer-change-button">Change</button></div>

						</div>
					</div>
					<div class="row">
					<input type="hidden" class="admin-lawyer-info-id" value = ""/>
						<div class="col-lg-4 admin-lawyer-info-skype text-center">
							<h4>Skype</h4>
							<a href="" class="btn btn-success form-control"><span class = "glyphicon glyphicon-earphone"></span></a>
						</div>
						<div class="col-lg-4 admin-lawyer-info-email">
							<h4>Email</h4>
							<p></p>
						</div>
						<div class="col-lg-4 admin-lawyer-info-hangout">
							<h4>Hangout</h4>
							<p></p>
						</div>
					</div>
					<div class="row">
						<div class="admin-lawyer-info-resume col-lg-12 text-center">
							<h3>Resume</h3>
							<pre></pre>
						</div>
					</div>
				</div>
				<div class="change-lawyer-info-container">
					<div class="col-lg-1" style = "float:right;">
						<button class="btn btn-danger" onclick = "$(this).parent().parent().hide('fast');">X</button>
					</div>
					<?php echo '<form method="post" id = "change-lawyer" action="'.REL_URL.'res/func/lawyers/LawyerPostReceiver.php" enctype="multipart/form-data">'; ?>
					<div class="form-group col-lg-12">	
						<input type="hidden" name = "id" class = "change-form-id" value = "" />
						<label>Name</label>
						<input type="text" name = "name" value="" class="form-control change-form-name">
						<label>SecondName</label>
						<input type="text" name = "second-name" value="" class="form-control change-form-second-name">
						<label>Skype</label>
						<input type="text" name = "skype" value="" class="form-control change-form-skype">
						<label>Email</label>
						<input type="text" name = "email" value="" class="form-control change-form-email">
						<label>Hangout</label>
						<input type="text" name = "hangout" value="" class="form-control change-form-hangout">
						<input type="file" name = "photo" style = "display:none;" value="" class = "change-form-photo-input">
						<button class="btn btn-info col-lg-6 change-form-photo-button" onclick = "return false;" accept = "image/*">Change photo</button>
						<input type="file" name = "resume" style = "display:none;" value="" class = "change-form-resume-input">
						<button class="btn btn-info col-lg-6 change-form-resume-button" onclick = "return false;">Change resume</button>
						<input type="hidden" name = "changeLawyerInfo" class = "change-form-id" value = "1" />
						<button class="btn btn-success form-control change-form-submit-button" onclick = "return false;">Confirm</button>
					</form>
					</div>
				</div>
			</div>
		</div>
		<?php getFooter(); ?></div>
</body>
</html>