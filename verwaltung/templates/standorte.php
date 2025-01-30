<?php
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Standorte</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Standorte</h1>
										<?php
											if($_SESSION['status_msg'] !== "") {
												switch (($_SESSION['status_msg']) ) {
													case 'standort_empty':
														echo "<h5>Standort konnte nicht angelegt werden: Der Name darf nicht leer sein.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'standort_exists':
														echo "<h5>Standort konnte nicht angelegt werden: Der Standort existiert bereits.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'standort_added':
														echo "<h5>Standort wurde hinzugefügt.</h5>";
														$_SESSION['status_msg'] = "";
														break;
												}
											}
										?>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<div class="col-12-medium">

													<form method="post" action="./inc/controller.php">
														<input type="hidden" name="add_standort" value="true">
														<div class="row gtr-uniform">
															<div class="col-6 col-12-xsmall">
																<input type="text" name="standortName" id="standortName" value="" placeholder="Name" />
															</div>                                                            
															
															<div class="col-12">
																<ul class="actions">
																	<li><input type="submit" value="Speichern" class="primary" /></li>
																	<li><input type="reset" value="Zurücksetzen" /></li>
																</ul>
															</div>
														</div>
													</form>
											</div>
										</div>

								</section>

						</div>
					</div>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>