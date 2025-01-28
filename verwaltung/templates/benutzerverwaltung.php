<?php include '../inc/controller.php'; 
if(session_status() === PHP_SESSION_NONE){
	session_start();
}
$routing = $_SESSION['routing'] ?? 'show_users';
if ($routing !='show_users' && $routing!='edit_user' && $routing !='add_user') {
	$routing='show_users';
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
										<?php 
											if(($_SESSION['status_msg'] !== "") && ($_SESSION['status_msg'] === "password_empty") ){
												echo "<h5>Benutzer konnte nicht angelegt werden: Das Passwort darf nicht leer sein</h5>";
											}
											if(($_SESSION['status_msg'] !== "") && ($_SESSION['status_msg'] === "password_not_equal") ){
												echo "<h5>Benutzer konnte nicht angelegt werden: Die Passwörter waren nicht identisch</h5>";
											}
											if(($_SESSION['status_msg'] !== "") && ($_SESSION['status_msg'] === "username_exists") ){
												echo "<h5>Benutzer konnte nicht angelegt werden: Benutzername existiert bereits</h5>";
											}
											if(($_SESSION['status_msg'] !== "") && ($_SESSION['status_msg'] === "username_empty") ){
												echo "<h5>Benutzer konnte nicht angelegt werden: Benutzername darf nicht leer sein</h5>";
											}
										?>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<?php if ($routing=='show_users') { ?>
												<div class="col-12-medium">
													<h4>Nutzer</h4>
													<form method="post" action="/verwaltung/inc/controller.php">
														<input type="hidden" name="routing" value="add_user">
														<input type='submit' value='neuer Nutzer' class='primary'/>
													</form>
														<div class="table-wrapper">
															<table class="alt">
																<thead>
																	<tr>																
																		<th>Anmeldung</th>
																		<th>Anzeigename</th>
																		<th>Admin</th>																
																	</tr>
																</thead>
																<tbody>
																	<?php
																		$daten = show_users();
																		foreach($daten as $data){ ?>
																				<tr>																	
																					<td><?php echo $data['Anmeldung']?></td>
																					<td><?php echo $data['Anzeigename']?></td>
																					<td>
																					<?php if ($data['Recht'] == 1) {
																						echo "x";
																					} else {
																						echo " ";
																					}
																					?>
																					</td>
																					<td>
																					<form method="post" action="/verwaltung/inc/controller.php">
																						<input type='hidden' name='routing' value='edit_user'>
																						<input type='hidden' name='speichern' value='0'>
																						<input type='hidden' name='nutzer_id' value='<?php echo $data['Nutzer_ID']?>'>
																						<input type='submit' value='Editieren' class='primary'/>
																					</form>
																					</td>
																					<td>
																					<form method="post" action="/verwaltung/inc/controller.php">
																						<input type="hidden" name="delete_user" value="delete">
																						<input type='hidden' name='nutzer_id' value='<?php echo $data['Nutzer_ID']?>'>
																						<input type='submit' value='Löschen' class='primary'/>
																					</form>
																					</td>
																				</tr>
																		<?php											
																		}
																	?>
																</tbody>															
															</table>
														</div>									
													</div>
												</div>

											<?php } elseif ($routing=='add_user') { ?>
												<div class="col-12-medium">
													<h4>Nutzer anlegen</h4>
													<form method="post" action="/verwaltung/inc/controller.php">
														<input type="hidden" name="routing" value="show_users">
														<input type='submit' value='zurück' class='primary'/>
													</form>	
													<div class="four">
														<form method="post" action="/verwaltung/inc/controller.php">
															<label for="anmeldung">Benutzername</label>
															<input type="text" name="anmeldung" placeholder="musterm">
															<label for="anzeigename">Anzeigename</label>
															<input type="text" name="anzeigename" placeholder="Muster, Max">
															<label for="passwort">Passwort</label>
															<input type="text" name="passwort" placeholder="123abc">
															<label for="passwort2">Passwort wiederholen</label>
															<input type="text" name="passwort2" placeholder="123abc">
															<label for="recht">Zugriffsberechtigung</label>
															<select name="recht" id="recht">
																<option value="0">Standardnutzer</option>
																<option value="1">Admin</option>
															</select>
															<input type="hidden" name="routing" value="add_user">
															<input type="hidden" name="speichern" value="1">
															<input type='submit' value='speichern' class='primary'/>
														</form>
													</div>
												</div>
											<?php } elseif ($routing=='edit_user') { ?>
												<div class="col-12-medium">
													<?php
														$daten = show_user($_SESSION['nutzer_id']);
													?>
													<form method="post" action="/verwaltung/inc/controller.php">
														<input type="hidden" name="routing" value="show_users">
														<input type='submit' value='zurück' class='primary'/>
													</form>
													<h4>Nutzer bearbeiten</h4>
													<div class="four">
														<form method="post" action="/verwaltung/inc/controller.php">
															<label for="anmeldung">Benutzername</label>
															<input type="text" name="anmeldung" id="anmeldung" value="<?php echo $daten[0]['Anmeldung']?>">
															<label for="anzeigename">Anzeigename</label>
															<input type="text" name="anzeigename" id="anzeigename" value="<?php echo $daten[0]['Anzeigename']?>">															
															<label for="recht">Zugriffsberechtigung</label>															
															<select name="recht" id="recht">
																<option value="0"<?php if ($daten[0]['Recht'] == '0') { ?> selected <?php } ?>>Standardnutzer</option>
																<option value="1"<?php if ($daten[0]['Recht'] == '1') { ?> selected <?php } ?>>Admin</option>
															</select>
															<input type="hidden" name="routing" value="edit_user">
															<input type="hidden" name="speichern" value="1">
															<input type='hidden' name='nutzer_id' value='<?php echo $_SESSION['nutzer_id']?>'>
															<input type='submit' value='speichern' class='primary'/>
														</form>
													</div>
												</div>
											<?php } ?>
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