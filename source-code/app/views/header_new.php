<?php

	/* General header - menu used in all project pages */
    if(!defined("RELATIVE_PATH")){
        define("RELATIVE_PATH", "..");
    }

	// Helper function -> return avatar;
	function avatar(){
		return empty(trim($_SESSION['avatar'])) ? 'avatar.svg' : $_SESSION['avatar'];
	}

    // Helper function -> print uri with the correct relative path
    function printUri($link){
        echo RELATIVE_PATH . $link;
    }

/*
    $homeurl = "/";
    if(isset($landing_page_) && $landing_page_ === true){
        $homeurl = "/about/";
    }
*/

?>

<?php if ($userLogged){ ?>
    <?php include 'search.php'; ?>
    <?php include 'loading_screen.php'; ?>
<?php } ?>

<header>

	<div class="logo">
    	<a href="<?php printUri("/");?>" title="Home - Startuppuccino">
        	<img alt="Startuppuccino" src="<?php printUri("/app/assets/pics/logos/startuppuccino_logo.svg");?>" />
    	</a>
    </div>

    <!--
    <div class="page_title">
    	<span>Lean Startup</span>
    </div>
    -->

    <nav class="menu">

    	<div id="mobile_menu__button" class="mobile_menu__button" onclick="Sp.layout.toggleMobileMenu()">
    		<div></div>
            <div></div>
            <div></div>
    	</div>

    	<ul class="menu_list menu_list--hide" id="menu_list" data-mobile="0">

		<?php if ($userLogged){ ?>

			<?php if($_SESSION['role']=="educator"){ ?>

			<li class="menu_link--top">
                <a href="<?php printUri("/educators/manage/ideas/");?>">Edu-area</a>
            </li>

			<?php } ?>

            <!--
			<li class="menu_link--top">
                <a href="../home/">Lectures</a>
            </li>

            <li class="menu_link--top">
                <a href="../ideas/">Ideas</a>
            </li>
			-->

            <li class="menu_link--top <?php if (isset($currentPage) && $currentPage == 'home') echo 'menu_link--active'  ?>">
                <a href="<?php printUri("/"); ?>">Home</a>
            </li>

        	<li class="menu_link--top">
                <a href="#" class="search_trigger_button">Search</a>
            </li>

        	<li class="menu_link submenu_trigger">
        		<div class="menu_profile_picture" style="background-image: url('<?php printUri("/app/assets/pics/people/".avatar());?>')" alt="Profile">
        			<div class="role_filter--<?php echo $_SESSION['role'];?>"></div>
        		</div> 
        		<ul class="submenu">
                    <!--<li class="menu_link--sub"><a href="<?php printUri("/people/?user_id=".$_SESSION['id']);?>">Profile</a></li>-->
                    <li class="menu_link--sub"><a href="<?php printUri("/settings/");?>">Settings</a></li>
				    <li class="menu_link--sub"><a href="<?php printUri("/logout/");?>">Logout</a></li>
                    <!--<li class="menu_link--sub"><a href="#" id="askforhelp_trigger_button">Help</a></li>-->
				</ul>
        	</li>

		<?php } else { ?>

            <li class="menu_link--top <?php if (isset($currentPage) && $currentPage == 'about') echo 'menu_link--active'  ?>">
                <a href="<?php printUri("/about/");?>">About</a>
            </li>

			<!-- change this into a login form (external ajax login form script -> include) -->
			<li class="menu_link--top <?php if (isset($currentPage) && $currentPage == 'login') echo 'menu_link--active'  ?>">
                <a href="<?php printUri("/login/");?>">Login</a>
            </li>

            <li class="menu_link--top <?php if (isset($currentPage) && $currentPage == 'register') echo 'menu_link--active'  ?>">
                <a href="<?php printUri("/register/");?>">Register</a>
            </li>

		<?php } // endif userlogged ?>

		</ul>

    </nav>
        
    <div class="header_separator"></div>

</header>