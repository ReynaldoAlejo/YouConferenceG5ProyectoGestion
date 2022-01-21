<footer class="site-footer">
    <div class="contenedor clearfix">
        <ul class="contenedores-footer clearfix">
          <li>
            <div class="contenido-footer clearfix">
            <h3><span>Sobre</span> YouConference</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
          </li>
          
          <li>
            <div class="contenido-footer clearfix">
            <h3><span>Redes</span> Sociales</h3>
              <nav class="redes-sociales">
                  <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                  <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-pinterest" target="_blank"></i></a>
                  <a href="#"><i class="fab fa-youtube" target="_blank"></i></a>
                  <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
              </nav> <!--.redes-sociales-->
            </div> <!--.contenido-footer-->
          </li>
      </ul> <!--.contenedores-footer-->
  </div> <!--.contenedor-->
  <p class="copyright">Todos los Derechos Reservados YouConference &copy;</p>
</footer> <!--.contenedor-inferor-->

  <!-- Begin MailChimp Signup Form -->
  <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
  <style type="text/css">
  	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
  	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
  	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
  </style>
  <div style="display:none;">
  
  <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
  <!--End mc_embed_signup-->

<script src="js/vendor/modernizr-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
<script src="js/plugins.js"></script>
<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.lettering.js"></script>

<?php

  $archivo = basename($_SERVER['PHP_SELF']);
  $pagina = str_replace(".php", "", $archivo);

  if($pagina == "invitados" || $pagina == "index") {

    echo '<script src="js/jquery.colorbox-min.js"></script>';

  }

  else if($pagina == "conferencia") {

    echo '<script src="js/lightbox.js"></script>">';

  }

?>

<script src="js/main.js"></script>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
  window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
  ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>

</html>
