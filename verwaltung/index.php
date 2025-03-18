<?php 
	if(session_status() === PHP_SESSION_NONE){
		session_start();
		if(empty($_SESSION)){
			$_SESSION['routing'] = 'anmeldung';
			$_SESSION['anmelde_id'] = NULL;
			$_SESSION['recht'] = 0;
			$_SESSION['status_msg'] = "";
			$_SESSION['exp_filter'] = "";
			$_SESSION['exp_sort'] = "";
		}
	}
	include './inc/controller.php';
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
				
				<?php if ($_SESSION['anmelde_id'] !== NULL) { ?>
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
													<?php if($_SESSION['recht'] == "1" || $_SESSION['recht'] == "2") { ?>
														<li><a onclick="routing('exponate')">Exponate anlegen</a></li>
													<?php } ?>
													<li><a onclick="routing('exponate_verwalten')">Exponate verwalten</a></li>
												</ul>
											</li>
											<li>
												<span class="opener">Kategorien</span>
												<ul>
													<?php if($_SESSION['recht'] == "1" || $_SESSION['recht'] == "2") { ?>
														<li><a onclick="routing('kategorien')">Kategorien anlegen</a></li>
													<?php } ?>
													<li><a onclick="routing('kategorien_verwalten')">Kategorien verwalten</a></li>
												</ul>
											</li>
											<li>
												<span class="opener">Standorte</span>
												<ul>
													<?php if($_SESSION['recht'] == "1" || $_SESSION['recht'] == "2") { ?>
														<li><a onclick="routing('standorte')">Standorte anlegen</a></li>
													<?php } ?>
													<li><a onclick="routing('standorte_verwalten')">Standorte verwalten</a></li>
												</ul>
											</li>
											<?php if($_SESSION['recht'] == 2){ ?>
												<li>
													<span class="opener">Adminbereich</span>
													<ul>
														<li><a onclick="routing('benutzerverwaltung')">Benutzerverwaltung</a></li>
														<li><a onclick="routing('auditlog')">Audit Log</a></li>
														<li><a onclick="routing('tickets')">Tickets</a></li>
														<li><a onclick="routing('test')">Test</a></li>
														<li><a onclick="routing('qrcode')"></a></li>
													</ul>
												</li>
											<?php } ?>
											<li><a onclick="routing('anmeldung')">Abmelden</a></li>
										</ul>
									</nav>

								<!-- Footer -->

							</div>
						</div>
				<?php } ?>
			
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
			<script src="assets/js/qrCodeGen/qrcode.js"></script>
        	<script src="assets/js/qrCodeGen/jquery.min.js"></script>
			<script src="assets/js/qrCodeGen/create.js"></script>
												
	</body>
</html>