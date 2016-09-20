<?php

	/* General header - menu used in all project pages (except for landing-page) */

	// Helper function -> print avatar;
	function printAvatar(){
		echo empty(trim($_SESSION['avatar'])) ? 'people.png' : $_SESSION['avatar'];
	}

?>	

<?php if ($userLogged){ ?>
    <?php include 'search.php'; ?>
    <?php include 'loading_screen.php'; ?>
<?php } ?>

<header>
        
	<div class="logo">
    	<a href="../" title="Home - Startuppuccino">
        	<img alt="Startuppuccino" src="../app/assets/pics/logos/startuppuccino_logo.svg" />
    	</a>
    </div>

    <!--
    <div class="page_title">
    	<span>Lean Startup</span>
    </div>
    -->

    <nav class="menu">

    	<div onclick="Sp.layout.toggleMobileMenu(this)" id="mobile_menu__button" class="mobile_menu__button">
    		<div></div>
    		<div></div>
    		<div></div>
    		<div></div>
    	</div>

    	<ul>

			<?php if ($userLogged){ ?>

			<?php if($_SESSION['role']=="educator"){ ?>

			<li class="menu_link--top">
                <a href="../educators/manage/ideas/">Edu-area</a>
            </li>

			<?php } ?>

			<li class="menu_link--top">
                <a href="../ideas/">Ideas</a>
            </li>
				
        	<li class="menu_link--top">
                <a href="#" onclick="Sp.layout.toggleSearch()">Search</a>
            </li>

        	<li class="menu_link submenu_trigger">
        		<div class="menu_profile_picture" style="background-image: url('../app/assets/pics/people/<?php printAvatar();?>')" alt="Profile">
        			<div class="role_filter--<?php echo $_SESSION['role'];?>"></div>
        		</div> 
        		<ul class="submenu">
					<li class="menu_link--sub"><a href="../account/">Profile</a></li>
					<li class="menu_link--sub"><a href="../logout/">Logout</a></li>
                    <li class="menu_link--sub"><a href="#" onclick="showAskForHelp()">Help</a></li>
				</ul>
        	</li>

		<?php } else { ?>

			<!-- change this into a login form (external ajax login form script -> include) -->
			<li class="menu_link--top">
                <a href="../login/">Login</a>
            </li>

			<li class="menu_link--top">
                <a href="../register/">Register</a>
            </li>

		<?php } // endif userlogged ?>

		</ul>

    </nav>
        
    <div class="header_separator"></div>

</header>