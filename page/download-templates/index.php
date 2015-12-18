<?php require("../../const.php"); ?>
<?php require(SITE_URL . "init.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php getHead("Download template"); ?>
	<?php echo '<script src="'.REL_URL.'res/js/templates.js'.'"></script>
' ?>
</head>
<body>
<div class="wrapper">
	<?php getHeader("beautiful+image+placeholder"); ?>
	<div class="warning-container container text-center">
		<div class="warning">
			<p>Alert!</p>
		</div>
	</div>
	<div class="container">
		<div class="row select-template-container">
			<?php
				$builder = new Builder;
				$showTemplates = $builder->
			printTemplatePreview($server, $username, $password, $db);
				echo $showTemplates;
				?>
		</div>
	</div>
	<a id = "anchor" href="#anchor"></a>
	<div class="container">
		<div class="row">

			<div class="template-info-container col-lg-12">
				<div class="row template-download-and-data bg-info">
					<div class="col-lg-3 template-info-download-container">
						<a href = "" download="download" class="btn btn-lg btn-success form-control download-button">
							<span class="glyphicon glyphicon-download">&nbsp;</span>
							Download
						</a>
					</div>
					<div class="col-lg-9 template-info-data-container text-right">
						<p>Date of last update</p>
						<p>
							<span>dd.mm.YYYY</span>
						</p>
					</div>
				</div>
				<div class="main-content-container row text-justify">
					<div class="col-lg-12">
						<pre>
						<h1 class="text-center">Header</h1>
						<div>Text Field</div>
						</pre>
					</div>
				</div>
				<div class="template-info-nav">
					<div class="previous-button-container col-lg-6">
						<button class="btn btn-lg btn-info form-control previous-button">Previous</button>
					</div>
					<div class="next-button-container col-lg-6 text-right">
						<button class="btn btn-lg btn-info form-control next-button">Next</button>
					</div>
					<input type="hidden" class = "template-id"/>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php getFooter(); ?>
</body>
</html>