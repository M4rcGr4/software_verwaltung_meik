<?php include '../inc/controller.php' ?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>Exponate</title>
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
								<section>
									<header class="main">
										<h1>Exponate</h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<div class="col-6 col-12-medium">

													<form method="get" action="./inc/controller.php">
														<input type="hidden" name="add_exponat" id="add_exponat" value="true">
														<div class="row gtr-uniform">
															<div class="col-6 col-12-xsmall">
																<input type="text" name="expName" id="expName" value="" placeholder="Exp. Nummer (Zahl)" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="expTitel" id="expTitel" value="" placeholder="Titel (Text)" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="expBaujahr" id="expBaujahr" value="" placeholder="Baujahr (Zahl)" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="expHersteller" id="expHersteller" value="" placeholder="Hersteller (Text)" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="expOrgPreis" id="expOrgPreis" value="" placeholder="Org. Preis" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="expWert" id="expWert" value="" placeholder="Wert" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="expHerkunft" id="expHerkunft" value="" placeholder="Herkunft" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="expMaße" id="expMaße" value="" placeholder="Maße" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="expMaterial" id="expMaterial" value="" placeholder="Material" />
															</div>
															<!-- Break -->
															<div class="col-12">
																<select name="expZust" id="expZust">
																	<option value="0">- Zustand wählen-</option>																	
																	<?php
																		$daten = show_zustaende();
																		foreach($daten as $data){																			
																			echo "<option value=". $data['Zu_ID'] .">" . $data['Bezeichnung'] . "</option>";																
																		}
																	?>
																</select>
															</div>
															<div class="col-12">
																<select name="expKat" id="expKat">
																	<option value="0">- Kategorie wählen-</option>
																	<?php
																		$daten = show_kategorien();
																		foreach($daten as $data){																			
																			echo "<option value=". $data['Kat_ID'] .">" . $data['Bezeichnung'] . "</option>";																
																		}
																	?>
																</select>
															</div>
                                                            <div class="col-12">
																<select name="expStandort" id="expStandort">
																	<option value="0">- Standort wählen-</option>
																	<?php
																		$daten = show_standorte();
																		foreach($daten as $data){																			
																			echo "<option value=". $data['Standort_ID'] .">" . $data['Name'] . "</option>";																
																		}
																	?>
																</select>
															</div>

                                                            <div class="col-12">
																<textarea name="expVeranst" id="expVeranst" placeholder="Veranstaltungen" rows="6"></textarea>
															</div>
                                                            <div class="col-12">
																<textarea name="expNote" id="expNote" placeholder="Notizen für Besucher" rows="6"></textarea>
															</div>
															<div class="col-12">
																<textarea name="expBesch" id="expBesch" placeholder="ausführliche Beschreibung" rows="6"></textarea>
															</div>
                                                            <div class="col-12">
																<textarea name="expDoks" id="expDoks" placeholder="zug. Dokumente" rows="6"></textarea>
															</div>
                                                            <div class="col-12">
																<textarea name="expZugExp" id="expZugExp" placeholder="zug. Exponate" rows="6"></textarea>
															</div>
															<li><a href="#" class="button icon solid fa-download">Bild</a></li>
															
															<div class="col-12">
																<ul class="actions">
																	<li><input type="submit" value="Speichern" class="primary" /></li>
																	<li><input type="reset" value="Zurücksetzen" onclick="get_values_exp()" /></li>
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
			<script src="assets/js/ajax.js"></script>
			

	</body>
</html>