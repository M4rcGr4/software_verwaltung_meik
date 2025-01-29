<?php 
if(session_status() == 1){
	session_start();
}
include './inc/controller.php';
?>
<!DOCTYPE HTML>
<!--
	Alpha by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>MEIK - Web</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="landing is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header" class="alt">
					<img src="./images/CI/Logo/PNG/rechteckig/weiss-transparent/isc weiss-transparent 100x47.png" alt="">
					<nav id="nav">
						<ul>
							<li>
								<a href="index.php" class="fa-solid fa-house-chimney-window" onclick="routing('main')">Start</a>
							</li>
							<li>
								<input type="submit" value="Exponate" class="fit" onclick="routing('exponate')" />
							</li>
						</ul>
					</nav>
				</header>

			<!-- Banner -->
				<section id="banner">
					<h2>MEIK</h2>
					<p>Museum zur
						Entwicklung der Informations- und
						Kommunikationstechnik</p>
				</section>

			<!-- Main -->
				<section id="main" class="container">

					<!--<section class="box special">
						<header class="major">
							<h2>Ein Einblick in die Geschichte der IT</h2>
						</header>
						<span class="image featured"><img src="images/CI/Logo/JPEG/rechteckig/blau-weiss/isc blau-weiss 500x232.jpg" alt="lol"></span>
					</section>

					<div class="row">
						<div class="col-6 col-12-narrower">

							<section class="box special">
								<span class="image featured"><img src="images/WaltherETR21-165-vornekl-330x320.jpg" alt="" /></span>
								<h3>Walther ETR21</h3>
								<p>Der ETR 21 ist ein elektronischer Tischrechner der Firma Walther.

								Die Kapazität der Ein-und Ausgabe beträgt jeweils 12 Stellen die im Gegensatz zum Taschenrechner ETR 2-5, direkt zur Anzeige gebracht werden.

								Rechenkapazität: 14 Stellen. Rechnet die 4 Grundrechenarten.

								Konstante für alle Rechenarten.</p>
								<ul class="actions special">
									<li><a href="#" class="button alt" style="color: white;">Mehr Infos</a></li>
								</ul>
							</section>

						</div>
						<div class="col-6 col-12-narrower">

							<section class="box special">
								<span class="image featured"><img src="images/m55.jpg" alt="" /></span>
								<h3>Nixdorf M55</h3>
								<p>Neue technologische Maßstäbe präsentierte Nixdorf zur ORGA-Technik 1986 in Köln. Mit eigener unterbrechungsfreier Notstromversorgung ausgestattet, gehörte der 8810 M55 von Nixdorf zu den leistungsstärksten PC-Versionen des Jahres. Er wurde ursprünglich bei der Fa.</p>
								<ul class="actions special">
									<li><a href="#" class="button alt" style="color: white;">Mehr Infos</a></li>
								</ul>
							</section>

						</div>
					</div>-->

				</section>
				
			<!-- Footer -->
			 	<footer id="footer">
					<ul class="copyright">
						<li>&copy; Projektgruppe 4; Marwin Gorldt, Lucas Winkler, Marc Kaden</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="./assets/js/routing.js"></script>
			<script src="assets/js/ajax.js"></script>
			<script src="assets/js/viewhelper.js"></script>

	</body>
</html>