console.log('debug1lol');
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
        console.log('debug2');
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
        


