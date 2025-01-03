<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Kategorien</title>
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
										<h1>Kategorien</h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<div class="col-12-medium">

													<form method="get" action="./inc/controller.php">
														<input type="hidden" name="add_kategorie" value="true">
														<div class="row gtr-uniform">
															<div class="col-6 col-12-xsmall">
																<input type="text" name="katName" id="katName" value="" placeholder="Name" />
															</div>                                                            
															<!-- Break -->														

                                                            <div class="col-12">
																<textarea name="katBeschreib" id="katBeschreib" placeholder="ausführliche Beschreibung" rows="6"></textarea>
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