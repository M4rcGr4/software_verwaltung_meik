<?php
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
 include './test.php'
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
      <body>
        <h2>QR Code</h2>
      <?php
     
      ?>

      
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/browser.min.js"></script>
        <script src="assets/js/breakpoints.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/validation.js"></script>
        <script src="assets/js/qrCodeGen/qrcode.js"></script>
        <script src="assets/js/qrCodeGen/jquery.min.js"></script>
		<script src="assets/js/qrCodeGen/create.js"></script>
      </body>
</html>