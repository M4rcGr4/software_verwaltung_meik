<?php 
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
	include '../inc/controller.php';

	$routing = $_SESSION['routing'] ?? 'show_all';

	if ($routing != 'show_all' && $routing != 'edit' && $routing != 'show_exp') {
		$routing='show_all';
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
						<div class="inner padding-0">


							<!-- Content -->
								<section>
									<header class="main">
										<h1>Verwaltung bestehender Exponate</h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
									<?php 
									 	if ($routing === 'show_all') {
									?>
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
																	echo "<td>" . substr($data['Beschreibung'],0,30);
																	if (strlen($data['Beschreibung'])>30) {echo " [...]";}
																	echo "</td>";
																	echo "<td>" . $data['Hersteller'] . "</td>";
																	echo "<td>" . $data['Baujahr'] . "</td>";
																	echo "<td>" . $data['Wert'] . "</td>";																	
																	echo "<td>" . $data['Material'] . "</td>";
																	echo "<td>" . $data['Kategorie'] . "</td>";
																	echo "<td>" . $data['Zustand'] . "</td>";
																	echo "<td>" . $data['Standort'] . "</td>";
																	?>
																	<td>
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="exp_id" value="<?php  echo $data['Objekt_ID'] ?>">
																			<input type="hidden" name="routing" value="show_exp">
																			<input type="submit" name="aktion" value="i" class="submit-icon">
																		</form>
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="exp_id" value="<?php  echo $data['Objekt_ID'] ?>">
																			<input type="hidden" name="routing" value="edit">
																			<input type="submit" name="aktion" value="" class="submit-icon">
																		</form>
																		<form method="post" action="/verwaltung/inc/controller.php">
																			<input type="hidden" name="exp_id" value="<?php  echo $data['Objekt_ID'] ?>">
																			<input type="hidden" name="routing" value="delete">
																			<input type="submit" name="aktion" value="del" class="submit-icon">
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
									<?php
									} elseif ($routing === 'show_exp') {
										$daten = get_exponat($_SESSION['exp_id']);
										$data = $daten[0];
									?>
										<form method="post" action="/verwaltung/inc/controller.php">
											<input type="hidden" name="routing" value="show_all">
											<input type='submit' value='zurück' class='primary'/>
										</form>
										<div class="exponat">
												<div class="four gray">
													<div class="name">Exp-Nr.</div>
													<div class="value"><?php echo $data['Exp-Nr']; ?></div>
													<div class="name">Titel</div>
													<div class="value border-right"><?php echo $data['Titel']; ?></div>
												</div>
												<div class="four">
													<div class="name">Baujahr</div>
													<div class="value"><?php echo $data['Baujahr']; ?> </div>
													<div class="name">Hersteller</div>
													<div class="value border-right"><?php echo $data['Hersteller']; ?> </div>
												</div>
												<div class="four gray">
													<div class="name">Org. Preis</div>
													<div class="value"><?php echo $data['OrigPreis']; ?> </div>
													<div class="name">Wert</div>
													<div class="value border-right"><?php echo $data['Wert']; ?> </div>
												</div>
												<div class="four">
													<div class="name">Herkunft</div>
													<div class="value"><?php echo $data['Herkunft']; ?> </div>
													<div class="name">Maße</div>
													<div class="value border-right"><?php echo $data['Abmessungen']; ?></div>
												</div>
												<div class="four gray">
													<div class="name">Material</div>
													<div class="value"><?php echo $data['Material']; ?> </div>
													<div class="name">Zustand</div>
													<div class="value border-right">
														<select name="expZust" id="expZust" disabled>
															<?php
																$zustaende = show_zustaende('');
																if ($data['Zu_ID'] == 0) {echo "<option value='0' selected>- kein Zustand gewählt-</option>";}																	
																foreach($zustaende as $zustand){																			
																	echo "<option value=". $zustand['Zu_ID'] ;
																	if ($zustand['Zu_ID'] == $data['Zu_ID']) { echo " selected";}
																	echo ">" . $zustand['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
													</div>
												</div>
												<div class="four">
													<div class="name">Kategorie</div>
													<div class="value">
														<select name="expKat" id="expKat" disabled>
															<?php
																$kat = show_kategorien();
																if ($data['Kat_ID'] == 0) {echo "<option value='0' selected>- keine Kategorie gewählt-</option>";}
																foreach($kat as $kategorie){																			
																	echo "<option value=". $kategorie['Kat_ID'];
																	if ($kategorie['Kat_ID'] == $data['Kat_ID']) {echo " selected";}
																	echo ">" . $kategorie['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
													</div>
													<div class="name">Standort</div>
													<div class="value border-right">
														<select name="expStandort" id="expStandort" disabled>
															<?php
																$standorte = show_standorte();
																if ($data['Standort_ID'] == 0) {echo "<option value='0' selected>- kein Standort gewählt-</option>";}
																foreach($standorte as $std){																			
																	echo "<option value=". $std['Standort_ID'];
																	if ($std['Standort_ID'] == $data['Standort_ID']) {echo " selected";}
																	echo ">" . $std['Name'] . "</option>";																
																}
															?>
														</select>
													</div>
												</div>
												<div class="two gray">
													<div class="name">Veranstaltungen</div>
													<div class="name border-right">Notizen für Besucher</div>
												</div>
												<div class="two">
													<div class="value"><?php echo $data['Ausstellung']; ?></div>
													<div class="value border-right"><?php echo $data['Interesse']; ?></div>
												</div>
												<div class="two gray">
													<div class="name">zug. Dokumente</div>
													<div class="name border-right">zug. Exponate</div>
												</div>
												<div class="two">
													<div class="value"></div>
													<div class="value border-right"></div>
												</div>
												<div class="one border-right gray">ausführl. Beschreibung</div>
												<div class="one border-right"><textarea rows="6" name="" readonly><?php echo $data['Beschreibung']; ?></textarea></div>
												<input type="hidden" name="exp_id" value="<?php echo $_SESSION['exp_id']; ?>">
											</div>
									<?php
									} elseif ($routing === 'edit') {
										$daten = get_exponat($_SESSION['exp_id']);
										$data = $daten[0];
									?>
										<form method="post" action="/verwaltung/inc/controller.php">
											<input type="hidden" name="routing" value="show_all">
											<input type='submit' value='zurück' class='primary'/>
										</form>
										<form method="post" action="/verwaltung/inc/controller.php">
											<div class="exponat">
												<div class="four gray">
													<div class="name">Exp-Nr.</div>
													<div class="value"><input type="text" name="expName" value="<?php echo $data['Exp-Nr']; ?>"></div>
													<div class="name">Titel</div>
													<div class="value border-right"><input type="text" name="expTitel" value="<?php echo $data['Titel']; ?>"></div>
												</div>
												<div class="four">
													<div class="name">Baujahr</div>
													<div class="value"><input type="text" name="expBaujahr" value="<?php echo $data['Baujahr']; ?> "></div>
													<div class="name">Hersteller</div>
													<div class="value border-right"><input type="text" name="expHersteller" value="<?php echo $data['Hersteller']; ?> "></div>
												</div>
												<div class="four gray">
													<div class="name">Org. Preis</div>
													<div class="value"><input type="text" name="expOrgPreis" value="<?php echo $data['OrigPreis']; ?> "></div>
													<div class="name">Wert</div>
													<div class="value border-right"><input type="text" name="expWert" value="<?php echo $data['Wert']; ?> "></div>
												</div>
												<div class="four">
													<div class="name">Herkunft</div>
													<div class="value"><input type="text" name="expHerkunft" value="<?php echo $data['Herkunft']; ?> "></div>
													<div class="name">Maße</div>
													<div class="value border-right"><input type="text" name="expMaße" value="<?php echo $data['Abmessungen']; ?>"></div>
												</div>
												<div class="four gray">
													<div class="name">Material</div>
													<div class="value"><input type="text" name="expMaterial" value="<?php echo $data['Material']; ?> "></div>
													<div class="name">Zustand</div>
													<div class="value border-right">
														<select name="expZust" id="expZust">
															<option value="0">- Zustand wählen-</option>																	
															<?php
																$zustaende = show_zustaende('nicht_geloescht');
																foreach($zustaende as $zustand){																			
																	echo "<option value=". $zustand['Zu_ID'] ;
																	if ($zustand['Zu_ID'] == $data['Zu_ID']) { echo " selected";}
																	echo ">" . $zustand['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
													</div>
												</div>
												<div class="four">
													<div class="name">Kategorie</div>
													<div class="value">
														<select name="expKat" id="expKat">
															<option value="0">- Kategorie wählen-</option>
															<?php
																$kat = show_kategorien();
																foreach($kat as $kategorie){																			
																	echo "<option value=". $kategorie['Kat_ID'];
																	if ($kategorie['Kat_ID'] == $data['Kat_ID']) {echo " selected";}
																	echo ">" . $kategorie['Bezeichnung'] . "</option>";																
																}
															?>
														</select>
													</div>
													<div class="name">Standort</div>
													<div class="value border-right">
														<select name="expStandort" id="expStandort">
															<option value="0" <?php if ($data['Standort_ID'] == 0) {echo "selected";}?>>- Standort wählen-</option>
															<?php
																$standorte = show_standorte();
																foreach($standorte as $std){																			
																	echo "<option value=". $std['Standort_ID'];
																	if ($std['Standort_ID'] == $data['Standort_ID']) {echo " selected";}
																	echo ">" . $std['Name'] . "</option>";																
																}
															?>
														</select>
													</div>
												</div>
												<div class="two gray">
													<div class="name">Veranstaltungen</div>
													<div class="name border-right">Notizen für Besucher</div>
												</div>
												<div class="two">
													<div class="value"><textarea name="expVeranst"><?php echo $data['Ausstellung']; ?></textarea></div>
													<div class="value border-right"><textarea name="expNote"><?php echo $data['Interesse']; ?></textarea></div>
												</div>
												<div class="two gray">
													<div class="name">zug. Dokumente</div>
													<div class="name border-right">zug. Exponate</div>
												</div>
												<div class="two">
													<div class="value"></div>
													<div class="value border-right"></div>
												</div>
												<div class="one border-right gray">ausführl. Beschreibung</div>
												<div class="one border-right"><textarea rows="6" name="expBesch" ><?php echo $data['Beschreibung']; ?></textarea></div>
												<input type="hidden" name="exp_id" value="<?php echo $_SESSION['exp_id']; ?>">
												<input type="hidden" value="edit" name="routing">
												<input type="hidden" value="true" name="edit_exponat">
												<div class="one border-right border-bottom"><input type="submit" value="Speichern" class="primary"/></div>
											</div>
										</form>
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