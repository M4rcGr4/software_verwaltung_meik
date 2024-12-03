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

							<!-- Header -->
								<header id="header">
									<a href="index.html" class="logo"><strong>MEIK</strong> Museum zur
										Entwicklung der Informations- und
										Kommunikationstechnik</a>
								</header>

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

				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">
							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2>Menü</h2>
									</header>
									<ul>
										<li><a onclick="routing('main')">Home</a></li>
										<li>
											<span class="opener">Exponate</span>
											<ul>
												<li><a onclick="routing('exponate')">Exponate anlegen</a></li>
												<li><a onclick="routing('exponate_verwalten')">Exponate verwalten</a></li>
											</ul>
										</li>
										<li>
											<span class="opener">Kategorien</span>
											<ul>
												<li><a onclick="routing('kategorien')">Kategorien anlegen</a></li>
												<li><a href="#">Kategorien verwalten</a></li>
											</ul>
										</li>
										<li><a onclick="routing('service')">Service</a></li>
										<li><a href="#">BarCode-Scanner</a></li>
										<li><a href="#">QR-Code Scanner</a></li>
										<li>
											<span class="opener">Adminbereich</span>
											<ul>
												<li><a onclick="routing('benutzerverwaltung')">Benutzerverwaltung</a></li>
												<li><a onclick="routing('auditlog')">Audit Log</a></li>
												<li><a onclick="routing('gelObj')">gelöschte Exponate</a></li>
												<li><a onclick="routing('test')">Test</a></li>
											</ul>
										</li>
									</ul>
								</nav>

							<!-- Footer -->

						</div>
					</div>

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