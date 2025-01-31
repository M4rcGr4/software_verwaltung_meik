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
								<section>
									<header class="main">
										<h1>Tickets</h1>
									</header>


									<hr class="major" />

									<!-- Elements -->
										<div class="row gtr-200">
											<?php if (false) { ?>
											<div class="col-12" style="display: none;">
												<h4>vorgemerkte Exponate für den Webauftritt</h4>
												<div class="table-wrapper">
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
														
														</tbody>
													</table>
												</div>
												<h4>ausgeblendete Exponate zum Löschen</h4>
												<div class="table-wrapper">
													<table class="alt">
														<thead>
															<tr>
																<th>Exp.-Nr.</th>
																<th>Name</th>
																<th>Name</th>
																<th>Name</th>
															</tr>
														</thead>
														<tbody>
														
														</tbody>
													</table>
												</div>
											</div>
											<?php } ?>
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