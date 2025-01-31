<?php 
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
	include '../inc/controller.php';
	
	$routing = $_SESSION['routing'] ?? 'show_all_standort';

	if ($routing != 'show_all_standort' && $routing != 'edit_standort' && $routing != 'show_standort') {
		$routing='show_all_standort';
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
										<?php
											if($_SESSION['status_msg'] !== "") {
												switch (($_SESSION['status_msg']) ) {
													case 'standort_empty':
														echo "<h5>Standort konnte nicht gespeichert werden: Der Name darf nicht leer sein.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'standort_added':
														echo "<h5>Standort wurde gespeichert.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'standort_deleted':
														echo "<h5>Standort wurde gelöscht.</h5>";
														$_SESSION['status_msg'] = "";
														break;
												}
											}
										?>
									</header>


									<hr class="major" />

									<!-- Elements -->
									<?php
										if ($routing === 'show_all_standort') {
									?>
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
																	<td style="display: inline-flex">
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="standort_id" value="<?php  echo $data['Standort_ID'] ?>">
																			<input type="hidden" name="routing" value="show_standort">
																			<input type="submit" name="aktion" value="i" class="submit-icon">
																		</form>
																	</td>
																	<?php
																		if($_SESSION['recht'] == "1" || $_SESSION['recht'] == "2"){
																	?>
																	<td style="display: inline-flex">
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="standort_id" value="<?php  echo $data['Standort_ID'] ?>">
																			<input type="hidden" name="routing" value="edit_standort">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																	</td>
																	<?php } ?>
																	<?php
																		if($_SESSION['recht'] == "2"){
																	?>
																	<td style="display: inline-flex">
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="standort_id" value="<?php  echo $data['Standort_ID'] ?>">
																			<input type="hidden" name="routing" value="delete_standort">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																	</td>
																	<?php } ?>
																	<?php
																	echo "</tr>";
																}
																?>																
														</tbody>															
													</table>
												</div>									
											</div>
										</div>
									<?php
										} elseif ($routing === 'show_standort') {
											$daten = show_standort($_SESSION['standort_id']);
									?>
										<div class="row gtr-200">
											<div class="col-12-medium">
												<form method="post" action="/verwaltung/inc/controller.php">
													<input type="hidden" name="routing" value="show_all_standort">
													<input type='submit' value='zurück' class='primary'/>
												</form>
												<label for="standort_name">Name des Standortes</label>
												<div id="standort_name"><?php echo $daten[0]['Name']; ?></div>
												<label for="anzahl_exp">Anzahl der zugeordneten Exponate</label>
												<div id="anzahl_exp"><?php echo $daten[0]['AnzahlExp']; ?></div>
											</div>
										</div>
									<?php
										} elseif ($routing === 'edit_standort') {
											$daten = show_standort($_SESSION['standort_id']);
									?>
										<div class="row gtr-200">
											<div class="col-12-medium">
												<form method="post" action="/verwaltung/inc/controller.php">
													<input type="hidden" name="routing" value="show_all_standort">
													<input type='submit' value='zurück' class='primary'/>
												</form>
												<h4>Standort bearbeiten</h4>
												<div class="four">
													<form method="post" action="/verwaltung/inc/controller.php">
														<label for="name">Name des Standortes</label>
														<input id="name" type="text" name="standortName" value="<?php echo $daten[0]['Name']; ?>">
														<input type="hidden" name="routing" value="edit_standort">
														<input type="hidden" name="edit_standort" value="true">
														<input type="hidden" name="standort_id" value="<?php echo $_SESSION['standort_id'];?>">
														<input type='submit' value='speichern' class='primary' style="margin-top: 20px;"/>
													</form>
												</div>
											</div>
										</div>
									<?php
										}
									?>

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