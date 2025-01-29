<?php
	if(session_status() === PHP_SESSION_NONE){
		session_start();
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
		<title>Anmeldung</title>
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
							<header class="main">
								<?php 
									if ($_SESSION['anmelde_id'] === NULL) {
								?>
								<h1>Anmeldung</h1>
								<?php
									}
									else{
								?>
									<h1>Abmeldung</h1>
								<?php 
									}

									if(($_SESSION['status_msg'] !== "") && ($_SESSION['status_msg'] === "wrong_pw") ){
										echo "<h5>Anmeldung fehlgeschlagen: Falsches Passwort </h5>";
									}
									if(($_SESSION['status_msg'] !== "") && ($_SESSION['status_msg'] === "wrong_username") ){
										echo "<h5>Anmeldung fehlgeschlagen: Benutzer existiert nicht </h5>";
									}
								?>
							</header>


							<hr class="major" />

							<!-- Elements -->
							<?php 
								if ($_SESSION['anmelde_id'] === NULL) {
							?>
								<div class="row gtr-200">
									<div class="col-12-medium">
										<h4>Anmeldung</h4>
										<div class="four">
											<form method="post" action="/verwaltung/inc/controller.php">
												<label for="anmeldung">Benutzername</label>
												<input type="text" name="nutzername">
												<label for="passwort">Passwort</label>
												<input type="password" name="passwort" >
												<input type='submit' value='anmelden' class='primary'/>
											</form>
										</div>
									</div>
								</div>
							<?php
								}
								else{
							?>
								<div class="row gtr-200">
									<div class="col-12-medium">
										<div class="four">
											<p>
												Aktueller Benutzer: <br>
												<strong><?php echo $_SESSION['anmelde_name']?></strong> <br><br>
												Berechtigungsebene: <br>
												<strong>
													<?php 
														if($_SESSION['recht'] == 0){
															echo "Betrachter";
														}
														else if ($_SESSION['recht'] == 1){
															echo "Verwalter";
														}
														else if ($_SESSION['recht'] == 2){
															echo "Administrator";
														}
													?>
												</strong><br>
											</p>
											<br>
											<form method="post" action="/verwaltung/inc/controller.php">
												<input type="hidden" name="sign_out" value="true">
												<input type='submit' value='abmelden' class='primary'/>
											</form>
										</div>
									</div>
								</div>
							<?php 
								}
							?>
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