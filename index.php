<?php require("const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<!DOCTYPE html5>
<html lang="en">
<head>
	<?php getHead("Document Generator"); ?>
</head>
<body>
	<div class="wrapper">
		<?php getHeader(); ?>
		<div class="row"></div>
		<div class="warning-container container bg-danger text-center">
			<div class="warning"><p>Alert!</p></div>	
		</div>
		<div class="col-lg-12">
			<div class="row">
				<div class="text-center col-lg-6 col-lg-offset-3 call-lawyer-container">
					<button class="btn btn-warning btn-lg form-control call-lawyer" onclick="window.location = getURL()+'page/search-lawyer/'">Contact a lawyer</button>
				</div>
				<div class="text-center col-lg-6 col-lg-offset-3 call-lawyer-container">
					<button class="btn btn-info btn-lg form-control show-template" onclick="window.location = getURL()+'page/download-templates/'">Download Template</button>
				</div>
			</div>
		</div>
		<div class="fake-div"></div>
		<?php getFooter(); ?>
	</div>
</body>
</html>