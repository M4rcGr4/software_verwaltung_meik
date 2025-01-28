<?php
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>MEIK</title>
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
							<!-- Banner -->
								<section id="banner">
									<div class="content">
										<header>
											<h1>Verwaltung<br />
											MEIK</h1>
											<p>Eine Software zur Verwaltung <br>
											von Inseraten und Ausstellungsstücken</p>
										</header>
										<p>Diese Software dient zur Verwaltung der Exponate für "MEIK" (Museum zur
											Entwicklung der Informations- und
											Kommunikationstechnik), welches durch den Förderverein Freundeskreis der Industrieschule Chemnitz e. V. unterstützt wird.</p>
									</div>
									<span class="image object">
										<img src="./images/CI/Logo/PNG/quadratisch/blau-transparent/isc blau-transparent 1000x1000.png" alt="" />
									</span>
								</section>

								<footer id="foooter">
										
								</footer>
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