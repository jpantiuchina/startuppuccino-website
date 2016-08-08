<?php

	/* General header - menu used in all project pages (except for landing-page) */

?>	

	<section id="loading_screen" style="display: none">
		
		<div id="loading_circle">
			<div id="loading_ball1" class="loading_ball"></div>
			<div id="loading_ball2" class="loading_ball"></div>
			<div id="loading_ball3" class="loading_ball"></div>
			<div id="loading_ball4" class="loading_ball"></div>
		</div>

	</section>

	<script>
		// Javascript script to manage the mobile menu view
		function toggleMobileMenu(e){
			e.classList.toggle("mobile_menu__button--active");
			document.getElementById("main_menu").classList.toggle("main_menu--visible");
			document.getElementsByTagName("main")[0].classList.toggle("force--hidden");
			document.getElementsByClassName("bottom_header")[0].classList.toggle("force--hidden");
		}
	</script>

	<header>

		<!--
        <div class="header__background"></div>
		-->

        <section class="top_header custom_padding__header">
            
        	<div onclick="toggleMobileMenu(this)" class="mobile_menu__button">
        		<div></div>
        		<div></div>
        		<div></div>
        		<div></div>
        	</div>

        	<a href="../" title="Home - Startuppuccino">
	        	<img class="logo logo--link" alt="Startuppuccino" src="../app/assets/pics/logos/startuppuccino_logo.svg" />
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

    </header>
