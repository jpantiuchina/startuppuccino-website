<?php
	
	/* General footer user included in all pages (except for landing page) */

?>


<footer class="footer">
	
	<div class="footer__separator"></div>

	<p class="footer__links">

	   <a class="footer__link" href="http://leanstartup.bz" target="_blank">Leanstartup.bz</a>
	   <a class="footer__link" href="http://facebook.com" target="_blank">Leanstartup on facebook</a>
	   <a class="footer__link" href="https://unibz.it" target="_blank">Unibz.it</a>
	   <a class="footer__link" href="../about/" target="_blank">© 2016 Startuppuccino. All rights reserved </a>
	  
	 </p>

</footer>




<?php 

	if($userLogged){ include '../app/views/askforhelp.php'; } 

?>

<script src="../app/assets/js/startuppuccino.js"></script>