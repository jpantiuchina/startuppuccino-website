<?php 

    require_once './app/models/session.php';

    if($userLogged){
        header("Location: ./home/");
        exit;
    }


    /* Set the correct relative path */
    define("RELATIVE_PATH",".");

?>

<!DOCTYPE html>
<html>
	<head>
        
        <title>Startuppuccino</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="icon" href="http://thatsmy.name/startuppuccino/land/icon.svg" type="image/svg+xml">
        <link rel="mask-icon" href="http://thatsmy.name/startuppuccino/land/icon.svg">

        <link rel="stylesheet" href="./app/assets/newcss/landing.css" media="all" />
        <!-- temp -->
        <link rel="stylesheet" href="./app/assets/newcss/login.css" media="all" />
        <link rel="stylesheet" href="./app/assets/newcss/register.css" media="all" />
        

        <?php include './app/views/extra_head_html.php'; ?>


    </head>
    <body>
        
        <?php include './app/views/header_new.php'; ?>

        <main>

            <div class="center_column">
                <div class="center_aligner">
                    <div id="landing_logo_container">
                        <div>
                            <h1>
                                <a href="http://leanstartup.bz" target="_blank"><img src="./app/assets/pics/logos/leanstartup.png" ></a>
                                <span>Lean Startup</span>
                            </h1>
                            <div class="sublogo_links">
                                
                                <span><a href="./login/">Login</a></span>
                                <span><a href="./register/">Register</a></span>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!--
            <section id="login">
                <h4>Login</h4>
                <?php // temporary ?>
                <?php // $form_action = "./login/index.php"; $loginOk = true; ?>
                <?php //include './app/views/login_form.php'; ?>
            </section>

            <section id="register">
                <h4>Register</h4>
                <?php // $form_action = "./register/index.php"; ?>
                <?php //include './app/views/register_form.php'; ?>            
            </section>
            -->
        </main>

        <footer class="landing_footer">
            Powered by <a href="./about/">Startuppuccino</a>
        </footer>

        <script src="./app/assets/js/startuppuccino.js"></script>

	</body>
</html>