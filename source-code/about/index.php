<?php require_once '../app/models/session.php'; ?> 

<!DOCTYPE html>
<html>
	<head>
		
		<link href="../app/assets/css/general.css" rel="stylesheet" media="all" type="text/css" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Startuppuccino</title>

		<script>
    		function toggleMobileMenu(e){
    			e.classList.toggle("mobile_menu__button--active");
    			document.getElementById("main_menu").classList.toggle("main_menu--visible");
    			document.getElementsByTagName("main")[0].classList.toggle("force--hidden");
    			document.getElementsByClassName("bottom_header")[0].classList.toggle("force--hidden");
    		}
    	</script>

	</head>
	<body>

		<div id="wrapper">
	        
	        <header class="header--home">

	            <div class="header__background"></div>

	            <section class="top_header custom_padding__header">
	                
	            	<div onclick="toggleMobileMenu(this)" class="mobile_menu__button">
	            		<div></div>
	            		<div></div>
	            		<div></div>
	            		<div></div>
	            	</div>

	            	<a href="../" title="Home - Startuppuccino">
                		<img class="logo" alt="Startuppuccino" src="../app/assets/pics/logos/startuppuccino_logo.svg" />
                	</a>

	                <nav id="main_menu">
						
						<?php if ($userLogged){ ?>

							<a class="menu_link" href="../ideas/">IDEAS</a>

		       				<a class="menu_link" href="../teams/">TEAMS</a>

	           				<a class="menu_link" href="../people/">PEOPLE</a>

	           				<a class="menu_link" href="../account/"><?php print strtoupper($_SESSION['firstname']); ?></a>

	           				<!--
							<div class="menu_link menu_link--controller" >
								<span class="menu_link menu_link--placeholder"><?php //print strtoupper($_SESSION['firstname']); ?></span>
								<a class="menu_link menu_link--submenu" href="../account/">ACCOUNT</a>
							</div>
							-->

							<a class="menu_link" href="../logout/">LOGOUT</a>

						<?php } else { ?>

							<!-- change this into a login form (external ajax login form script -> include) -->
							<a class="menu_link" href="../login/">LOGIN</a>

							<a class="menu_link" href="../signup/">REGISTER</a>

						<?php } // endif userlogged ?>

	                </nav>
	                
	            </section>

	            <section class="bottom_header split_view">
	                
            		<div class="box_view custom_padding">
            			<h3></h3>
            			<p></p>
            		</div>
            		<div class="box_view box_view--tagline custom_padding">
            			
            			<h3>Meet Startuppuccino</h3>
		                <p>Startuppuccino is a project whose vision is to provide startups the guidance they need at their early steps</p>
		                <span><a href="../ideas/">DISCOVER</a></span>

            		</div>

	            </section>

	        </header>
	        
	        <main>
	            
	            <section class="split_view split_view--info">
	                
	                <div class="box_view custom_padding">
	                    <h3>
	                        <span class="span-line span-line-orange"></span>
	                        INTRODUCTION
	                    </h3>
	                    <p>Startuppuccino is a project whose vision is to provide startups the guidance they may need in their early steps.</p>
	                    <p>On the portal, startuppers and enterpreneurs can find every direct guidance through the help of our mentors team, specialized personal ready to direct people into the correct direction, as well as a selection of useful web tools they can use to improve their working experience.</p>
	                    <p>Startuppuccino is a free service, born during the Lean Startup course and sponsored by Unibz.</p>
	                </div>
	                
	                <div class="box_view custom_padding" id="vision">
	                    <h3>
	                        <span class="span-line span-line-black"></span>
	                        VIDEO
	                    </h3>
	                    <iframe src="https://player.vimeo.com/video/151849090" width="300" height="180" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	                </div>
	                
	            </section>
	            
	            <section class="full-view custom_padding" id="partners">
	                
	                <h3>
	                    <span class="span-line span-line-white"></span>
	                    PARTNERS
	                </h3>
	                <p>Startuppuccino is sponsored by different companies or associations, but is still searching an investor for year 2016.</p>
	                <a href="http://unibz.it" target="_blank"><img src="../app/assets/pics/logos/unibz_logo.jpg" /></a>
	                <a href="#"><img src="../app/assets/pics/logos/minetoolz.jpg" /></a>
	            
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