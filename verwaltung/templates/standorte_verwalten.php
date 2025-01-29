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
		<title>Standorte verwalten</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner padding-0">


							<!-- Content -->
								<section>
									<header class="main">
										<h1>Verwaltung bestehender Standorte <h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
									 
										<div class="row gtr-200">
											<div class="col-12">
											<h4>Standorte</h4>
												<div class="table-wrapper">
													<table class="alt">
														<thead>
															<tr>
																<th>Name</th>
																<th>Anzahl Exponate</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$daten = show_standorte();
																foreach($daten as $data){
																	echo "<tr>";
																	echo "<td>" . $data['Name'] . "</td>";
																	echo "<td>" . $data['AnzahlExp'] . "</td>";
																	?>
																	<td>
																		<form method="post" action="">
																			<input type="hidden" name="edit_stand" value="<?php  echo $data['Standort_ID'] ?>">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																	</td>
																	<?php
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