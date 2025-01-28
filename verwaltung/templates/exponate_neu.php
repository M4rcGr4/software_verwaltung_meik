<?php 

if(session_status() === PHP_SESSION_NONE){
	session_start();
}

include '../inc/controller.php';

$routing = $_SESSION['routing'] ?? 'show_all';

if ($routing != 'show_all' && $routing != 'edit') {
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
									 
										<div class="row gtr-200">
											<div class="col-12">
											<h4>Exponate</h4>
											</div>
											<?php
												if($routing == "edit"){
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
																<div class="value"><input type="text" name="" value="<?php echo $data['Exp-Nr']; ?>"></div>
																<div class="name">Titel</div>
																<div class="value border-right"><?php echo $data['Titel']; ?></div>
															</div>
															<div class="four">
																<div class="name">Baujahr</div>
																<div class="value"><input type="text" name="" value="<?php echo $data['Baujahr']; ?> "></div>
																<div class="name">Hersteller</div>
																<div class="value border-right"><input type="text" name="" value="<?php echo $data['Hersteller']; ?> "></div>
															</div>
															<div class="four gray">
																<div class="name">Org. Preis</div>
																<div class="value"><input type="text" name="" value="<?php echo $data['OrigPreis']; ?> "></div>
																<div class="name">Wert</div>
																<div class="value border-right"><input type="text" name="" value="<?php echo $data['Wert']; ?> "></div>
															</div>
															<div class="four">
																<div class="name">Herkunft</div>
																<div class="value"><input type="text" name="" value="<?php echo $data['Herkunft']; ?> "></div>
																<div class="name">Maße</div>
																<div class="value border-right"><?php echo $data['Abmessungen']; ?></div>
															</div>
															<div class="four gray">
																<div class="name">Material</div>
																<div class="value"><input type="text" name="" value="<?php echo $data['Material']; ?> "></div>
																<div class="name">Zustand</div>
																<div class="value border-right">
																	<select name="expZust" id="expZust">
																		<option value="0">- Zustand wählen-</option>																	
																		<?php
																			$zustaende = show_zustaende();
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
																		<option value="0">- Standort wählen-</option>
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
															<div class="twogray">
																<div class="name">Veranstaltungen</div>
																<div class="name border-right">Notizen für Besucher</div>
															</div>
															<div class="two">
																<div class="value"><?php echo $data['Ausstellung']; ?></div>
																<div class="value border-right"><?php echo $data['Interesse']; ?></div>
															</div>
															<div class="twogray">
																<div class="name">zug. Dokumente</div>
																<div class="name border-right">zug. Exponate</div>
															</div>
															<div class="two">
																<div class="value"></div>
																<div class="value border-right"></div>
															</div>
															<div class="oneborder-rightgray">ausführl. Beschreibung</div>
															<div class="oneborder-right"><textarea rows="6" name="" ><?php echo $data['Beschreibung']; ?></textarea></div>
															<input type="hidden" name="exp_id" value="<?php echo $_SESSION['exp_id']; ?>">
															<input type="hidden" value="edit" name="routing">
															<div class="one border-right border-bottom"><input type="submit" value="Speichern" class="primary"/></div>
														</div>
													</form>
												<?php
												}
												elseif($routing == "show_all"){
													$daten = get_exponate();
													foreach($daten as $data){
													?>
													<form method="post" action="/verwaltung/inc/controller.php">
														<div class="exponat">
															<div class="four gray">
																<div class="name">Exp-Nr.</div>
																<div class="value"><?php echo $data['Exp-Nr']; ?></div>
																<div class="name">Titel</div>
																<div class="value border-right"><?php echo $data['Titel']; ?></div>
															</div>
															<div class="four">
																<div class="name">Baujahr</div>
																<div class="value"><?php echo $data['Baujahr']; ?></div>
																<div class="name">Hersteller</div>
																<div class="value border-right"><?php echo $data['Hersteller']; ?></div>
															</div>
															<div class="four gray">
																<div class="name">Org. Preis</div>
																<div class="value"><?php echo $data['OrigPreis']; ?></div>
																<div class="name">Wert</div>
																<div class="value border-right"><?php echo $data['Wert']; ?></div>
															</div>
															<div class="four">
																<div class="name">Herkunft</div>
																<div class="value"><?php echo $data['Herkunft']; ?></div>
																<div class="name">Maße</div>
																<div class="value border-right"><?php echo $data['Abmessungen']; ?></div>
															</div>
															<div class="four gray">
																<div class="name">Material</div>
																<div class="value"><?php echo $data['Material']; ?></div>
																<div class="name">Zustand</div>
																<div class="value border-right"><?php echo $data['Zustand']; ?></div>
															</div>
															<div class="four">
																<div class="name">Kategorie</div>
																<div class="value"><?php echo $data['Kategorie']; ?></div>
																<div class="name">Standort</div>
																<div class="value border-right"><?php echo $data['Standort']; ?></div>
															</div>
															<div class="two gray">
																<div class="name">Veranstaltungen</div>
																<div class="name border-right">Notizen für Besucher</div>
															</div>
															<div class="two">
																<div class="value"><?php echo $data['Ausstellung']; ?></div>
																<div class="value border-right"<?php echo $data['Interesse']; ?>></div>
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
															<div class="one border-right"><?php echo $data['Beschreibung']; ?></div>
															<input type="hidden" name="exp_id" value="<?php echo $data['Objekt_ID']; ?>">
															<input type="hidden" name="routing" value="edit">
															<div class="one border-right border-bottom">
															<input type="submit" value="" name="submit" class="submit-icon">															
														</form>
														<form >
															<input type="hidden" name="routing" value="delete">
															<input type="submit" value="" class="submit-icon"></div>
														</div>
													</form>
													<?php
													}
												}
												?>
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