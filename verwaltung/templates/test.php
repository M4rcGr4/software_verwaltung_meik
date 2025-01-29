<?php
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
      #snackbar {
        visibility: hidden;
        min-width: 500px;
        margin-left: -125px;
        background-color: #8bce4c;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
      }

      #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
      }

      @-webkit-keyframes fadein {
        from {bottom: 0; opacity: 0;} 
        to {bottom: 30px; opacity: 1;}
      }

      @keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
      }

      @-webkit-keyframes fadeout {
        from {bottom: 30px; opacity: 1;} 
        to {bottom: 0; opacity: 0;}
      }

      @keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
      }
      .video {
        position: relative;
        padding: 0.5rem;
        width: 30rem;
        background-color: #00fff1;
        border-radius: 1rem;
      }
      .video video {
        width: 100%;
        border-radius: 1rem;
        overflow: hidden;
        aspect-ratio: 5/3.8;
        vertical-align: bottom;
      }
      .video .line {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 100;
        background-color: #00fff1;
        width: 32rem;
        height: 0.5rem;
        border-radius: 1rem;
        opacity: 0;
        transform: translate(-1rem, 0);
      }
      .video .line.animate {
        opacity: 1;
        -webkit-animation: move infinite ease-in-out 1s alternate;
                animation: move infinite ease-in-out 1s alternate;
      }

      @-webkit-keyframes move {
        0% {
          top: 10%;
        }
        100% {
          top: 90%;
        }
      }

      @keyframes move {
        0% {
          top: 10%;
        }
        100% {
          top: 90%;
        }
      }
      </style>
    </head>
      <body>

      <h2>leer</h2>

      </body>
</html>
