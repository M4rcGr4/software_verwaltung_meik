<?php include '../inc/controller.php' ?>
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
										<h1>Benutzerverwaltung</h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<div class="col-12-medium">
												<div class="table-wrapper">
													<table class="alt">
														<thead>
															<tr>
																<th>Nutzer</th>
																<th>Berechtigung</th>																
																<th>Anzeigename</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$daten = show_users();
																foreach($daten as $data){
																	echo "<tr>";
																	echo "<td>" . $data['Anmeldung'] . "</td>";
																	echo "<td>" . $data['Recht'] . "</td>";																	
																	echo "<td>" . $data['Anzeigename'] . "</td>";																	
																	echo "</tr>";
																}
															?>																
														</tbody>															
													</table>
												</div>													
											</div>
										</div>
								</section>

						</div>
					</div>

				<!-- Sidebar -->
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>