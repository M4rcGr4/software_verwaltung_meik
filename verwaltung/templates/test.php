<?php
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
      <body>

        <h2>Test</h2>
          <!---<div class="row gtr-uniform">
              <label for="standortName">
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="standortName" id="standortName" value="" placeholder="Name" />
                  </div>                                                             
                  <div class="col-12">
                    <ul class="actions">
                      <li><input type="submit" value="Speichern" class="primary" /></li>
                      <li><input type="reset" value="Zurücksetzen" /></li>
                    </ul>
                  </div>
                  <ul class="input-requirements">
                    <li>At least 8 characters long (and less than 100 characters)</li>
                    <li>Contains at least 1 number</li>
                  </ul>
              </label>
          </div>--->
        <br>
          <div lass="col-6 col-12-xsmall">
            <input id="text" type="text" value="http://meik-gr4.industrieschule.de/webauftritt/" style="width:80%" /><br />
            <div id="qrcode" style="width:100px; height:100px; margin-top:15px;"></div>
            <button onclick="makeCode()">IchmagDasNicht</button>
            <?php
              '<script type"text/javascript">
                addEventListener("DOMContentLoaded", (event) => {
                    var qrcode = new QRCode(document.getElementById("qrcode"), {
                        width : 100,
                        height : 100
                      });
                    
                      function makeCode () {		
                        var elText = document.getElementById("text");
                        
                        if (!elText.value) {
                          alert("Input a text");
                          elText.focus();
                          return;
                        }
                        
                        qrcode.makeCode(elText.value);
                      }
                    
                      makeCode();
                    
                      $("#text").
                        on("blur", function () {
                          makeCode();
                        }).
                        on("keydown", function (e) {
                          if (e.keyCode == 13) {
                            makeCode();
                          }
                        });
                        
                });
               </script>' 
            ?>

          </div>
      
      
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