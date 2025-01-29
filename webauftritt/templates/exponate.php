<?php
if(session_status() == 1){
	session_start();
}
include '../inc/controller.php';


?>
<!DOCTYPE HTML>
<!--
	Alpha by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Exponate</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="landing is-preload">
		<div id="page-wrapper">
				<br>
				<br>
				<?php 
					if ($_SESSION['exponat_id'] === NULL || empty($_SESSION['exponat_id']))	{
				?>
					<section id="main" class="container">
						<section class="box special">
								<header class="major">
									<h2>Exponate</h2>
								</header>
						</section>
						<div class="row">
							<?php 
								$daten = get_exponate('highlight');
								$daten_length=count($daten);
								
								for ($i=0;$i<$daten_length;$i++) {
									?>
								<div class="col-6 col-12-narrower">
									<section class="box2 special2">
										<span class="image2 featured"><img src="images/WaltherETR21-165-vornekl-330x320.jpg" alt="" /></span>
										<h3><?php echo $daten[$i]['Titel']?></h3>
										<ul class="actions special">
											<form action="/webauftritt/inc/controller.php">
												<input type="hidden" name="exponat_id" value="<?php echo $daten[$i]['Objekt_ID']?>">
												<input type="submit" value="Mehr Infos">
											</form>
										</ul>
									</section>
								</div>
							<?php
									if ($i % 2 == 1) {
										//immer zwei Elemente in einer Zeile
										echo "</div><div class='row'>";
									}		
								}
								?>
						</div>

					</section>
				<?php
					} else {
						$exponat_id = $_SESSION['exponat_id'];
						$daten = get_exponat($exponat_id);
				?>
					<section id="main" class="container">
						<section class="box special">
								<header class="major">
									<form action="/webauftritt/inc/controller.php">
										<input type="hidden" name="exponat_id" value="-1">
										<input type="submit" value="zurück">
									</form>
									<h2><div class="value"><?php echo $daten[0]['Titel']; ?></div></h2>
								</header>
						</section>
						<div class="box">
							<span class="image featured"><img src="images/pic01.jpg" alt="" /></span>
							<div class="row">
								<div class="row-6 row-12-mobilep">
									<p>Baujahr: <?php echo $daten[0]['Baujahr']; ?></p>
									<p>Hersteller: <?php echo $daten[0]['Hersteller']; ?></p>
								</div>
								<div class="row-6 row-12-mobilep">
									<p>Originaler Preis: <?php echo $daten[0]['OrigPreis']; ?></p>
									<p>Wert: <?php echo $daten[0]['Wert']; ?></p>
								</div>	
								<div class="row-6 row-12-mobilep">
									<p>Herkunft: <?php echo $daten[0]['Herkunft']; ?></p>
									<p>Maße: <?php echo $daten[0]['Abmessungen']; ?></p>
								</div>
								<div class="row-6 row-12-mobilep">
									<p>Kategorie: <?php echo $daten[0]['Kategorie']; ?></p>
									<p>Material: <?php echo $daten[0]['Material']; ?></p>
								</div>	
							</div>
							
							<div class="row">
								<div class="row-6 row-12-mobilep">
									<h3 style="color: white; background-color: #003a6a; text-align: center;">Beschreibung</h3>
									<p><?php echo $daten[0]['Beschreibung']; ?></p>
								</div>
							</div>
						</div>
					</section>
				<?php
					}
				?>
		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>