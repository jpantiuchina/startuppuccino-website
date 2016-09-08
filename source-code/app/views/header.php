<?php

	/* General header - menu used in all project pages (except for landing-page) */

?>	

	<?php include 'search.php'; ?>
	<?php include 'loading_screen.php'; ?>

	<header>

        <section class="top_header custom_padding__header">
            
        	<div onclick="Sp.layout.toggleMobileMenu(this)" id="mobile_menu__button" class="mobile_menu__button">
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

       			<?php if($_SESSION['role']=="educator"){ ?>

					<a class="menu_link" href="../educators/manage/ideas/">EDU-AREA</a>

       			<?php } ?>

					<a class="menu_link" href="../ideas/">IDEAS</a>

       				<a class="menu_link" href="../teams/">TEAMS</a>
       				
                	<a class="menu_link" href="#" onclick="Sp.layout.toggleSearch()">SEARCH</a>

                	<a class="menu_link" href="../account/">ACCOUNT</a>

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

					<a class="menu_link" href="../register/">REGISTER</a>

				<?php } // endif userlogged ?>

            </nav>
            
        </section>

    </header>
