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
																	<form method="post" action="/verwaltung/inc/controller.php">
																		<input type="hidden" name="kat_id" value="<?php  echo $data['Kat_ID'] ?>">
																		<input type="hidden" name="routing" value="edit_kat">
																		<input type="submit" name="aktion" value="" class="submit-icon">
																	</form>
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
											<form method="post" action="/verwaltung/inc/controller.php">
												<input type="hidden" name="routing" value="show_all_kat">
												<input type='submit' value='zurück' class='primary'/>
											</form>
											<div class="exponat">
												<div class="two">
													<div class="name">Bezeichnung</div>
													<div class="value"><?php echo $daten[0]['Bezeichnung']; ?></div>
												</div>
												<div class="one">
													Beschreibung
												</div>
												<div class="one">
													<textarea readonly><?php echo $daten[0]['Beschreibung']; ?></textarea>
												</div>
											</div>
										</div>
									<?php
										} elseif ($routing === 'edit_kat') {
											$daten = show_kategorie($_SESSION['kat_id']);
									?>
										<div class="row gtr-200">
											<form method="post" action="/verwaltung/inc/controller.php">
												<input type="hidden" name="routing" value="show_all_kat">
												<input type='submit' value='zurück' class='primary'/>
											</form>
											<form method="post" action="/verwaltung/inc/controller.php">
												<div class="exponat">
													<div class="two">
														<div class="name">Bezeichnung</div>
														<div class="value"><input type="text" name="kat_name" value="<?php echo $daten[0]['Bezeichnung']; ?>"></div>
													</div>
													<div class="one">
														Beschreibung
													</div>
													<div class="one">
														<textarea name="kat_beschreibung"><?php echo $daten[0]['Beschreibung']; ?></textarea>
													</div>
												</div>
												<input type="hidden" name="routing" value="edit_kat">
												<input type="hidden" name="edit_kategorie" value="true">
												<input type="hidden" name="kat_id" value="<?php echo $_SESSION['kat_id'];?>">
												<input type='submit' value='speichern' class='primary'/>
											</form>
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