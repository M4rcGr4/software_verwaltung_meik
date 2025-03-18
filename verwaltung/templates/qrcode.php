<?php
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
 include '../phpqrcode/qrlib.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
      <body>
        <h2>QR Code</h2>
            <?php
                function createQR( $id )
                {
                    $text = "http://meik-gr4.industrieschule.de/webauftritt/" . $id;
                    $filename = "../qrcodes/Test" . $id;
                
                    
                    QRcode::png( $text, $filename, QR_ECLEVEL_M );
                    return $filename;
                }
                $filename = createQR( 9999 );
                echo $filename;
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