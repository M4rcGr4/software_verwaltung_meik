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
		<title>Audit Log</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper" style="width: 100%;">

				<!-- Main -->
					<div id="main">
						<div class="inner padding-0">

							<?php
								$log = show_log();
							?>
							<!-- Content -->
								<section style="padding: 0 !important;">
									<header class="main">
										<h1>Audit Log</h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<div class="col-12">

												<div class="table-wrapper">
													<?php
														echo '<table class="alt">';
														echo '<thead>';
														echo "<tr>
																<th>Eintragsnummer</th>
																<th>Datum</th>
																<th>Nutzer</th>
																<th>Typ der Änderung</th>
																<th>Art des geänderten Objektes</th>
																<th>Objekt ID</th>
																<th>geänderte Daten</th>
															</tr>";
														echo '</thead>';
														echo '<tbody>';
														foreach ($log as $id){
															$username = get_username($id['Edit_Nutzer_ID']);
															if($id['Log_add_edit'] == "delete"){
																$add_edit = "hat gelöscht";

															}else if($id['Log_add_edit'] == "add"){
																$add_edit = "hat hinzugefügt";

															}else if($id['Log_add_edit'] == "edit"){
																$add_edit = "hat editiert";

															}else if($id['Log_add_edit'] == "mark_web_prepare"){
																$add_edit = "hat Exponat für Webauftritt vorgemerkt";

															}else if($id['Log_add_edit'] == "mark_web_hide"){
																$add_edit = "hat Exponat aus dem Webauftritt entfernt";

															}else if($id['Log_add_edit'] == "mark_web_deny"){
																$add_edit = "hat Ticket (Webauftritt) abgelehnt";

															}else if($id['Log_add_edit'] == "mark_web_confirm"){
																$add_edit = "hat Ticket (Webauftritt) bestätigt";

															}else if($id['Log_add_edit'] == "mark_del_prepare"){
																$add_edit = "hat Exponat zur Löschung vorgemerkt";

															}else if($id['Log_add_edit'] == "mark_del_deny"){
																$add_edit = "hat Ticket (Löschung) abgelehnt";

															}else if($id['Log_add_edit'] == "mark_del_confirm"){
																$add_edit = "hat Ticket (Löschung) bestätigt";

															}
															if($id['Log_Typ'] == 0){
																$log_typ = "Exponat";
															}
															else if($id['Log_Typ'] == 1){
																$log_typ = "Kategorie";
															}
															else if($id['Log_Typ'] == 2){
																$log_typ = "Standort";
															}
															else if($id['Log_Typ'] == 3){
																$log_typ = "Nutzer";
															}

															echo "<tr>";
															echo "<td>" . $id['Log_ID'] . "</td>";
															echo "<td>" . $id['Log_Datum'] . "</td>";
															echo "<td>" . $username . "</td>";
															echo "<td>" . $add_edit . "</td>";
															echo "<td>" . $log_typ . "</td>";
															echo "<td>" . $id['Log_Obj_ID'] . "</td>";
															echo "<td>" . substr($id['Log_Text'] , 0, 30). "</td>";
															echo "</tr>";
														}
														echo '</tbody>';
														echo "</table>";
													?>
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