<?php 
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
	include '../inc/controller.php';

	$routing = $_SESSION['routing'] ?? 'show_all_kat';

	if ($routing != 'show_all_kat' && $routing != 'edit_kat' && $routing != 'show_kat') {
		$routing='show_all_kat';
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
										<?php
											if($_SESSION['status_msg'] !== "") {
												switch (($_SESSION['status_msg']) ) {
													case 'kat_empty':
														echo "<h5>Kategorie konnte gespeichert werden: Der Name darf nicht leer sein.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'kat_added':
														echo "<h5>Kategorie wurde gespeichert.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'kat_deleted':
														echo "<h5>Kategorie wurde gelöscht.</h5>";
														$_SESSION['status_msg'] = "";
														break;
												}
											}
										?>
									</header>


									<hr class="major" />

									<!-- Elements -->
									<?php 
										if ($routing === 'show_all_kat') {
									?>
										<div class="row gtr-200">
											<div class="col-12">
											<h4>Kategorien</h4>
												<div class="table-wrapper">
													<table class="alt">
														<thead>
															<tr>																
																<th>Name</th>
																<th>Beschreibung</th>																
																<th>Anzahl Exponate</th>																
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
																	echo "</td>";
																	echo "<td>" . $data['AnzahlExp'] . "</td>";
																	echo "<td style='display: inline-flex;'>";
																	?>
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<input type="hidden" name="kat_id" value="<?php  echo $data['Kat_ID'] ?>">
																		<input type="hidden" name="routing" value="show_kat">
																		<input type="submit" name="aktion" value="i" class="submit-icon">
																	</form>
																	<?php
																		if($_SESSION['recht'] == "1" || $_SESSION['recht'] == "2"){
																	?>
																	<td style='display: inline-flex;'>
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="kat_id" value="<?php  echo $data['Kat_ID'] ?>">
																			<input type="hidden" name="routing" value="edit_kat">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																	</td>
																	<?php } ?>
																	<?php
																		if($_SESSION['recht'] == "2"){
																	?>
																	<td style='display: inline-flex;'>
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="kat_id" value="<?php  echo $data['Kat_ID'] ?>">
																			<input type="hidden" name="routing" value="delete_kat">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																	</td>
																	<?php } ?>
																	<?php
																	echo "</td></tr>";											
																}
															?>																
														</tbody>															
													</table>
												</div>									
											</div>
											</div>
										</div>
									<?php 
										} elseif ($routing === 'show_kat') {
											$daten = show_kategorie($_SESSION['kat_id']);
									?>
										<div class="row gtr-200">
											<div class="col-12-medium">
												<form method="post" action="/verwaltung/inc/controller.php">
													<input type="hidden" name="routing" value="show_all_kat">
													<input type='submit' value='zurück' class='primary'/>
												</form>
												<label for="kat_bezeichnung">Bezeichnung</label>
												<div id="kat_bezeichnung"><?php echo $daten[0]['Bezeichnung']; ?></div>
												<label for="kat_beschreibung">Beschreibung</label>
												<p id="kat_beschreibung"><?php echo $daten[0]['Beschreibung']; ?></p>
												<label for="exp_count">Anzahl der zugeordneten Exponate</label>
												<p id="exp_count"><?php echo $daten[0]['AnzahlExp']; ?></p>
											</div>
										</div>
									<?php
										} elseif ($routing === 'edit_kat') {
											$daten = show_kategorie($_SESSION['kat_id']);
									?>
										<div class="row gtr-200">
											<div class="col-12-medium">
												<form method="post" action="/verwaltung/inc/controller.php">
													<input type="hidden" name="routing" value="show_all_kat">
													<input type='submit' value='zurück' class='primary'/>
												</form>
												<h4>Kategorie bearbeiten</h4>
												<form method="post" action="/verwaltung/inc/controller.php">
													<label for="kat_bezeichnung">Bezeichnung</label>
													<input id="kat_bezeichnung" type="text" name="kat_name" value="<?php echo $daten[0]['Bezeichnung']; ?>">
													<label for="kat_beschreibung">Beschreibung</label>
													<textarea name="kat_beschreibung"><?php echo $daten[0]['Beschreibung']; ?></textarea>
													<input type="hidden" name="edit_kategorie" value="true">
													<input type="hidden" name="kat_id" value="<?php echo $_SESSION['kat_id'];?>">
													<input type='submit' value='speichern' class='primary' style="margin-top: 20px;"/>
												</form>
											</div>
										</div>
									<?php
										}
									?>
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