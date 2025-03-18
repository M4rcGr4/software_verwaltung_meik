<?php
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
	include '../inc/controller.php';
?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Service</title>
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
								<section class="padding-0">
									<header class="main">
										<h1>Tickets</h1>
										<?php
											if($_SESSION['status_msg'] !== "") {
												switch (($_SESSION['status_msg']) ) {
													case 'tickets_empty':
														echo "<h5>Tickets konnten nicht aktualisiert werden: Es muss mindestens eine Aktion ausgewählt werden.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'tickets_web_denied':
														echo "<h5>Tickets wurde aktualisiert: Die gewählten Exponate wurden abgelehnt.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'tickets_web_confirmed':
														echo "<h5>Tickets wurde aktualisiert: Die gewählten Exponate wurden für den Webauftritt freigegeben.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'tickets_del_denied':
														echo "<h5>Tickets wurde aktualisiert: Die Löschung der gewählten Exponate wurde abgelehnt.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'tickets_del_confirmed':
														echo "<h5>Tickets wurde aktualisiert: Die gewählten Exponate wurden endgültig gelöscht.</h5>";
														$_SESSION['status_msg'] = "";
														break;
													case 'tickets_both':
														echo "<h5>Tickets konnten nicht aktualisiert werden: Für die Exponate kann nur eine Aktion ausgewählt werden.</h5>";
														$_SESSION['status_msg'] = "";
														break;
												}
											}
										?>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">											
											<div class="col-6 col-12-medium">
												<h4>vorgemerkte Exponate für den Webauftritt</h4>
												<div class="table-wrapper">
													<form method="post" action="/verwaltung/inc/controller.php">
														<table class="alt">
															<thead>
																<tr>
																	<th>Exp.-Nr.</th>
																	<th>Titel</th>
																	<th>Ablehnen</th>
																	<th>Freigeben</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																	$daten = get_exponate('ticket_highlight');
																	if (!empty($daten)) {
																		foreach ($daten as $data) {
																?>
																	<tr>
																		<td><?php echo $data['Exp-Nr'];?></td>
																		<td><?php echo $data['Titel'];?></td>
																		<td style="text-align: center;">
																			<input id="web_ablehnen|<?php echo $data['Objekt_ID'];?>" name="web_ablehnen[]" value="<?php echo $data['Objekt_ID'];?>" type="checkbox">
																			<label for="web_ablehnen|<?php echo $data['Objekt_ID'];?>"></label>
																		</td>
																		<td style="text-align: center;">
																			<input id="web_freigeben|<?php echo $data['Objekt_ID'];?>" name="web_freigeben[]" value="<?php echo $data['Objekt_ID'];?>" type="checkbox">
																			<label for="web_freigeben|<?php echo $data['Objekt_ID'];?>"></label>
																		</td>
																	</tr>
																<?php
																		}
																	} else {
																		echo "<tr><td colspan='5'>Keine Exponate ausgewählt.</td></tr>";
																	}
																?>
															</tbody>
														</table>
														<?php if (!empty($daten)) { ?>
															<input type="hidden" name="routing" value="tickets_webauftritt" >
															<input type="submit" value="speichern">
														<?php } ?>
													</form>
												</div>
											</div>
											<div class="col-6 col-12-medium">
												<h4>ausgeblendete Exponate zum Löschen</h4>
												<div class="table-wrapper">
													<form method="post" action="/verwaltung/inc/controller.php">
														<table class="alt">
															<thead>
																<tr>
																	<th>Exp.-Nr.</th>
																	<th>Name</th>
																	<th>Ablehnen</th>
																	<th>Löschen</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																	$daten = get_exponate('ticket_delete');
																	if (!empty($daten)) {
																		foreach ($daten as $data) {
																?>
																	<tr>
																		<td><?php echo $data['Exp-Nr'];?></td>
																		<td><?php echo $data['Titel'];?></td>
																		<td style="text-align: center;">
																			<input id="del_ablehnen|<?php echo $data['Objekt_ID'];?>" name="del_ablehnen[]" value="<?php echo $data['Objekt_ID'];?>" type="checkbox">
																			<label for="del_ablehnen|<?php echo $data['Objekt_ID'];?>"></label>
																		</td>
																		<td style="text-align: center;">
																			<input id="del_freigeben|<?php echo $data['Objekt_ID'];?>" name="del_freigeben[]" value="<?php echo $data['Objekt_ID'];?>" type="checkbox">
																			<label for="del_freigeben|<?php echo $data['Objekt_ID'];?>"></label>
																		</td>
																	</tr>
																<?php
																		}
																	} else {
																		echo "<tr><td colspan='5'>Keine Exponate ausgewählt.</td></tr>";
																	}
																?>
															</tbody>
														</table>
														<?php if (!empty($daten)) { ?>
															<input type="hidden" name="routing" value="tickets_loeschen">
															<input type="submit" value="speichern">
														<?php } ?>
													</form>
												</div>
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

	</body>
</html>