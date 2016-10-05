<?php 

    require_once '../app/models/session.php';
    $currentPage = "about";

?> 

<!DOCTYPE html>
<html>
	<head>
		
		<link href="../app/assets/newcss/about.css" rel="stylesheet" media="all" type="text/css" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Startuppuccino | Active learning education</title>

	</head>
	<body>

		<?php include '../app/views/header_new.php'; ?>

        <main>
            
            <section class="land">

                <img class="land__logo" src="../app/assets/pics/logos/startuppuccino_logo.svg" />

                <div class="land__separator"></div>

                <div class="land__anchors">
                    <span><a href="#why">WHY</a></span>
                    <span><a href="#what">WHAT</a></span>
                    <!--<span><a href="#contact">CONTACT</a></span>-->
                </div>


            </section>

            <section class="goals" id="why">
                
                <div class="goals__box">
                    <img src="" />
                    <h4>Educators & Mentors</h4>
                    <p>Better visibility and tracking to startup projects</p>
                </div><!--

                --><div class="goals__box">
                    <img src="" />
                    <h4>Students</h4>
                    <p>Active and interactive learning experience</p>
                </div>

            </section>

            <section class="description" id="what">
              
                <div class="description__tagline">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500"><path class="c_green" d="M132.12,221.32a44.39,44.39,0,1,1-44.39-44.39,44.39,44.39,0,0,1,44.39,44.39"/><path class="c_red" d="M316.74,116.52a74,74,0,1,1-74-74,74,74,0,0,1,74,74"/><path class="c_brown" d="M450.66,346.37A118.37,118.37,0,1,1,332.29,228,118.37,118.37,0,0,1,450.66,346.37"/></svg>
                    <p>
                        <span class="c_green">an educational platform</span><br>
                        <span class="c_red">for active learning</span><br>  
                        <span class="c_brown">of entrepreneurship</span><br>
                    </p>
                </div>
                <!--
                <div class="description__longtext">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.</p>
                </div>
                -->

            </section>


            <section class="courses">

                <h4>Courses using startuppuccino</h4>

                <div class="courses__box">
                    <a href="../">
                        <img src="../app/assets/pics/logos/leanstartup.png" />
                        <span>Lean Startup</span>
                    </a>
                </div>

            </section>

            <section class="contacts" id="contact">
<!--
                <h4>Let's keep in contact!</h4>

                <form>
                    <input type="email" placeholder="Yourfunny@email.com" required><span>SUBMIT</span>
                </form>
-->
            </section>

        </main>

        <footer>

            <div class="land__separator"></div>

            <p><a class="about_links" href="http://leanstartup.bz" target="_blank">Leanstartup.bz</a></p>
            <p><a class="about_links" href="https://unibz.it" target="_blank">Unibz.it</a></p>

        	<p>© 2016 Startuppuccino. All rights reserved<!-- — Privacy — Contacts--></p>

        </footer> 

	</body>
</html>