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

													<form method="post" action="#">
														<div class="row gtr-uniform">
															<div class="col-6 col-12-xsmall">
																<input type="text" name="demo-name" id="expName" value="" placeholder="Exp. Nummer" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="demo-email" id="expTitel" value="" placeholder="Titel" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="demo-email" id="expBaujahr" value="" placeholder="Baujahr" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="demo-email" id="expHersteller" value="" placeholder="Hersteller" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="demo-email" id="expOrgPreis" value="" placeholder="Org. Preis" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="demo-email" id="expWert" value="" placeholder="Wert" />
															</div>
															<div class="col-6 col-12-xsmall">
																<input type="text" name="demo-email" id="expHerkunft" value="" placeholder="Herkunft" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="demo-email" id="expMaße" value="" placeholder="Maße" />
															</div>
                                                            <div class="col-6 col-12-xsmall">
																<input type="text" name="demo-email" id="expMaterial" value="" placeholder="Material" />
															</div>
                                                            <div class="col-6 col-12-small">
																<input type="checkbox" id="demo-human" name="demo-human" checked>
																<label for="demo-human">öffentlich zugänglich</label>
															</div>
															<!-- Break -->
															<div class="col-12">
																<select name="demo-category" id="expZust">
																	<option value="">- Zustand -</option>
																	<option value="">kaputt</option>
																	<option value="1">ok</option>
																	<option value="1">restauriert</option>
																	<option value="1">top</option>
																</select>
															</div>
															<div class="col-12">
																<select name="demo-category" id="expKat">
																	<option value="">- Kategorie -</option>
																	<option value="">Ohne Kategorie</option>
																	<option value="1">Shipping</option>
																	<option value="1">Administration</option>
																	<option value="1">Human Resources</option>
																</select>
															</div>
                                                            <div class="col-12">
																<select name="demo-category" id="expStandort">
																	<option value="">- Standort -</option>
																	<option value="">ohne Standort</option>
																	<option value="1">Shipping</option>
																	<option value="1">Administration</option>
																	<option value="1">Human Resources</option>
																</select>
															</div>

                                                            <div class="col-12">
																<textarea name="demo-message" id="expVeranst" placeholder="Veranstaltungen" rows="6"></textarea>
															</div>
                                                            <div class="col-12">
																<textarea name="demo-message" id="expNote" placeholder="Notizen für Besucher" rows="6"></textarea>
															</div>
															<div class="col-12">
																<textarea name="demo-message" id="expBesch" placeholder="ausführliche Beschreibung" rows="6"></textarea>
															</div>
                                                            <div class="col-12">
																<textarea name="demo-message" id="expDoks" placeholder="zug. Dokumente" rows="6"></textarea>
															</div>
                                                            <div class="col-12">
																<textarea name="demo-message" id="expZugExp" placeholder="zug. Exponate" rows="6"></textarea>
															</div>
															
															<div class="col-12">
																<ul class="actions">
																	<li><input type="submit" value="Speichern" onclick="add_exp()" class="primary" /></li>
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