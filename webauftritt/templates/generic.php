<?php
include '../inc/controller.php';
?>
<!DOCTYPE HTML>
<!--
	Alpha by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<body class="is-preload">
	<?php
		$daten = get_exponate();
		foreach($daten as $data)
	?>
		<div id="page-wrapper">
				<br>
				<br>
				<section id="main" class="container">
					<section class="box special">
							<header class="major">
								<h2><div class="value"><?php echo $data['Titel']; ?></div></h2>
							</header>
					</section>
					<div class="box">
						<span class="image featured"><img src="images/pic01.jpg" alt="" /></span>
						<div class="row">
							<div class="row-6 row-12-mobilep">
								<p>Baujahr: <?php echo $data['Baujahr']; ?></p>
								<p>Hersteller: <?php echo $data['Hersteller']; ?></p>
							</div>
							<div class="row-6 row-12-mobilep">
								<p>Org. Preis: <?php echo $data['OrigPreis']; ?></p>
								<p>Wert: <?php echo $data['Wert']; ?></p>
							</div>	
							<div class="row-6 row-12-mobilep">
								<p>Herkunft: <?php echo $data['Herkunft']; ?></p>
								<p>Maße: <?php echo $data['Abmessungen']; ?></p>
							</div>
							<div class="row-6 row-12-mobilep">
								<p>Kategorie: <?php echo $data['Kategorie']; ?></p>
								<p>Material: <?php echo $data['Material']; ?></p>
							</div>	
						</div>
						
						<div class="row">
							<div class="row-6 row-12-mobilep">
								<h3 style="color: white; background-color: #003a6a; text-align: center;">Beschreibung</h3>
								<p><?php echo $data['Beschreibung']; ?></p>
							</div>
						</div>
					</div>
				</section>
		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					// Warten auf das Laden der Seite
					var banner = document.getElementById('banner'); // Hier die ID des Banners anpassen
					if (banner) {
						banner.style.display = 'none'; // Banner ausblenden
					}
				});
			</script>

	</body>
</html>