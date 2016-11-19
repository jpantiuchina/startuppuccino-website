<?php
    
    $CONTROLLERS_DIR = dirname( __DIR__ );


    require_once $CONTROLLERS_DIR . '/session.php';

    if($userLogged){
        header("Location: ./home/");
        exit;
    }


    $currentPage = "";
    $page_title = "Startuppuccino";
    $metatags = [
                    [
                        "kind" => "link",
                        "type" => "text/css",
                        "rel"  => "stylesheet",
                        "href" => "app/assets/css/landing.css"
                    ]
                ];
    $footer_scripts = [];


    // Include header and footer controllers
    include 'page__init.php';

    // Set template name and variables
    
    $template_file = "landing.twig";

    $template_variables['sess'] = $_SESSION;
    $template_variables['userLogged'] = $userLogged;
    $template_variables['page_title'] = $page_title;
    $template_variables['metatags'] = $metatags;
    $template_variables['footer_scripts'] = $footer_scripts;

    // Render the template
    require_once $CONTROLLERS_DIR . '/Twig_Loader.php';
    Twig_Loader::show($template_file, $template_variables);

?>