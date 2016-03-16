<?php include './assets/php/session.php'; ?> 

<!DOCTYPE html>
<html>
	<head>
		
		<link href="assets/css/landing.css" rel="stylesheet" media="all" type="text/css" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Startuppuccino</title>

	</head>
	<body>

		<div id="wrapper" class="center">
	        
	        <header class="custom-padding">
	            
	            <div class="top_header">
	                
	                <nav>

	                	<a href="./people/">People</a>

	           			<?php if ($userLogged){ ?>

							<h1>Hello <?php print $_SESSION['firstname']; ?>!</h1>

							<a href="./account/">My account</a>

							<a href="./logout/">Logout</a>

						<?php } else { ?>

							<!-- change this into a login form (external ajax login form script -> include) -->
							<a href="./login/">Login</a>

							<a href="./signup/">Sign up</a>

						<?php } // endif userlogged ?>

	                </nav>
	                
	            </div>
	            <div class="bottom_header">
	                
	                <img class="logo" alt="Startuppuccino" src="assets/pics/startuppuccino_logo.svg" />
	                <h3>
	                    <span class="span-line span-line-white"></span>
	                    WE MENTOR<br/>YOUR STARTUP
	                </h3>
	                
	            </div>
	            
	        </header>
	        
	        <main>
	            
	            <section class="mobile-menu custom-padding">
	                
	                <nav><a href="#partners" title="Partners">PARTNERS</a></nav>
	                <nav><a href="./login/" title="CLab Trento">CLAB - TN</a></nav>
	                
	            </section>
	            
	            <section class="split-view">
	                
	                <div class="box-view custom-padding">
	                    <h3>
	                        <span class="span-line span-line-orange"></span>
	                        INTRODUCTION
	                    </h3>
	                    <p>Startuppuccino is a project whose vision is to provide startups the guidance they may need in their early steps.</p>
	                    <p>On the portal, startuppers and enterpreneurs can find every direct guidance through the help of our mentors team, specialized personal ready to direct people into the correct direction, as well as a selection of useful web tools they can use to improve their working experience.</p>
	                    <p>Startuppuccino is a free service, born during the Lean Startup course and sponsored by Unibz.</p>
	                </div>
	                
	                <div class="box-view custom-padding" id="vision">
	                    <h3>
	                        <span class="span-line span-line-black"></span>
	                        VIDEO
	                    </h3>
	                    <iframe src="https://player.vimeo.com/video/151849090" width="300" height="180" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	                </div>
	                
	            </section>
	            
	            <section class="full-view custom-padding" id="partners">
	                
	                <h3>
	                    <span class="span-line span-line-white"></span>
	                    PARTNERS
	                </h3>
	                <p>Startuppuccino is sponsored by different companies or associations, but is still searching an investor for year 2016.</p>
	                <a href="http://unibz.it" target="_blank"><img src="assets/pics/unibz_logo.jpg" /></a>
	                <a href="http://international.unitn.it/mim/clab-trento" target="_blank"><img src="assets/pics/CLab_logo.jpg" /></a>
	                <a href="#"><img src="assets/pics/minetoolz.jpg" /></a>
	            
	            </section>
	            
	        </main>
	        
	        <footer>
	            
	            <!--
	            <p>Developed with love by your <a href="http://startuppuccino.com">Startuppuccino</a></p>
	            -->
	            
	        </footer>
	        
	    </div>

	</body>
</html>