<?php

	/* General header - menu used in all project pages (except for landing-page) */

	// Helper function -> print avatar;
	function printAvatar(){
		echo empty(trim($_SESSION['avatar'])) ? 'people.png' : $_SESSION['avatar'];
	}

?>	

<?php include 'search.php'; ?>
<?php include 'loading_screen.php'; ?>

<header>
        
	<div class="logo">
    	<a href="../" title="Home - Startuppuccino">
        	<img alt="Startuppuccino" src="../app/assets/pics/logos/startuppuccino_logo.svg" />
    	</a>
    </div>

    <div class="page_title">
    	<span><?php echo $page_title; ?></span>
    </div>

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

			<li class="menu_link--top"><a href="../educators/manage/ideas/">Edu-area</a></li>

			<?php } ?>

			<li class="menu_link--top"><a href="../ideas/">
				<svg class="idea_icon c_<?php echo $_SESSION['role']; ?> b_<?php echo $_SESSION['role']; ?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 299.994 299.994" style="enable-background:new 0 0 299.994 299.994;" xml:space="preserve" width="512px" height="512px"><g><g><g><path d="M148.75,87.806c-17.424,0.568-37.578,10.605-37.576,37.143c0,13.445,7.965,21.42,16.402,29.865     c3.278,3.278,6.608,6.611,9.306,10.32h23.739c2.695-3.706,6.025-7.042,9.306-10.32c8.434-8.445,16.399-16.42,16.399-29.865     C186.326,98.411,166.171,88.374,148.75,87.806z" /><path d="M149.997,0C67.156,0,0,67.156,0,149.997c0,82.839,67.156,149.997,149.997,149.997s149.997-67.158,149.997-149.997     C299.995,67.156,232.839,0,149.997,0z M148.75,218.471c-12.893,0-23.342-11.085-23.342-24.766h46.685     C172.095,207.388,161.643,218.471,148.75,218.471z M170.412,180.695h-43.326c-1.167-12.753-31.476-23.871-31.476-55.747     c0-34.002,25.425-52.027,53.137-52.709c0,0,0,0,0.005,0c27.71,0.682,53.135,18.708,53.135,52.709     C201.887,156.824,171.576,167.942,170.412,180.695z" /></g></g></g></svg>
			</a></li>

			<!-- <li class="menu_link--top"><a href="../teams/">Projects</a></li> -->
				
        	<li class="menu_link--top"><a href="#" onclick="Sp.layout.toggleSearch()">
        		<svg class="idea_icon c_<?php echo $_SESSION['role']; ?> b_<?php echo $_SESSION['role']; ?>" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 44 44" enable-background="new 0 0 44 44"><g><circle cx="20" cy="20" r="7"/><path d="m22,0c-12.2,0-22,9.8-22,22s9.8,22 22,22 22-9.8 22-22-9.8-22-22-22zm12.7,33.3l-1.4,1.4c-0.4,0.4-1,0.4-1.4,0l-5.4-5.4c-0.2-0.2-0.4-0.2-0.6-0.1-1.7,1.1-3.7,1.7-5.9,1.7-6.1,0-11-4.9-11-11s4.9-11 11-11 11,4.9 11,11c0,2.2-0.6,4.2-1.7,5.9-0.1,0.2-0.1,0.5 0.1,0.6l5.4,5.4c0.3,0.5 0.3,1.1-0.1,1.5z"/></g></svg>
        	</a></li>

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
			<li class="menu_link--top"><a href="../login/">Login</a></li>

			<li class="menu_link--top"><a href="../register/">Register</a></li>

		<?php } // endif userlogged ?>

		</ul>

    </nav>
        
</header>