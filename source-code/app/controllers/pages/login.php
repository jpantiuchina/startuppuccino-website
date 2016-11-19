<?php
    
    $CONTROLLERS_DIR = dirname( __DIR__ );


    require_once $CONTROLLERS_DIR . '/session.php';

    if($userLogged){
        header("Location: ../");
        exit;
    }


    $currentPage = "login";
    $page_title = "Login - Startuppuccino";
    $metatags = [
                    [
                        "kind" => "link",
                        "type" => "text/css",
                        "rel"  => "stylesheet",
                        "href" => "app/assets/css/login.css"
                    ]
                ];
    $footer_scripts = [];

    $login_data = ["email"=>"","password"=>""];


    if (isset($_POST['login'])){

        $login_email = $_POST['email'];
        $login_password = md5($_POST['password']);

        $isPermaLogin = isset($_POST['permalogin']) && $_POST['permalogin'] === "y";

        include $CONTROLLERS_DIR . '/login.php';
        
        $resetOk = true;

    } else if (isset($_POST['reset_password'])){

        $login_email = $_POST['email'];

        include $CONTROLLERS_DIR . '/reset_password.php';

        $loginOk = true;

    } else {

        // initialize variable to prevent to show the error message
        $loginOk = true;
        $resetOk = true;
        
    }

    // Include header and footer controllers
    include 'page__init.php';

    // Set template name and variables
    
    $template_file = "login.twig";

    $template_variables['sess'] = $_SESSION;
    $template_variables['userLogged'] = $userLogged;
    $template_variables['page_title'] = $page_title;
    $template_variables['metatags'] = $metatags;
    $template_variables['footer_scripts'] = $footer_scripts;

    $template_variables['reset_password'] = isset($_GET['reset']);
    $template_variables['reset_password_success'] = isset($_GET['reset_done']);
    $template_variables['resetOk'] = $resetOk;
    $template_variables['loginOk'] = $loginOk;
    $template_variables['login_data'] = $login_data;


    // Render the template
    require_once $CONTROLLERS_DIR . '/Twig_Loader.php';
    Twig_Loader::show($template_file, $template_variables);

?>