<?php
    
    $CONTROLLERS_DIR = dirname( __DIR__ );


    require_once $CONTROLLERS_DIR . '/session.php';

    if($userLogged){
        header("Location: ../");
        exit;
    }


    $currentPage = "register";
    $page_title = "Register - Startuppuccino";
    $metatags = [
                    [
                        "kind" => "link",
                        "type" => "text/css",
                        "rel"  => "stylesheet",
                        "href" => "app/assets/css/register.css"
                    ]
                ];
    $footer_scripts = [];



    if (isset($_POST['submit'])){

        include $CONTROLLERS_DIR . '/register.php';

    }


    // Include header and footer controllers
    include 'page__init.php';

    // Set template name and variables
    
    $template_file = "register.twig";

    $template_variables['sess'] = $_SESSION;
    $template_variables['userLogged'] = $userLogged;
    $template_variables['page_title'] = $page_title;
    $template_variables['metatags'] = $metatags;
    $template_variables['footer_scripts'] = $footer_scripts;

    // Render the template
    require_once $CONTROLLERS_DIR . '/Twig_Loader.php';
    Twig_Loader::show($template_file, $template_variables);

?>