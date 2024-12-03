<?php include '../inc/controller.php' ?>

<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Exponate verwalten</title>
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
										<h1>Verwaltung bestehender Exponate</h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
									 
										<div class="row gtr-200">
											<div class="col-12">
											<h4>Exponate</h4>
												<div class="table-wrapper">
													<table class="alt">
														<thead>
															<tr>
																<th>Exp.-Nr.</th>
																<th>Name</th>
																<th>Beschreibung</th>
																<th>Hersteller</th>
																<th>Baujahr</th>
																<th>Wert</th>
																<th>Originalpreis</th>
																<th>Provenienz</th>
																<th>Abmessungen</th>
																<th>Material</th>
																<th>Kategorie</th>
																<th>Zustand</th>
																<th>Standort</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$daten = get_exponate();
																foreach($daten as $data){
																	echo "<tr>";
																	echo "<td>" . $data['Exp-Nr'] . "</td>";
																	echo "<td>" . $data['Titel'] . "</td>";
																	echo "<td>" . $data['Beschreibung'] . "</td>";
																	echo "<td>" . $data['Hersteller'] . "</td>";
																	echo "<td>" . $data['Baujahr'] . "</td>";
																	echo "<td>" . $data['Wert'] . "</td>";
																	echo "<td>" . $data['OrigPreis'] . "</td>";
																	echo "<td>" . $data['Herkunft'] . "</td>";
																	echo "<td>" . $data['Abmessungen'] . "</td>";
																	echo "<td>" . $data['Material'] . "</td>";
																	echo "<td>" . $data['Kategorie'] . "</td>";
																	echo "<td>" . $data['Zu_ID'] . "</td>";
																	echo "<td>" . $data['Standort_ID'] . "</td>";
																	?>
																	<td>
																		<form method="get">
																			<input type="hidden" name="edit" value="<?php  echo $data['Objekt_ID'] ?>">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																	</td>
																	<?php
																	// var_dump($data);
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