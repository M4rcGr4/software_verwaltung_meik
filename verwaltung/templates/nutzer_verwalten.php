<?php 
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
	include '../inc/controller.php'; 
	$routing = $_SESSION['routing'] ?? 'new_user';
?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Benutzerverwaltung</title>
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
										<h1>Nutzer <?php if ($routing="new_user") {?> anlegen <?php } elseif ($routing="users") {?> bearbeiten<?php }?></h1>
									</header>

									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<div class="col-12-medium">												
												<?php 
												
												if( $routing=="new_user") {?>
													<form action="/verwaltung/inc/controller.php">
														<div class="four">
															<input type="text" name="anmeldung" placeholder="musterm">
															<input type="text" name="anzeigename" placeholder="Muster, Max">
															<input type="text" name="pw" placeholder="123abc">
															<input type="hidden" name="routing" value="add_user">
														</div>
													</form>
												<?php } elseif ($routing="users") { ?>
													<form action="/verwaltung/inc/controller.php">
														<div class="four">
															<input type="text" name="anmeldung" placeholder="">
															<input type="text" name="anzeigename" placeholder="">
															<input type="text" name="pw" placeholder="">
															<input type="hidden" name="routing" value="edit_user">
														</div>
													</form>
												<?php }	?>			
												</div>
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