<?php require("../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>
<?php require(SITE_URL . "res/func/registration/CheckAdminRights.php"); ?>

<!DOCTYPE html5>
<html lang="en">
<head>
	<?php getHead("Admin Panel"); ?></head>
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
							<div class="col-lg-8 text-center">
								<div class="admin-button-container">
									<button class="btn btn-lg btn-success ">
										<span class = "glyphicon glyphicon-plus">&nbsp;Add Lawyer</span>
									</button>
								</div>
								<div class="admin-button-container">
									<button class="btn btn-lg btn-warning" onclick = "document.location = getURL()+'page/search-lawyer/'";>
										<span class = "glyphicon glyphicon-search">&nbsp;Select Lawyer</span>
									</button>
								</div>
								<div class="admin-button-container">
									<button class="btn btn-lg btn-danger">
										<span class = "glyphicon glyphicon-remove">&nbsp;Delete Lawyer</span>
									</button>
								</div>
							</div>
							<div class="col-lg-4 admin-preview-container">
								<?php echo '<img src = "'.REL_URL.'res/pictures/lawyer-placeholder.jpg" />
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
					<hr />
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
				<div class="col-lg-5 admin-location-container">
					<div class="col-lg-6">
						<button class="btn btn-info form-control fill-table-countries-button show">Show All Countries</button>
					</div>
					<div class="col-lg-6">
						<button class="btn btn-info form-control fill-table-cities-button show">Show All Cities</button>
					</div>
					<div class="col-lg-12 admin-location-table-container">
						<table class="table table-striped table-bordered">
						<thead>
						</thead>
						<tbody>
						</tbody>
						</table>
						<div class="table table-bottom-container">
							<button class="btn btn-success form-control add-button">Add</button>
						</div>
						<div class="col-lg-12 add-form">
							<label class = "input-country-name">Add new country</label>
							<input placeholder = "What's the name of this country?" type="text" class="input-country-name form-control add-form-item">
							<label class="input-city-name">Add new city</label>
							<select class = "country-selector form-control add-form-item">Select a country</select>
							<input placeholder = "What's the name of this city?" type="text" class="input-city-name form-control add-form-item">
							<button class="btn btn-info form-control add-form-submit add-form-item">Confirm and Submit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php getFooter(); ?></div>
</body>
</html>