<?php 
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
	include '../inc/controller.php' 
?>
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
										<h1>Kategorien verwalten</h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<div class="col-12-medium">
											<h4>Kategorien</h4>
												<div class="table-wrapper">
													<table class="alt">
														<thead>
															<tr>																
																<th>Name</th>
																<th>Beschreibung</th>																
															</tr>
														</thead>
														<tbody>
															<?php
																$daten = show_kategorien();
																foreach($daten as $data){
																	echo "<tr>";																	
																	echo "<td>" . $data['Bezeichnung'] . "</td>";
																	echo "<td>" . substr($data['Beschreibung'],0,30);
																	if (strlen($data['Beschreibung'])>100) {echo " [...]";}
																	echo "</td></tr>";											
																}
															?>																
														</tbody>															
													</table>
												</div>									
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