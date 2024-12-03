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
																<input type="text" name="expName" id="expName" value="" placeholder="Exp. Nummer" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="expTitel" id="expTitel" value="" placeholder="Titel" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="expBaujahr" id="expBaujahr" value="" placeholder="Baujahr" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="expHersteller" id="expHersteller" value="" placeholder="Hersteller" />
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
<<<<<<< HEAD
																	<option value="0">- Zustand -</option>
																	<option value="-1">kaputt</option>
																	<option value="1">ok</option>
																	<option value="2">restauriert</option>
																	<option value="3">top</option>
=======
																	<option value="0">- Zustand -</option>																	
																	<option value="1">gelagert</option>
																	<option value="2">ausgestellt</option>
																	<option value="3">reparaturbedürftig</option>
																	<option value="4">verliehen</option>
>>>>>>> 28f27cc7bf0da331621e94d6e714ee1187ae872c
																</select>
															</div>
															<div class="col-12">
																<select name="expKat" id="expKat">
																	<option value="0">- Kategorie -</option>
																	<option value="-1">Ohne Kategorie</option>
																	<option value="1">Shipping</option>
																	<option value="2">Administration</option>
																	<option value="3">Human Resources</option>
																</select>
															</div>
                                                            <div class="col-12">
																<select name="expStandort" id="expStandort">
																	<option value="0">- Standort -</option>
																	<option value="-1">ohne Standort</option>
																	<option value="1">Shipping</option>
																	<option value="2">Administration</option>
																	<option value="3">Human Resources</option>
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